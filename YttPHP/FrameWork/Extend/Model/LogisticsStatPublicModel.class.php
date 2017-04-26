<?php 
/**
 * 物流应付款统计
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class LogisticsStatPublicModel extends AbsStatPublicModel { 
	 
	public $comp_type=2; 
	///字段列表
	private $sqlFields	=	'';		
	
	/**
	 * 取列表数据
	 *
	 * @param  array $info 查询参数
	 * @return array
	 */
	public function getDetail($info) {
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
		if (!empty($info['from_paid_date'])) {
			$where[] = 'paid_date>=\''.$info['from_paid_date'].'\'';
		}				
		if (!empty($info['to_paid_date'])) {
			$where[] = 'paid_date<=\''.$info['to_paid_date'].'\'';
		}
        if (!empty($info['warehouse_id'])) {
			$where[] = 'warehouse_id=\''.(int)$info['warehouse_id'].'\'';
		}
        $where      = implode(' and ',$where);
		$source_type = intval($info['type']); 
		switch ($source_type){
			case 2:
				/// 上次平帐后
				$list = $this->afterList($where,$info);
				break;
//			case 3:
//				/// 全部款项
//				$list = $this->closeOutList($where);
//				break;
			case 4:
				/// 未结清款项
				$list = $this->closeOutBetweenList($where);
				break;
//            case 5:
//                $list = $this->closeOutSaleList($where);
//                break;
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
    /**
	 * 所有欠款分组显示
	 *
	 * @param string $where
	 * @return array
	 */
	public function closeOutBetweenList($where){
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $where      .= ' and warehouse_id='.getUser('company_id');
        }
		$sql = 'select `object_id`, `object_type`, `pay_class_id`, `relation_type`, `basic_id`, `paid_id`, `paid_date`, `paid_type`, `comp_id`, `income_type`, `billing_type`, `quantity`, `price`, `discount_money`, `currency_id`, `prototype_currency_type`, `account_no`, `have_paid`, `need_paid`, `state`, `is_close`, `object_type_extend`, `operate_id`, `record_num`, `befor_rate`, `comments`'.$this->sqlFields.',(original_money+if(object_type=302,discount_money,0)) as original_money,should_paid,warehouse_id
		from logistics_paid_detail where '.$where.' and object_type!=129 order by paid_date asc,is_close desc';///按照日期在按照打包关系排列lee 110916
		
		$sql_total = 'select 
			sum(if(income_type<0,original_money+if(object_type=302,discount_money,0),0)) as original_money,
			sum(discount_money) as discount_money,
			sum(should_paid) as should_paid,
			sum(if(income_type<0,0,original_money+if(object_type=302,discount_money,0))) as have_paid,
			sum(if(income_type<0,need_paid,have_paid)) as need_paid,
			sum(if(income_type>0,need_paid,0)) as use_paid, 
			sum(should_paid*income_type*-1) as money 
			from logistics_paid_detail where '.$where.' and object_type!=129 order by paid_date asc,is_close desc';///按照日期在按照打包关系排列lee 110916
		$list		= _listStat($sql);
		if(empty($list)) return array();
		$sum_need_paid = 0;
		$is_close = -1;
		$total = array();
		foreach ($list as &$value) {
			$value['total_original_money'] = $value['total_original_money'];
			
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
	 * 对账后的所有款项信息(未被使用完的)
	 *
	 * @param string $where
	 * @return array
	 */
	public function afterHavePaidList($where){
		$where      .= ' and is_close=0 and need_paid<>0 '; 
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $where  .= ' and warehouse_id='.getUser('company_id');
        }
		$sql 		= 'select `object_id`,`warehouse_id`, `object_type`, `pay_class_id`, `relation_type`, `basic_id`, `paid_id`, `paid_date`, `paid_type`, `comp_id`, `income_type`, `billing_type`, `quantity`, `price`, `discount_money`, `currency_id`, `prototype_currency_type`, `account_no`, `have_paid`, `need_paid`, `state`, `is_close`, `object_type_extend`, `operate_id`, `record_num`, `befor_rate`, `comments`'.$this->sqlFields.',(original_money+if(object_type=302,discount_money,0)) as original_money,(should_paid+if(object_type=302,discount_money,0)) as should_paid from logistics_paid_detail where '.$where.' order by paid_date asc';
		$list		= $_GET['show_type'] == 'not_page'?$this->db->query($sql):_listStat($sql);
		if(empty($list)) return array();
		$list		= $_GET['for_type']==2?$this->regroupAfterHavePaidListForType($list):$this->regroupAfterHavePaidListForDate($list);
		//总合计
		if($_GET['show_type']<>'not_page'){
			$sql_total 	= 'select
								income_type,
								sum(original_money+if(object_type=302,discount_money,0)) as original_money,
								sum(discount_money) as discount_money,
								sum(should_paid+if(object_type=302,discount_money,0)) as should_paid,
								sum(have_paid) as have_paid,
								sum(need_paid) as need_paid
								from logistics_paid_detail where '.$where.' group by income_type';
			$all_total	= $this->db->query($sql_total);
			$list['all_total']['should_paid']		= 0;
			$list['all_total']['original_money']	= 0;
			foreach((array)$all_total as $value){
				if($value['income_type']>0){
					$list['all_total']['have_paid']			+= $value['need_paid']-$value['discount_money'];	
				}else{
					$list['all_total']['should_paid']		= $value['need_paid'];
					$list['all_total']['have_paid']			+= $value['have_paid'];
					$list['all_total']['original_money']	= $value['original_money'];
				}
				$list['all_total']['discount_money']	+= $value['discount_money'];
				$list['all_total']['need_paid']			-= $value['income_type']*$value['need_paid'];
			}
			$list['all_total'] = _formatArray($list['all_total']);
		}
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
		 * 未结清款项-按日期重组数据
		 */
		public function regroupAfterHavePaidListForDate($list){
			$sum_need_paid = 0;
			foreach ($list as &$value) {
				if ($value['income_type']>0) {
					$value['use_paid']			= $value['have_paid'];
					$value['have_paid']			= $value['need_paid']-$value['discount_money'];
					$sum_need_paid				-= $value['need_paid'];
					$value['sum_need_paid']		= $sum_need_paid;
					$value['need_paid']			= $value['original_money'] = 0; 
				}else {
					$value['use_paid']			= 0;
					$sum_need_paid				+= $value['need_paid'];
					$value['sum_need_paid']		= $sum_need_paid;
				}
				/// 生成备注
				$value = $this->objectTypeCommentSubsidiary($value);	 
			}
			$list = _formatList($list);
			$list['total']['title']	 				= '“'.$list['list'][0]['comp_name'].'”'.L('in').'“'.$list['list'][0]['dd_basic_id'].'”'.L('de').'“'.$list['list'][0]['dd_currency_id'].'”'.L('funds_detail').'：';
			$list['total']['dml_sum_need_paid']		= moneyFormat($sum_need_paid,0,C('MONEY_LENGTH'));
			return $list;
		}
        
	/**
	 * afterList
	 *
	 * @param array $info
	 * @return array
	 */
	public function afterList($where) {
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $where      .= ' and warehouse_id='.getUser('company_id');
        }
		$model	=	M('logistics_paid_detail');   
		$model->_sortBy =' paid_date ';		
		$model->_asc 	= true; 
 		$opert['where']			=	$where.' and is_close=0 ';   
		$opert['field']			=	'*';	  
		$opert['order']			=	'paid_date';	  
		///格式化+获取列表信息 
		$list	=	_formatList($model->field($opert['field'])->where($opert['where'])->order($opert['order'])->select());
		return	$list;	
	}
	 
	/**
	 * 未结清的款项
	 *
	 * @param array $info
	 * @return array
	 */
	public function UnPaidList($where) {
		$sql	= 'select * '.$this->sqlFields.$this->fundsField().'				
					from logistics_paid_detail 
					where is_close=0 and need_paid!=0 and '.$where.' 
					order by is_close desc ,paid_date asc,paid_id asc';		
		$list	=	_listStat($sql); 
		
		$sql_total = 'select 
			sum(if(income_type<0,original_money,0)) as original_money,
			sum(discount_money) as discount_money,
			sum(should_paid) as should_paid,
			sum(if(income_type<0,have_paid,original_money)) as have_paid,
			sum(if(income_type<0,need_paid,have_paid)) as need_paid,
			sum(if(income_type>0,need_paid,0)) as use_paid, 
			sum(need_paid*income_type*-1) as money
		from logistics_paid_detail 
					where   is_close=0 and need_paid!=0 and '.$where;
		$totalList	= _formatList($this->db->query($sql_total));  
		
		if (empty($list)) return ;	
		$sum_need_paid = 0;		
		foreach ($list as &$value) {
			if ($value['income_type']==1) { ///付款
				$sum_need_paid 			-= $value['need_paid'];
				$value['sum_need_paid']	= $sum_need_paid;
				$value['use_paid']		= $value['need_paid'];
				$value['have_paid'] 	= $value['original_money'];
				$value['need_paid']		= $value['original_money'] = 0;	 				
			}else { /// 欠款
				$value['use_paid']		= 0;
				$sum_need_paid 			+= $value['need_paid'];
				$value['sum_need_paid']	= $sum_need_paid;
			}	
			/// 生成备注
			$value = $this->objectTypeCommentSubsidiary($value);			
		}		
		$list = _formatList($list);			
		$list['total']['total_sum_need_paid'] = moneyFormat($value['sum_need_paid'], 0, C('MONEY_LENGTH'));
		$list['all_total']						= $totalList['list'][0];  	///合计	   
		return $list;
	}
	 
	/**
	 * 平账后的所有款项信息
	 *
	 * @param array $info 查询参数
	 * @return array
	 */
	public function afterCloseOutList($where) {
		$sql = 'select * '.$this->sqlFields.' 
				from logistics_paid_detail 
				where  should_paid!=0 and is_close=0 and '.$where.'
				order by paid_date asc,paid_id asc';	
		$list =	_listStat($sql); 
		
		$sql_total = 'select 
			sum(if(income_type<0,original_money,0)) as original_money,
			sum(discount_money) as discount_money,
			sum(should_paid) as should_paid,
			sum(if(income_type<0,0,original_money)) as have_paid,
			sum(if(income_type<0,need_paid,have_paid)) as need_paid,
			sum(if(income_type>0,need_paid,0)) as use_paid, 
			sum(need_paid*income_type*-1) as money
		from logistics_paid_detail 
				where  should_paid!=0 and '.$where.'
				 ';	
		$totalList	= _formatList($this->db->query($sql_total));  

		if (empty($list)) return ;	
		foreach ($list as &$value) {
			if ($value['income_type']==1) { ///付款
				$sum_need_paid 			-= $value['should_paid'];
				$value['sum_need_paid']	= $sum_need_paid;				
				$value['have_paid'] 	= $value['original_money'];
				$value['need_paid']		= $value['original_money'] = 0;				
			}else {	/// 欠款			
				$sum_need_paid 			+= $value['should_paid'];
				$value['have_paid']		= 0;
				$value['sum_need_paid']	= $sum_need_paid;
			}	
			/// 生成备注
			$value = $this->objectTypeCommentSubsidiary($value);			
		}			
		$list = _formatList($list);
		$list['total']['total_sum_need_paid'] = moneyFormat($value['sum_need_paid'], 0, C('MONEY_LENGTH'));				
		$list['all_total']					  = $totalList['list'][0];  	///合计	   
		return $list;
	}	
	 
	/**
	 * 平账后的所有款项信息
	 *
	 * @param array $info
	 * @return array
	 */
	public function afterCloseOutBetweenList($where) {
		$sql = 'select * '.$this->sqlFields.' 
				from logistics_paid_detail 
				where should_paid!=0 and is_close=0 and object_type !=229 and '.$where.'
				order by paid_date asc,paid_id asc';	
		$list	=	_listStat($sql); 		 

		$sql_total = 'select 
			sum(if(income_type<0,original_money,0)) as original_money,
			sum(discount_money) as discount_money,
			sum(should_paid) as should_paid,
			sum(if(income_type<0,0,original_money)) as have_paid,
			sum(if(income_type<0,need_paid,have_paid)) as need_paid,
			sum(if(income_type>0,need_paid,0)) as use_paid, 
			sum(need_paid*income_type*-1) as money
		from logistics_paid_detail 
				where  should_paid!=0 and is_close=0 and object_type !=229 and '.$where;	
		$totalList	= _formatList($this->db->query($sql_total));  
		 
		if (empty($list)) return ;	
		foreach ($list as &$value) {
			if ($value['income_type']==1) { ///付款
				$sum_need_paid 			-= $value['should_paid'];
				$value['sum_need_paid']	= $sum_need_paid;				
				$value['have_paid'] 	= $value['original_money'];
				$value['need_paid']		= $value['original_money'] = 0;				
			}else {	/// 欠款			
				$sum_need_paid 			+= $value['should_paid'];
				$value['have_paid']		= 0;
				$value['sum_need_paid']	= $sum_need_paid;
			}	
			/// 生成备注
			$value = $this->objectTypeCommentSubsidiary($value);			
		}			
		$list = _formatList($list);
		$list['total']['total_sum_need_paid'] = moneyFormat($value['sum_need_paid'], 0, C('MONEY_LENGTH'));		 	
		$list['all_total']					  = $totalList['list'][0];  	///合计	   
		return $list;
	}	
		 
	/**
	 * 欠款明细分组显示(全部欠款明细)
	 *
	 * @param array $info 查询参数
	 * @return array 
	 */
	public function AllList($where){
		///取平帐及对帐日期		
		$sql	= ' select * '.$this->sqlFields.' from (
					select *,if(is_close=0, 99999, is_close) as order_is_close
		 			from logistics_paid_detail 
		 			where   should_paid !=0 and '.$where.'
		 			) b 
		 			order by order_is_close asc,paid_date asc,paid_id asc';	
		$list	=	_listStat($sql); 		   	
		$sql_total = 'select 
			sum(if(income_type<0,original_money,0)) as original_money,
			sum(discount_money) as discount_money,
			sum(should_paid) as should_paid,
			sum(if(income_type<0,0,original_money)) as have_paid,
			sum(if(income_type<0,need_paid,have_paid)) as need_paid,
			sum(if(income_type>0,need_paid,0)) as use_paid, 
			sum(need_paid*income_type*-1) as money
			  from (
					select *,if(is_close=0, 99999, is_close) as order_is_close
		 			from logistics_paid_detail 
		 			where   should_paid !=0 and '.$where.'
		 			) b 
		 			order by order_is_close asc,paid_date asc,paid_id asc';
		$totalList	= _formatList($this->db->query($sql_total));  
			
		if (empty($list)) return ;				
		$is_close = 0;
		foreach ($list as $k =>  &$value) {
			/// 设置分组
			if ($is_close!=$value['is_close']) {
				$sum_need_paid 	= 0;
				!$value['is_close'] && $temp[$value['is_close']] = $temp[$is_close];	
				$is_close		= $value['is_close'];										
			}	
			/// 产生分组头所需的数据
			if (in_array($value['object_type'], array(204,229))) {
				$temp[$is_close] = array('paid_date' => $value['paid_date'], 'object_type' => $value['object_type']);	
			}			
			if ($value['income_type']==1) {/// 付款
				$value['have_paid'] 		= $value['original_money'];
				$value['original_money'] 	= 0;
				$sum_need_paid 				-= $value['should_paid'];
				$value['sum_need_paid']		= $sum_need_paid;
			}else { /// 欠款
				$value['have_paid'] 		= 0;
				$sum_need_paid 				+= $value['should_paid'];
				$value['sum_need_paid']		= $sum_need_paid;
			}						
			/// 生成备注
			$value = $this->objectTypeCommentSubsidiary($value);	
			/// 合计部分
			$sum[$is_close]['total_original_money'] += $value['original_money'];
			$sum[$is_close]['total_have_paid'] 		+= $value['have_paid'];
			$sum[$is_close]['total_discount_money'] += $value['discount_money'];
			$sum[$is_close]['sum_need_paid'] 		= $sum_need_paid;
		}				
			
		$list = _formatList($list);	
		$total_sum_need_paid = moneyFormat($value['sum_need_paid'], 0, C('MONEY_LENGTH'));		
		foreach ($list['list'] as $k =>  &$value)	{
			$value['total_original_money'] = moneyFormat($sum[$value['is_close']]['total_original_money'],0,C('MONEY_LENGTH'));
			$value['total_have_paid']	   = moneyFormat($sum[$value['is_close']]['total_have_paid'],0,C('MONEY_LENGTH'));
			$value['total_discount_money'] = moneyFormat($sum[$value['is_close']]['total_discount_money'],0,C('MONEY_LENGTH'));
			$value['total_sum_need_paid']  = moneyFormat($sum[$value['is_close']]['sum_need_paid'],0,C('MONEY_LENGTH'));				
			/// 生成分组明细的标题
			if (empty($temp)) { /// 无平帐
				$value['title'] = $value['comp_name'].$value['dd_currency_id'].L('arrearage_details');
			} else { /// 有平帐				
				$ext_title = $temp[$value['is_close']]['object_type'] == 204 ? '' : '';				
///				$ext_title = $temp[$value['is_close']]['object_type'] == 204 ? L('closeout') : L('checkout');				
				$ext_title.= !$value['is_close'] ? L('aft_arrearage_details') : L('bef_arrearage_details');				
				$value['title'] = $value['comp_name'].$value['dd_currency_id'].formatDate($temp[$value['is_close']]['paid_date'], 'outdate').$ext_title;
			} 
			$list['group_list'][$value['is_close']][]	=	$value;
		}
		$list['all_total']						= $totalList['list'][0];  	///合计	      
		return $list;
	}
	
	/**
	 * 取列表数据
	 *
	 * @param  array $info 查询参数
	 * @return array
	 */
	public function getIndex() {
		if (!empty($_POST['date']['from_paid_date']) && !empty($_POST['date']['to_paid_date'])){
			$money = '(should_paid)*income_type'; 
			$having = $_POST['show']==1 ? '' : ' having(total_need_paid!=0)';
			$s_where = 'object_type!=229';			
		}else{
			if ($_POST['date']['lt_paid_date']) {
				$money = '(original_money+discount_money)*income_type';
				$s_where = 'object_type!=229';			
			} else {
				$money = 'need_paid*income_type';
				$s_where = $_POST['show']==1 ? '( is_close=0 or (  is_close>0 and object_type= 203 and object_type_extend=3 ) )' : 'is_close=0 and need_paid!=0';  
			}	
			if(!$_POST['show']) { /// 不显示己结清的厂家 
				$having = " having total_need_paid !=0";
			}		
		}
		
		$where = _search($s_where);		
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $where  .= ' and warehouse_id='.getUser('company_id');
        }
		$sql_field =  'select basic_id,company.*,comp_id,currency_id,-sum('.$money.') as total_need_paid,warehouse_id,
							-sum(if(object_type=221,need_paid*income_type,0)) as total_on_road '.$this->fundsField().'
							from logistics_paid_detail left join company on company.id=logistics_paid_detail.comp_id			
							where  '.$where.' ';
		$sql_group	=  ' group by comp_id,currency_id'.$having.'
							order by comp_id ';	
		$sql_group_total	=  ' group by currency_id'.$having.'  ';
		$sql				=	$sql_field.$sql_group;	 
//		$list = $this->db->query($sql);	
		$list	= _listStat($sql);  
		if (empty($list)) return ;	
		$list = _formatList($list);
		
		if (!empty($_POST['date']['from_paid_date']) && !empty($_POST['date']['to_paid_date'])){
			$url_date = '/type/4/from_paid_date/'.formatDate($_POST['date']['from_paid_date']).'/to_paid_date/'.formatDate($_POST['date']['to_paid_date']); 
		}else{
			if(empty($_POST['date']['lt_paid_date'])){
				$url_date = ''; 
			}else {
				$url_date = '/type/4/to_paid_date/'.formatDate($_POST['date']['lt_paid_date']); 
			}			
		} 
		foreach ($list['list'] as $key => &$value) {
            $warehosue  = '';
            if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
                $warehosue  = '/warehouse_id/'.getUser('company_id');
            }
            if(!empty($_POST['query']['warehouse_id'])){
                $warehosue  = '/warehouse_id/'.$_POST['query']['warehouse_id'];
            }
			$value['detail_url'] = 	U('/LogisticsStat/view/type/1/comp_id/'.$value['comp_id'].
							'/currency_id/'.$value['currency_id'].$url_date.'/basic_id/'.$value['basic_id']).$warehosue;
		}	  
		$have_currency_name	=	C('factory_currency_count')>1?true:false;
		$list	=	$this->getTotalCurrencyInfo($list,array('total_need_paid','total_on_road'),1,$have_currency_name); 
		 
		///合计为分页的总数量
		$sql_total		=	$sql_field.$sql_group_total;
		$detail_total 	= _formatList($this->db->query($sql_total)); 
		$detail_total	= $this->getTotalCurrencyInfo($detail_total,array('total_need_paid','total_on_road'),1,$have_currency_name); 
		$list['page_total']	= $detail_total; 
		///print_r($list);	
		return $list;			
	} 	
	 
	
	
}