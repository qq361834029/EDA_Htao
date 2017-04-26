<?php

/**
 * 客户交易分析
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    统计信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class StatClientAnalysisPublicModel extends RelationCommonModel  {
	protected $tableName = 'sale_order';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("",'validDate','require',1,'callbacks'), 	
	);
	
	public $searchValid	=		array( 
		array("from_order_date",'require',"require",1,'id'=>'date[from_order_date]'),
		array("to_order_date",'require',"require",1,'id'=>'date[to_order_date]'),
	);	
	
	/**
	 * 列表搜索验证日期
	 * @param string $data
	 * @return string
	 */
	public function validDate($data){   
		$name	=	'searchValid';
		foreach ((array)$data as $k=>$v){
			foreach ((array)$v as $kk=>$vv){
				$list[$kk]	= $vv;
			}
		}
		return $this->_validSubmit($list,$name);     
	}
	
	///搜索验证
	public function validSearch(){
		//重新组合POST来的信息 
		$info	= $this->setPost();
		//模型验证 
		if ($this->autoValidation($info)) {	 	
			return true;
		} else {     
			$this->error_type	=	1; 
			return false; 
		} 
	}
	
	/// 取订单日期范围--用于分页
	public function getOrderDate(){
		$compare_type	= $_REQUEST['compare_type'];
		if($compare_type==2){
			$date_format= '%Y-%m';
		}elseif($compare_type==3){
			$date_format= '%Y-%m-%d';
		}else{
			$date_format= '%Y';
		}
		$search_where	= D('StatSale')->getSearchWhere();
		$sql	= "select date_format(order_date,'".$date_format."') order_date from 
						sale_order_detail b force INDEX(PRIMARY) inner join sale_order a force INDEX(PRIMARY) on a.id=b.sale_order_id inner join product_class_info c force INDEX(PRIMARY) on b.product_id=c.product_id
						where ".$search_where['where']." group by date_format(order_date,'".$date_format."') 
						union
						select date_format(a.return_order_date,'".$date_format."') order_date from 
						return_sale_order_detail b force INDEX(PRIMARY) inner join return_sale_order a force INDEX(PRIMARY) on a.id=b.return_sale_order_id inner join product_class_info c force INDEX(PRIMARY) on b.product_id=c.product_id
						where ".$search_where['return_where']." group by date_format(a.return_order_date,'".$date_format."')";
		$info	= getAnalysisDate($sql);
		return $info;
	}
}






