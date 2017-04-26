<?php 
/**
 * 客户收款
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-08-06
 */
class StatTodayPublicModel extends ObjectFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName 			= 'paid_detail'; 
	 
	public $comp_type				=	1;	 
	 
	
	/**
	 * 获取列表
	 *
	 * @return array
	 */
	public function index(){ 
		if (count($_POST['date'])==0){ 
			$_POST['date']['from_paid_date']	=	formatDate(date("Y-m-d"),'outdate');
			$_POST['date']['to_paid_date']		=	formatDate(date("Y-m-d"),'outdate');
		}else{
			empty($_POST['date']['from_paid_date'])&&	$_POST['date']['from_paid_date']	=	$_POST['date']['to_paid_date'];
			empty($_POST['date']['to_paid_date'])&&	$_POST['date']['to_paid_date']			=	$_POST['date']['from_paid_date'];
		}
		$sql			= ACTION_NAME.'Sql';
		$_sql			= $this->$sql(); 
		return $list	= $this->indexList('',$_sql['sql'],$_sql['sql_sale'],$_sql['sql_before'],$_sql['sql_after']);
	}
	
	/**
	 * 列表
	 *
	 * @return unknown
	 */
	public function indexSql(){   
		if (isset($_POST['date']['from_paid_date'])){	 
			$dateArray			=	explode('-',formatDate($_POST['date']['from_paid_date'],'date'));  
			$yesterday  		= 	date('Y-m-d',mktime(0, 0, 0, $dateArray[1],$dateArray[2]-1,$dateArray[0]));
			$info['paid_date']	=	$yesterday;
			$info				=	_formatArray($info); 
			////计算前一天的日期是那一天
			$before_date		=	$info['fmd_paid_date'];  
		}
		
		$before_fields	=	L('stop').$before_date.L('balance');
		$after_fields	=	L('stop').$_POST['date']['to_paid_date'].L('balance'); 
		$before_array['date']['ltt_paid_date']	=	$_POST['date']['from_paid_date'];
		$after_array['date']['lt_paid_date']	=	$_POST['date']['to_paid_date'];  
		
		$info['field']			=	' *,comp_id as client_id,
										if(object_type=120,3,paid_income_type) as paid_income_type,
										if(object_type in (121,123,130),reserve_id,"") as flow_no,
										0 as income_money,
										0 as sale_money,
										0 as outlay_money,
										0 as quantity,
										0 as capability ';
		$info['from']			=	'paid_detail'; 
		$info['extend']			=	' WHERE  '._search().' and  comp_type in (0,1) and object_type in (800,801,120,121,123,130,103) order by paid_date  ';
		$info['extend_before']	=	' WHERE  '._search_array($before_array).' and object_type in (800,801,121,123,130,103)	and  comp_type in (0,1) group by currency_id order by currency_id ';
		$info['extend_after']	=	' WHERE  '._search_array($after_array).'  and object_type in (800,801,121,123,130,103)	and  comp_type in (0,1)  group by currency_id order by currency_id ';
		$info['extend_sale']	=	' WHERE  '._search().' and  comp_type=0 and object_type=120  group by a.object_id '; 
		$sql					= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		///获取销售单数量
		$sql_sale				= 'select reserve_id as flow_no,object_id,sum(quantity) as quantity,sum(quantity*capability*dozen) as capability  
									from '.$info['from'].' as a inner join sale_order_detail as b on a.object_id=b.sale_order_id '.$info['extend_sale']; 
		$sql_before				= 'select \''.$before_fields.'\' as name,1 as name_id, sum(if(object_type=120,0,money*paid_income_type)) as money,currency_id from '.$info['from'].' '.$info['extend_before']; 
		$sql_after				= 'select \''.$after_fields.'\' as name ,1 as name_id, sum(if(object_type=120,0,money*paid_income_type)) as money,currency_id from '.$info['from'].' '.$info['extend_after']; 
	  
		$info['sql']		= $sql;
		$info['sql_sale']	= $sql_sale;
		$info['sql_before']	= $sql_before; 
		$info['sql_after']	= $sql_after;  
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
	function indexList($limit,$sql,$sale_sql,$sql_before,$sql_after){ 
		$expand['sum_group_by']	=	array('currency_id,paid_income_type');  
		$list	= _formatList($this->db->query($sql),null,1,null,$expand);  
		 
		$sale	= _formatList($this->db->query($sale_sql)); 

		$link	=	array(
								120=>'/SaleOrder/view/id/',
								121=>'/SaleOrder/view/id/',
								123=>'/ReturnSaleOrder/view/id/',
                                130=>'/PriceAdjust/view/id/',//added by jp 20131216
                                125=>'/QuestionOrder/view/id/',//added by yyh 20150425
		); 
		foreach ((array)$sale['list'] as $key=>$row) {  $saleQuantity[$row['object_id']]	=	$row;	} 
		foreach ((array)$list['list'] as $key=>$row) {  
			switch ($row['paid_income_type']){
				case 1: 
					$row['income_money'] 			= $row['money'];
					$row['dml_income_money'] 		= $row['dml_money']; 
					$row['link']					= U($link[$row['object_type']].$row['object_id']);  
					break;
				case 3:
					$row['sale_money'] 				= $row['money'];
					$row['dml_sale_money'] 			= $row['dml_money']; 
					$row['link']					= U($link[$row['object_type']].$row['object_id']);  
					///合并销售数量
					$row							= array_merge($row,$saleQuantity[$row['object_id']]);
					break;
				case -1:
					$row['outlay_money'] 			= $row['money'];
					$row['dml_outlay_money'] 		= $row['dml_money'];
					break;			
			} 
			$list['list'][$key]	=	$row;
		}  
		///特殊处理记录销售数量与总数量的合计 
		$list['total']['quantity']				=	$sale['total']['quantity'];
		$list['total']['dml_quantity']			=	$sale['total']['dml_quantity'];
		$list['total']['capability']			=	$sale['total']['capability'];
		$list['total']['dml_capability']		=	$sale['total']['dml_capability'];   
		if ($_POST['show']==1){   
			///最终结余
			$list['after']	=	_formatList($this->db->query($sql_after),null,0);    
			///某日期之前的结余
			$list['before']	=	_formatList($this->db->query($sql_before),null,0);   	 
		}    
		$currencyDd	=	S('currency');
		///特殊处理显示
		foreach ((array)$list['total']['currency_id_paid_income_type_sum'] as $key=>$row) {  
			$total[]	= array( 
							'total_id'		=>1, 
							'total'			=>L('total'), 
							'quantity'		=>$list['total']['quantity'], 
							'currency_no'	=>$currencyDd[$key]['currency_no'],
							'capability'	=>$list['total']['capability'],
							'sale_money'	=>$row[3]['money'],
							'income_money'	=>$row[1]['money'],
							'outlay_money'	=>$row[-1]['money']
						); 
		} 
		$list['total_list']	=	$total;   
		return $list;
	}
	
	
}