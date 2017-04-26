<?php

/**
 * 进销存统计
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    统计
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class StatStoragePublicModel extends Model {
	protected $tableName	= 'product';
	
	public function __construct(){
		parent::__construct();
		import('ORG.Util.Page');
	}
	/**
	 * 进销存按类别统计
	 * @return array
	 */
	public function getStorage() {
		$group_level 	= intval($_POST['class_level']);
		$parent_level	= $group_level-1;
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
		$from_date && $url_search = '/from_date/'.formatDate($from_date);
		$to_date && $url_search .= '/to_date/'.formatDate($to_date);
		$_POST['query']['class_1'] && $url_search .= '/class_1/'.$_POST['query']['class_1'];
		$_POST['query']['class_2'] && $url_search .= '/class_2/'.$_POST['query']['class_2'];
		$_POST['query']['class_3'] && $url_search .= '/class_3/'.$_POST['query']['class_3'];
		$_POST['query']['class_4'] && $url_search .= '/class_4/'.$_POST['query']['class_4'];
		$group_by = ' group by class_'.$group_level.' order by class_'.$group_level.' asc'; 
		$class_field = 'class_'.$group_level.' as product_class_id,';
		// 取期初单据数量
		$_POST['date']['from_init_storage_date'] 	= $from_date;
		$_POST['date']['to_init_storage_date'] 		= $to_date;
		$where = _search();
		unset($_POST['date']['from_init_storage_date']);
		unset($_POST['date']['to_init_storage_date']);
		if ($from_date) {
			// 加起始日期结余
			$_POST['date']['ltt_in_date'] 	= $from_date;
			$where_history = _search();
			unset($_POST['date']['ltt_in_date']);
			$_POST['date']['ltt_out_date'] 	= $from_date;
			$where_out = _search();
			unset($_POST['date']['ltt_out_date']);
			$sql = '
				select id,product_id,class_1,class_2,class_3,class_4,product_class_id,sum(init_quantity) as init_quantity from (
					select c.*,'.$class_field.'a.quantity*a.capability*a.dozen as init_quantity 
					from stock_in a 
					left join product_class_info c on(a.product_id = c.product_id) 
					where '.$where_history.' 
				union all 
					select c.*,'.$class_field.'a.quantity*a.capability*a.dozen*-1 as init_quantity 
					from stock_out a 
					left join product_class_info c on(a.product_id = c.product_id) 
					where '.$where_out.' 
				) as a '.$group_by;
			$temp_init = $this->resetArray($this->db->query($sql),'product_class_id');
		}
		// 入库数量
		$_POST['date']['from_real_arrive_date'] = $from_date;
		$_POST['date']['to_real_arrive_date'] = $to_date;
		$where 		= _search();
		unset($_POST['date']['from_real_arrive_date']);
		unset($_POST['date']['to_real_arrive_date']);
		$_POST['date']['from_init_storage_date'] = $from_date;
		$_POST['date']['to_init_storage_date'] = $to_date;
		$where_init = _search();
		unset($_POST['date']['from_init_storage_date']);
		unset($_POST['date']['to_init_storage_date']);
		$sql = '
				select id,product_id,class_1,class_2,class_3,class_4,product_class_id,sum(stock_quantity) as stock_quantity from(
					select c.*,'.$class_field.'a.quantity*a.capability*a.dozen as stock_quantity 
						from instock_detail a 
						left join instock b on(b.id=a.instock_id) 
						left join product_class_info c on(a.product_id = c.product_id) 
						where '.$where.' 
					union all 
					select c.*,'.$class_field.'a.quantity*a.capability*a.dozen as stock_quantity 
					from init_storage_detail a 
					left join init_storage b on(b.id=a.init_storage_id) 
					left join product_class_info c on(a.product_id = c.product_id) 
					where '.$where_init.') as a '.$group_by;
		$temp_instock = $this->resetArray($this->db->query($sql),'product_class_id');
		if (C('sale.relation_sale_follow_up')==1) {
			// 统计发货数量
			$_POST['date']['from_delivery_date'] = $from_date;
			$_POST['date']['to_delivery_date'] = $to_date;
			$where = _search();
			unset($_POST['date']['from_delivery_date']);
			unset($_POST['date']['to_delivery_date']);
			$sql = 'select c.*,'.$class_field.'sum(a.quantity*a.capability*a.dozen) as sale_quantity 
				from delivery_detail a 
				left join delivery b on(b.id=a.delivery_id) 
				left join product_class_info c on(a.product_id = c.product_id) 
				where '.$where.$group_by;
			$temp_sale = $this->resetArray($this->db->query($sql),'product_class_id');
		}else {	
			// 统计销售数量
			$_POST['date']['from_order_date'] = $from_date;
			$_POST['date']['to_order_date'] = $to_date;
			$where = _search();
			unset($_POST['date']['from_order_date']);
			unset($_POST['date']['to_order_date']);
			$sql = 'select c.*,'.$class_field.'sum(a.quantity*a.capability*a.dozen) as sale_quantity 
				from sale_order_detail a 
				left join sale_order b on(b.id=a.sale_order_id) 
				left join product_class_info c on(a.product_id = c.product_id) 
				where '.$where.$group_by;
			$temp_sale = $this->resetArray($this->db->query($sql),'product_class_id');
		}
		// 退货数量
		$_POST['date']['from_return_order_date'] = $from_date;
		$_POST['date']['to_return_order_date'] = $to_date;
		$where = _search();
		unset($_POST['date']['from_return_order_date']);
		unset($_POST['date']['to_return_order_date']);
		$sql = 'select c.*,'.$class_field.'
					sum(if(a.is_use=1,a.quantity*a.capability*a.dozen,0)) as back_quantity, 
					sum(if(a.is_use=2,a.quantity*a.capability*a.dozen,0)) as no_use_quantity 
				from return_sale_order_detail a 
				left join return_sale_order b on(b.id=a.return_sale_order_id) 
				left join product_class_info c on(a.product_id = c.product_id) 
				where '.$where.$group_by;
		$temp_return = $this->resetArray($this->db->query($sql),'product_class_id');
		
		// 调整数量
		$_POST['date']['from_adjust_date'] = $from_date;
		$_POST['date']['to_adjust_date'] = $to_date;
		$where = _search();
		unset($_POST['date']['from_adjust_date']);
		unset($_POST['date']['to_adjust_date']);
		$sql = 'select c.*,'.$class_field.'sum(a.quantity*a.capability*a.dozen) as adjust_quantity 
				from adjust_detail a 
				left join adjust b on(b.id=a.adjust_id) 
				left join product_class_info c on(a.product_id = c.product_id) 
				where '.$where.$group_by;
		$temp_adjust = $this->resetArray($this->db->query($sql),'product_class_id');
		
		// 盈亏数量
		$_POST['date']['from_profitandloss_date'] = $from_date;
		$_POST['date']['to_profitandloss_date'] = $to_date;
		$where = _search();
		unset($_POST['date']['from_profitandloss_date']);
		unset($_POST['date']['to_profitandloss_date']);
		$sql = 'select c.*,'.$class_field.'sum((a.stocktake_quantity-a.storage_quantity)*a.capability*a.dozen) as stocktake_quantity 
				from profitandloss_detail a 
				left join profitandloss b on(b.id=a.profitandloss_id) 
				left join product_class_info c on(a.product_id = c.product_id) 
				where '.$where.' and b.state=2 '.$group_by;
		$temp_profitandloss = $this->resetArray($this->db->query($sql),'product_class_id');
		// 获取存在数据的产品类别
		$all_class_1 = $temp_init ? array_keys($temp_init) : array();
		$all_class_2 = $temp_instock ? array_keys($temp_instock) : array();
		$all_class_3 = $temp_sale ? array_keys($temp_sale) : array();
		$all_class_4 = $temp_return ? array_keys($temp_return) : array();
		$all_class_5 = $temp_adjust ? array_keys($temp_adjust) : array();
		$all_class_6 = $temp_profitandloss ? array_keys($temp_profitandloss) : array();

		$temp_class = array_unique(array_merge($all_class_1,$all_class_2,$all_class_3,$all_class_4,$all_class_5,$all_class_6));
		$dd_class = S('product_class');
		// 组织报表数组
		foreach ($temp_class as $key => $class_id) {
			$list[$key]['product_class_id'] 	= $class_id;
			$list[$key]['class_1'] 				= $temp_init[$class_id]['class_1']|$temp_instock[$class_id]['class_1']|$temp_sale[$class_id]['class_1']|$temp_return[$class_id]['class_1']|$temp_adjust[$class_id]['class_1']|$temp_profitandloss[$class_id]['class_1'];
			$list[$key]['class_2'] 				= $temp_init[$class_id]['class_2']|$temp_instock[$class_id]['class_2']|$temp_sale[$class_id]['class_2']|$temp_return[$class_id]['class_2']|$temp_adjust[$class_id]['class_2']|$temp_profitandloss[$class_id]['class_2'];
			$list[$key]['class_3'] 				= $temp_init[$class_id]['class_3']|$temp_instock[$class_id]['class_3']|$temp_sale[$class_id]['class_3']|$temp_return[$class_id]['class_3']|$temp_adjust[$class_id]['class_3']|$temp_profitandloss[$class_id]['class_3'];
			$list[$key]['class_4'] 				= $temp_init[$class_id]['class_4']|$temp_instock[$class_id]['class_4']|$temp_sale[$class_id]['class_4']|$temp_return[$class_id]['class_4']|$temp_adjust[$class_id]['class_4']|$temp_profitandloss[$class_id]['class_4'];
			
			$list[$key]['init_quantity'] 		= $temp_init[$class_id]['init_quantity']|0;
			$list[$key]['stock_quantity'] 		= $temp_instock[$class_id]['stock_quantity']|0;
			$list[$key]['sale_quantity'] 		= $temp_sale[$class_id]['sale_quantity']|0;
			$list[$key]['back_quantity'] 		= $temp_return[$class_id]['back_quantity']|0;
			$list[$key]['no_use_quantity'] 		= $temp_return[$class_id]['no_use_quantity']|0;
			$list[$key]['adjust_quantity'] 		= $temp_adjust[$class_id]['adjust_quantity']|0;
			$list[$key]['stocktake_quantity'] 	= $temp_profitandloss[$class_id]['stocktake_quantity']|0;
			$list[$key]['real_quantity'] 		= $temp_init[$class_id]['init_quantity']+$temp_instock[$class_id]['stock_quantity']-$temp_sale[$class_id]['sale_quantity']+$temp_return[$class_id]['back_quantity']+$temp_adjust[$class_id]['adjust_quantity']+$temp_profitandloss[$class_id]['stocktake_quantity'];
			if ($parent_level>0) {
				$list[$key]['parent_id'] 	= $list[$key]['class_'.$parent_level];
				$list[$key]['parent_name']	= '“'.$dd_class[$list[$key]['parent_id']]['class_name'].'”合计：';
				$sum[$list[$key]['class_'.$parent_level]]['sum_sale_quantity'] 			+= $temp_sale[$class_id]['sale_quantity']|0;
				$sum[$list[$key]['class_'.$parent_level]]['sum_init_quantity'] 			+= $temp_init[$class_id]['init_quantity']|0;
				$sum[$list[$key]['class_'.$parent_level]]['sum_stock_quantity'] 		+= $temp_instock[$class_id]['stock_quantity']|0;
				$sum[$list[$key]['class_'.$parent_level]]['sum_back_quantity'] 			+= $temp_return[$class_id]['back_quantity']|0;
				$sum[$list[$key]['class_'.$parent_level]]['sum_adjust_quantity'] 		+= $temp_adjust[$class_id]['adjust_quantity']|0;
				$sum[$list[$key]['class_'.$parent_level]]['sum_stocktake_quantity'] 	+= $temp_profitandloss[$class_id]['stocktake_quantity']|0;
				$sum[$list[$key]['class_'.$parent_level]]['sum_real_quantity'] 			+= $list[$key]['real_quantity'];
				$sum[$list[$key]['class_'.$parent_level]]['sum_no_use_quantity'] 		+= $temp_return[$class_id]['no_use_quantity']|0;
			}
			// 设置链接地址
			
			$list[$key]['url_stock'] 			= U('/StatStorage/storageDetail/type/stock/class_'.$group_level.'/'.$class_id.$url_search);
			$list[$key]['url_sale'] 			= U('/StatStorage/storageDetail/type/sale/class_'.$group_level.'/'.$class_id.$url_search);
			$list[$key]['url_return_use'] 		= U('/StatStorage/storageDetail/type/returnuse/class_'.$group_level.'/'.$class_id.$url_search);
			$list[$key]['url_return_no_use'] 	= U('/StatStorage/storageDetail/type/returnnouse/class_'.$group_level.'/'.$class_id.$url_search);
			$list[$key]['url_adjust'] 			= U('/StatStorage/storageDetail/type/adjust/class_'.$group_level.'/'.$class_id.$url_search);
			$list[$key]['url_stocktake'] 		= U('/StatStorage/storageDetail/type/stocktake/class_'.$group_level.'/'.$class_id.$url_search);
			$list[$key]['url_product'] 			= U('/StatStorage/storageProduct/class_'.$group_level.'/'.$class_id.$url_search);
			$list[$key]['view'] 				= L('view');
			$total_real_quantity				+= $list[$key]['real_quantity'];
		}
		if ($parent_level>0) {// 合并上级类别合计到数组中
			foreach ($list as &$value2) {
				$value2 = array_merge($value2,$sum[$value2['class_'.$parent_level]]);
			}
		}
		$list = _formatList($list);
		$list['total']['total_real_quantity'] = moneyFormat($total_real_quantity,0,0);
		$list = $this->getClassArray($list);
		return $list;
	}
	
	/**
	 * 进销存按产品统计
	 * @return uarray
	 */
	public function getProduct() {
		$_POST = array();
		$url_search = '';
		foreach ($_GET as $key => $value) {
			if (strpos($key,'lass_')) {$_POST['query'][$key] = $value;}
		}
		if ($_GET['pid']){ $_POST['query']['a.product_id'] = $_GET['pid'];}
		
		$from_date 	= $_GET['from_date'];
		$to_date 	= $_GET['to_date'];
		$from_date && $url_search .= '/from_date/'.formatDate($from_date);
		$to_date && $url_search .= '/to_date/'.formatDate($to_date);
		
		$order_by	= ' group by a.product_id order by a.product_id asc';
		// 取期初单据数量+起始日期结余
		$_POST['date']['from_init_storage_date'] = $from_date;
		$_POST['date']['to_init_storage_date'] = $to_date;
		 $where = _search();
		unset($_POST['date']['from_init_storage_date']);
		unset($_POST['date']['to_init_storage_date']);
		unset($_POST['query']['a_product_id']);
//		echo $from_date;
		if ($from_date) {
			// 加起始日期结余
			$_POST['date']['ltt_in_date'] 	= $from_date;
			$where_history = _search();
			unset($_POST['date']['ltt_in_date']);
			$_POST['date']['ltt_out_date'] 	= $from_date;
			unset($_POST['query']['a_product_id']);
			$where_out = _search();
			unset($_POST['date']['ltt_out_date']);
			$sql = '
				select product_id,sum(init_quantity) as init_quantity from (
					select a.product_id,a.quantity*a.capability*a.dozen as init_quantity 
					from stock_in a 
					left join product_class_info c on(a.product_id = c.product_id) 
					where '.$where_history.' 
				union all 
					select a.product_id,a.quantity*a.capability*a.dozen*-1 as init_quantity 
					from stock_out a 
					left join product_class_info c on(a.product_id = c.product_id) 
					where '.$where_out.'
				) as a '.$order_by;
			$temp_init = $this->resetArray($this->db->query($sql),'product_id');
		}
		// 入库数量
		$_POST['date']['from_real_arrive_date'] = $from_date;
		$_POST['date']['to_real_arrive_date'] = $to_date;
		unset($_POST['query']['a_product_id']);
		$where = _search();
		unset($_POST['query']['a_product_id']);
		unset($_POST['date']['from_real_arrive_date']);
		unset($_POST['date']['to_real_arrive_date']);
		$_POST['date']['from_init_storage_date'] = $from_date;
		$_POST['date']['to_init_storage_date'] = $to_date;
		$where_init = _search();
		unset($_POST['date']['from_init_storage_date']);
		unset($_POST['date']['to_init_storage_date']);
		
		$sql = '
				select product_id,sum(instock_quantity) as instock_quantity from (
					select  a.product_id, a.quantity*a.capability*a.dozen as instock_quantity from instock_detail a 
					left join instock b on(a.instock_id=b.id) 
					left join product_class_info c on(a.product_id=c.product_id) 
					where '.$where.'
				union all 
					select a.product_id, a.quantity*a.capability*a.dozen as instock_quantity from init_storage_detail a 
					left join init_storage b on(b.id=a.init_storage_id) 
					left join product_class_info c on(a.product_id = c.product_id) 
					where '.$where_init.') as a '.$order_by; 
		$temp_instock = $this->resetArray($this->db->query($sql),'product_id');

		if (C('sale.relation_sale_follow_up')==1) {
			// 统计发货数量
			$_POST['date']['from_delivery_date'] = $from_date;
			$_POST['date']['to_delivery_date'] = $to_date;
			unset($_POST['query']['a_product_id']);
			$where = _search();
			unset($_POST['date']['from_delivery_date']);
			unset($_POST['date']['to_delivery_date']);
			$sql = 'select 
					a.product_id,
					sum(a.quantity*a.capability*a.dozen) as sale_quantity 
				from delivery_detail a 
				left join delivery b on(a.delivery_id=b.id) 
				left join product_class_info c on(a.product_id=c.product_id) 
				where '.$where.$order_by;
			$temp_sale = $this->resetArray($this->db->query($sql),'product_id');
		}else {	
			// 统计销售数量
			$_POST['date']['from_order_date'] = $from_date;
			$_POST['date']['to_order_date'] = $to_date;
			unset($_POST['query']['a_product_id']);
			$where = _search();
			unset($_POST['date']['from_order_date']);
			unset($_POST['date']['to_order_date']);
			$sql = 'select 
					a.product_id,
					sum(a.quantity*a.capability*a.dozen) as sale_quantity 
				from sale_order_detail a 
				left join sale_order b on(a.sale_order_id=b.id) 
				left join product_class_info c on(a.product_id=c.product_id) 
				where '.$where.$order_by;
			$temp_sale = $this->resetArray($this->db->query($sql),'product_id');
		}
		// 退货数量
		$_POST['date']['from_return_order_date'] = $from_date;
		$_POST['date']['to_return_order_date'] = $to_date;
		unset($_POST['query']['a_product_id']);
		$where = _search();
		unset($_POST['date']['from_return_order_date']);
		unset($_POST['date']['to_return_order_date']);
		$sql = 'select 
					a.product_id,
					sum(if(a.is_use=1,a.quantity*a.capability*a.dozen,0)) as back_quantity, 
					sum(if(a.is_use=2,a.quantity*a.capability*a.dozen,0)) as no_use_quantity 
				from return_sale_order_detail a 
				left join return_sale_order b on(a.return_sale_order_id=b.id) 
				left join product_class_info c on(a.product_id=c.product_id) 
				where '.$where.$order_by;
		$temp_return = $this->resetArray($this->db->query($sql),'product_id');
		
		// 调整数量
		$_POST['date']['from_adjust_date'] = $from_date;
		$_POST['date']['to_adjust_date'] = $to_date;
		unset($_POST['query']['a_product_id']);
		$where = _search();
		unset($_POST['date']['from_adjust_date']);
		unset($_POST['date']['to_adjust_date']);
		$sql = 'select 
					a.product_id,
					sum(a.quantity*a.capability*a.dozen) as adjust_quantity 
				from adjust_detail a 
				left join adjust b on(a.adjust_id=b.id) 
				left join product_class_info c on(a.product_id=c.product_id) 
				where '.$where.$order_by;
		$temp_adjust = $this->resetArray($this->db->query($sql),'product_id');
		
		// 盈亏数量
		$_POST['date']['from_profitandloss_date'] = $from_date;
		$_POST['date']['to_profitandloss_date'] = $to_date;
		unset($_POST['query']['a_product_id']);
		$where = _search();
		unset($_POST['date']['from_profitandloss_date']);
		unset($_POST['date']['to_profitandloss_date']);
		$sql = 'select 
					a.product_id,
					sum((a.stocktake_quantity-a.storage_quantity)*a.capability*a.dozen) as stocktake_quantity 
				from profitandloss_detail a 
				left join profitandloss b on(a.profitandloss_id=b.id) 
				left join product_class_info c on(a.product_id=c.product_id) 
				where '.$where.$order_by;
		$temp_profitandloss = $this->resetArray($this->db->query($sql),'product_id');
		
		$where = '';
		// 获取存在数据的产品类别
		$all_product_1 = $temp_init ? array_keys($temp_init) : array();
		$all_product_2 = $temp_instock ? array_keys($temp_instock) : array();
		$all_product_3 = $temp_sale ? array_keys($temp_sale) : array();
		$all_product_4 = $temp_return ? array_keys($temp_return) : array();
		$all_product_5 = $temp_adjust ? array_keys($temp_adjust) : array();
		$all_product_6 = $temp_profitandloss ? array_keys($temp_profitandloss) : array();
		$temp_product = array_unique(array_merge($all_product_1,$all_product_2,$all_product_3,$all_product_4,$all_product_5,$all_product_6));
		
		
		$list = array();
		foreach ($temp_product as $key => $product_id) {
			$list[$product_id]['product_id']			= $product_id;
			$list[$product_id]['init_quantity'] 		= $temp_init[$product_id]['init_quantity']|0;
			$list[$product_id]['stock_quantity'] 	= $temp_instock[$product_id]['instock_quantity']|0;
			$list[$product_id]['sale_quantity'] 		= $temp_sale[$product_id]['sale_quantity']|0;
			$list[$product_id]['back_quantity'] 		= $temp_return[$product_id]['back_quantity']|0;
			$list[$product_id]['no_use_quantity'] 	= $temp_return[$product_id]['no_use_quantity']|0;
			$list[$product_id]['adjust_quantity'] 	= $temp_adjust[$product_id]['adjust_quantity']|0;
			$list[$product_id]['stocktake_quantity'] = $temp_profitandloss[$product_id]['stocktake_quantity']|0;
			$list[$product_id]['real_quantity'] 		= $temp_init[$product_id]['init_quantity']+$temp_instock[$product_id]['instock_quantity']-$temp_sale[$product_id]['sale_quantity']+$temp_return[$product_id]['back_quantity']+$temp_adjust[$product_id]['adjust_quantity']+$temp_profitandloss[$product_id]['stocktake_quantity'];
			
			// 指定各流程链接地址
			
			$list[$product_id]['url_stock'] 		= U('/StatStorage/storageDetail/type/stock/product/'.$product_id.$url_search);
			$list[$product_id]['url_sale'] 			= U('/StatStorage/storageDetail/type/sale/product/'.$product_id.$url_search);
			$list[$product_id]['url_return_use'] 	= U('/StatStorage/storageDetail/type/returnuse/product/'.$product_id.$url_search);
			$list[$product_id]['url_return_no_use'] = U('/StatStorage/storageDetail/type/returnnouse/product/'.$product_id.$url_search);
			$list[$product_id]['url_adjust'] 		= U('/StatStorage/storageDetail/type/adjust/product/'.$product_id.$url_search);
			$list[$product_id]['url_stocktake'] 	= U('/StatStorage/storageDetail/type/stocktake/product/'.$product_id.$url_search);

		}
		
		$list = _formatList($list);
		return $list;
	}

	/**
	 * 查看各流程明细
	 * @return  array
	 */
	public function storageDetail() {
		$type = trim($_GET['type']);
		unset($_GET['type']);
		$url_array = array('stock'=>'real_arrive_date','returnuse'=>'date(return_order_date)','adjust'=>'adjust_date','stocktake'=>'profitandloss_date');
		$url_array['sale'] = C('sale.relation_sale_follow_up')==1 ? 'date(delivery_date)' : 'date(order_date)';
		$url_array['returnnouse'] = $url_array['returnuse'];
		foreach ($_GET as $key => $value) {
			if ($key=='p') {
				continue;
			}
			if ($key=='from_date') {
				$_POST['date']['from_'.$url_array[$type]] = $value;
				continue;
			}
			if ($key=='to_date') {
				$_POST['date']['to_'.$url_array[$type]] = $value;
				continue;
			}
			if ($key=='product') {
				$_POST['query']['a.product_id'] = $value;
				continue;
			}
			$_POST['query'][$key] = $value;
		}
		$where = _search();
		if ($type=='stock') {
			$where2 = str_replace('real_arrive_date','init_storage_date',$where);
		}
		$sql = $this->getSql($type,$where,$where2);
		$sql2 	= 'select count(1) as count from ('.$sql.') as tmp';
		$count 	= M()->cache()->query($sql2);
		$count	= reset($count);
		$p = new Page($count['count']);
		$page = $p->show();
		// 取列表信息
		$limit = ' limit '.$p->firstRow . ','.$p->listRows;
		$sql .= $limit;
		$list = $this->db->query($sql);
		$url_array = array('stock'=>'/Instock/view/id/','init'=>'/InitStorage/view/id/','returnuse'=>'/ReturnSaleOrder/view/id/','adjust'=>'/Adjust/view/id/','stocktake'=>'/Profitandloss/view/id/');
		if (C('sale.relation_sale_follow_up')==1) {
			$url_array['sale'] = '/Delivery/view/id/';
		}else {
			$url_array['sale'] = '/SaleOrder/view/id/';
		}
		$url_array['returnnouse'] = $url_array['returnuse'];
		foreach ($list as &$value) {
			if ($value['flow_type']==8) {
				$value['detail_url'] = U($url_array['init'].$value['link_id']);
				$arr	= @explode('/',$url_array['init']);
			}else {
				$value['detail_url'] = U($url_array[$type].$value['link_id']);
				$arr	= @explode('/',$url_array[$type]);
			}
			$value['detail_title']	= title($arr[2],$arr[1]);
		}
		$list = _formatList($list);
		$list['page'] = $page;
		foreach($_POST as $key=>$val){
			if($key=='search_form') continue;
			unset($_POST[$key]);
		}
		
		return $list;
	}
	
	/**
	 * 根据流程获取对应明细信息
	 * @param  strng $type
	 * @param  string $where
	 * @return  array
	 */
	private function getSql($type,$where=null,$where2=null){
		// 入库数量 包括入库流程+期初单据
		$sql['stock'] = '
						select 2 as flow_type,a.product_id,b.id as link_id,b.instock_no as link_no,a.quantity*a.capability*a.dozen as sum_quantity from instock_detail a left join instock b on(a.instock_id=b.id) left join product_class_info c on(a.product_id=c.product_id) where '.$where.' 
						union all 
						select 8 as flow_type,a.product_id,b.id as link_id,b.init_storage_no as link_no,a.quantity*a.capability*a.dozen as sum_quantity from init_storage_detail  a left join init_storage b on(a.init_storage_id=b.id) left join product_class_info c on(a.product_id=c.product_id) where '.$where2;
		// 销售数量
		if (C('sale.relation_sale_follow_up')==1) {
			$sql['sale'] = 'select a.*,b.id as link_id,b.delivery_no as link_no,sum(a.quantity*a.capability*a.dozen) as sum_quantity from delivery_detail a left join delivery b on(a.delivery_id=b.id) left join product_class_info c on(a.product_id=c.product_id) where '.$where.' group by a.delivery_id,a.product_id order by a.id asc';
		}else {
			$sql['sale'] = 'select a.*,b.id as link_id,b.sale_order_no as link_no,sum(a.quantity*a.capability*a.dozen) as sum_quantity from sale_order_detail a left join sale_order b on(a.sale_order_id=b.id) left join product_class_info c on(a.product_id=c.product_id) where '.$where.' group by a.sale_order_id,a.product_id order by a.id asc';
		}
		// 退货可用数量
		$sql['returnuse'] = 'select a.*,b.id as link_id,b.return_sale_order_no as link_no,a.quantity*a.capability*a.dozen as sum_quantity from return_sale_order_detail a left join return_sale_order b on(a.return_sale_order_id=b.id) left join product_class_info c on(a.product_id=c.product_id) where '.$where.' and is_use=1 order by a.id asc';
		// 退货不可用数量
		$sql['returnnouse'] = 'select a.*,b.id as link_id,b.return_sale_order_no as link_no,a.quantity*a.capability*a.dozen as sum_quantity from return_sale_order_detail a left join return_sale_order b on(a.return_sale_order_id=b.id) left join product_class_info c on(a.product_id=c.product_id) where '.$where.' and is_use=2 order by a.id asc';
		// 调整数量
		$sql['adjust'] = 'select a.*,b.id as link_id,b.adjust_no as link_no,a.quantity*a.capability*a.dozen as sum_quantity from adjust_detail a left join adjust b on(a.adjust_id=b.id) left join product_class_info c on(a.product_id=c.product_id) where '.$where.' order by a.id asc';
		// 盈亏已过帐数量
		$sql['stocktake'] = 'select a.*,b.id as link_id,b.profitandloss_no as link_no,(a.stocktake_quantity-a.storage_quantity)*a.capability*a.dozen as sum_quantity from profitandloss_detail a left join profitandloss b on(a.profitandloss_id=b.id) left join product_class_info c on(a.product_id=c.product_id) where '.$where.' and b.state=2 order by a.id asc';
		return $sql[$type];
	}
	
	public function resetArray($list,$col){
		if(empty($col)){
			return $list;
		}
		foreach((array)$list as $key=>$val){
			if(isset($val[$col])){
				$tmp[$val[$col]]	= $val;
			}else{
				$tmp[]				= $val;
			}
		}
		return $tmp;
	}
	
	public function getClassArray($list){
		foreach($list['list'] as $key=>$val){
			$parent_id	= intval($val['parent_id']);
			$info[$parent_id][]	= $val;
		}
		foreach($info as $key=>$val){
			$count	= count($val)-1;
			foreach($val as $k=>$v){
				if($k==$count){
					$v['show_total']	=1;
				}
				$tmp['list'][]	= $v;
			}
		}
		$tmp['total']	= $list['total'];
		return $tmp;
	}
}