<?php
/**
 * 按产品利润	
 * @copyright   2012 展联软件友拓通
 * @category   	按产品利润
 * @package  	Model 
 * @version 	2.1
 * @author 		何剑波
 */
class StatProductProfitPublicModel extends AbsStatPublicModel {
	private $order_by		=	'paid_date'; 
	private $profit_key		=	'product_id'; 
  
	///列表
	public function index() {   
		///初始化利润
		$this->iniProfitInfo(); 
		$_POST	=	array_merge($_POST,$_REQUEST);  
	 	if ($_POST['factory_id']>0) {$_POST['query']['factory_id']		=	$_POST['factory_id'];}
		$opert	=	array('where'=>_search().' '.$this->profitDefaultWhere($this->profit_key));///特殊处理过滤掉流程中没有的产品  
	 
		$sql 	= 'select count(a.id)  as count from product a left join product_class_info b on(a.id=b.product_id) where '.$opert['where'];
		$count 	= $this->cache()->query($sql);
		if (!$count[0]['count']) return ;
		///取列表信息
		$sql = 'select a.id as '.$this->profit_key.',0 as befor_money,0 as in_stock_money,0 as adjust_money,0 as sale_money,0 as stock_money,0 as profit_money,0 as sale_basic_money,0 as return_is_use_money
				 from product a left join product_class_info b on(a.id=b.product_id) 
				 where  '.$opert['where'].' order by product_no '; 
		$_limit		=	_page($count[0]['count']);
		$list		=	_formatList($this->cache()->query($sql._limit($_limit)));     
		$date['date']['from_in_date']	=	$_POST['from_date'];
		$date['date']['to_in_date']		=	$_POST['to_date'];  
		$profit_info	=	$this->profit($this->profit_key,$list,$date);  
//		foreach ((array)$profit_info['list'] as $key=>$row) {
//			$profit_info['list'][$key]['link']	=	U('Stat/productInfo/product_id/'.$row['product_id']);	 	
//		} 
//		$profit_info['page'] = $page;   
		$this->addSessionPost($_POST);
		return $profit_info;
	}	
}