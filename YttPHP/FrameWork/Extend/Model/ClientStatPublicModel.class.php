<?php
/**
 * 客户应付款统计
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */
class ClientStatPublicModel extends AbsStatPublicModel {

	public $comp_type	=	1;

	///字段列表
	private $sqlFields	=	'';

	/**
	 * 取合计数据
	 *厂家 229  物流 329
	 * @return array
	 */
	public function getIndex() {
		if (!empty($_POST['date']['from_paid_date']) && !empty($_POST['date']['to_paid_date'])){
			$money = '(round(if(object_type=103, need_paid,original_money), ' . C('MONEY_LENGTH') . '))*income_type*-1';
			$s_where = 'object_type!=129';
		}else{
			if ($_POST['date']['lt_paid_date']) {
				$money = '(round(original_money, ' . C('MONEY_LENGTH') . ')+if(object_type=102,0,round(discount_money, ' . C('MONEY_LENGTH') . ')))*income_type*-1';
				$s_where =  'object_type!=129';
			}else {
				$money = 'round(if(object_type=103, need_paid,original_money), ' . C('MONEY_LENGTH') . ')*income_type*-1';
				///显示所有
				$s_where = $_POST['show']==1 ? '( is_close=0 or (  is_close>0 and object_type= 103 and object_type_extend=3 ) )' : 'is_close=0 and need_paid!=0';
			}
		}
		/// 是否显示0款项客户
		$having = $_POST['show']==1 ? '' : ' having(total_need_paid!=0)';

        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $warehouse  = ' and warehouse_id in ('.getUser('company_id').',0) ';
            $warehouse_id   = '/warehouse_id/'.getUser('company_id');
        }else{
            if(!empty($_POST['warehouse_id'])){
                $warehouse  = ' and warehouse_id in ('.$_POST['warehouse_id'].',0) ';
                $warehouse_id   = '/warehouse_id/'.$_POST['warehouse_id'];
            }
        }
		$where = _search($s_where.' and '._search_array(_getSpecialUrl($_GET)).$warehouse);
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$where .= ' and comp_id='.intval(getUser('company_id'));
		}
		$field = '';
		if($_REQUEST['flag']==1){
			$client_currency      = C('CLIENT_CURRENCY') ? M('Currency')->where('id in (' . C('CLIENT_CURRENCY') . ')')->getField('id, currency_no') : array();
			if (!empty($client_currency)) {
				$having_charge	= ' (case ';
				foreach ($client_currency as $currency_id => $currency_no) {
					$field_name		= 'warning_balance_' . strtolower($currency_no);
					$having_charge	.= ' when currency_id=' . $currency_id . ' and '.$field_name.' <> \'\' or '.$field_name.'  <> null   then total_need_paid > -' . $field_name;
					$field			.= ', ' . $field_name;
				}
				$having_charge	.= ' end)';			
				$having .= empty($having)? 'having  '.$having_charge : ' and '.$having_charge ;
			}
		}
		/// 取明细数组
		$sql_field 		= 'select a.comp_id, a.currency_id,a.basic_id,a.paid_id,sum('.$money.') as total_need_paid '.$this->fundsField().''.$field.'
						from client_paid_detail as a
						inner join company as b on a.comp_id=b.id and b.comp_type=1
						where '.$where.' ';
		$sql_field_group= 'select currency_id,basic_id,paid_id,sum('.$money.') as total_need_paid '.$this->fundsField().''.$field.'
						from client_paid_detail
						where '.$where.' ';
		$sql_group 		= ' group by comp_id,currency_id,basic_id '.$having.'
								order by comp_id,currency_id,basic_id,a.paid_id asc ';
		$sql_group_total= ' group by currency_id '.$having.'
							  order by currency_id ';
		$sql			= $sql_field.$sql_group;

		$detail_data	= _listStat($sql);
		foreach ((array)$detail_data as $key => $value) {
			$main_data_format[$value['comp_id'].'_'.$value['currency_id']]['total_comp_need_paid']	+=	$value['total_need_paid'];
		}
		$list = array();

		if (!empty($_POST['date']['from_paid_date']) && !empty($_POST['date']['to_paid_date'])){
			$url_date = '/from_paid_date/'.formatDate($_POST['date']['from_paid_date']).'/to_paid_date/'.formatDate($_POST['date']['to_paid_date']);
			$sourcetype = 4;
		}else{
			if(empty($_POST['date']['lt_paid_date'])){
				$url_date = '';
				$sourcetype = 1;///3
			}else {
				$url_date = '/to_paid_date/'.formatDate($_POST['date']['lt_paid_date']);
				$sourcetype = 4;
			}
		}
		$for_type	= 0;
		$show_type	= 'page';
		if(in_array($sourcetype, array('1','2','3'))){
			if($sourcetype==1){
				$for_type = C('UNPAID_ARREARAGE_DETAILS');
				if($for_type==2) $show_type = 'not_page';
			}elseif($sourcetype==2){
				$for_type = C('ALL_ARREARAGE_DETAIL');
			}else{
				$for_type = C('ARREARAGE_DETAILS_AFCLOSEOUT');
			}
			if($for_type==3) $for_type = 1;
		}
		$url	= '/ClientStat/view/type/'.$sourcetype.'/for_type/'.$for_type.'/show_type/'.$show_type . $url_date;
		foreach ($detail_data as $key => $value) {
			$value['detail_url'] 		= U($url . '/comp_id/'.$value['comp_id'].'/currency_id/'.$value['currency_id'].'/basic_id/'.$value['basic_id'].$warehouse_id);
			$value['total_comp_need_paid']	= $main_data_format[$value['comp_id'].'_'.$value['currency_id']]['total_comp_need_paid'];
			$list[] = $value;
		}
		$list 	= $this->addRemindMoney(_formatList($list));
		$list	= $this->getTotalCurrencyInfo($list,array('total_need_paid'));
		///没有分页的合计
		///合计为分页的总数量
		if($_REQUEST['flag']==1){
			$sql_field_group = $sql_field;
			$sql_group_total=$sql_group;
		}
		$sql_total		=	$sql_field_group.$sql_group_total;
		$detail_total 	= _formatList($this->db->query($sql_total));
		$detail_total	= $this->getTotalCurrencyInfo($detail_total,array('total_need_paid'));
		$list['page_total']	= $detail_total;
		foreach((array)$list['list'] as $val){
			$comp_id[]      = $val['comp_id'];
		}
		$comp_id=array_unique($comp_id);
		$arr=array();
		if($comp_id){
		$company_data = M('company')->where('comp_type=1 and id in ('.implode(',', $comp_id).')')->order('id')->getField('id,email,mobile,contact');
		foreach ((array)$list['list'] as $key=>$val) {
			$list['list'][$key]['email']   = $company_data[$val['comp_id']]['email'];
			$list['list'][$key]['mobile']  = $company_data[$val['comp_id']]['mobile'];
			$list['list'][$key]['contact'] = $company_data[$val['comp_id']]['contact'];
		}
		unset($company_data);
		}
		return $list;
	}

	/**
	 * 增加提醒日期
	 *
	 * @param array $list
	 * @param array $info
	 * @return array
	 */
	function addRemindDay(&$list,$info){
		$company_expand	=	S('company_expand');
		$id_key			=	$info['id']?$info['id']:'comp_id';
		$money_key		=	$info['date']?$info['date']:'edml_total_comp_need_paid';
		if (is_array($list['list'])){
			foreach ($list['list'] as $key => $value) {
				if ($value[$money_key]>$company_expand[$value[$id_key]]['remind_money'] && $company_expand[$value[$id_key]]['remind_money']>0){
					$list['list'][$key]['tr_color']	=2;
				}else{
					$list['list'][$key]['tr_color']	=1;
				}
			}
		}
		return $list;
	}

	 /**
	 * 卖家款项汇总
	 * @author jph 20140709
	 * @return array
	 */
	public function collectByClass(){
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $where  = ' warehouse_id in ('.getUser('company_id').',0) ';
            $warehouse_id   = '/warehouse_id/'.getUser('company_id');
        }else{
            if(!empty($_POST['warehouse_id'])){
                $where  = ' warehouse_id in ('.$_POST['warehouse_id'].',0) ';
                $warehouse_id   = '/warehouse_id/'.$_POST['warehouse_id'];
            }
        }
		$sql = 'select income_type,pay_class_id,paid_date,currency_id,comp_id as factory_id,basic_id,warehouse_id,object_type,
			sum(round(original_money, ' . C('MONEY_LENGTH') . ')+if(object_type=102,round(discount_money, ' . C('MONEY_LENGTH') . '),0)) as original_money,
			sum(round(if(object_type=132,-1*discount_money,discount_money), ' . C('MONEY_LENGTH') . ')) as discount_money,
			sum(round(should_paid, ' . C('MONEY_LENGTH') . ')) as should_paid,
			sum(if(income_type<0,0,round(original_money, ' . C('MONEY_LENGTH') . ')+if(object_type=102,round(discount_money, ' . C('MONEY_LENGTH') . '),0))) as have_paid,
			sum(if(income_type<0,round(need_paid, ' . C('MONEY_LENGTH') . '),round(have_paid, ' . C('MONEY_LENGTH') . '))) as need_paid,
			sum(if(income_type>0,round(need_paid, ' . C('MONEY_LENGTH') . '),0)) as use_paid,
			sum(round(should_paid, ' . C('MONEY_LENGTH') . ')*income_type*-1) as money
			from client_paid_detail where '._search($where).' and object_type!=129 group by comp_id,paid_date,pay_class_id,currency_id,basic_id order by paid_date asc,is_close desc, paid_id asc';
		$sql_total = 'select income_type,pay_class_id,paid_date,currency_id,comp_id as factory_id,basic_id,warehouse_id,
			sum(if(income_type<0,round(original_money, ' . C('MONEY_LENGTH') . ')+if(object_type=102,round(discount_money, ' . C('MONEY_LENGTH') . '),0),if(object_type=132,-need_paid,0))) as original_money,
			sum(round(if(object_type=132,-1*discount_money,discount_money), ' . C('MONEY_LENGTH') . ')) as discount_money,
			sum(round(if(object_type=103,original_money,if(object_type=121,original_money,0)), ' . C('MONEY_LENGTH') . ')) AS have_paid,
			sum(round(if(object_type=103, need_paid,original_money), ' . C('MONEY_LENGTH') . ')*income_type*-1) AS money
			from client_paid_detail where '._search($where).' and object_type!=129 group by currency_id';
		$list		= _listStat($sql);
		if(empty($list)) return array();
		$sum_need_paid = 0;
		$url	= '/ClientStat/view/type/1/for_type/1/show_type/page';
		foreach ($list as &$value) {
			$value['url']	= U($url . '/from_paid_date/' . $value['paid_date'] . '/to_paid_date/' . $value['paid_date'] . '/pay_class_id/' . $value['pay_class_id'] . '/comp_id/' . $value['factory_id'] . '/currency_id/' . $value['currency_id'] . '/basic_id/' . $value['basic_id'].$warehouse_id);
			if ($value['income_type'] == 1) {
				//应付款
				if($value['object_type'] == 132){
					$sum_need_paid				-= $value['original_money'] ;
					$value['original_money']	= -$value['should_paid'];
					$value['have_paid'] = 0;
				}else{
				//已收款
					$value['have_paid']			= $value['original_money'];
					$value['original_money'] = 0;
					$sum_need_paid				-= $value['should_paid'];
				}
			}else {
				//应收款
                $value['have_paid']			= 0;
                $sum_need_paid				+= $value['should_paid'];
            }
			$value['sum_need_paid']		= $sum_need_paid;
		}
		$rs									=  _formatList($list);
		$rs['total']['dml_sum_need_paid']	= moneyFormat($sum_need_paid, 0, C('MONEY_LENGTH'));
		$rs['all_total']					= _listStatTotal($sql_total);
		return $rs;
	}

	 /**
	 * 取明细数据
	 *
	 * @return array
	 */
	public function getDetail($info){
		$comp_id	=	$info['comp_id']?$info['comp_id']:$info['client_id'];
		if ($comp_id>0){
			$remind_day	=	SOnly('company_expand',intval($comp_id), 'remind_day');
			$today = date("Y-m-d");
			if ($remind_day>0){
				$this->sqlFields	= ' ,if(datediff(\''.$today.'\',paid_date)>'.$remind_day.' && income_type=-1 and need_paid>0 and is_close=0 ,2,1) as tr_color	';
			}else{
				$this->sqlFields	= ' ,1 as tr_color ';
			}
		}
		$where = array(
			'comp_id='.$comp_id,///客户
			'currency_id='.$info['currency_id'],///币种
			'basic_id='.$info['basic_id'],///公司
		);
		if (!empty($info['pay_class_id'])) {
			$where[] = 'pay_class_id=\''.(int)$info['pay_class_id'].'\'';
		}
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $where[] = 'warehouse_id in ('.getUser('company_id').',0)';
        }elseif(!empty($info['warehouse_id'])){//added yyh 20150119 查询条件添加仓库
            $where[] = 'warehouse_id in ('.(int)$info['warehouse_id'].',0)';
        }
		$where      = implode(' and ',$where);
		$where      .= _getWhereDate($info);	//日期特殊处理
		$source_type = intval($info['type']);
		switch ($source_type){
			case 2:
				/// 上次平帐后
				$list = $this->afterList($where,$info);
				break;
			case 3:
				/// 全部款项
				$list = $this->closeOutList($where);
				break;
			case 4:
				/// 未结清款项
				$list = $this->closeOutBetweenList($where);
				break;
            case 5:
                $list = $this->closeOutSaleList($where);
                break;
			case 1:
			default :
				/// 未结清款项
				$list = $this->afterHavePaidList($where);
				break;
		}
		if(C('delivery.show_delivery_status')==1 && C('sale.relation_sale_follow_up')==1){
			$list = $this->getSaleOrderState($list);
		}
		return $list;
	}

	 /**
	 * 上次对账后的所有款项信息
	 *
	 * @param string $where
	 * @return array
	 */
	public function afterList($where,$info){
		!$info['to_paid_date'] && $where    .= ' and is_close=0';
		$sql = 'select *'.$this->sqlFields.' from client_paid_detail where '.$where.' order by paid_date asc';
		if($info['sent_email']==1 || $_GET['for_type']==2){
			$list =	$this->db->query($sql);
		}else{
			$list =	_listStat($sql);
		}
		if(empty($list)) return array();
		$list	= $_GET['for_type']==2?$this->regroupAfterListForType($list,$info):$this->regroupAfterListForDate($list,$info);
		if($info['sent_email']<>1 && $_GET['for_type']<>2){
			///发送邮件不需要再次查询总合计。
			$sql_total = 'select
							sum(if(income_type<0,original_money,0)) as original_money,
							sum(discount_money) as discount_money,
							sum(should_paid) as should_paid,
							sum(if(income_type<0,0,original_money)) as have_paid,
							sum(if(income_type<0,need_paid,have_paid)) as need_paid,
							sum(if(income_type>0,need_paid,0)) as use_paid,
							sum(need_paid*income_type*-1) as money
						from client_paid_detail where '.$where.' order by paid_date asc';
			$list['all_total']	= _listStatTotal($sql_total);
		}
		return $list;
	}

	public function SaleOrderDetail($ids){
			$list   = M('sale_order_detail')
                    ->join('left join delivery_detail on sale_order_detail.id=delivery_detail.sale_order_detail_id')
                    ->join('sale_order on sale_order.id=sale_order_detail.sale_order_id')
                    ->field('
                         sale_order_detail.product_id,sale_order_detail.color_id,sale_order_detail.size_id,sale_order_detail.warehouse_id,sale_order_detail.sale_order_id,ifnull(delivery_detail.id,0) as delivery_detail_id,sale_order.sale_order_state,
                        if(delivery_detail.id>0,delivery_detail.quantity,sale_order_detail.quantity) as quantity,
                        if(delivery_detail.id>0,delivery_detail.capability,sale_order_detail.capability) as capability,
                        if(delivery_detail.id>0,delivery_detail.dozen,sale_order_detail.dozen) as dozen,
                        if(delivery_detail.id>0,delivery_detail.price,sale_order_detail.price) as price,
                        if(delivery_detail.id>0,delivery_detail.discount,sale_order_detail.discount) as discount,
                        sale_order.currency_id')
                    ->where('sale_order_detail.sale_order_id in('.implode(',',$ids).')')->order('delivery_detail.id desc')->select();

            foreach($list as $key=>&$val){
				///判断是否有发货，只要有发货记录则只显示发货的销售明细，不显示销售单的销售明细
				if(!isset($delivery_sale_order_list['sale_order_id']) && $val['delivery_detail_id']>0){
					$delivery_sale_order_list[$val['sale_order_id']] = true;
				}
				if($val['quantity']==0 || ($delivery_sale_order_list[$val['sale_order_id']] && $val['delivery_detail_id'] == 0)){
					unset($list[$key]);
					continue;
				}
                $list[$key]['sum_qua']		= $val['quantity'];
                $list[$key]['sum_cap']		= $val['sum_cap'];
                $list[$key]['sum_quantity'] = $val['quantity']*$val['capability']*$val['dozen'];
                $list[$key]['money']		= $val['quantity']*$val['capability']*$val['dozen']*$val['price'];
                $list[$key]['discount_money'] =$val['quantity']*$val['capability']*$val['dozen']*$val['price']*$val['discount'];
                $list[$key]['discount']		= (1-$val['discount'])*100;
            }
			return $list;
	}

	/**
	 * 所有欠款分组显示
	 *
	 * @param string $where
	 * @return array
	 */
	public function closeOutBetweenList($where){
        $where    .= ' and should_paid<>0';
		$sql = 'select `object_id`, `object_type`, `pay_class_id`, `relation_type`, `basic_id`, `paid_id`, `paid_date`, `paid_type`, `comp_id`, `income_type`, `billing_type`, `quantity`, `price`,if(object_type=132,-1*discount_money,discount_money) AS discount_money, `currency_id`, `prototype_currency_type`, `account_no`, round(`have_paid`, ' . C('MONEY_LENGTH') . ') as have_paid, round(`need_paid`, ' . C('MONEY_LENGTH') . ') as need_paid, `state`, `is_close`, `object_type_extend`, `operate_id`, `record_num`, `befor_rate`, `comments`'.$this->sqlFields.',(round(original_money, ' . C('MONEY_LENGTH') . ')+if(object_type=102,round(discount_money, ' . C('MONEY_LENGTH') . '),0)) as original_money,round(should_paid, ' . C('MONEY_LENGTH') . ') as should_paid,warehouse_id
		from client_paid_detail where '.$where.' and object_type!=129 order by paid_date asc,is_close desc, paid_id asc';///按照日期在按照打包关系排列lee 110916

		$sql_total = 'select
			sum(round(if(income_type=1,if(object_type=132,-need_paid,0),original_money+discount_money), ' . C('MONEY_LENGTH') . ')) as original_money,
			sum(round(if(object_type=132,-1*discount_money,discount_money), ' . C('MONEY_LENGTH') . ')) AS discount_money,
			sum(round(should_paid, ' . C('MONEY_LENGTH') . ')) as should_paid,
			sum(round(if(object_type=103,original_money,if(object_type=121,original_money,0)), ' . C('MONEY_LENGTH') . ')) AS have_paid,
			sum(if(income_type<0,round(need_paid, ' . C('MONEY_LENGTH') . '),round(have_paid, ' . C('MONEY_LENGTH') . '))) as need_paid,
			sum(if(income_type>0,round(need_paid, ' . C('MONEY_LENGTH') . '),0)) as use_paid,
			sum(round(if(object_type=103, need_paid,original_money), ' . C('MONEY_LENGTH') . ')*income_type*-1) AS money
			from client_paid_detail where '.$where.' and object_type!=129';///按照日期在按照打包关系排列lee 110916
		$list		= _listStat($sql);
		if(empty($list)) return array();
		$sum_need_paid = 0;
		$is_close = -1;
		$total = array();
		foreach ($list as &$value) {
			$value['total_original_money'] = $value['total_original_money'];
			if ($value['income_type']==1) {
				//应付款
				$value['use_paid']			= $value['have_paid'];
				if($value['object_type'] == 132){
					$sum_need_paid				-= $value['original_money'] ;
					$value['original_money']	= -$value['need_paid'];
				}else{
					//已收款
					$value['have_paid']			= $value['original_money'];
					$sum_need_paid				-= $value['need_paid'] ;
					$value['need_paid'] = $value['original_money'] = 0;
				}
			}else {
				//应收款
                $value['use_paid']			= 0;
                $sum_need_paid				+= $value['need_paid'];
			}
			$value['sum_need_paid']		= $sum_need_paid;
			/// 生成备注
			$value = $this->objectTypeCommentSubsidiary($value);
			$total[$is_close]['total_original_money'] 	+= $value['original_money'];
			$total[$is_close]['total_have_paid'] 		+= $value['have_paid'];
			$total[$is_close]['total_discount_money'] 	+= $value['discount_money'];
			$total[$is_close]['total_sum_need_paid'] 	 = moneyFormat($sum_need_paid,0,C('MONEY_LENGTH'));
			$total[$is_close]['close_date'] 			 = $value['paid_date'];
		}
		foreach ($list as &$value) {
			$value['total_original_money'] 	= $total[$value['is_close']]['total_original_money'];
			$value['total_have_paid'] 		= $total[$value['is_close']]['total_have_paid'];
			$value['total_discount_money'] 	= $total[$value['is_close']]['total_discount_money'];
			$value['total_sum_need_paid'] 	= $total[$value['is_close']]['total_sum_need_paid'];
			$value['close_date'] 			= $total[$value['is_close']]['close_date'];
		}
		$list = _formatList($list);

		foreach ($list['list'] as &$value2) {
			$value2['title'] 	= '“'.$value2['comp_name'].'('.$value2['dd_currency_id'].')”于“'.$value2['fmd_close_date'].'”前的欠款明细：';
			$last_sum_need_paid	= $value2['dml_sum_need_paid'];
		}
		$list['total']['total_sum_need_paid']	=	$last_sum_need_paid;
		$list['all_total']						= _listStatTotal($sql_total);
		return $list;
	}

	/**
	 * 所有欠款分组显示
	 *
	 * @param string $where
	 * @return array
	 */
	public function closeOutList($where){

		$_REQUEST ['listRows'] = 1;
		$is_close_sql	= 'select distinct is_close as is_close from client_paid_detail where '.$where.' order by is_close';
		$is_close		= _listStat($is_close_sql);
		if(empty($is_close)) return array();
		$where  	.= ' and is_close = '.intval($is_close[0]['is_close']);
		$sql			= 'select *'.$this->sqlFields.'
							from client_paid_detail where '.$where.' order by paid_date asc';
		$list			= $this->db->query($sql);
		if(empty($list)) return array();
		return	 $_GET['for_type']==2?$this->regroupCloseOutListForType($list):$this->regroupCloseOutListForDate($list);

	}

	/**
	 * 对账后的所有款项信息(未被使用完的)
	 *
	 * @param string $where
	 * @return array
	 */
	public function afterHavePaidList($where){
		$where     .= ' and is_close=0 and need_paid<>0 ';
		$sql 		= 'select `object_id`,`warehouse_id`, `object_type`, `pay_class_id`, `relation_type`, `basic_id`, `paid_id`, `paid_date`, `paid_type`, `comp_id`, `income_type`, `billing_type`, `quantity`, `price`,if(object_type=132,-1*discount_money,discount_money) AS discount_money, `currency_id`, `prototype_currency_type`, `account_no`, round(`have_paid`, ' . C('MONEY_LENGTH') . ') as have_paid, round(`need_paid`, ' . C('MONEY_LENGTH') . ') as need_paid, `state`, `is_close`, `object_type_extend`, `operate_id`, `record_num`, `befor_rate`, `comments`'.$this->sqlFields.',(round(original_money, ' . C('MONEY_LENGTH') . ')+if(object_type=102,round(discount_money, ' . C('MONEY_LENGTH') . '),0)) as original_money,(round(should_paid, ' . C('MONEY_LENGTH') . ')+if(object_type=102,round(discount_money, ' . C('MONEY_LENGTH') . '),0)) as should_paid from client_paid_detail where '.$where.' order by paid_date asc, paid_id asc';
		$list		= $_GET['show_type'] == 'not_page'?$this->db->query($sql):_listStat($sql);
		if(empty($list)) return array();
		$list		= $_GET['for_type']==2?$this->regroupAfterHavePaidListForType($list):$this->regroupAfterHavePaidListForDate($list);
		//总合计
		if($_GET['show_type']<>'not_page'){
			$sql_total 	= "	SELECT
								sum(round(if(income_type=1,if(object_type=132,-need_paid,0),original_money+discount_money), " . C('MONEY_LENGTH') . ")) as original_money,
								sum(round(if(object_type=132,-1*discount_money,discount_money), " . C('MONEY_LENGTH') . ")) AS discount_money,
								sum(round(if(object_type=103,original_money,if(object_type=121,original_money,0)), " . C('MONEY_LENGTH') . ")) AS have_paid,
								sum(round(if(object_type=103,need_paid,original_money), " . C('MONEY_LENGTH') . ")*income_type*-1) AS need_paid
							FROM client_paid_detail WHERE ".$where;
			$all_total	= $this->db->query($sql_total);
			$list['all_total']['original_money']	= $all_total[0]['original_money'];
			$list['all_total']['discount_money']	= $all_total[0]['discount_money'];
			$list['all_total']['have_paid']			= $all_total[0]['have_paid'];
			$list['all_total']['need_paid']			= $all_total[0]['need_paid'];
			$list['all_total'] = _formatArray($list['all_total']);
		}
		return $list;
	}

   private function getCloseOutSaleListWhere($where){

            switch(intval($_GET['relation_type'])){
                case 1:
                    $where  .=' and is_close=0';
                    $where  .=' and need_paid<>0';
                    break;
                case 2:
                    $where  .=' and is_close=0';
                    break;
                case 3:
                default:
                    break;
            }
            return $where;
        }

    private function closeOutSaleList($where){
        $where  = $this->getCloseOutSaleListWhere($where);
        //未付款销售单
        $sale_order_id	= M('ClientPaidDetail')->where(implode(' and ', $where) .'  and object_type=120')->order('paid_date')->getField('object_id', true);
        if(empty($sale_order_id)){
            return array();
        }
        $sql    = "select * from sale_order where id in (".  implode(',', $sale_order_id)." )";
        $info   = _formatList(M()->query($sql));
        foreach($info['list'] as $key=>$val){
            $tmp[$val['id']]    = $val;
            $pr_money   += $val['pr_money'];
        }
        $info   = $tmp;
//            echo '<pre>';print_r($tmp);exit;
        //销售明细  有发货取发货明细
        $sql    = "select a.product_id,a.color_id,a.size_id,a.warehouse_id,a.sale_order_id,
            if(b.id>0,b.quantity,a.quantity) as quantity,
            if(b.id>0,b.capability,a.capability) as capability,
            if(b.id>0,b.dozen,a.dozen) as dozen,
            if(b.id>0,b.price,a.price) as price,
            if(b.id>0,b.discount,a.discount) as discount,
            c.currency_id
            from sale_order_detail a left join  delivery_detail b on a.id=b.sale_order_detail_id inner join sale_order c on a.sale_order_id=c.id
            where a.sale_order_id in (".  implode(',', $sale_order_id).") group by a.id";
        $list   = M()->query($sql);
        foreach($list as $key=>$val){
            $val['sum_quantity'] = $val['quantity']*$val['capability']*$val['dozen'];
            $val['money']    = $val['quantity']*$val['capability']*$val['dozen']*$val['price']*$val['discount'];
            $val['discount'] = (1-$val['discount'])*100;
            $info[$val['sale_order_id']]['detail'][]  = _formatArray($val);
            $info[$val['sale_order_id']]['sum_quantity']    += $val['quantity'];
            $info[$val['sale_order_id']]['total_quantity']    += $val['sum_quantity'];
            $info[$val['sale_order_id']]['money']           += $val['money'];
        }
        unset($list);
        $list['list']   = $info;
        foreach($list['list'] as $key=>$val){
            $list['list'][$key]['account_money']    = $val['money']-$val['pr_money'];
            $list['list'][$key]['dml_account_money']= moneyFormat($list['list'][$key]['account_money'],0,C('MONEY_LENGTH'));
            $list['list'][$key]['dml_money']= moneyFormat($list['list'][$key]['money'],0,C('MONEY_LENGTH'));
            $list['list'][$key]['detail'] = _formatList($list['list'][$key]['detail']);
            $list['list'][$key]['dml_sum_quantity'] = moneyFormat($val['sum_quantity'],0,C('MONEY_LENGTH'));
            $list['list'][$key]['dml_total_quantity']=moneyFormat($val['total_quantity'],0,C('MONEY_LENGTH'));
            $list['total']['money']         += $list['list'][$key]['money'];
            $list['total']['account_money'] += $list['list'][$key]['account_money'];
            $list['total']['sum_quantity']      += $val['sum_quantity'];
            $list['total']['total_quantity']  += $val['total_quantity'];
        }
        $list['total']['pr_money']  = $pr_money;
        $list['total']['dml_pr_money']= moneyFormat($pr_money,0,C('MONEY_LENGTH'));
        $list['total']['dml_money'] = moneyFormat($list['total']['money'],0,C('MONEY_LENGTH'));
        $list['total']['dml_account_money'] = moneyFormat($list['total']['account_money'],0,C('MONEY_LENGTH'));
        $list['total']['dml_quantity']= moneyFormat($list['total']['quantity'],0,C('MONEY_LENGTH'));
        $list['total']['dml_total_quantity']= moneyFormat($list['total']['total_quantity'],0,C('MONEY_LENGTH'));
        $list['total']['dml_sum_quantity']= moneyFormat($list['total']['sum_quantity'],0,C('MONEY_LENGTH'));
        return $list;
    }


    /**
     * 返回是否已经发货
     *
     * @param array $rs  销售数据
     * @return array 发货数量
     */
    public function getSaleOrderState(&$rs) {
        ///如果是全部款项则只需要判断最后一组的欠款即可，因为前面平账或者对账的前提是销售单已经全部发货
        if($rs['group_list']){
            $list		= &$rs['group_list'][0];
        }else{
            $list = &$rs['list'];
        }
        foreach ($list as $k => $v) {
            if($v['object_type'] == '120'){
                $sale_order_id[$k] = $v['object_id'];
            }
        }
        if (!empty($sale_order_id)){
            $delivery_state = M('SaleOrder')
                            ->where('id in ('.implode(',', $sale_order_id).')')
                            ->getField('id,sale_order_state');
            foreach ($sale_order_id as $k => $v) {
                $list[$k]['sale_order_state'] = $delivery_state[$v];
            }
        }
        return $rs;
    }
    /*
     * 未结清款项-按日期重组数据
     */
    public function regroupAfterHavePaidListForDate($list){
        $sum_need_paid = 0;
        foreach ($list as &$value) {
            if ($value['income_type'] == 1) {
				//应付款
				$value['use_paid']			= $value['have_paid'];
				if($value['object_type'] == 132){
					$sum_need_paid				-= $value['original_money'] ;
					$value['original_money']	= -$value['need_paid'];
				}else{
				//已收款
					$value['have_paid']			= $value['original_money'];
					$sum_need_paid				-= $value['need_paid'] ;
					$value['need_paid'] = $value['original_money'] = 0;
				}
			}else {
				//应收款
                $value['use_paid']			= 0;
                $sum_need_paid				+= $value['need_paid'];
               
            }
			$value['sum_need_paid']		= $sum_need_paid;
            /// 生成备注
            $value = $this->objectTypeCommentSubsidiary($value);
        }
        $list = _formatList($list);
        $list['total']['title']	 				= '“'.$list['list'][0]['comp_name'].'”'.L('in').'“'.$list['list'][0]['dd_basic_id'].'”'.L('de').'“'.$list['list'][0]['dd_currency_id'].'”'.L('funds_detail').'：';
        $list['total']['dml_sum_need_paid']		= moneyFormat($sum_need_paid,0,C('MONEY_LENGTH'));
        return $list;
    }
    /*
     * 未结清款项-按类型重组数据
     */
    public function regroupAfterHavePaidListForType($list){
        foreach ($list as $value) {
            /// 生成备注
            $value = $this->objectTypeCommentSubsidiary($value);
            $regroupInfo[$value['income_type']][] = $value;
        }
        $returnInfo['debt']						= _formatList($regroupInfo[-1]);
        $returnInfo['paid']						= _formatList($regroupInfo[1]);
        $returnInfo['total']['dml_should_paid']	= empty($returnInfo['debt']['total']['dml_need_paid'])?'0.00':$returnInfo['debt']['total']['dml_need_paid'];
        $returnInfo['total']['dml_have_paid']	= empty($returnInfo['paid']['total']['dml_need_paid'])?'0.00':$returnInfo['paid']['total']['dml_need_paid'];
        $returnInfo['total']['dml_need_paid']	= moneyFormat($returnInfo['debt']['total']['need_paid']-$returnInfo['paid']['total']['need_paid'],0,C('MONEY_LENGTH'));

        return $returnInfo;
    }
    /*
     * 全部款项-按日期重组数据
     */
    public function regroupCloseOutListForDate($list){
        $sum_need_paid	= 0;
        foreach ($list as &$value) {
            $sum_need_paid 				-= $value['income_type']*$value['should_paid'];
            $value['sum_need_paid']		= $sum_need_paid;
            if ($value['income_type']>0) {
                $value['have_paid']		= $value['original_money'];
                $value['should_paid']	= 0;
                $value['need_paid']		= 0;
            }else {
                $value['need_paid']		= $value['should_paid'];
                $value['have_paid']		= 0;
            }
            $value['original_money']	= 0;
            /// 生成备注
            $value = $this->objectTypeCommentSubsidiary($value);
            $close_date					= $value['paid_date'];
        }
        $list			= _formatList($list);
        $list['title']	= '“'.$list['list'][0]['comp_name'].'('.$list['list'][0]['currency_no'].')”于“'.$close_date.'”前的欠款明细：';
        $list['total']['dml_sum_need_paid']	= moneyFormat($sum_need_paid,0,C('MONEY_LENGTH'));
        return $list;
    }
    /*
     * 全部款项-按类型重组数据
     */
    public function regroupCloseOutListForType($list){
        foreach ($list as $value) {
            /// 生成备注
            $value = $this->objectTypeCommentSubsidiary($value);
            $regroupInfo[$value['income_type']][] = $value;
        }
        $returnInfo['debt']						= _formatList($regroupInfo[-1]);
        $returnInfo['paid']						= _formatList($regroupInfo[1]);
        $returnInfo['total']['dml_should_paid']	= empty($returnInfo['debt']['total']['dml_should_paid'])?'0.00':$returnInfo['debt']['total']['dml_should_paid'];
        $returnInfo['total']['dml_have_paid']	= empty($returnInfo['paid']['total']['dml_should_paid'])?'0.00':$returnInfo['paid']['total']['dml_should_paid'];
        $returnInfo['total']['dml_need_paid']	= moneyFormat($returnInfo['debt']['total']['should_paid']-$returnInfo['paid']['total']['should_paid'],0,C('MONEY_LENGTH'));
        return $returnInfo;
    }
    /*
     * 平账/对账后欠款-按日期重组数据
     */
    public function regroupAfterListForDate($list,$info){
        $sum_need_paid = 0;
        foreach ($list as $key => &$value) {
            if(C('client_stat_sent_email')==1 && $info['sent_email']==1 && $value['object_type']=='120' && $value['object_id']>0){
                $sale_order_id[$key] = $value['object_id'];
            }
            if ($value['income_type']==1) {
                $value['have_paid'] 		= $value['original_money'];
                $value['original_money'] 	= 0;
                $sum_need_paid 				-= $value['should_paid'];
                $value['sum_need_paid']		= $sum_need_paid;
            }else {
                $value['have_paid'] 		= 0;
                $sum_need_paid 				+= $value['should_paid'];
                $value['sum_need_paid']		= $sum_need_paid;
            }
            /// 生成备注
            $value = $this->objectTypeCommentSubsidiary($value);
        }
        //如果发货调用，则取销售单明细
        if($info['sent_email']==1 && count($sale_order_id)>0){
            //取销售单明细
            $sale_order_detail = _formatList($this->SaleOrderDetail($sale_order_id));
            //取销售单主表
            $main   = M('SaleOrder')->where('id in ('.implode(',', $sale_order_id).')')->formatFindAll(array('key'=>'id'));
            $sum_un_delivery_money = 0;
            foreach ($sale_order_detail['list'] as &$value) {
                ///根据销售单ID找到在LIST所对应的KEY
                $list_key = array_search($value['sale_order_id'],$sale_order_id);
                ///第一个的时候扣减预付款金额，接下来就不能再扣减
                if(!$list[$list_key]['sale_order_detail']['list']){
                    $main[$value['sale_order_id']]['account_money']  = $value['discount_money']-$main[$value['sale_order_id']]['pr_money'];
                    if($value['sale_order_state'] !=3){
                        $sum_un_delivery_money += $list[$list_key]['original_money'] - $list[$list_key]['discount_money'];
                    }
                }else{
                    $main[$value['sale_order_id']]['account_money'] += $value['discount_money'];
                }
                ///合计到数据中
                $list[$list_key]['sale_order_detail']['list'][]	= $value;
                $list[$list_key]['sale_order_detail']['total']['quantity']		+= $value['quantity'];
                $list[$list_key]['sale_order_detail']['total']['sum_quantity']	+= $value['sum_quantity'];
                $list[$list_key]['sale_order_detail']['total']['money']			+= $value['money'];
                $list[$list_key]['sale_order_detail']['total']['discount_money']+= $value['discount_money'];
                $list[$list_key]['sale_order_detail']['main']	= _formatArray($main[$value['sale_order_id']]);
                $list[$list_key]['sale_order_detail']['total']	= _formatArray($list[$list_key]['sale_order_detail']['total']);
            }
        }
        $list = _formatList($list);
        $list['total']['title']	 = '“'.$list['list'][0]['comp_name'].'”在“'.$list['list'][0]['dd_basic_id'].'”的“'.$list['list'][0]['dd_currency_id'].'”欠款明细：';
        $list['total']['total_sum_need_paid']		= moneyFormat($sum_need_paid,0,C('MONEY_LENGTH'));
        $list['total']['un_delivery_sale_money']	= moneyFormat($sum_un_delivery_money,0,C('MONEY_LENGTH'));
        return $list;
    }
    /*
     * 平账/对账后欠款-按日期重组数据
     */
    public function regroupAfterListForType($list,$info){
			foreach ($list as $value) {
				/// 生成备注
				$value = $this->objectTypeCommentSubsidiary($value);
				$regroupInfo[$value['income_type']][] = $value;
			}
			$returnInfo['debt']						= _formatList($regroupInfo[-1]);
			$returnInfo['paid']						= _formatList($regroupInfo[1]);
			$returnInfo['total']['dml_should_paid']	= empty($returnInfo['debt']['total']['dml_should_paid'])?'0.00':$returnInfo['debt']['total']['dml_should_paid'];
			$returnInfo['total']['dml_have_paid']	= empty($returnInfo['paid']['total']['dml_should_paid'])?'0.00':$returnInfo['paid']['total']['dml_should_paid'];
			$returnInfo['total']['dml_need_paid']	= moneyFormat($returnInfo['debt']['total']['should_paid']-$returnInfo['paid']['total']['should_paid'],0,C('MONEY_LENGTH'));
			return $returnInfo;
		}
}
?>