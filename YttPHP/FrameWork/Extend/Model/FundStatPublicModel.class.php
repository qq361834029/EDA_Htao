<?php 
/**
 * 款项汇总表
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-08-06
 */

class FundStatPublicModel extends AbsStatPublicModel {
	 
	public $object_type_outlay	=	'203,303,800';    
	public $object_type_all		=	'121,103,203,303,800,801';    
	  
	/**
	 * 获取现金统计
	 *
	 * @return unknown
	 */
	public function index() { 
		$sql		= $this->getCaseIndexSql();///获取SQL语句 
		$list 		= $this->db->query($sql);     
		$list_info	= $this->getCaseIndexFormat(_formatList($list));///格式化
		///pr(_formatList($list),'$list_info');
		$list_info['total_list']	=	 $this->getCaseIndexTotal($list_info);///合计  
///		$list_info['total_count']	=	count($list_info['total_list']>1)?1:2; 
		return $list_info; 
	}
	
	/**
	 * 格式化列表
	 *
	 * @param array $list_info
	 * @return array
	 */
	public function getCaseIndexFormat($list_info){  
		$from_date		=	formatDate($_POST['date']['from_paid_date']); 
		$to_date		=	formatDate($_POST['date']['to_paid_date']);  
		$object_type	=	$_POST['query']['object_type']; ///来源 
		foreach ($list_info['list'] as $k => $row) {  
			unset($row['dd_bank_id']);	///数组中多余的字段
			unset($row['bank_name']);	///数组中多余的字段 
			if ($row['bank_id']==0){
				$row['bank_name']	=	L('cash');
			}elseif ($row['bank_id']==-1){
				$row['bank_name']	=	L('bill');
			}else {
				$row['bank_name']	=	$row['account_name'];
				unset($row['account_name']);
			} 
///			unset($row['bank_name']);
			$url	=	'/FundStat/view/'; 
			$from_date 	&&	$url		.=	'from_date/'.$from_date.'/';
			$to_date 	&&	$url		.=	'to_date/'.$to_date.'/';
			if ($object_type>=0 && $object_type!=null){ $url	.=	'object_type/'.$object_type.'/';} 
			///连接
			$row['bank_money_url']		=	U($url.'currency_id/'.$row['currency_id'].'/bank_id/'.$row['bank_id'].'/type/bank_money'); 
			$row['banklog_money_url']	=	U($url.'currency_id/'.$row['currency_id'].'/bank_id/'.$row['bank_id'].'/type/banklog_money'); 
			$row['advance_money_url']	=	U($url.'currency_id/'.$row['currency_id'].'/bank_id/'.$row['bank_id'].'/type/advance_money');
			$row['client_money_url']	=	U($url.'currency_id/'.$row['currency_id'].'/bank_id/'.$row['bank_id'].'/type/client_money');
			$row['factory_money_url']	=	U($url.'currency_id/'.$row['currency_id'].'/bank_id/'.$row['bank_id'].'/type/factory_money');
			$row['logistics_money_url']	=	U($url.'currency_id/'.$row['currency_id'].'/bank_id/'.$row['bank_id'].'/type/logistics_money');
			$row['other_out_money_url']	=	U($url.'currency_id/'.$row['currency_id'].'/bank_id/'.$row['bank_id'].'/type/other_out_money');
			$row['other_in_money_url']	=	U($url.'currency_id/'.$row['currency_id'].'/bank_id/'.$row['bank_id'].'/type/other_in_money'); 
			$row['all_url']				=	U($url.'currency_id/'.$row['currency_id'].'/bank_id/'.$row['bank_id'].''); 
			$list_info['list'][$k]	=	$row; 
		}
		return $list_info;
	}
	 
