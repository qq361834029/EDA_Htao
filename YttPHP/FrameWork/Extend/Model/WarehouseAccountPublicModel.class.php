<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class WarehouseAccountPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'warehouse_account';
	/// 定义索引字段
	public $id;
	public $days 				=	'';    
	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("account_date",'require',"require",self::MUST_VALIDATE), //1为必须验证
			array("warehouse_id",'require',"require",self::MUST_VALIDATE), //1为必须验证
			array("factory_id",'require',"require",self::MUST_VALIDATE), //1为必须验证
		);
	/// 验证表单明细
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);

	/**
	 * 查看调整明细
	 *
	 * @return  array
	 */
	public function view(){ 
		return $this->getInfo($this->id);
	}
	
	
	/**
	 * 获取明细信息(用于查看/编辑)
	 *
	 * @param int $id
	 * @return array
	 */
	public  function getInfo($id) {		
		$rs	= $this->field('*,quarter_warehouse_fee*warehouse_percentage as quarter_warehouse_fee,year_warehouse_fee*warehouse_percentage as year_warehouse_fee,
			(quarter_warehouse_fee*quarter_stock_cube*warehouse_percentage) as quarter_warehouse_account,
			(year_warehouse_fee*year_stock_cube*warehouse_percentage) as year_warehouse_account,
			(free_stock_quantity+quarter_stock_quantity+year_stock_quantity) as stock_quantity,
			(free_stock_cube+quarter_stock_cube+year_stock_cube) as stock_cube,
			(quarter_warehouse_fee*quarter_stock_cube+year_warehouse_fee*year_stock_cube)*warehouse_percentage as warehouse_account_fee')
			->find($id);
		$rs         = _formatListRelation($rs);
        $rs['comments'] = html_entity_decode(html_entity_decode($rs['comments']));
        $rs['currency_no']  = SOnly('currency',  SOnly('warehouse', $rs['warehouse_id'] ,'w_currency_id'),'currency_no');
		$rs['is_update']	= getUser('role_type')==C('SELLER_ROLE_TYPE') ? 0:1;
		return $rs;
	}
    public  function getDetailInfo() {
        $id           = intval($_GET['id']);
        $quarter      = intval($_GET['quarter']);
//        $product_id   = intval($_GET['product_id']);
        $account_date = trim($_GET['account_date']);
        
        //主表
        $rs = M('WarehouseAccount')->find($id);
//        $rs['product_id']   = $product_id;
        $rs['account_date'] = $account_date;
        
        //明细表
        $where['warehouse_account_id']  = $id;
        if($quarter == 5){//全季度
            $where['quarter']			= $quarter;
        }else{
			$where['quarter']			= array(array('gt',0),array('lt',5));
		}
//        $where['product_id']            = $product_id;
//        $where['storage_date']          = $account_date;
		$rs['detail']   = M('WarehouseAccountDetail')->where($where)->select();
		$rs = _formatListRelation($rs);
        foreach($rs['detail'] as &$value){
            $value['amount_money']  = $value['warehouse_fee']*$value['quantity']*$value['cube'];
            //加价百分比
            $value['amount_money']  += $value['amount_money']*$rs['warehouse_percentage']/100;
            $rs['total_amount_money'] += $value['amount_money'];
        }
        $rs['currency_no']  = SOnly('currency',  SOnly('warehouse', $rs['warehouse_id'] ,'w_currency_id'),'currency_no');
		return $rs;
	}
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		
		$count 	= $this->where(getWhere($_POST))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->where(getWhere($_POST))->order('account_date desc')->page()->selectIds();
		$info['from'] 	= 'warehouse_account';
		$info['group'] 	= ' order by account_date desc';
		$info['where'] 	= ' where id in'.$ids;
		$info['field'] 	= ' *,(quarter_warehouse_fee*quarter_stock_cube*warehouse_percentage) as quarter_warehouse_account,
							(year_warehouse_fee*year_stock_cube*warehouse_percentage) as year_warehouse_account,
							(free_stock_quantity+quarter_stock_quantity+year_stock_quantity) as stock_quantity,
							(free_stock_cube+quarter_stock_cube+year_stock_cube) as stock_cube,
							(quarter_warehouse_fee*quarter_stock_cube+year_warehouse_fee*year_stock_cube)*warehouse_percentage as warehouse_account_fee';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
    
    /**
     * 计算仓储费明细
     * @author yyh 20150624
     * @param array $rs
     * @return array $rs
     */
    public function warehouseAccountDetail(){
        if(isset($_GET['rand'])){
            $rs = S($_GET['rand']);
        }else{
            $is_insert  = TRUE;
            $rs = $_POST;
        }
		$rs['account_end_date']	= formatDate($rs['account_end_date']);
        
        $warehouse_id   = intval($rs['warehouse_id']);
        $factory_id     = intval($rs['factory_id']);
		if($warehouse_id <=0 || $factory_id <= 0){
			return FALSE;
		}
		//起始计费时间
		$warehouse_fee_start_date	= M('company_factory')->where('factory_id='.$factory_id)->getField('warehouse_fee_start_date');
        $rs['account_start_date'] = get_warehouse_account_start_date($factory_id, $warehouse_id, $warehouse_fee_start_date);

        $where  = 'p.factory_id='.$rs['factory_id'];
        $product_id = intval($_GET['product_id']);
        if($product_id > 0){
            $storage_date   = $_GET['storage_date'];
            $quarter        = $_GET['quarter'];
            $where  .= ' and s.product_id='.$product_id;
            $where  .= ' and s.in_date="'.$storage_date.'"';
        }else{
            $where  .= ' and s.in_date<"'.$rs['account_end_date'].'"';
        }
        $stock_in   = M('stock_in')
                ->join(' s left join product p on s.product_id=p.id')
                ->where($where.' and s.warehouse_id='.$rs['warehouse_id'].' and balance>0')
                ->field('sum(s.balance) AS quantity, s.in_date,s.in_date as in_storage_date,s.in_date as storage_date, s.product_id, (p.cube_high * p.cube_wide * p.cube_long) AS cube,(p.check_high * p.check_wide * p.check_long) AS check_cube,p.check_status')
                ->group('s.in_date,s.product_id')
                ->select();
        foreach($stock_in as &$in_info){
            $in_info['storage_date'] = max($warehouse_fee_start_date,$in_info['storage_date']);
            $in_info['in_date']      = max(strtotime($in_info['in_date']),strtotime($rs['account_start_date']));
            $in_info['out_date']     = strtotime($rs['account_end_date']);
            $in_info['cube']         = $in_info['check_status'] == C('CHECK_STATUS_PASS') ? $in_info['check_cube'] : $in_info['cube'];
            unset($in_info['check_status']);
        }
        $where  .= ' and s.out_date>="'.$rs['account_start_date'].'"';
        $stock_out  = M('stock_out')
                ->join(' s left join product p on s.product_id=p.id')
                ->where($where.' and s.out_warehouse_id='.$rs['warehouse_id'])
                ->group('s.out_date,s.product_id')
                ->order('s.out_date')
                ->field('s.in_date,s.product_id,sum(s.quantity) as quantity,s.in_date as in_storage_date,s.in_date as storage_date,s.out_date,(p.cube_high*p.cube_wide*p.cube_long) as cube,(p.check_high * p.check_wide * p.check_long) AS check_cube,p.check_status')
                ->select();
        foreach($stock_out as &$out_info){
            $out_info['storage_date']   = max($warehouse_fee_start_date,$in_info['storage_date']);//卖家开始计费时间
            $out_info['in_date']        = max(strtotime($out_info['in_date']),  strtotime($rs['account_start_date']));//计费起始时间
            $out_info['out_date']       = min(strtotime($out_info['out_date']),  strtotime($rs['account_end_date']));//计费截止时间
            $out_info['cube']           = $out_info['check_status'] == C('CHECK_STATUS_PASS') ? $out_info['check_cube'] : $out_info['cube'];//体积
            unset($out_info['check_status']);
        }
        
        //仓储费收费标准
        $warehouse_fee_id = M('company_factory')->where('factory_id='.$factory_id)->getField('warehouse_fee_id');
        $warehouse_fee    = M('warehouse_fee_detail')->where('warehouse_id='.$warehouse_id.' and warehouse_fee_id='.$warehouse_fee_id)->select();
//        $warehouse_fee    = M('warehouse_fee')->where('factory_id='.$rs['factory_id'])->select();
        //加价百分比
        $warehouse_percentage = M('company_factory')->where('factory_id='.$rs['factory_id'])->getField('warehouse_percentage');
        //构造仓储费每季度天数明细
        if(!empty($stock_in) && !empty($stock_out)){
            $info   = array_merge($stock_in,$stock_out);
        }else{
            $info   = empty($stock_in) ? $stock_out : $stock_in;
        }
        foreach($info as $v){
            //入库时间,出库时间,产品ID
            $key    = $v['in_storage_date'].','.$v['out_date'].','.$v['product_id'];
            if(empty($date[$key])){
                $date[$key] = $v;
            }else{
                $date[$key]['quantity'] += $v['quantity'];
            }
        }
        $info   = $date;
        foreach($info as $value){
            $this->quarterSurplusDay($value);
        }
        $detail = array();
        foreach($this->days as $days){
            $detail   = array_merge($detail,$this->calculationAccount($days,$warehouse_fee,$warehouse_percentage));
        }
        if($is_insert){
            $rs['detail']   = $detail;
        }else{
            if($quarter > 0){//第二层明细
                foreach($detail as $account_info){
                    $rs['storage_date'] = $account_info['storage_date'];
                    $rs['product_id']   = $account_info['product_id'];
                    if($account_info['quarter'] == $quarter || $quarter == 5){
                        $rs['detail'][]   = $account_info;
                    }
                }
            }else{
                $quarter_field  = C('QUARTER_FIELD');
                //按入库时间/ID/季度合计
                foreach($detail as $account_info){
                    $quarter  = $quarter_field[$account_info['quarter']];
                    if(isset($rs['detail'][$account_info['storage_date'].','.$account_info['product_id']])){
                        $rs['detail'][$account_info['storage_date'].','.$account_info['product_id']][$quarter]  += $account_info['amount_money'];
                        $rs['detail'][$account_info['storage_date'].','.$account_info['product_id']]['row_total']   += $account_info['amount_money'];
                    }else{
                        foreach($quarter_field as $field){
                            if($quarter == $field){
                                $account_info[$field]   = $account_info['amount_money'];
                            }else{
                                $account_info[$field]   = 0;
                            }
                        }
    //                    $account_info['product_no'] = SOnly('product', $account_info['product_id'],'product_no');
                        $account_info['row_total']  = $account_info['amount_money'];
                        $rs['detail'][$account_info['storage_date'].','.$account_info['product_id']]  = $account_info;
                    }
                }
            }
        }
        $rs['warehouse_percentage'] = $warehouse_percentage;
        $rs['rand']     = $_GET['rand'];
        $rs = _formatListRelation($rs);
        foreach($rs['detail'] as $value){
            $rs['total_amount_money'] += $value['amount_money'];
            $rs['total'] += $value['row_total'];
        }
        $rs['currency_no']  = SOnly('currency',  SOnly('warehouse', $rs['warehouse_id'] ,'w_currency_id'),'currency_no');
        return $rs;
    }
    /**
     * 按入库明细计算仓储费
     * @author yyh 20150624
     * @param type $info
     * @return array $rs
     */
    public function calculationAccount($days,$warehouse_fee,$warehouse_percentage){
        $quarter_field      = C('QUARTER_FIELD');
        $cumulative_days    = $days['start_days'];
        $detail = array();
        $billing_end_date   = '';
        foreach($warehouse_fee as $standard){
            if($days['days'] > 0){
                if($cumulative_days < $standard['end_days']){
                    $billing_days   = $standard['end_days'] - $cumulative_days;
                    $billing_days   = min($billing_days,$days['days']);
                    $days['days']   -= $billing_days;
                }else if($standard['end_days'] == 0){
                    $billing_days           = $days['days'];
                    $days['days']   = 0;
                }else{
                    continue;
                }
                $billing_quarter    = $standard[$quarter_field[$days['quarter']]];
                //仓储费=计费天数 * 立方数 * 季度单价
                $billing_start_date = empty($billing_end_date) ? date('Y-m-d',$days['in_date']) : $billing_end_date;
                $billing_end_date   = date('Y-m-d',  strtotime($billing_start_date)+3600+$billing_days*86400);//+3600防止夏令时影响时间
                $money  = bcmul($billing_days*$days['quantity'],bcmul($billing_quarter,$days['cube']));
                //加价百分比
                $money  += bcmul($money,$warehouse_percentage)/100;
                //明细早点季度	计费开始时间	计费结束时间	计费天数	单价	数量	立方数	金额
                $detail_info['product_id']          = $days['product_id'];
                $detail_info['quarter']             = $days['quarter'];
                $detail_info['storage_date']        = $days['in_storage_date'];//开始计费时间和入库时间
                $detail_info['billing_start_date']  = $billing_start_date;
                $detail_info['billing_end_date']    = $billing_end_date;
                $detail_info['billing_days']        = $billing_days;
                $detail_info['price']               = $billing_quarter;
                $detail_info['quantity']            = $days['quantity'];
                $detail_info['cube']                = $days['cube']/1000000;
                $detail_info['amount_money']        = $money/1000000;//立方厘米转立方米(计算后再除减少误差)
                $detail[]   = $detail_info;
                if($days['days'] <= 0){
                    break;
                }else{
                    $cumulative_days    += $billing_days;
                }
            }else{
                break;
            }
        }
        return $detail;
    }
    
    /**
     * 本季度存储天数
     */
    public function quarterSurplusDay($info){
        $start_date         = $info['in_date'];
//        $quarter_arr        = C('QUARTER');
        $quarter_end_date   = C('QUARTER_END_DATE');
//        $quarter            = $quarter_arr[date('m',$start_date)];//入库时间所属季度
        $quarter            = ceil(date('m',$start_date)/3);//入库时间所属季度
        $new_year           = $quarter==C('NEW_YEAR_QUARTER') ? 1 : 0;
        $next_quarter_year  = date('Y',  $start_date)+$new_year;
        //计费结束时间是否小于下一个季度
        $next_quarter_date  = min(strtotime($next_quarter_year.'-'.$quarter_end_date[$quarter]),$info['out_date']);
        $quarter_days   = $next_quarter_date - $start_date;
        $this->days[]   = array(
            'quarter'       => $quarter,
            'days'          => round($quarter_days/86400),
            'start_days'    => round(($start_date-strtotime($info['storage_date']))/86400),
            'quantity'      => $info['quantity'],
            'cube'          => $info['cube'],
            'storage_date'  => $info['storage_date'],
            'in_date'       => $info['in_date'],
            'out_date'      => $info['in_date'] + $quarter_days,
            'product_id'    => $info['product_id'],
            'in_storage_date' => $info['in_storage_date'],
        );
        if($next_quarter_date < $info['out_date']){
            $info['in_date']    = $next_quarter_date;
            $this->quarterSurplusDay($info);
        }
    }
    /**
	 * 按先进先出设置计算仓储费的信息
	 * @param array $stock_in 先进信息
	 * @param array $stock_out 先出信息
	 * @return array
	 */
    public function setStockInfo($stock_in,$stock_out,$account_end_date,$account_start_date){
        foreach($stock_out as $out_info){
            $stock_out_info[$out_info['in_date']][$out_info['product_id']][] = array(
                'billing_end_date'      => $out_info['out_date'],
                'cube'                  => $out_info['cube'],
                'quantity'              => $out_info['quantity'],
            );
        }
        foreach($stock_in as $value){
            $billing_start_date = empty($account_start_date) ? $value['in_date'] : max($account_start_date,$value['in_date']);
            if($value['quantity'] > 0){
                //入库到对账结束的对账信息
                $in_info    = array(
                    'billing_start_date'    => $billing_start_date,
                    'billing_end_date'      => $account_end_date,
                    'cube'                  => $value['cube'],
                    'quantity'              => $value['quantity'],
                );
                $total_quantity = $value['quantity'];
                //对存在出库产品批次处理
                foreach($stock_out_info[$value['in_date']][$value['product_id']] as $val){
                    //出库后到对账结束对账信息
                    $billing_start_date = $in_info['billing_start_date'];
                    $in_info['quantity']            = $total_quantity - $val['quantity'];
                    $in_info['billing_start_date']  = $val['billing_end_date'];
                    //新增出库前仓储费信息
                    $val['quantity']            = $total_quantity;
                    if($val['billing_end_date'] != $value['in_date']){
                        $val['billing_start_date']  = $billing_start_date;
                        $info[$value['in_date']][$value['product_id']][]    = $val;
                    }
                }
                if($in_info['quantity'] > 0){
                    $info[$value['in_date']][$value['product_id']][]    = $in_info;
                }
            }
        }
        return $info;
    }

    /**
	 * 关联insert
	 *
	 * @return array
	 */
	public function relationInsert(){
		//重新组合POST来的信息 
//		$info	= $this->warehouseAccountDetail();
		$info	= $this->setPost();
		//模型验证 
		if ($this->create($info)) {	  
			$this->_brf();
			if($this->_beforeModel($info) == false){
				$this->error_type	= 1;
				return false;
			}
			$id = $this->relation(true)->add();   
			if (false === $id) {
				$this->error_type	=	2;
				return false; 
			}	 
			$this->id	=	$id;  
			empty($info) ? $_POST['id'] = $id : $info['id'] = $id; 
			$this->_afterModel($info); 
			$this->execTags($info);   
		} else {     
			$this->error_type	=	1; 
			return false;
		} 
	}
	///仓储费 日结余
	public function warehouseFeeBalanceByDay($date,$factory, $debug = false){
		if(empty($date)){
			$date	= date('Y-m-d',time());
		}
		//当前季度
		$quarter_field	= C('QUARTER_FIELD');

		$where	= ' p.factory_id='.$factory.' and EXISTS(select * from warehouse_fee where f.warehouse_fee_id=warehouse_fee.id)';
//		$where	= ' p.factory_id in('.  implode(',', $factory).')';
		$in_where	= ' and in_date>=f.warehouse_fee_start_date and in_date<="'.$date.'"';
		$out_where	= $in_where.' and out_date>f.warehouse_fee_start_date and out_date>"'.$date.'"';
		$group	= 'factory_id,warehouse_id';
		$join	= ' s left join product p on s.product_id=p.id
					left join company_factory f on p.factory_id=f.factory_id
					left join warehouse_fee_detail w on f.warehouse_fee_id=w.warehouse_fee_id';//
		$product_cube_field	= 'if(p.check_status=1,check_long*check_wide*check_high, cube_long*cube_wide*cube_high)/1000000';
		$w_fee_field		= 'w.'.$quarter_field[ceil(date('m',strtotime($date))/3)];
		$sql	= ' select f.factory_id,s.warehouse_id,f.warehouse_percentage,
					if(DATEDIFF("'.$date.'",s.in_date)<ifnull(w.free_days,0),s.balance,0) as free_stock_quantity,
					if(DATEDIFF("'.$date.'",s.in_date)<ifnull(w.free_days,0),s.balance*'.$product_cube_field.',0) as free_stock_cube,
					ifnull(w.free_days,0) as free_days,
					if(DATEDIFF("'.$date.'",s.in_date)>=ifnull(w.free_days,0) and TIMESTAMPDIFF(YEAR,s.in_date,"'.$date.'")<1,s.balance,0) as quarter_stock_quantity,
					if(DATEDIFF("'.$date.'",s.in_date)>=ifnull(w.free_days,0) and TIMESTAMPDIFF(YEAR,s.in_date,"'.$date.'")<1,s.balance*'.$product_cube_field.',0) as quarter_stock_cube,
					ifnull('.$w_fee_field.',0) as quarter_warehouse_fee,
					if(TIMESTAMPDIFF(YEAR,s.in_date,"'.$date.'")>=1,s.balance,0) as year_stock_quantity,
					if(TIMESTAMPDIFF(YEAR,s.in_date,"'.$date.'")>=1,s.balance*'.$product_cube_field.',0) as year_stock_cube,
					ifnull(w.over_year,0) as year_warehouse_fee '.
					'from stock_in'.$join.' and w.warehouse_id=s.warehouse_id where'.$where.$in_where.
					' UNION ALL
					select f.factory_id,s.out_warehouse_id as warehouse_id,f.warehouse_percentage,
					if(DATEDIFF("'.$date.'",s.in_date)<ifnull(w.free_days,0),s.quantity,0) as free_stock_quantity,
					if(DATEDIFF("'.$date.'",s.in_date)<ifnull(w.free_days,0),s.quantity*'.$product_cube_field.',0) as free_stock_cube,
					ifnull(w.free_days,0) as free_days,
					if(DATEDIFF("'.$date.'",s.in_date)>=ifnull(w.free_days,0) and TIMESTAMPDIFF(YEAR,s.in_date,"'.$date.'")<1,s.quantity,0) as quarter_stock_quantity,
					if(DATEDIFF("'.$date.'",s.in_date)>=ifnull(w.free_days,0) and TIMESTAMPDIFF(YEAR,s.in_date,"'.$date.'")<1,s.quantity*'.$product_cube_field.',0) as quarter_stock_cube,
					ifnull('.$w_fee_field.',0) as quarter_warehouse_fee,
					if(TIMESTAMPDIFF(YEAR,s.in_date,"'.$date.'")>=1,s.quantity,0) as year_stock_quantity,
					if(TIMESTAMPDIFF(YEAR,s.in_date,"'.$date.'")>=1,s.quantity*'.$product_cube_field.',0) as year_stock_cube,
					ifnull(w.over_year,0) as year_warehouse_fee '.
					'from stock_out'.$join.' and w.warehouse_id=s.out_warehouse_id where'.$where.$out_where;
//		dump($this->query($sql));exit;
		$sql	= ' select factory_id,warehouse_id,(1+warehouse_percentage/100) as warehouse_percentage,"'.$date.'" as account_date,sum(free_stock_quantity) as free_stock_quantity,sum(free_stock_cube) as free_stock_cube,
					sum(quarter_stock_quantity) as quarter_stock_quantity,sum(quarter_stock_cube) as quarter_stock_cube,'.ceil(date('m',strtotime($date))/3).' as quarter,quarter_warehouse_fee,
					sum(year_stock_quantity) as year_stock_quantity,sum(year_stock_cube) as year_stock_cube,year_warehouse_fee
					from('.$sql.') as tmp group by '.$group.' having free_stock_quantity>0 or quarter_stock_quantity>0 or year_stock_quantity>0';
		$warehouse_balance	= $this->query($sql);
		$msg	= '';
		if (empty($warehouse_balance)) {
			$msg	.= '无库存数据！<br /><br />';
		} else {
			foreach ($warehouse_balance as $val){
				$_POST	= $val;
				$this->isAjax	= true;
				$is_exist	= $this->where(array('factory_id'=>$val['factory_id'],'warehouse_id'=>$val['warehouse_id'],'account_date'=>$date))->find();
				$msg	.= '仓库: ' . SOnly('warehouse', $val['warehouse_id'], 'w_name') . '[' . $val['warehouse_id'] . ']';
				if(empty($is_exist)){
					$this->setModuleInfo('WarehouseAccount', 'insert');
					$this->relationInsert();
					$msg	.= '对账成功！';
				} else {
					$msg	.= '已对账过！';
				}
				$msg	.= '<br />';
			}
			$msg	.= '<br />';
		}
		if ($debug === true) {
			echo $msg;
		}
	}
}