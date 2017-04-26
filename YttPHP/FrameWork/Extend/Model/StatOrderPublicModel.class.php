<?php
/**
 * 进货进度管理表	
 * @copyright   2012 展联软件友拓通
 * @category   	进货进度管理表
 * @package  	Model 
 * @author 		何剑波
 * @version 	2.1
 */
class StatOrderPublicModel extends RelationCommonModel{

	/// 定义真实表名
	protected $tableName = 'instock';
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'instock_id',
										'class_name'	=> 'InstockDetail',
									)
								);	
	/**
	 * 列表
	 * @param array
	 */
	public function orderProcess(){
		$sql 		= 'select 
						order_no,factory_id,product_id,color_id,size_id,(quantity*capability*dozen) as quantity,load_quantity,
						order_date,expect_date,order_details.id as order_details_id,price
						from orders , order_details  
						 where  orders.id=order_details.orders_id  and  '._search().' 
						 order by  orders.id ,order_details.product_id';
		$sql_count	= 'select count(orders.id) as count
				from orders , order_details  
				 where  orders.id=order_details.orders_id  and  '._search();
		$list_count		= $this->db->query($sql_count);
		$_limit			= _page($list_count[0]['count']);
		$list 			= $this->db->query($sql._limit($_limit));
		foreach ((array)$list as $value) {
			$order_details_id[] = $value['order_details_id'];
		}
		if(isset($order_details_id)){
			///取装柜信息
			$sql = 'select b.* ,group_concat(load_date order by b.id desc) as load_date,a.order_details_id,
					group_concat(delivery_date order by b.id desc) as delivery_date,
					group_concat(expect_arrive_date order by b.id desc) as expect_arrive_date
					from load_container_details a left join load_container b on a.load_container_id=b.id 
					 where b.load_state != 2 and a.order_details_id in ('.implode(',', $order_details_id).')
					 group by a.order_details_id ';
			$load_info = formatArray($this->db->query($sql),'order_details_id');			
			/// 取入库信息
			$sql = 'select a.order_details_id,b.*,sum(a.quantity*a.capability*a.dozen) as instock_quantity,
					 group_concat(real_arrive_date order by b.id desc) as real_arrive_date
					 from instock_detail a left join instock b on a.instock_id=b.id 
					 where a.order_details_id in ('.implode(',', $order_details_id).')
					 group by a.order_details_id
					 order by b.id desc';
			$instock_info = formatArray($this->db->query($sql),'order_details_id');	
		}	
		$list	= $list ? $list : array();
		foreach ($list as &$value) { // 计算装柜达交量等 				
			$value['load_date'] 			= $load_info[$value['order_details_id']]['load_date'] ?
												substr($load_info[$value['order_details_id']]['load_date'],0,10) : '0000-00-00';					
			$value['delivery_date'] 		= $load_info[$value['order_details_id']]['delivery_date'] ?
												substr($load_info[$value['order_details_id']]['delivery_date'],0,10) : '0000-00-00';
			$value['expect_arrive_date'] 	= $load_info[$value['order_details_id']]['expect_arrive_date'] ?
												substr($load_info[$value['order_details_id']]['expect_arrive_date'],0,10) : '0000-00-00';
			$value['real_arrive_date'] 		= $instock_info[$value['order_details_id']]['real_arrive_date'] ?
			 									substr($instock_info[$value['order_details_id']]['real_arrive_date'],0,10) : '0000-00-00';
			$value['sum_instock_quantity'] 	= $instock_info[$value['order_details_id']]['instock_quantity'] ? 
												 $instock_info[$value['order_details_id']]['instock_quantity']  : 0 ;
			$value['diff_load_days']		= $value['load_quantity']? round((strtotime($value['load_date'])-strtotime($value['expect_date']))/3600/24) : 0;
			$value['diff_load_quantity']	= intval($value['load_quantity']) - intval($value['quantity'])  ;
			$value['load_percent']			=  moneyFormat($value['load_quantity'] / $value['quantity'] * 100, 0, 2).'%';
			$value['diff_instock_days']		= $value['sum_instock_quantity']? round((strtotime($value['real_arrive_date'])-strtotime($value['expect_arrive_date']))/3600/24) : 0;
			$value['diff_instock_quantity']	= intval($value['sum_instock_quantity']) - intval($value['load_quantity']) ;
			$value['instock_percent']		= moneyFormat($value['sum_instock_quantity'] / $value['load_quantity'] * 100, 0, 2).'%';
			$value['bgstate'] = 0;
			/// 根据装柜数量判断背景颜色
			if ($value['sum_instock_quantity']!=$value['load_quantity']) {
				$value['bgstate'] = 2;
			}elseif ($value['quantity']!=$value['load_quantity']){
				$value['bgstate'] = 1;
			}
		}
		$list			= _formatList($list);
		return $list;
	}
}
?>