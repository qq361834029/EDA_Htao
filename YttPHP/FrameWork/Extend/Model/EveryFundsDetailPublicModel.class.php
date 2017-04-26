<?php 
/**
 * 每日出入明细
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-08-06
 */
class EveryFundsDetailPublicModel extends ObjectFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName 			= 'paid_detail'; 
	public $comp_type				= 1;
	 
	
	/**
	 * 获取列表
	 *
	 * @return array
	 */
	public function index(){
		$sql			= ACTION_NAME.'Sql';
		$_sql			= $this->$sql();
		return $this->indexList($_sql);
	}
	
	/**
	 * 列表
	 *
	 * @return unknown
	 */
	public function indexSql(){
		$before_array['date']['ltt_paid_date']				=	$_POST['date']['from_paid_date'];
		$before_bank_array['date']['ltt_delivery_date']		=	$_POST['date']['from_paid_date'];
		$bank_array['date']['from_delivery_date']			=	$_POST['date']['from_paid_date'];
		$bank_array['date']['to_delivery_date']				=	$_POST['date']['to_paid_date'];

		$bank_array['query']['currency_id'] = $before_bank_array['query']['currency_id'] = $before_array['query']['currency_id'] =	$_POST['query']['currency_id'];
		
		if($_POST['query']['object_type']>0){
			$before_array['query']['object_type'] =	$_POST['query']['object_type'];
			if($_POST['query']['object_type']<1000){
				$bank_where		= ' and 1=2';
			}else{
				$bank_array['query']['paid_object_type'] = $_POST['query']['object_type'];
			}
			$where			= _search();
			$where_before	= _search_array($before_array);
		}elseif($_POST['query']['object_type'] == 0){
			$where			= '1=2';
			$where_before	= '1=2';
		}else{
			$where			= _search().' and object_type in (800,801,121,103)';
			$where_before	= _search_array($before_array).' and object_type in (800,801,121,103)';
		}

		
		$info['field']				= ' paid_date,currency_id,comp_id as client_id,paid_income_type as income_type,if(paid_income_type=1,money,0) as income_money,if(paid_income_type=-1,money,0) as outlay_money,paid_type,0 as bank_id,object_type,comments,pay_class_id';
		$info['from']				= 'paid_detail'; 
		$info['extend']				= ' WHERE  '.$where.' and comp_type in (0,1) and paid_type = 1';
		$info['extend_before']		= ' WHERE  '.$where_before.' and comp_type in (0,1) and paid_type = 1 group by currency_id';

		$sql						= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend'];

		///获取银行的数据
		$info['extend_bank']		= ' WHERE '._search_array($bank_array).$bank_where.' and ((paid_object_type in (1001,1003) and bank_id=0) or paid_object_type=1002) and  paid_id=0 and state=2 and to_hide=1 and paid_type = 1';
		$info['extend_before_bank']	= ' WHERE '._search_array($before_bank_array).$bank_where.' and ((paid_object_type in (1001,1003) and bank_id=0) or paid_object_type=1002) and paid_id=0 and state=2 and to_hide=1 and paid_type = 1 group by currency_id';
		
		$sql_bank					= 'select delivery_date as paid_date,0 as client_id,currency_id,income_type,if((income_type=1 and paid_object_type!=1002) or (income_type=-1 and paid_object_type=1002),money,0) as income_money,if((income_type=-1 and paid_object_type!=1002) or (income_type=1 and paid_object_type=1002),money,0) as outlay_money,paid_type,paid_object_type as object_type,bank_id,comments,0 as pay_class_id
									from bank_center '.$info['extend_bank'];
		$sql_before_bank			= 'select sum(if((income_type=1 and paid_object_type!=1002) or (income_type=-1 and paid_object_type=1002),money,0)) as income_money,sum(if((income_type=-1 and paid_object_type!=1002) or (income_type=1 and paid_object_type=1002),money,0)) as outlay_money,currency_id 
									from bank_center '.$info['extend_before_bank'];
		$sql_before					= 'select sum(if(paid_income_type=1,money,0)) as income_money,sum(if(paid_income_type=-1,money,0)) as outlay_money,currency_id from '.$info['from'].' '.$info['extend_before'];
	  
		$info['sql']				= $sql;
		$info['sql_before']			= $sql_before;
		$info['sql_bank']			= $sql_bank;
		$info['sql_before_bank']	= $sql_before_bank;
		return $info;
	}
	
	
	/**
	 * 根据SQL语句获取数据
	 *
	 * @param array $limit
	 * @param array $sql
	 * @param array $sale_sql
	 * @param array $sql_before
	 * @param array $sql_after
	 * @return array
	 */
	function indexList($sql){
		$expand['sum_group_by']	=	array('currency_id','paid_income_type');  
		$list	= $this->db->query($sql['sql']);  
		$bank	= $this->db->query($sql['sql_bank']);
		
		///某日期之前的结余
		$list_before			= $this->db->query($sql['sql_before']);
		///银行某日期之前的结余
		$list_before_bank		= $this->db->query($sql['sql_before_bank']);
		//合并数组list_before和list_before_bank的数组
		$list_before = array_merge_recursive($list_before,$list_before_bank);
		if(count($list_before)>0){
			foreach ($list_before as $key => &$row){
				$rs['total'][$row['currency_id']]['balance']		= $rs['before'][$row['currency_id']]['balance'] = $rs['before'][$row['currency_id']]['balance'] + $row['income_money'] - $row['outlay_money'];
				$rs['before'][$row['currency_id']]['currency_id']	= $row['currency_id'];
			}
		}else{
			$rs['before'][$_POST['query']['currency_id']]['dml_balance']	= '0.00';
			$rs['before'][$_POST['query']['currency_id']]['currency_id']	= $_POST['query']['currency_id'];
		}
		//如果没有明细则合计等于期初金额
		if($list || $bank){
			//合并数组paid_detail和bank的数组
			$list = array_merge_recursive($list,$bank);
			foreach ($list as $key => &$row){
				//抽取paid_date用于下面的排序
				$sort_array[$key]		= $row['paid_date'];
			}
			//按paid_date进行排序
			array_multisort($sort_array,SORT_ASC, $list);
			$linkModel	=	D('AbsStat');
			foreach ($list as $key => &$row){
				//处理按币种进行合计
				$rs['total'][$row['currency_id']]['income_money']	+= $row['income_money'];
				$rs['total'][$row['currency_id']]['outlay_money']	+= $row['outlay_money'];
				$rs['total'][$row['currency_id']]['balance']		= $row['balance'] = $rs['total'][$row['currency_id']]['balance'] + $row['income_money'] - $row['outlay_money'];
				$rs['total'][$row['currency_id']]['currency_id']	= $row['currency_id'];
				/// 生成备注
				$row = $linkModel->objectTypeCommentSubsidiary($row);
			}
			unset($linkModel);
		}else{
			$rs['total'] = $rs['before'];
		}
		$rs['before']	= _formatList($rs['before'],null,0,null,array(),'Original');
		$rs['list']		= _formatList($list,null,0,null,array(),'Original');
		$rs['total']	= _formatList($rs['total'],null,0,null,array(),'Original');

		return $rs;
	}
	
	
}