	/**
	 * 获取列表的SQL语句
	 *
	 * @return array
	 */
	public function getCaseIndexSql(){     
		$today = date("Y-m-d");
		$paid_type		=	$_POST['query']['bank_id'];
		$object_type	=	$_POST['query']['object_type'];
		if ($_POST['query']['bank_id']<=0){ unset($_POST['query']['bank_id']);}
		$where 		= _search('to_hide=1 and currency_id>0');  
		$where_paid = str_replace('paid_date','delivery_date',$where);
		$where_paid = str_replace('object_type','paid_object_type',$where_paid);  
		 
		$where_bank = str_replace('paid_date','delivery_date',$where); 
		$where_bank = str_replace('object_type','paid_object_type',$where_bank); 
		
		$where_bill = str_replace('paid_date','bank_date',$where);   
		$where_bill = str_replace('object_type','paid_object_type',$where_bill);   
		
		$where 		= str_replace('currency_id','befor_currency_id',$where); 
			 
		$_POST['query']['bank_id']	=	$paid_type;
		$sql	=	'select bank_id,currency_id,income_type,paid_date,
				sum(bank_money) as bank_money,
				sum(banklog_money) as banklog_money,
				sum(advance_money) as advance_money,
				sum(client_money) as client_money,
				sum(factory_money) as factory_money,
				sum(logistics_money) as logistics_money,
				sum(other_out_money) as other_out_money,
				sum(other_in_money) as other_in_money,
				sum(money) as money
				from ('; 
		
		if ($object_type==0 && isset($_POST['query']['object_type'])){///手工增加(特殊处理)
				$where_paid = str_replace('paid_object_type="0"','1',$where_paid);
				$where 		= str_replace('object_type="0"','1',$where).' and object_type=1	and object_type not in ('.$this->object_type_all.')';
		}
		
		if (empty($paid_type)){    
			$sql.= $this->getCaseIndexSqlStr('cash',array('where_bank'=>$where_paid,'where'=>$where)).' 
				union all '.$this->getCaseIndexSqlStr('bill',array('where_paid'=>$where_bill)).' 
				union all '.$this->getCaseIndexSqlStr('bank',array('where_paid'=>$where_bank));    
		}else{
			if ($paid_type==-1){///现金    
					$sql.= $this->getCaseIndexSqlStr('cash',array('where_paid'=>$where_paid,'where'=>$where));
			}elseif ($paid_type==-2){///支票 
					$sql.= $this->getCaseIndexSqlStr('bill',array('where_paid'=>$where_bill));
			}elseif ($paid_type>0) {///银行 
					$sql.= $this->getCaseIndexSqlStr('bank',array('where_paid'=>$where_bank));
			}
		}    
		$sql	.=	') as tmp group by bank_id,currency_id  order by bank_id,income_type asc  ';  
///		echo $sql; 
		return $sql;
	}
	
	/**
	 * 现金/支票/银行的SQL语句
	 *
	 * @param string $type
	 * @param array $info
	 * @return string
	 */
	public function getCaseIndexSqlStr($type,$info){  
		if (is_array($info)){
			extract($info);
		}    
		empty($where_bank)	&&	$where_bank	=	'1';
		empty($where)		&&	$where		=	'1';
		empty($where_paid)	&&	$where_paid	=	'1';
		switch ($type){
			case 'cash':///现金
				$sql = ' 
				select 0 as bank_id,currency_id,income_type as income_type,delivery_date as paid_date,
					sum(if(paid_object_type in (1001,1003,1005),money*income_type,0)) as bank_money,
					sum(if(paid_object_type = 1002,money*-1*income_type,0)) as banklog_money,
					0 as advance_money,0 as client_money,0 as factory_money,0 as logistics_money,0 as other_out_money,0 as other_in_money,
					sum(if(paid_object_type = 1002,money*-1*income_type,money*income_type)) as money 
					from bank_center
					where '.$where_bank.' and state=2 and paid_type=1 and ((paid_object_type in (1001,1003,1005) and bank_id=0) or paid_object_type=1002)
					group by currency_id
				union all
				select 0 as bank_id,befor_currency_id as currency_id,if(object_type in ('.$this->object_type_outlay.'),-1,1) as income_type,paid_date,
					sum(if(object_type not in ('.$this->object_type_all.'),money/befor_rate*if(object_type in ('.$this->object_type_outlay.'),-1,1),0)) as bank_money,sum(if(object_type = 1002,money,0)) as banklog_money,
					sum(if(object_type=121,money/befor_rate*if(object_type in ('.$this->object_type_outlay.'),-1,1),0)) as advance_money,
					sum(if(object_type in (103),money/befor_rate*if(object_type in ('.$this->object_type_outlay.'),-1,1),0)) as client_money,
					sum(if(object_type=203,money/befor_rate*if(object_type in ('.$this->object_type_outlay.'),-1,1),0)) as factory_money,
					sum(if(object_type=303,money/befor_rate*if(object_type in ('.$this->object_type_outlay.'),-1,1),0)) as logistics_money,
					sum(if(object_type=800,money/befor_rate*if(object_type in ('.$this->object_type_outlay.'),-1,1),0)) as other_out_money,
					sum(if(object_type=801,money/befor_rate*if(object_type in ('.$this->object_type_outlay.'),-1,1),0)) as other_in_money,
					sum(money/befor_rate*if(object_type in ('.$this->object_type_outlay.'),-1,1)) as money 
					from paid_detail 
					where '.$where.' and paid_type =1 and object_type in (1,103,121,801,203,303,800,1001,1002,1003,1005)
					group by object_type,befor_currency_id ';//edited by jp 20131212 (add ",1005")   
				break;
			case 'bill':
				$sql = ' 
					select -1 as bank_id,currency_id,income_type,bank_date as paid_date
					'.$this->getCaseIndexSqlStrFields().'
					from bank_center
					where '.$where_paid.' and paid_type in (2,3) and state=1
					group by paid_type,currency_id   '; 
				break;
			case 'bank':
				$sql = '  
					select bank_id,currency_id,income_type,delivery_date as paid_date 
					'.$this->getCaseIndexSqlStrFields().'
					from bank_center
					where '.$where_paid.' and bank_id>0 and state=2
					group by bank_id,currency_id'; 
				break;		
		}
		return $sql;
	}
	 
	/**
	 * 返回列字段名称
	 *
	 * @param string $key
	 * @return string
	 */
	public function getCaseIndexSqlStrFields($key='paid_object_type'){  
		$str	=	'	,sum(if('.$key.' in (1001,1003,1005),money*income_type,0)) as bank_money,
						sum(if('.$key.' =1002,money*income_type,0)) as banklog_money,
						sum(if('.$key.'=121,money*income_type,0)) as advance_money,
						sum(if('.$key.' in (103) ,money*income_type,0)) as client_money,
						sum(if('.$key.'=203,money*income_type,0)) as factory_money,
						sum(if('.$key.'=303,money*income_type,0)) as logistics_money,
						sum(if('.$key.'=800,money*income_type,0)) as other_out_money,
						sum(if('.$key.'=801,money*income_type,0)) as other_in_money,
						sum(money*income_type) as money  '; //edited by jp 20131212 (add ",1005")   
		return $str;
	}
	 
	/**
	 * 款项合计信息
	 *
	 * @param array $list_info
	 * @return array
	 */
	public function getCaseIndexTotal(&$list_info){   
		$total = $info = array();
		foreach ((array)$list_info['list'] as $value) { 
			/// 计算同币种合计金额
			$total[$value['currency_id']]['income_money']	+= ($value['bank_money']+$value['banklog_money']+$value['advance_money']+$value['client_money']+$value['other_in_money']);   ///收入
			$total[$value['currency_id']]['outlay_money']	+= abs($value['factory_money']+$value['logistics_money']+$value['other_out_money']);  ///支出
			$total[$value['currency_id']]['money']			+= ($value['bank_money']+$value['banklog_money']+$value['advance_money']+$value['client_money']+$value['other_in_money'])+($value['factory_money']+$value['logistics_money']+$value['other_out_money']);  ///支出
			$total[$value['currency_id']]['currency_no'] 	= $value['currency_no']; 
			$total[$value['currency_id']]['currency_id'] 	= $value['currency_id']; 
		}

		$total	=_formatList($total);    
		return $total;
	}
	
	/**
	 * 取现金明细数据
	 *
	 * @param array $info
	 * @return array
	 */
	public function view() {
		$_POST['query']['bank_id'] 			= $_GET['bank_id'];
		$_POST['query']['currency_id'] 		= $_GET['currency_id'];
		$_POST['date']['from_paid_date'] 	= $_GET['from_date'];
		$_POST['date']['to_paid_date'] 		= $_GET['to_date'];
		$_POST['date']['to_paid_date'] 		= $_GET['to_date']; 
		$_GET['object_type']>0	&&	$_POST['query']['object_type'] 		= $_GET['object_type'];  
		$type	=	$_GET['type'];  
		if (empty($type)){ 
			if ($_GET['bank_id']==0){		///现金 
				$all_paid_type	= 1; 
			}elseif ($_GET['bank_id']==-1){	///支票 
				$all_paid_type	=	2; 
			}else {							///银行
				$all_paid_type	=	3; 
			} 
		}else{
			if ($_GET['bank_id']==0){		///现金 
				$paid_type							= 1;
				$_POST['query']['paid_type'] 		= 1; 
			}elseif ($_GET['bank_id']==-1){	///支票 
				$paid_type	=	2;
				$_POST['query']['paid_type'] 		= 2;  
			}else {							///银行
				$paid_type	=	3; 
			}
		}
		///特殊处理
		if ($_POST['query']['bank_id']<=0){	unset($_POST['query']['bank_id']);} 
		$type_array	=	array(
								'bank_money'		=>' in (1001,1003,1005)',//edited by jp 20131212 (add ",1005")   
								'banklog_money'		=>'=1002',
								'advance_money'		=>'=121',
								'client_money'		=>'in (103)',
								'factory_money'		=>'=203',
								'logistics_money'	=>'=303',
								'other_out_money'	=>'=800',
								'other_in_money'	=>'=801',  );  					
		$where = _search('to_hide=1');
		if (isset($type_array[$type])){
			$where .= ' and object_type '.$type_array[$type];  
		} 
		
		$where_paid = str_replace('paid_date','delivery_date',$where);
		$where_paid = str_replace('object_type','paid_object_type',$where); 
		
		$where_bill = str_replace('paid_date','bank_date',$where);
		$where_bill = str_replace('object_type','paid_object_type',$where_bill); 
		
		$where_bank = str_replace('paid_date','delivery_date',$where);
		$where_bank = str_replace('object_type','paid_object_type',$where_bank);
		$where = str_replace('currency_id','befor_currency_id',$where);
	  
		///手工单据
		if ($_GET['object_type']=='0'){ 
			$where_paid .= ' and object_type=1';  
			$where_bill	.='';
			$where_bank .= ' and bank_object_type in (1,2,3,4,5)';//edited by jp 20131212 (add ",5")
		}  
		if ($paid_type==1){///现金  
			$sql 	= 'select * from ( 
					select 0 as bank_id,befor_currency_id as currency_id,if(object_type in ('.$this->object_type_outlay.'),-1,1) as income_type,basic_id,paid_date,comments, 
					object_type,object_id,reserve_id as account_no, 
					(money/befor_rate) as money 
					from paid_detail 
					where '.$where.' and paid_type =1 and object_type in (1,103,121,801,203,303,800,1001,1002,1003,1005)
					union all
					select 0 as bank_id,currency_id,if(paid_object_type=1002,-1*income_type,income_type) as income_type,basic_id,delivery_date as paid_date,comments, 
							paid_object_type as object_type,bank_object_id as object_id,reserve_id as account_no, 
							money as money 
							from bank_center
							where '.$where_bank.' and state=2 and paid_type=1 and ((paid_object_type in (1001,1003,1005) and bank_id=0) or paid_object_type=1002)
					) as tmp order by paid_date,bank_id,income_type asc';//edited by jp 20131212 (add ",1005")   
		}elseif ($paid_type==2){///支票
			$sql 	= 'select * from (  
					select -1 as bank_id,currency_id,income_type,basic_id,bank_date as paid_date,comments, 
					paid_object_type as object_type,bank_object_id as object_id,reserve_id as account_no, 
						(money) as money 
						from bank_center
						where '.$where_bill.' and paid_type in (2,3) and state=1
					) as tmp order by paid_date,bank_id,income_type asc';
		}elseif ($paid_type==3) {
			$sql 	= 'select * from (  
					select bank_id,currency_id,income_type,basic_id,delivery_date as paid_date,  
						paid_object_type as object_type,bank_object_id as object_id,reserve_id as account_no,comments, 
						(money) as money 
						from bank_center
						where '.$where_bank.' and paid_type in (1,2,3) and state=2';
			$sql 	.= ' ) as tmp order by paid_date,bank_id,income_type asc';
		}else{  
			if ($all_paid_type==2){///支票 
				$sql = 'select * from (   
					select -1 as bank_id,currency_id,income_type,bank_date as paid_date,
						paid_object_type as object_type,bank_object_id as object_id,reserve_id as account_no,comments, 
						(money) as money 
						from bank_center
						where '.$where_bill.' and paid_type in (2,3) and state=1
						) as tmp order by paid_date,bank_id,income_type asc';
			}elseif ($all_paid_type==1){
				 $sql = 'select * from (   
				 	select 0 as bank_id,currency_id,if(income_type=1,-1,1) as income_type,delivery_date as paid_date, 
					paid_object_type as object_type,bank_object_id as object_id,reserve_id as account_no,comments, 
					(money) as money 
					from bank_center
					where '.$where_bank.' and state=2 and ((paid_object_type in (1001,1003,1005) and bank_id=0) or paid_object_type=1002)
				 	union all
					select 0 as bank_id,befor_currency_id as currency_id,if(object_type in ('.$this->object_type_outlay.'),-1,1) as income_type,paid_date,
					object_type,object_id,reserve_id as account_no,comments, 
					(money/befor_rate) as money 
					from paid_detail 
					where '.$where.' and ( money>0 || account_money>0 ) and paid_type =1 and object_type in (1,103,121,801,203,303,800,1001,1002,1003,1005) 
						) as tmp order by paid_date,bank_id,income_type asc';//edited by jp 20131212 (add ",1005")   
			}else{
				$sql = 'select * from (   ';
				if ($_GET['bank_id']<=0){
				$sql_untion=1;
				$sql .= ' 
				select 0 as bank_id,befor_currency_id as currency_id,if(object_type in ('.$this->object_type_outlay.'),-1,1) as income_type,paid_date,
					object_type,object_id,reserve_id as account_no,comments, 
					(money/befor_rate) as money 
					from paid_detail 
					where '.$where.' and ( money>0 || account_money>0 ) and paid_type =1 and object_type in (1,103,121,801,203,303,800,1001,1002,1003,1005) ';//edited by jp 20131212 (add ",1005")   
				}
			if ($sql_untion>0){
				$sql .= ' union all ';
			} 
			$sql .= '   
				select bank_id,currency_id,income_type,delivery_date as paid_date, 
					paid_object_type as object_type,bank_object_id as object_id,reserve_id as account_no,comments, 
					(money) as money 
					from bank_center
					where '.$where_bank.' and paid_type in (1,2,3) and state=2
				) as tmp order by paid_date,bank_id,income_type asc';
			} 
		}  
