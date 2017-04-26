<?php

/**
 * 销售统计
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    统计
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class StatSalePublicModel extends RelationCommonModel {
	
	protected $tableName	= 'sale_order';
	
	public function __construct(){
		parent::__construct();
		import('ORG.Util.Page');
	}
	/**
	 * 销售统计表
	 * @return 统计结果集
	 */
	public function getSaleStat() {
		
		return $this->getSaleNumByClass();
		
	}	
	
	/**
	 * 销售统计数据源
	 * @param array $info 查询条件
	 * @return array 查询结果集
	 */
	public function saleSource($info = array()) {
		extract($info);	
		$search 	= $this->getSearchWhere();	
		extract($search);	
		///$group.=' ,a.currency_id';
		if ($page) { /// 需分页
			if (C('sale.relation_sale_follow_up')==2) { /// 无发货流程
				$sql = 'select count(1) as count,sum(sale_quantity) as sale_quantity from (
							select a.id,sum(b.quantity*b.capability*b.dozen) as sale_quantity
							from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id 
							left join product_class_info c on b.product_id=c.product_id 
							where '.$where.'
							group by '.$group.'
						) as tmp group by 1=1';				
			} else { /// 有发货流程
				$sql = ' select count(1) as count, sum(sale_quantity) as sale_quantity  from (
							select a.id ,sum(if(a.sale_order_state =3 ,
							(d.quantity*d.capability*d.dozen),
							(b.quantity*b.capability*b.dozen)))as sale_quantity,
							a.currency_id, 0 as return_use_quantity, 0 as return_unuse_quantity, 
							0 as return_currency_id,0 as return_money
							from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id 
							left join delivery_detail d ON b.id = d.sale_order_detail_id and a.sale_order_state=3
							left join product_class_info c on b.product_id=c.product_id 
							where  (a.sale_order_state in (1,2) OR (a.sale_order_state =3 && d.id >0)) and  '.$where .'
							group by '.$group.'
						) as tmp  group by 1=1';								
			}			
			$count 	= M()->cache()->query($sql);
			$count	= reset($count);			
			///if (!$count) return ;
			$p 		= new Page($count['count']);
			$page 	= $p->show();
			/// 分页信息
			$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;
		}
		/// 取销售数量
		if (C('sale.relation_sale_follow_up')==2) { /// 无发货流程
			$sql = 'select a.client_id,a.basic_id,sum(quantity*capability*dozen) as sale_quantity,a.currency_id, 0 as return_unuse_quantity, 
					0 as return_currency_id,0 as return_money,
					sum(quantity*capability*dozen*price*discount) as sale_money,b.product_id,a.order_date,c.*'.$field.'
					from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id 
					left join product_class_info c on b.product_id=c.product_id 
					where '.$where.'
					group by '.$group.'
					order by '.$order_by.$limit;
		} else { /// 有发货流程
			$sql = 'select a.client_id,a.basic_id,a.order_date,a.currency_id,
					sum(if(a.sale_order_state =3 ,
					(d.quantity*d.capability*d.dozen),
					(b.quantity*b.capability*b.dozen))) as sale_quantity ,
					sum(if(a.sale_order_state =3 ,
					(d.quantity*d.capability*d.dozen*d.price*d.discount),
					(b.quantity*b.capability*b.dozen*b.price*b.discount))) as sale_money,				
					b.product_id,c.*'.$field.',0 as return_use_quantity, 0 as return_unuse_quantity, 
					0 as return_currency_id,0 as return_money
					from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id 
					left join delivery_detail d ON b.id = d.sale_order_detail_id  and a.sale_order_state=3
					left join product_class_info c on b.product_id=c.product_id 
					where   (a.sale_order_state in (1,2) OR (a.sale_order_state =3 && d.id >0)) and  '.$where .'
					group by '.$group.'
					order by '.$order_by.$limit;
		}
		$sale = $this->db->query($sql);				
		if (!$no_get_return) {			
			/// 取退货数量
			$sql = 'select sum(if (b.is_use =1,quantity*capability*dozen,0)) as return_use_quantity ,
					sum(if (b.is_use =2,quantity*capability*dozen,0)) as return_unuse_quantity,
					sum(quantity*capability*dozen*price*discount) as return_money,a.return_order_date,client_id,basic_id,
					b.product_id,c.*'.$field.',a.currency_id as return_currency_id,0 as sale_quantity,0 as sale_money,a.currency_id
					from return_sale_order a inner join return_sale_order_detail b on a.id=b.return_sale_order_id 
					left join product_class_info c on b.product_id=c.product_id 
					where '.$return_where.'
					group by '.$group.'
					order by '.$order_by;
			$return = $this->db->query($sql);			
			$return = _formatList($return);	
		}			
		return array('sale' => $sale, 'return' => $return['list'], 'page' => $page, 
					 'total_sale_quantity' 		 => $count['sale_quantity'], 
					 'total_return_use_quantity' => $return['total']['return_use_quantity'],
					 'total_return_unuse_quantity' => $return['total']['return_unuse_quantity'],
					 );
	}
		
	/**
	 * 获取查询条件.
	 * @return array 查询条件
	 */
	public function getSearchWhere() {
		
		if($_GET['sp_date_order_date']){
			return array('where' => _search_array(_getSpecialUrl($_GET)), 'return_where' => str_replace('order_date','return_order_date', _search_array(_getSpecialUrl($_GET))));
		}
		
		if ($_GET) {
			foreach ($_GET as $k => $v) {
				
				if ($k == 'type' || $k == 'sum_all' || $k == 'p' ||$k=='newtab' || $k=='_URL_'){ continue;}//added by jp 20131127 (add " || $k=='_URL_'")
				else if (strpos($k, 'date')) {
					
					$_POST['date'][$k] = $v;
				} else {
				
					$k == 'product_id' && $k='b.'.$k;
					$_POST['query'][$k] = $v;
				}				
			}
		}
		
		/// 销售与退货的日期字段不同做处理				
		if (array_filter(($_POST['date']))) {			
			$where = _search(); ///销售的查询条件
			$_POST['date']['from_return_order_date'] 	= $_POST['date']['from_order_date'];
			$_POST['date']['to_return_order_date'] 		= $_POST['date']['to_order_date'];		
			unset( $_POST['date']['from_order_date'], $_POST['date']['to_order_date'], $_POST['query']['b_product_id']);								
			$return_where 								= _search();	/// 退货的查询条件				
			$_POST['date']['from_order_date'] 			= $_POST['date']['from_return_order_date'];
			$_POST['date']['to_order_date'] 			= $_POST['date']['to_return_order_date'];	
			$_POST['query']['b_product_id']				= $_POST['query']['b.product_id'];
		} else {			
			$where 			= _search();	
			$return_where 	= $where;				
		}
		
		return array('where' => $where, 'return_where' => $return_where);
	}
		
	/**
	 * 获取链接URL
	 * @return string URL
	 */
	public function getUrl($ignore_date = 0) {		
		/// 生成URL链接	
		if (!empty($_POST)) {			
			$url_param 		= $_POST['query']['client_id'] ? '/client_id/'.$_POST['query']['client_id'] : '';
			$url_param 		.= $_POST['query']['basic_id'] ? '/basic_id/'.$_POST['query']['basic_id'] : '';
			!$ignore_date && $url_param 		.= $_POST['date']['from_order_date'] ? '/from_order_date/'.formatDate($_POST['date']['from_order_date']) : '';
			!$ignore_date && $url_param 		.= $_POST['date']['to_order_date'] ? '/to_order_date/'.formatDate($_POST['date']['to_order_date']) : '';	
			$url_param		.= $_POST['query']['class_1'] ? '/class_1/'.$_POST['query']['class_1'] : '';	
			$url_param		.= $_POST['query']['class_2'] ? '/class_2/'.$_POST['query']['class_2'] : '';
			$url_param		.= $_POST['query']['class_3'] ? '/class_3/'.$_POST['query']['class_3'] : '';	
			$url_param		.= $_POST['query']['class_4'] ? '/class_4/'.$_POST['query']['class_4'] : '';	
		} else {
			$url_param 		= $_GET['client_id'] ? '/client_id/'.$_GET['client_id'] : '';
			$url_param 		.= $_GET['basic_id'] ? '/basic_id/'.$_GET['basic_id'] : '';
			$url_param 		.= $_GET['from_order_date'] ? '/from_order_date/'.$_GET['from_order_date'] : ($_GET['sp_date_order_date'] ? '/from_order_date/'.$_GET['sp_date_order_date'] : '');
			
			$url_param 		.= $_GET['to_order_date'] ? '/to_order_date/'.$_GET['to_order_date'] : ($_GET['sp_date_order_date'] ? '/from_order_date/'.$_GET['sp_date_order_date'] : '');	
			$url_param		.= $_GET['class_1'] ? '/class_1/'.$_GET['class_1'] : '';	
			$url_param		.= $_GET['class_2'] ? '/class_2/'.$_GET['class_2'] : '';
			$url_param		.= $_GET['class_3'] ? '/class_3/'.$_GET['class_3'] : '';	
			$url_param		.= $_GET['class_4'] ? '/class_4/'.$_GET['class_4'] : '';	
			$url_param		.= $_GET['currency_id'] ? '/currency_id/'.$_GET['currency_id'] : '';				
		}	
		return $url_param;
	}
	
	/// 处理统计数据
	public function dealStatData($data, $class_level, $url_key) {
		$loop_data		= $data['sale'] ? $data['sale'] : $data['return'];
		$class_level == 5 && $url_key = 'client_id';
		$_POST['query']['b.product_id'] && $url_key = 'product_id';
		$_GET['type'] == 4 && $url_key = 'product_id';
		
		foreach ($loop_data as $k => $list) {					
			foreach ((array)$data['return'] as $rk => $r_list) { /// 退货数量					
				/// 类别和币种相同则合并为一条记录					
				if ($r_list['return_currency_id'] == $list['currency_id'] && $r_list[$url_key] == $list[$url_key]) {
				 	if (($class_level != 5) || ($class_level == 5 && $r_list['basic_id'] == $list['basic_id'])) {
						$list['return_use_quantity'] 			= $r_list['return_use_quantity'];
						$list['return_unuse_quantity'] 			= $r_list['return_unuse_quantity'];
						$list['return_currency_id']				= $r_list['return_currency_id'];
						$list['return_money']					= $r_list['return_money'];
						unset($data['return'][$rk]);
						continue;
			  		} 		
				}
			}			
			$stat[] = $list;	///[$list[$url_key]]
		}
					
		if(!empty($data['return'])) { /// 存在退货币种与销售不一致时,需将退货中币种合并到销售中
			foreach ($data['return'] as $rlist) {
				$temp['client_id'] 		= $rlist['client_id'];
				$temp['basic_id']  		= $rlist['basic_id'];
				$temp['order_date'] 	= $rlist['return_order_date'];
				$temp['currency_id']	= $rlist['return_currency_id'];
				$temp['sale_quantity']	= 0;
				$temp['sale_money']		= 0;				
				$temp['product_id'] 	= $rlist['product_id'];
				$temp['id'] 			= $rlist['id'];
				$temp['class_1'] 		= $rlist['class_1'];
				$temp['class_2'] 		= $rlist['class_2'];
				$temp['class_3'] 		= $rlist['class_3'];
				$temp['class_4'] 		= $rlist['class_4'];				
				$s_temp					=  array('return_use_quantity' 		=> $rlist['return_use_quantity'],
									 		'return_unuse_quantity' 		=> $rlist['return_unuse_quantity'],
									 		'return_currency_id'			=> $rlist['return_currency_id'],
											'return_money'			 		=> $rlist['return_money'],
										);	
				$stat_return[] = array_merge($temp, $s_temp); ///[$rlist[$url_key]]
			}
		}
		foreach((array)$stat as $key=>$val){
			$info[]	= $val;
			foreach((array)$stat_return as $k=>$value){
				if($val[$url_key]==$value[$url_key]){
					$info[]	= $value;
					unset($stat_return[$k]);
				}
			}
		}
		
		return $info;		
	}
	
	/**
	 * 销售统计（按类别）
	 * @return  array 统计结果集
	 */
	public function getSaleNumByClass() {		
		/// 产生搜索条件		
		$class_level 	= $_POST['class_level']; 
		$group 			= ($class_level == 2 ? 'c.class_2' : ($class_level == 3 ? 'c.class_3' : ($class_level == 4 ? 'c.class_4' : 'c.class_1')));
		$order_by		= ($class_level == 2 ? 'c.class_1' : ($class_level == 3 ? 'c.class_2' : ($class_level == 4 ? 'c.class_3' : 'c.class_1')));
		$url_key		= ($class_level == 2 ? 'class_2' : ($class_level == 3 ? 'class_3' : ($class_level == 4 ? 'class_4' : ($class_level == 5 ? 'client_id': 'class_1'))));
		$sum_key		= ($class_level == 2 ? 'class_1' : ($class_level == 3 ? 'class_2' : ($class_level == 4 ? 'class_3' : '')));	
			
		/// 执行查询语句
		if ($class_level == 5) { /// 客户统计
			$data 			= $this->saleSource(array('group' => 'client_id,basic_id,a.currency_id', 'field' => ',client_id,basic_id,currency_id', 'order_by' => 'client_id,basic_id', 'page' => 1));		
		} else if ($_POST['query']['b.product_id'] || $_GET['type'] == 4) { /// 按产品统计
			$url_key 		= 'product_id';
			$data 			= $this->saleSource(array('group' => 'b.product_id,a.currency_id', 'order_by' => 'b.product_id', 'page' => 1));	
		} else { /// 类别统计
			$data 			= $this->saleSource(array('group' => $group.' ,a.currency_id','order_by' => $order_by));	
		}	
		if (empty($data['sale']) && empty($data['return'])) return ;			
		foreach ((array)$data['return'] as $rk => $r_list) { /// 退货数量	
			/// 各类别的退货数量合计
			$sum_return_use[$r_list[$url_key]] 			+= $r_list['return_use_quantity'];
			$sum_return_unuse[$r_list[$url_key]] 		+= $r_list['return_unuse_quantity'];		
		}	
		foreach ((array)$data['sale'] as $rk => $r_list) { /// 退货数量				
			/// 各类别的销售数量合计
			$sum_sale[$r_list[$url_key]] 				+= $r_list['sale_quantity'];		
		}		
		
		///统计数据
		$stat = $this->dealStatData($data, $class_level, $url_key);		

		/// 获取URL参数
		$url_param		= $this->getUrl();			
		$product_class 	= S('product_class');

///		echo '<pre>';print_r($stat);exit;	
		///$stat_keys		= array_keys($stat);///用于二三级类别中判断是否加上一级的合计
		///$sum_i			= 0;	///用于二三级类别中判断是否加上一级的合计
		///foreach ($stat as $k => $top) {		
			///$sum_i++;		
			foreach ($stat as $tk => $list) {
				$url_param_2 = '';
				if($class_level == 5) { /// 按客户
					$url_param_2 = 'client_id/'.$list['client_id'].$url_param;///'/basic_id/'.$list['basic_id'].
				} else if($_GET['type'] == 4 || $_POST['query']['b.product_id']) { /// 按产品
					$url_param_2 = 'product_id/'.$list['product_id'].$url_param;
				} else {
					$url_param_2 = $url_key.'/'.$list[$url_key].$url_param;
				}								
				$list['head_field']											= $class_level == 5 ? $list['client_id'] : (($_POST['query']['b.product_id']||$_GET['type']==4) ? $list['product_id'] : $list[$url_key]); /// 分组头字段															
				$list['color']												= 0;			
				$list['class_name'] 										= $product_class[$list[$url_key]]['class_name'];	
				$list['sale_url']											= U('/StatSale/saleStatDetail/type/1/'.$url_param_2);
				$list['view_url']											= U('/StatSale/saleStatProduct/type/4/'.$url_param_2);	
				$list['return_use_url']										= U('/StatSale/saleStatDetail/type/2/'.$url_param_2);
				$list['return_unuse_url']									= U('/StatSale/saleStatDetail/type/3/'.$url_param_2);						
				$sum[$list[$sum_key]]['sale_quantity'] 						+= 	$list['sale_quantity'];			
				$sum[$list[$sum_key]]['return_use_quantity'] 				+= 	$list['return_use_quantity'];			
				$sum[$list[$sum_key]]['return_unuse_quantity']  			+= 	$list['return_unuse_quantity'];	
				$d_sum[$list[$sum_key]][$list['currency_id']]['sale_money']  += 	$list['sale_money'];	
				$d_sum[$list[$sum_key]][$list['currency_id']]['return_money'] += 	$list['return_money'];	
				$sum_money[$list['currency_id']]['sale']					+= $list['sale_money'];	
				$sum_money[$list['currency_id']]['return']					+= $list['return_money'];				
				$list['sale_quantity']										= intval($sum_sale[$list[$url_key]]);
				$list['return_use_quantity'] 								= intval($sum_return_use[$list[$url_key]]);
				$list['return_unuse_quantity'] 								= intval($sum_return_unuse[$list[$url_key]]);				
				$new_data[] = $list;	
								
				/// 将上级类别的合计附加到各类别数据后
				if ($class_level > 1 && $class_level <5 && !$_POST['query']['b.product_id']) {
					$list['color']				= 1;				
					$list['return_unuse_url'] 	= $list['sale_url'] = $list['return_use_url'] = $list['view_url'] = '';						
					if ($stat[$tk+1][$sum_key] != $list[$sum_key]) {
						$list['head_field']		= $list[$url_key].'000';
						$list['class_name']		= '"'. $product_class[$list[$sum_key]]['class_name'].'"'.L('row_total').'：';						
						foreach ($d_sum[$list[$sum_key]] as $cid => $m_list) {
							$list['sale_money']		= $m_list['sale_money'];
							$list['return_money']	= $m_list['return_money'];
							$list['currency_id']	= $cid;
							$new_data[] 			= array_merge($list, $sum[$list[$sum_key]]);
						}						
					}					
				} 

			}
		///} /// end foreach			
		/// 总合计		
		unset($m_list);			
		$list['head_field']				= 999990; /// 分组头字段		
		$list['class_name'] 			= L('row_total').'：';			
		$list['color']					= 1;			
		$list['basic_id']				= 0;					
		$list['return_unuse_url'] = $list['sale_url'] = $list['return_use_url'] = $list['view_url'] = '';
		$list['sale_quantity'] 			=	array_sum($sum_sale);
		$list['return_use_quantity'] 	= 	array_sum($sum_return_use);
		$list['return_unuse_quantity']	= 	array_sum($sum_return_unuse);
		foreach ($sum_money as $k => $m_list) {
			$list['currency_id'] 		= $k;
			$list['sale_money'] 		= $m_list['sale'];
			$list['return_money'] 		= $m_list['return'];
			unset($list['return_currency_id']);			
			$new_data[] 				= $list;	
		}			
		$new_data 					= _formatList($new_data);	
		$new_data['page']			= $data['page'];		
		$count						= count($new_data['list']);	
		return  $new_data;
	}
		
	/**
	 *  销售统计(按产品)
	 * @return  array 统计结果集
	 */
	public function getSaleNumByProduct() {				
		/// 执行查询语句
		$data 		= $this->saleSource(array('group' => 'b.product_id', 'order_by' => 'b.product_id', 'page' => 1));	
		if (empty($data['sale'])  && empty($data['return'])) return ;	
		$url_param	= $this->getUrl();	
		$loop_data	= $data['sale'] ? 	$data['sale'] : $data['return'];				
		foreach ($loop_data as $k => &$list) {			
			empty($data['sale']) &&	$list['sale_quantity']	= 0;
			$list['return_use_quantity']  				= $list['return_unuse_quantity'] = 0;
			foreach ((array)$data['return'] as $r_list) {	/// 退货数量					
				if ($r_list['product_id'] == $list['product_id']) {												
					$list['return_use_quantity'] 		= $r_list['return_use_quantity'];
					$list['return_unuse_quantity'] 		= $r_list['return_unuse_quantity'];
				}
			}
			$list['sale_url']							= U('/StatSale/saleStatDetail/type/1/product_id/'.$list['product_id'].$url_param);
			$list['return_use_url']						= U('/StatSale/saleStatDetail/type/2/product_id/'.$list['product_id'].$url_param);
			$list['return_unuse_url']					= U('/StatSale/saleStatDetail/type/3/product_id/'.$list['product_id'].$url_param);						
		}
		$list 			= _formatList($loop_data);
		$list['page']	= $data['page'];	
		if ($_POST['query']['b.product_id']) { 
			$list['total']['all_sale_quantity'] 		= $list['total']['total_sale_quantity'];
			$list['total']['all_use_quantity'] 			= $list['total']['total_return_use_quantity'];
			$list['total']['all_unuse_quantity']		= $list['total']['total_return_unuse_quantity'];
		} else {
			$list['total']['all_sale_quantity'] 		= moneyFormat($data['total_sale_quantity'], 0, 0);
			$list['total']['all_use_quantity'] 			= moneyFormat($data['total_return_use_quantity'], 0, 0);
			$list['total']['all_unuse_quantity']		= moneyFormat($data['total_return_unuse_quantity'], 0, 0);
		}
		return $list;			
	}
		
	/**
	 * 销售统计(按客户)
	 * @return array 统计结果集
	 */
	public function getSaleNumByClient() {
		$compare_type = $_GET['compare_type'];
		unset($_GET['compare_type']);	
		$url_param		= $this->getUrl();				  
		/// 执行SQL语句
		$data = $this->saleSource(array('group' => 'client_id,basic_id', 'field' => ',client_id,basic_id,currency_id', 'order_by' => 'client_id,basic_id', 'page' => 1));	
		
		if (empty($data['sale']) && empty($data['return'])) return ;	
		$loop_data = $data['sale'] ? $data['sale'] : $data['return'];
		$tmp	= $data['return'];
		foreach($loop_data as $key=>$val){
			foreach($tmp as $k=>$v){
				if($val['client_id']==$v['client_id']&&$val['basic_id']==$v['basic_id']){
					unset($tmp[$k]);
				}
			}
		}
		if(!empty($tmp)){
			$loop_data	= array_merge($loop_data,$tmp);
		}
		foreach ($loop_data as $k => &$list) {							
			$list['return_use_quantity']  =	$list['return_money'] = $list['return_unuse_quantity'] = 0;
			empty($data['sale']) && $list['sale_quantity'] = 0;
			foreach ((array)$data['return'] as $r_list) {	/// 退货数量					
				if ($r_list['client_id'] == $list['client_id'] && $r_list['basic_id'] == $list['basic_id']) {												
					$list['return_use_quantity'] 		= $r_list['return_use_quantity'];
					$list['return_unuse_quantity'] 		= $r_list['return_unuse_quantity'];
					$list['return_money']				= $r_list['return_money'];
				}						
			}
			/// 算平均单价
			$list['avg_price']							= ($list['sale_money'] - $list['return_money'])
															/($list['sale_quantity']-$list['return_use_quantity']-$list['return_unuse_quantity']);
			$list['view']								= L('view');	
		
			/// 生成URL
			$list['sale_url']							= U('/StatSale/saleStatDetail/type/1/client_id/'.$list['client_id'].'/basic_id/'.$list['basic_id'].$url_param);
			$list['return_use_url']						= U('/StatSale/saleStatDetail/type/2/client_id/'.$list['client_id'].'/basic_id/'.$list['basic_id'].$url_param);
			$list['return_unuse_url']					= U('/StatSale/saleStatDetail/type/3/client_id/'.$list['client_id'].'/basic_id/'.$list['basic_id'].$url_param);	
			$list['view_url']							= U('/StatSale/saleStatProduct/type/4/client_id/'.$list['client_id'].'/basic_id/'.$list['basic_id'].$url_param);
			$list['client_view_url']					= U('/StatClientAnalysis/clientDealAnalysisProduct/client_id/'.$list['client_id'].'/basic_id/'.$list['basic_id'].'/compare_type/'.$compare_type.$url_param);
																	
		}
		$list 											= _formatList($loop_data);
		$list['page']									= $data['page'];
		$list['total']['all_sale_quantity'] 			= moneyFormat($data['total_sale_quantity'], 0, 0);
		$list['total']['all_use_quantity'] 				= moneyFormat($data['total_return_use_quantity'], 0, 0);
		$list['total']['all_unuse_quantity']			= moneyFormat($data['total_return_unuse_quantity'], 0, 0);
		$title_date										= 	($compare_type == 1) ? substr($_GET['from_order_date'],0,4) : 
					  									 	(($compare_type == 2) ? substr($_GET['from_order_date'],0,7) :
					   										formatDate($_GET['from_order_date'], 'outdate')) ;		
		if (C('DIGITAL_FORMAT') == 'eur' && $compare_type ==2) {
			$title_date 								= formatDate($title_date.'-01', 'outdate');
			$title_date 								= substr($title_date, 3);	
		}
		$list['total']['title']							= '"'.$title_date.'""'.$list['list'][0]['currency_no'].'"'.L('deal_detail');	
		return $list;		
	}	
	
	/// 获取销售明细
	public function getSaleDetail() {

		/// 执行SQL语句
		$data 	= $this->saleSource(array('group' => 'a.id,b.product_id', 'field' => ',a.id as sale_id,a.sale_order_no', 'order_by' => 'b.product_id,a.id', 'page' => 1, 'no_get_return' => 1));										
		if (empty($data['sale'])) return ;		
		foreach ($data['sale'] as &$value) {
			$value['view_url'] 					= U('/SaleOrder/view/id/'.$value['sale_id'].'/product_id/'.$value['product_id']);
			$curr_money[$value['currency_id']] += $value['sale_money'];	
		}
		$list 					= _formatList($data['sale']);		
		$list['page']			= $data['page'];
		$list['total']['all_sale_quantity'] = $data['total_sale_quantity'];
		$currency	= S('currency');
		foreach ($curr_money as $k => $m) {
			$total_money.=$currency[$k]['currency_no'].'：'.moneyFormat($m, 0, C('MONEY_LENGTH')).'<br>';			
		}
		$list['total']['total_money']  	= $total_money;
		return $list;		
	}	
	
	/// 获取退货明细
	public function getReturnDetail() {
		/// 获取查询条件			
		$search 				= $this->getSearchWhere();	
		$search['return_where'] .= $_GET['type'] ==2 ? ' and is_use=1' : ' and is_use=2';		
		$title					= $_GET['type'] ==2 ? L('usefull') : L('usefull');
		$sql					= 'select count(1) as count ,sum(quantity) as all_quantity from ( 
									select a.id ,sum(quantity*capability*dozen) as quantity,
									sum(quantity*capability*dozen*price*discount) as return_money
									from return_sale_order a inner join return_sale_order_detail b on a.id=b.return_sale_order_id 
									left join product_class_info c on b.product_id=c.product_id 
									where '.$search['return_where'].'
									group by a.id,b.product_id
				  				   ) as tmp';		
		$count 					= M()->cache()->query($sql);
		$count					= reset($count);
		if (!$count) {			
			$list['total']['title'] = $_GET['type'] ==2 ? L('usefull') : L('unusefull');
			return $list;
		}
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		/// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;	
		/// 执行SQL语句
		$sql 	= 'select a.id as return_id,a.return_sale_order_no,sum(quantity*capability*dozen) as quantity ,		
						sum(quantity*capability*dozen*price*discount) as return_money,currency_id,			   
						b.product_id,c.* 
					from return_sale_order a inner join return_sale_order_detail b on a.id=b.return_sale_order_id 
					left join product_class_info c on b.product_id=c.product_id 
					where '.$search['return_where'].'
					group by a.id,b.product_id
					order by b.product_id,a.id'.$limit;	
		$list 	= $this->db->query($sql);	
		foreach ($list as &$value) {
			$value['view_url'] 					= U('/ReturnSaleOrder/view/id/'.$value['return_id'].'/product_id/'.$value['product_id']);
			$curr_money[$value['currency_id']] 	+= $value['return_money'];	
		}
		$list 									= _formatList($list);
		$list['page']							= $page;
		$list['total']['title'] 				= $_GET['type'] == 2 ? L('usefull') : L('unusefull');		
		$list['total']['all_quantity']			= moneyFormat($count['all_quantity'] , 0, 0) ;
		$currency	= S('currency');
		foreach ($curr_money as $k => $m) {
			$total_money.=$currency[$k]['currency_no'].'：'.moneyFormat($m, 0, C('MONEY_LENGTH')).'<br>';			
		}
		$list['total']['total_money']  	= $total_money;																	
		return $list;		
	}		
		

		 
	/**
	 * 客户久未交易分析
	 * @return array 客户久未交易分析数据
	 */
	public function getClientUndealDays() {
		$date 		= formatDate($_POST['to_order_date'] ? $_POST['to_order_date'] : date('Y-m-d'));
		$undeal_days= intval($_POST['undeal_days']);		
		$_POST['client_id'] && $where = ' and client_id='.intval($_POST['client_id']);
		if ($_POST['never_deal']) {
			$extra_where  = ' or b_id is null ';
		} else {
			$extra_where  = ' and b_id >0 ';
		}
		$sql 	= ' select count(1) as count  from (
						select a.id as client_id,b.id as b_id, if(isnull(b.id), 0, datediff(\''.$date.'\',max(b.order_date))) as undeal_days
						from company a left join sale_order b on a.id=b.client_id 
						where a.to_hide=1 and a.comp_type=0 '. $where.'
						group by a.id						
					) as a where undeal_days>='.$undeal_days.$extra_where;

		$count 	= $this->db->query($sql);
		$count	= reset($count);
		if (!$count) return ;
		$p = new Page($count['count']);
		$page = $p->show();
		/// 取列表信息
		$limit 			= ' limit '.$p->firstRow . ','.$p->listRows;
		$sql			= ' select * from (
							select a.id as client_id,b.id as b_id,if(isnull(b.id),\'0000-00-00\',max(date(b.order_date))) as order_date, if(isnull(b.id), 0, datediff(\''.$date.'\',max(b.order_date))) as undeal_days
							from company a left join sale_order b on a.id=b.client_id
							where  a.to_hide=1 and  a.comp_type=0  '. $where.'
							group by a.id
							order by undeal_days desc
							) as a where undeal_days>='.$undeal_days.$extra_where .$limit;	   
		$list			= $this->db->query($sql);
		$list			= _formatList($list);
		$list['page'] 	= $page;	
		return $list;
	}
	
	/// 客户交易分析图
	public function getClientDealData() {		
		/// 执行SQL语句
		$source 	= $this->saleSource(array('group' => 'a.id',  'order_by' => 'a.id'));	

		if (empty($source['sale']) && empty($source['return'])) return ;	
		/// 计算日期
		$dates 		= cacuDate($_POST['date']['from_order_date'], $_POST['date']['to_order_date'], $_POST['compare_type']);		
		$_POST['compare_type'] == 1 ? $date_key = 'Y' : ($_POST['compare_type'] == 2 ? $date_key = 'Y-m' : $date_key = 'Y-m-d');			
		if (is_array($dates)) {				
				/// 销售					
			foreach ($source['sale'] as $s_list) {
				$c_date = date($date_key, strtotime($s_list['order_date']));								
				$data[$s_list['currency_id']][$c_date]['sum_quantity'] 	+= $s_list['sale_quantity'];
				$data[$s_list['currency_id']][$c_date]['sum_price'] 		+= $s_list['sale_money'];					
			}
			/// 退货
			foreach ($source['return'] as $s_list) {
				$c_date = date($date_key, strtotime($s_list['return_order_date']));															
				$data[$s_list['currency_id']][$c_date]['sum_quantity'] 	-= $s_list['return_use_quantity'];
				$data[$s_list['currency_id']][$c_date]['sum_quantity'] 	-= $s_list['return_unuse_quantity'];
				$data[$s_list['currency_id']][$c_date]['sum_price'] 	-= $s_list['return_money'];					
			}				
		}		
					
		$url_param = $this->getUrl(1);
		$currency	= array_keys($data);
		foreach ($data as $c =>  $temp) { /// 数据
			foreach ($dates as $date) { /// 日期
				$show_date = $date;
				if ($date_key == 'Y-m') {/// 按月		
					if (C('DIGITAL_FORMAT') == 'eur') {
						$show_date 			= formatDate($show_date.'-01', 'outdate');
						$show_date 			= substr($show_date, 3);	
					}				
					$f_cp_date = substr(formatDate($_POST['date']['from_order_date']),0,6);		
					$t_cp_date = substr(formatDate($_POST['date']['to_order_date']),0,6);					
					$from_order_date 	= $f_cp_date == $show_date ? formatDate($_POST['date']['from_order_date']) : $date.'-01';
					$to_order_date		= $f_cp_date == $show_date ? formatDate($_POST['date']['to_order_date']) : $date.'-'.date('t', strtotime($from_order_date));
				} else if ($date_key == 'Y-m-d') { /// 按日	
					if (C('DIGITAL_FORMAT') == 'eur') {
						$show_date 			= formatDate($show_date, 'outdate');
///						$show_date 			= substr($show_date, 0, 5);	
					}
										
					$from_order_date	= $date;
					$to_order_date		= $date;					
				} else { /// 按年
					$from_order_date	= formatDate($_POST['date']['from_order_date'] ? $_POST['date']['from_order_date'] : $date.'-01-01');
					$to_order_date		= formatDate($_POST['date']['to_order_date'] ? $_POST['date']['to_order_date'] : $date.'-12-'.date('t', strtotime($date.'-12-01')));
					
				}
								
				if($temp[$date]) {
					$list[] = array('order_date'	=> $show_date,
								'currency_id'		=> $c,
								'sum_quantity'		=> $temp[$date]['sum_quantity'],
								'avg_price'			=> number_format($temp[$date]['sum_price']/$temp[$date]['sum_quantity'],C('PRICE_LENGTH')),
								'detail_url'		=> U('/StatClientAnalysis/clientDealAnalysisDetail/compare_type/'.$_POST['compare_type'].'/from_order_date/'.$from_order_date.
														'/currency_id/'.$c.$url_param.'/to_order_date/'.$to_order_date),		
								);
				} else {
///					if(in_array($c,$currency)){
///						$list[] = array('order_date'	=> $show_date,
///									'currency_id'		=> $c,
///									'sum_quantity'		=> 0,
///									'avg_price'			=> 0,	
///									'detail_url'		=> '',			
///								);
///					}
				}
///				echo '<pre>';print_r($temp);
			}
		}					
		return $this->resetAnalysis(_formatList($list));		
	}
	
	/// 客户交易分析图
	public function getClientDealProduct() {
		$compare_type 	= $_GET['compare_type'];
		unset($_GET['compare_type']);
		$search			= $this->getSearchWhere();
		extract($search);
		if (C('sale.relation_sale_follow_up')==2) { /// 无发货流程
				$sql = 'select count(1) as count,sum(sale_quantity) as sale_quantity, 
							sum(retrun_use_quantity) as retrun_use_quantity, sum(retrun_unuse_quantity) as retrun_unuse_quantity
						from (
							select a.id,0 as retrun_use_quantity, 0 as retrun_unuse_quantity,
							sum(b.quantity*b.capability*b.dozen) as sale_quantity
							from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id 
							left join product_class_info c on b.product_id=c.product_id 
							where '.$where.'
							group by b.product_id,a.id
							union all 
							select a.id,
							sum(if (b.is_use =1,quantity*capability*dozen,0)) as return_use_quantity,
							sum(if (b.is_use =2,quantity*capability*dozen,0)) as return_unuse_quantity,
							 0 as sale_quantity 
							from  return_sale_order a inner join return_sale_order_detail b on a.id=b.return_sale_order_id 
							left join product_class_info c on b.product_id=c.product_id 
							where '.$return_where.'
							group by b.product_id,a.id							
					) as tmp group by 1=1 ';				
			} else { /// 有发货流程
				$sql = ' select count(1) as count, sum(sale_quantity) as sale_quantity  , 
							sum(retrun_use_quantity) as retrun_use_quantity, sum(retrun_unuse_quantity) as retrun_unuse_quantity
						from (
							select a.id , 0 as retrun_use_quantity, 0 as retrun_unuse_quantity,
							sum(if(a.sale_order_state =3 ,
							(d.quantity*d.capability*d.dozen),
							(b.quantity*b.capability*b.dozen)))
							as sale_quantity 
							from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id 
							left join delivery_detail d on b.id=d.sale_order_detail_id and a.sale_order_state=3
							left join product_class_info c on b.product_id=c.product_id 
							where '.$where .'
							group by b.product_id,a.id	
							union all 
							select a.id,
							sum(if (b.is_use =1,quantity*capability*dozen,0)) as return_use_quantity,
							sum(if (b.is_use =2,quantity*capability*dozen,0)) as return_unuse_quantity,
							 0 as sale_quantity 
							from  return_sale_order a inner join return_sale_order_detail b on a.id=b.return_sale_order_id 
							left join product_class_info c on b.product_id=c.product_id 
							where '.$return_where.'
							group by b.product_id,a.id	
						) as tmp group by 1=1 ';								
			}
			$count 	= $this->db->query($sql);
			$count	= reset($count);			
			if (!$count) return ;
			$p 		= new Page($count['count']);
			$page 	= $p->show();
			/// 分页信息
			$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;	
			if (C('sale.relation_sale_follow_up')==2) { /// 无发货流程
				$sql = 'select * 
						from (
							select 1 as type,a.id,0 as return_use_quantity, 0 as return_unuse_quantity,client_id,basic_id,currency_id,
							sum(b.quantity*b.capability*b.dozen) as sale_quantity,order_date,b.product_id,sale_order_no,
							sum(b.quantity*b.capability*b.dozen*b.price*b.discount)/sum(b.quantity*b.capability*b.dozen) as avg_price
							from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id 
							left join product_class_info c on b.product_id=c.product_id 
							where '.$where.'
							group by b.product_id,a.id
							union all 
							select 2 as type,a.id,
							sum(if (b.is_use =1,quantity*capability*dozen,0)) as return_use_quantity,
							sum(if (b.is_use =2,quantity*capability*dozen,0)) as return_unuse_quantity,
							client_id,basic_id,currency_id,0 as sale_quantity, return_order_date as order_date,b.product_id,return_sale_order_no as sale_order_no,
							sum(b.quantity*b.capability*b.dozen*b.price*b.discount)/sum(b.quantity*b.capability*b.dozen) as avg_price
							from  return_sale_order a inner join return_sale_order_detail b on a.id=b.return_sale_order_id 
							left join product_class_info c on b.product_id=c.product_id 
							where '.$return_where.'
							group by b.product_id,a.id 					
					) as tmp 
					order by  product_id,order_date asc '.$limit;			
			} else { /// 有发货流程
				$sql = ' select *
						from (
							select 1 as type,a.id ,client_id,basic_id,a.currency_id,0 as return_use_quantity, 0 as return_unuse_quantity,order_date,b.product_id,sale_order_no,
							sum(if(a.sale_order_state =3 ,
							(d.quantity*d.capability*d.dozen),
							(b.quantity*b.capability*b.dozen)))
							as sale_quantity, 
							sum(if(a.sale_order_state =3 ,
							(d.quantity*d.capability*d.dozen*d.price*d.discount),
							(b.quantity*b.capability*b.dozen*b.price*b.discount))) / sum(if(a.sale_order_state =3 ,
							(d.quantity*d.capability*d.dozen),
							(b.quantity*b.capability*b.dozen))) as avg_price						
							from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id 
							left join delivery_detail d on b.id=d.sale_order_detail_id  and a.sale_order_state=3
							left join product_class_info c on b.product_id=c.product_id 
							where '.$where .'
							group by b.product_id,a.id	
							union all 
							select 2 as type,a.id,client_id,basic_id,a.currency_id,
							sum(if (b.is_use =1,quantity*capability*dozen,0)) as return_use_quantity,
							sum(if (b.is_use =2,quantity*capability*dozen,0)) as return_unuse_quantity,	
							return_order_date as order_date,b.product_id,return_sale_order_no as sale_order_no, 0 as sale_quantity,							
							sum(quantity*capability*dozen*price*discount)/sum(quantity*capability*dozen) as avg_price
							from  return_sale_order a inner join return_sale_order_detail b on a.id=b.return_sale_order_id 
							left join product_class_info c on b.product_id=c.product_id 
							where '.$return_where.'
							group by b.product_id,a.id
						) as tmp
						order by product_id,order_date asc '.$limit;									
			}
			$list								= $this->db->query($sql);			
			$list								= _formatList($list);	
			foreach ($list['list'] as &$value) {
				$value['sale_url'] = $value['type'] ==1 ? U("/SaleOrder/view/id/".$value['id']) :   U("/ReturnSaleOrder/view/id/".$value['id']) ;
			}
			$list['page']						= $page;	
			$list['total']['all_sale_quantity']	= moneyFormat($count['sale_quantity'], 0, 0);
			$list['total']['all_use_quantity']	= moneyFormat($count['retrun_use_quantity'], 0, 0);
			$list['total']['all_unuse_quantity']= moneyFormat($count['retrun_unuse_quantity'], 0, 0);
			$title_date							= 	($compare_type == 1) ? substr($_GET['from_order_date'],0,4) : 
					  								(($compare_type == 2) ? substr($_GET['from_order_date'],0,7) :
					   								formatDate($_GET['from_order_date'], 'outdate')) ;		
			if (C('DIGITAL_FORMAT') == 'eur' && $compare_type ==2) {
				$title_date 					= formatDate($title_date.'-01', 'outdate');
				$title_date 					= substr($title_date, 3);	
			}
///			echo '<pre>';print_r($list);
			$list['total']['title']				= '"'.$title_date.'""'.$list['list'][0]['client_name'].'"'.L('in').'"'.$list['list'][0]['basic_name']
													.'"'.$list['list'][0]['currency_no'].'"'.L('deal_detail');
			return $list;
			
	}
	
	public function resetAnalysis($list){
		foreach((array)$list['list'] as $_key=>$_val){
			if(empty($info['list'][$_val['order_date']])){
				$info['list'][$_val['order_date']] = $_val;
				$info['list'][$_val['order_date']]['curr'][$_val['currency_id']]=$_val;
			}else{
				$info['list'][$_val['order_date']]['curr'][$_val['currency_id']]=$_val;
			}
		}
		$info['total']=$list['total'];
		
		return $info;
		
	}
}

?>