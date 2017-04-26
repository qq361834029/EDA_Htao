<?php
/**
 * 按厂家利润	
 * @copyright   2012 展联软件友拓通
 * @category   	按厂家利润
 * @package  	Model 
 * @author 		何剑波
 * @version 	2.1
 */
class StatFactoryProfitPublicModel extends AbsStatPublicModel {
	/// 模型名与数据表名不一致，需要指定
	private $order_by		=	'paid_date'; 
	private $profit_key		=	'factory_id'; 
	///列表
	public function index() {    
		
		$this->iniFactoryId();
		$opert			=	array('where'=>_search().' and comp_type=1 '.$this->profitDefaultWhere($this->profit_key)); ///特殊处理过滤掉流程中没有的厂家 
		$sql 	= 'select count(1) as count from company where '.$opert['where'];
		$count 	= $this->cache()->query($sql);
		if (!$count[0]['count']) return ;
		///取列表信息
		$sql = 'select id as '.$this->profit_key.',0 as befor_money,0 as in_stock_money,0 as adjust_money,0 as sale_money,0 as stock_money,0 as profit_money,0 as sale_basic_money,0 as return_is_use_money
				 from company
				 where  '.$opert['where'].' order by comp_name '; 
		$_limit			=	_page($count[0]['count']);
		$list			=	_formatList($this->query($sql._limit($_limit)));     
		$date['date']['from_in_date']	=	$_POST['from_date'];
		$date['date']['to_in_date']		=	$_POST['to_date'];  
		$from_date		=	formatDate($_POST['from_date']);
		$to_date		=	formatDate($_POST['to_date']);  
		$profit_info	=	$this->profit($this->profit_key,$list,$date); 
		$date_where		=	'';
		!empty($from_date)	&&	$date_where	.=	'/from_date/'.$from_date;
		!empty($to_date)	&&	$date_where	.=	'/to_date/'.$to_date; 
		foreach ((array)$profit_info['list'] as $key=>$row) { 
			$profit_info['list'][$key]['link']	=	U('Stat/productStat/search_div/2/factory_id/'.$row['factory_id'].$date_where);	  
		}  
		$profit_info['page'] = ''; 
		$this->addSessionPost($_POST); 
		return $profit_info;
	} 
	  
	/**
	 * 初始化补充stock_out stock_in中factory_id
	 *
	 */
	public function iniFactoryId(){ 
		///初始化产品利润
		$this->iniProfitInfo();
		
		///StockOut
		$out_sql	=	'update stock_out as a,product as b set a.factory_id =b.factory_id where a.product_id=b.id and a.factory_id=0 and b.factory_id>0';
		$this->db->query($out_sql);
		
		///StockIn
		$in_sql	=	'update stock_in as a,product as b set a.factory_id =b.factory_id where a.product_id=b.id and a.factory_id=0 and b.factory_id>0';
		$this->db->query($in_sql);
		
		///退货
		$return_sql	=	'update return_sale_order_detail as a,product as b set a.factory_id =b.factory_id where a.product_id=b.id and a.factory_id=0 and b.factory_id>0 and is_use=2';
		$this->db->query($return_sql);
	}
}