///		echo $sql; 
		$list	= _listStat($sql);
///		$list = $this->db->query($sql);      
		foreach ($list as &$value) {
			if ($value['income_type']==1) {
				$value['in_money'] 	= $value['money'];
				$value['out_money'] = 0;
				$remaining_money += $value['money'];
				$value['remaining_money'] = $remaining_money;
			}else {
				$value['out_money'] = $value['money'];
				$value['in_money'] 	= 0;
				$remaining_money -= $value['money'];
				$value['remaining_money'] = $remaining_money;
			}
			$value = $this->objectTypeCommentSubsidiary($value,'object_type');
		} 
		$list 	= _formatList($list);  
		
		$temp_b = S('bank');  
		$temp_b[0]['account_name']	=	L('cash');
		$temp_b[-1]['account_name']	=	L('bill');
		if ($_GET['from_date'] && $_GET['to_date']) {
			$str = formatDate($_GET['from_date'],'outdate').'——'.formatDate($_GET['to_date'],'outdate');
		}else {
			$str = $_GET['from_date'].$_GET['to_date'];
			$str = formatDate($str,'outdate');
		}    
		$currency_no	=	SOnly('currency',$_GET['currency_id'],'currency_no');
		$list['total']['title'] 				= '“'.$temp_b[$_GET['bank_id']]['account_name'].'('.$currency_no.')”账户'.$str.'的明细：';
		$list['total']['total_remaining_money'] = moneyFormat($remaining_money,0,C('MONEY_LENGTH'));
		///$list['page'] = $page;    
		return $list; 
	} 
	
	
}