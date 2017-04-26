<?php
/**
 * 库库显示管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	库存信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-08-06
*/

class StorageShowPublicModel extends Model {
	/// 定义库存表名
	protected $tableName = 'storage';
	/// 库存规格，属性
	protected $storage_attr;

	/**
	 * 按类别取实际库存
	 *
	 * @return array
	 */
	public function getRealStorageByClass() {
		/// 判断是否按截止日期查询
		if ($_POST['stop_date']) {
			$_POST['date']['lt_in_date'] = $_POST['stop_date'];
			$in_where = _search();
			unset($_POST['date']['lt_in_date']);
			$_POST['date']['lt_out_date'] = $_POST['stop_date'];
			$_POST['query']['a.out_warehouse_id'] = $_POST['query']['a.warehouse_id'];
			unset($_POST['query']['a.warehouse_id']);
			unset($_POST['query']['a_warehouse_id']);
			$out_where = _search();
			//处理零库存及库存数量查询的功能
			if (!C('STORAGE_ZERO') || (isset($_POST['having_quantity_less_than']) && $_POST['having_quantity_less_than'] != '')) {
				$having = ' 1=1 ';
				if (!C('STORAGE_ZERO')){
					$having = ' having quantity!=0';
				}
				if (isset($_POST['having_quantity_less_than']) && $_POST['having_quantity_less_than'] != '') {
					if (C('STORAGE_ZERO')){
						$having = ' having quantity!=0';
					}else{
						$having .= ' and quantity<' . (int)$_POST['having_quantity_less_than'];
					}
				}
				$sql = 'select product_class_id,sum(a.quantity) as quantity,sum(a.real_storage) as real_storage from (select product_class_id,product_id,capability,sum(quantity) as quantity,sum(real_storage) as real_storage,warehouse_id from (select class_1 as product_class_id,a.product_id,a.capability,a.dozen,a.quantity as quantity,a.quantity*a.capability*a.dozen as real_storage,a.warehouse_id from stock_in as a left join product_class_info b on (a.product_id=b.product_id) where '.$in_where.' union all 
					select class_1 as product_class_id,a.product_id,a.capability,a.dozen,-1*a.quantity as quantity,-1*a.quantity*a.capability*a.dozen as real_storage,a.out_warehouse_id as warehouse_id from stock_out as a left join product_class_info b on(a.product_id=b.product_id) where '.$out_where.') as p_table group by product_id,capability,dozen '.$having.') as a group by product_class_id ';
			}else{
				$sql = 'select product_class_id,sum(a.quantity) as quantity,sum(a.real_storage) as real_storage from (select class_1 as product_class_id,a.quantity as quantity,a.quantity*a.capability*a.dozen as real_storage,a.warehouse_id from stock_in as a left join product_class_info b on (a.product_id=b.product_id) where '.$in_where.' union all 
					select class_1 as product_class_id,-1*a.quantity as quantity,-1*a.quantity*a.capability*a.dozen as real_storage,a.out_warehouse_id as warehouse_id from stock_out as a left join product_class_info b on(a.product_id=b.product_id) where '.$out_where.') as a group by product_class_id';
			}
			$list = $this->db->query($sql);
		}else {
			$where = _search();
			//处理零库存及库存数量查询的功能
			if (!C('STORAGE_ZERO')) {$where .= ' and quantity!=0';}
			if (isset($_POST['having_quantity_less_than']) && $_POST['having_quantity_less_than'] != '') {
				$where .= ' and quantity<' . (int)$_POST['having_quantity_less_than'];
			}
			$sql = 'select b.class_1 as product_class_id,sum(a.quantity) as quantity,sum(a.quantity*a.capability*a.dozen) as real_storage from storage a left join product_class_info b on(a.product_id=b.product_id) where '.$where.' group by product_class_id';
			$list = $this->db->query($sql);
		}
	    if (!is_array($list)) {
	    	return array();
	    }
	    $list = _formatList($list);
		//pr($list,'$list',1);
	    return $list;
	}
	
	/**
	 * 取实际库存
	 *
	 * @return array
	 */
	public function getRealStorage() {
		$this->getSpec();
		$group = implode(',',$this->storage_attr);
		if (!C('STORAGE_ZERO')) {$having = ' having quantity!=0';}
		if (isset($_POST['having_quantity_less_than']) && $_POST['having_quantity_less_than'] != '') {
			if(!C('STORAGE_ZERO')){
				$having .= ' and quantity<' . (int)$_POST['having_quantity_less_than'];
			}else{
				$having = ' having quantity<' . (int)$_POST['having_quantity_less_than'];
			}
        }
		/// 判断是否按截止日期查询
		if ($_POST['stop_date']) {
			$_POST['date']['lt_in_date'] = $_POST['stop_date'];
			$in_where = _search();
			unset($_POST['date']['lt_in_date']);
			$_POST['date']['lt_out_date'] = $_POST['stop_date'];
			$_POST['query']['a.out_warehouse_id'] = $_POST['query']['a.warehouse_id'];
			unset($_POST['query']['a.warehouse_id']);
			unset($_POST['query']['a_warehouse_id']);
			$out_where = _search();
			$sql = '
				select product_id,color_id,size_id,sum(a.quantity) as quantity,sum(a.quantity*a.capability*a.dozen) as real_storage,a.capability,a.dozen,warehouse_id,mantissa from (
				select a.product_id,a.color_id,a.size_id,a.quantity,a.capability,a.dozen,a.warehouse_id,mantissa from stock_in as a left join product_class_info b on(a.product_id=b.product_id) where '.$in_where.' union all 
					select a.product_id,a.color_id,a.size_id,a.quantity*-1,a.capability,a.dozen,a.out_warehouse_id as warehouse_id,mantissa from stock_out as a left join product_class_info b on(a.product_id=b.product_id) where '.$out_where.') as a inner join product b on a.product_id=b.id group by '.$group.$having.' order by b.product_no,a.product_id,a.color_id,a.size_id,a.mantissa,a.capability,a.dozen';
			$list = $this->db->query($sql);
		}else {
			$where = _search();
			$sql = 'select a.*,sum(a.quantity) as quantity,sum(a.quantity*a.capability*a.dozen) as real_storage,mantissa from storage a left join product_class_info b on(a.product_id=b.product_id) inner join product c on a.product_id=c.id where '.$where.' group by '.$group.$having.' order by c.product_no,a.product_id,a.color_id,a.size_id,a.mantissa,a.capability,a.dozen';
			$list = $this->db->query($sql);
		}
	    if (!is_array($list)) {
	    	return array();
	    }
	    $list = _formatList($list);
	    $prev_value = array();
	    /// 移除相同产品号
	    foreach ($list['list'] as &$value) {
	    	if ($value['product_id']==$prev_value['product_id']) {
	    		$value['product_no'] = '';
	    		$value['product_name'] = '';
	    	}
	    	$prev_value = $value;
	    }
	   return $list;
	}

	/**
	 * 获取可销售库存按类别数组
	 *
	 * @return  array
	 */
	public function getSaleStorageByClass(){
		//判断是否按截止日期查询
		if ($_POST['stop_date']) {
			// 入库查询条件
			$_POST['date']['lt_in_date'] = $_POST['stop_date'];
			$in_where = _search();
			unset($_POST['date']['lt_in_date']);
			$_POST['date']['lt_out_date'] = $_POST['stop_date'];
			$out_where = _search();
			unset($_POST['date']['lt_out_date']);
			if (C('loadContainer.sale_storage')==1) {
				$_POST['date']['lt_delivery_date'] = $_POST['stop_date'];
				$lc_where = _search();
				unset($_POST['date']['lt_delivery_date']);
			}
			$_POST['date']['lt_order_date'] = $_POST['stop_date'];
			$sale_where = _search();
			unset($_POST['date']['lt_order_date']);
			$_POST['date']['lt_delivery_date'] = $_POST['stop_date'];
			$delivery_where = _search();
			unset($_POST['date']['lt_delivery_date']);
			//处理零库存及库存数量查询的功能
			if (!C('STORAGE_ZERO') || (isset($_POST['having_quantity_less_than']) && $_POST['having_quantity_less_than'] != '')) {
				$having = ' 1=1 ';
				if (!C('STORAGE_ZERO')){
					$having = ' having quantity!=0';
				}
				if (isset($_POST['having_quantity_less_than']) && $_POST['having_quantity_less_than'] != '') {
					if (C('STORAGE_ZERO')){
						$having = ' having quantity!=0';
					}else{
						$having .= ' and quantity<' . (int)$_POST['having_quantity_less_than'];
					}
				}
				$sub_select_head	= 'select product_class_id,product_id,capability,dozen,sum(quantity) as quantity,sum(sale_storage) as sale_storage from (';
				$sub_select_bottom	= ') as p_table group by product_id,capability,dozen '.$having;
			}
			if (C('loadContainer.sale_storage')==1) {
				$sql = '
					select product_class_id,sum(a.quantity) as quantity,sum(sale_storage) as sale_storage from ( '.$sub_select_head.'
						select b.class_1 as product_class_id,a.quantity as quantity,a.product_id,a.capability,a.dozen,a.quantity*a.capability*a.dozen as sale_storage from stock_in as a left join product_class_info b on(a.product_id=b.product_id) where '.$in_where.' 
						union all 
						select b.class_1 as product_class_id,-1*a.quantity as quantity,a.product_id,a.capability,a.dozen,-1*a.quantity*a.capability*a.dozen as sale_storage from stock_out as a left join product_class_info b on(a.product_id=b.product_id) where '.$out_where.' 
						union all 
						select b.class_1 as product_class_id,-1*a.quantity as quantity,a.product_id,a.capability,a.dozen,-1*a.quantity*a.capability*a.dozen as sale_storage from load_container_details as a 
						left join load_container as c on(a.load_container_id=c.id and c.load_state=1)
						left join product_class_info b on(a.product_id=b.product_id) where '.$lc_where.' 
						union all 
						select b.class_1 as product_class_id,-1*a.quantity as quantity,a.product_id,a.capability,a.dozen,-1*a.quantity*a.capability*a.dozen as sale_storage from sale_order_detail as a 
						left join sale_order as c on(a.sale_order_id=c.id and c.sale_order_state=1)
						left join product_class_info b on(a.product_id=b.product_id ) where '.$sale_where.' 
					'.$sub_select_bottom.') as a group by product_class_id';
			}else {
				$sql = '
					select product_class_id,sum(a.quantity) as quantity,sum(a.sale_storage) as sale_storage from ( '.$sub_select_head.'
						select b.class_1 as product_class_id,a.quantity as quantity,a.product_id,a.capability,a.dozen,a.quantity*a.capability*a.dozen as sale_storage from stock_in as a left join product_class_info b on(a.product_id=b.product_id) where '.$in_where.' 
						union all 
						select b.class_1 as product_class_id,-1*a.quantity as quantity,a.product_id,a.capability,a.dozen,-1*a.quantity*a.capability*a.dozen as sale_storage from sale_order_detail as a 
						left join sale_order as c on(a.sale_order_id=c.id and c.sale_order_state=1)
						left join product_class_info b on(a.product_id=b.product_id) where '.$sale_where.' 
						union all 
						select b.class_1 as product_class_id,-1*a.quantity as quantity,a.product_id,a.capability,a.dozen,-1*a.quantity*a.capability*a.dozen as sale_storage from stock_out as a left join product_class_info b on(a.product_id=b.product_id ) where '.$out_where.'
					'.$sub_select_bottom.') as a group by product_class_id ';
			}
			
			$list = $this->db->query($sql);
		}else {
			$where = _search();
			//处理零库存及库存数量查询的功能
			if (!C('STORAGE_ZERO')) {$where .= ' and quantity!=0';}
			if (isset($_POST['having_quantity_less_than']) && $_POST['having_quantity_less_than'] != '') {
				$where .= ' and quantity<' . (int)$_POST['having_quantity_less_than'];
			}
			$sql = 'select b.class_1 as product_class_id,sum(a.quantity) as quantity,sum(a.quantity*a.capability*a.dozen) as sale_storage,mantissa from sale_storage as a left join product_class_info b on(a.product_id=b.product_id) where '.$where.' group by product_class_id';
			$list = $this->db->query($sql);
		}
	    if (!is_array($list)) {
	    	return array();
	    }
	    $list = _formatList($list);
		return $list;
	}
	
	/**
	 * 获取可销售库存信息数组
	 *
	 * @return  array
	 */
	public function getSaleStorage(){
		$this->getSpec();
		$group = implode(',',$this->storage_attr);
		if (!C('STORAGE_ZERO')) {$having = ' having quantity!=0';}
		if (isset($_POST['having_quantity_less_than']) && $_POST['having_quantity_less_than'] != '') {
			if(!C('STORAGE_ZERO')){
				$having .= ' and quantity<' . (int)$_POST['having_quantity_less_than'];
			}else{
				$having = ' having quantity<' . (int)$_POST['having_quantity_less_than'];
			}
        }
		//判断是否按截止日期查询
		if ($_POST['stop_date']) {
			// 入库查询条件
			$_POST['date']['lt_in_date'] = $_POST['stop_date'];
			$in_where = _search();
			unset($_POST['date']['lt_in_date']);
			$_POST['date']['lt_out_date'] = $_POST['stop_date'];
			$out_where = _search();
			unset($_POST['date']['lt_out_date']);
			if (C('loadContainer.sale_storage')==1) {
				$_POST['date']['lt_delivery_date'] = $_POST['stop_date'];
				$lc_where = _search();
				unset($_POST['date']['lt_delivery_date']);
			}
			$_POST['date']['lt_order_date'] = $_POST['stop_date'];
			$sale_where = _search();
			unset($_POST['date']['lt_order_date']);
			$_POST['date']['lt_delivery_date'] = $_POST['stop_date'];
			$delivery_where = _search();
			unset($_POST['date']['lt_delivery_date']);
			if (C('loadContainer.sale_storage')==1) {
				$sql = '
					select product_id,color_id,size_id,sum(a.quantity) as quantity,sum(a.quantity*a.capability*a.dozen) as sale_storage,a.capability,a.dozen,mantissa from (
						select a.product_id,a.color_id,a.size_id,a.quantity,a.capability,a.dozen,a.mantissa from stock_in as a left join product_class_info b on(a.product_id=b.product_id) where '.$in_where.' 
						union all 
						select a.product_id,a.color_id,a.size_id,a.quantity*-1 as quantity,a.capability,a.dozen,a.mantissa from stock_out as a left join product_class_info b on(a.product_id=b.product_id) where '.$out_where.' 
						union all 
						select a.product_id,a.color_id,a.size_id,a.quantity,a.capability,a.dozen,a.mantissa from load_container_details as a 
						left join load_container as c on(a.load_container_id=c.id and c.load_state=1)
						left join product_class_info b on(a.product_id=b.product_id) where '.$lc_where.' 
						union all 
						select a.product_id,a.color_id,a.size_id,a.quantity*-1 as quantity,a.capability,a.dozen,a.mantissa from sale_order_detail as a 
						left join sale_order as c on(a.sale_order_id=c.id and c.sale_order_state=1)
						left join product_class_info b on(a.product_id=b.product_id) where '.$sale_where.' 
					) as a inner join product b on a.product_id=b.id group by '.$group.$having.' order by b.product_no,a.product_id,a.color_id,a.size_id,a.mantissa,a.capability,a.dozen';
			}else {
				$sql = '
					select product_id,color_id,size_id,sum(a.quantity) as quantity,sum(a.quantity*a.capability*a.dozen) as sale_storage,a.capability,a.dozen,mantissa from (
						select a.product_id,a.color_id,a.size_id,a.quantity,a.capability,a.dozen,a.mantissa from stock_in as a left join product_class_info b on(a.product_id=b.product_id) where '.$in_where.' 
						union all 
						select a.product_id,a.color_id,a.size_id,a.quantity*-1 as quantity,a.capability,a.dozen,a.mantissa from sale_order_detail as a 
						left join sale_order as c on(a.sale_order_id=c.id and c.sale_order_state=1)
						left join product_class_info b on(a.product_id=b.product_id) where '.$sale_where.' 
						union all 
						select a.product_id,a.color_id,a.size_id,a.quantity*-1,a.capability,a.dozen,a.mantissa from stock_out as a left join product_class_info b on(a.product_id=b.product_id) where '.$out_where.'
					) as a inner join product b on a.product_id=b.id group by '.$group.$having.' order by b.product_no, a.product_id,a.color_id,a.size_id,a.mantissa,a.capability,a.dozen';
			}
			
			$list = $this->db->query($sql);
		}else {
			$where = _search().$where;
			$sql = 'select a.product_id,a.color_id,a.size_id,a.quantity,sum(a.quantity*a.capability*a.dozen) as sale_storage,a.capability,a.dozen,mantissa from sale_storage as a left join product_class_info b on(a.product_id=b.product_id) inner join product c on a.product_id=c.id where '.$where.' group by '.$group.$having.' order by c.product_no,a.product_id,a.color_id,a.size_id,a.mantissa,a.capability,a.dozen';
			$list = $this->db->query($sql);
		}
	    if (!is_array($list)) {
	    	return array();
	    }
	    $list = _formatList($list);
	   $prev_value = array();
	    foreach ($list['list'] as &$value) {
	    	if ($value['product_id']==$prev_value['product_id']) {
	    		$value['product_no'] = '';
	    		$value['product_name'] = '';
	    	}
	    	$prev_value = $value;
	    }
	   return $list;
	}
	
	
	/**
	 * 取在途产品数组
	 *
	 * @return array
	 */
	public function getLCStorage() {
		$count 	= M('load_container_details')->exists('select 1 from load_container where '.getWhere($_POST['main']).' and id=load_container_details.load_container_id and load_state=1',$_POST['main'])->where(getWhere($_POST['detail']))->count();
		M('load_container_details')->setPage($count);
		C('line_number',200);
		$ids	= M('load_container_details')->field('id')->exists('select 1 from load_container where '.getWhere($_POST['main']).' and id=load_container_details.load_container_id and load_state=1',$_POST['main'])->where(getWhere($_POST['detail']))->order('product_id,color_id,size_id,mantissa,capability,dozen')->page()->selectIds();
		$info['from'] 	= 'load_container_details as a left join load_container as c on(a.load_container_id=c.id and c.load_state=1)';
		$info['where'] 	= 'where a.id in '.$ids;
		$info['group']	= 'order by a.product_id,a.color_id,a.size_id,a.mantissa,a.capability,a.dozen';
		$info['field'] 	= 'a.product_id,a.color_id,a.size_id,a.quantity,a.capability,a.dozen,a.mantissa,c.id as load_container_id,c.container_no ,(a.quantity*a.capability*a.dozen) as sum_quantity';
		$sql 	= 'select '.$info['field'].' from '.$info['from'].' '.$info['where'].$info['group']; 
		$list	= _formatList($this->query($sql)); 
		$prev_value = array();
		foreach ($list['list'] as &$value) {
			if ($value['product_id']==$prev_value['product_id']) {
				$value['product_no'] = '';
				$value['product_name'] = '';
			}
			$prev_value = $value;
		}
		return $list;
	}
	
	/**
	 * 按仓库显示时获取展开明细信息数组
	 *
	 * @return  array
	 */
	public function getExpand(){
		$this->getSpec();
		$group_ary = $this->storage_attr;
		$group_ary[] = 'warehouse_id';
		$group = implode(',',$group_ary);
		if (!C('STORAGE_ZERO')) {$having = ' having quantity!=0';}
		if ($_POST['stop_date']){
			$_POST['date']['lt_in_date'] = $_POST['stop_date'];
			$in_where = _search();
			unset($_POST['date']['lt_in_date']);
			$_POST['date']['lt_out_date'] = $_POST['stop_date'];
			$_POST['query']['a.out_warehouse_id'] = $_POST['query']['a.warehouse_id'];
			unset($_POST['query']['a.warehouse_id']);
			 $sql = '
				select product_id,color_id,size_id,sum(quantity) as quantity,sum(quantity*capability*dozen) as real_storage,capability,dozen,warehouse_id,mantissa from (
				select a.product_id,a.color_id,a.size_id,a.quantity,a.capability,a.dozen,a.warehouse_id,mantissa from stock_in as a left join product_class_info b on(a.product_id=b.product_id) where '.$in_where.' union all 
					select a.product_id,a.color_id,a.size_id,a.quantity*-1,a.capability,a.dozen,a.out_warehouse_id as warehouse_id,mantissa from stock_out as a left join product_class_info b on(a.product_id=b.product_id) where '._search().') as a group by '.$group.$having.' order by a.product_id,a.color_id,a.size_id,a.capability,a.dozen,a.mantissa';
			$list = $this->db->query($sql);
		}else{
			$sql = 'select a.*,sum(quantity) as quantity,sum(quantity*capability*dozen) as real_storage,mantissa from storage  as a left join product_class_info as b on(a.product_id=b.product_id) where '._search().' group by '.$group.$having.' order by a.product_id,a.color_id,a.size_id,a.capability,a.dozen,a.mantissa';
			$list = $this->db->query($sql);
		}
		return _formatList($list);
	}
	
	
	/**
	 * 根据配置信息获取库存更新属性
	 *
	 * @return  array
	 */
	protected function getSpec(){
		static $storage_attr;
		if($storage_attr) {
			$this->storage_attr = $storage_attr;
		}else {
			// 声明固定项
			$storage_attr = array('product_id');
			if (C('storage_format')>=2) {
				$storage_attr['capability'] = 'capability';
			}
			if (C('storage_format')>=3) {
				$storage_attr['dozen'] = 'dozen';
			}
			if (C('storage_color')) {
				$storage_attr['color'] = 'color_id';
			}
			if (C('storage_size')) {
				$storage_attr['size'] = 'size_id';
			}
			if (C('storage_mantissa')) {
				$storage_attr['mantissa'] = 'mantissa';
			}
			$this->storage_attr = $storage_attr;
		}
	}
	
	/**
	  * 获取指定产品可销售库存，区分在途与实际可销售
	  *
	  * @param string $where
	  * @return array
	  */
	 public function getProductSaleStorage($product_id,$is_return_sold) {
	 	$this->getSpec();
	 	if (C('loadContainer.sale_storage')==1) {
	 		foreach ($this->storage_attr as $value) {
	 			$field['a'][] = 'a.'.$value;
	 			$field['join'][] = 'a.'.$value.'=b.'.$value;
	 		}
	 		$sql = 'select a.product_id,a.capability,a.dozen,a.color_id,a.size_id,a.mantissa,a.quantity,sum(if(c.load_state=1,b.quantity,0)) as load_quantity,sum(a.quantity*a.capability*a.dozen) as sale_storage from sale_storage a 
	 				left join load_container_details b on('.implode(' and ',$field['join']).') 
					left join load_container c on(b.load_container_id=c.id and c.load_state=1)  
	 				where a.product_id='.$product_id.' and a.quantity!=0 group by a.id order by a.color_id,a.size_id,a.mantissa,a.capability,a.dozen,a.quantity';
	 		$temp = $this->db->query($sql);
	 		$list_storage 	= array();
	 		$list_load		= array();
	 		foreach ($temp as $value) {
	 			if ($value['load_quantity']==0) {
	 				$value['lc_state'] = 1;
	 				$value['sale_storage'] = $value['quantity']*$value['capability']*$value['dozen'];
	 				$list_storage[] = $value;
	 			}elseif ($value['quantity']>$value['load_quantity']) {
	 				$value['quantity'] -= $value['load_quantity'];
	 				$value['lc_state'] = 1;
	 				$value['sale_storage'] = $value['quantity']*$value['capability']*$value['dozen'];
	 				$list_storage[] = $value;
	 				$value['quantity'] = $value['load_quantity'];
	 				$value['lc_state'] = 2;
	 				$value['sale_storage'] = $value['quantity']*$value['capability']*$value['dozen'];
	 				$list_load[] = $value;
	 			}elseif ($value['quantity']==$value['load_quantity']){
	 				$value['quantity'] = $value['load_quantity'];
	 				$value['lc_state'] = 2;
	 				$value['sale_storage'] = $value['quantity']*$value['capability']*$value['dozen'];
	 				$list_load[] = $value;
	 			}else {
	 				$value['quantity'] = $value['load_quantity']-($value['load_quantity']-$value['quantity']);
	 				$value['lc_state'] = 2;
	 				$value['sale_storage'] = $value['quantity']*$value['capability']*$value['dozen'];
	 				$list_load[] = $value;
	 			}
	 		}
	 		if (empty($list_storage)) {
	 			return $list_load;
	 		}elseif (empty($list_load)){
	 			return $list_storage;
	 		}else {
	 			return array_merge($list_storage,$list_load);
	 		}
	 	}else {
	 		return M('SaleStorage')->field('*,quantity as sale_storage')->join('s left join warehouse w on w.id=s.warehouse_id')->where('product_id='.$product_id.' and quantity!=0'.$is_return_sold)->order('quantity')->select();
	 	}
	 	
	 }
	 
	 public function getProductStorage(){
		 $where	= getWhere($_POST);
         if(getUser('role_type') == C('WAREHOUSE_ROLE_TYPE')){
             if($_POST['query']['w.is_return_sold' ]== C('NO_RETURN_SOLD')){
                //是否属于退货不可再销售仓库登录
                $is_return_sold    = M('warehouse')->where('id='.getUser('company_id'))->getField('is_return_sold');
                if($is_return_sold==C('CAN_RETURN_SOLD')){
                   $where  .= ' and  relation_warehouse_id='.getUser('company_id');
                }else{
                    $where  .= ' and warehouse_id='.getUser('company_id');
                }
             }else{
                 $where  .= ' and warehouse_id='.getUser('company_id');
             }
         }
         if(empty($_POST['query']['location_id'])){
            $child_sql	= 'select 
							p.*,w.is_return_sold,b.warehouse_id,a.product_id,if(a.quantity>a.in_quantity,a.quantity-a.in_quantity,0) as onroad_qn,0 as sale_qn, 0 as real_qn, 0 as reserve_qn 
						from instock_detail a 
						left join instock b on b.id=a.instock_id 
						left join product p on p.id=a.product_id
                        left join warehouse w on w.id=b.warehouse_id 
						where ' . $where . ' and b.instock_type not in (' . C('NO_ONROAD_STATE') . ')
						union all
						select 
							p.*,w.is_return_sold,a.warehouse_id,a.product_id,0 as onroad_qn,a.quantity as sale_qn, 0 as real_qn, 0 as reserve_qn 
						from sale_storage a
						left join product p on p.id=a.product_id
                        left join warehouse w on w.id=a.warehouse_id 
						where ' . $where . '
						union all
						select 
							p.*,w.is_return_sold,a.warehouse_id,a.product_id,0 as onroad_qn,0 as sale_qn, a.quantity as real_qn, 0 as reserve_qn 
						from storage a
						left join product p on p.id=a.product_id
                        left join warehouse w on w.id=a.warehouse_id 
						where ' . $where;
         }else{
             $child_sql	= '
						select 
							p.*,w.is_return_sold,a.warehouse_id,a.product_id,0 as onroad_qn,a.quantity as sale_qn, a.quantity as real_qn, 0 as reserve_qn 
						from storage a
						left join product p on p.id=a.product_id
                        left join warehouse w on w.id=a.warehouse_id 
						where ' . $where.' group by product_id,warehouse_id order by warehouse_id desc';
         }
		 $count_field_str	= 'product_id,
                            sum(onroad_qn) as onroad_quantity,
                            sum(sale_qn) as sale_quantity,
                            sum(real_qn) as real_quantity,
                            sum(real_qn)-sum(sale_qn) as reserve_quantity';
        if(!empty($_POST['max_sale_quantity'])){
           $sql   = 'select ' . $count_field_str . ' from (' . $child_sql . ') as tmp group by product_id having (onroad_quantity<>0 or sale_quantity<>0 or real_quantity<>0 or reserve_quantity<>0) and sale_quantity<'.(int)$_POST['max_sale_quantity'];
        }else{
            $sql   = 'select ' . $count_field_str . ' from (' . $child_sql . ') as tmp group by product_id having onroad_quantity<>0 or sale_quantity<>0 or real_quantity<>0 or reserve_quantity<>0';
        }
         $rs 	= M()->query($sql);
		 $count	= count($rs);
		 if ($count>0){
            foreach ((array)$rs as $key => $value) {
               $total['real_quantity']    += $value['real_quantity'];
               $total['onroad_quantity']  += $value['onroad_quantity'];
               $total['sale_quantity']    += $value['sale_quantity'];
               $total['reserve_quantity'] += $value['reserve_quantity'];
            }
			$limit	= _page($count);
			$field_str	= '*,
						   sum(onroad_qn) as onroad_quantity,
						   sum(sale_qn) as sale_quantity,
						   sum(real_qn) as real_quantity,
						   sum(real_qn)-sum(sale_qn) as reserve_quantity';
            if(!empty($_POST['max_sale_quantity'])){
               $sql = 'select ' . $field_str . ' from (' . $child_sql . ') as tmp group by product_id having (onroad_quantity<>0 or sale_quantity<>0 or real_quantity<>0 or reserve_quantity<>0) and sale_quantity < '.$_POST['max_sale_quantity'].' order by product_no desc limit ' . $limit['firstRow'] . ',' . $limit['listRows']; 
            }else{
               $sql = 'select ' . $field_str . ' from (' . $child_sql . ') as tmp group by product_id having onroad_quantity<>0 or sale_quantity<>0 or real_quantity<>0 or reserve_quantity<>0 order by product_no desc limit ' . $limit['firstRow'] . ',' . $limit['listRows'];
            }			
            $list	= _formatList($this->query($sql));
            $list['all_total']['total']['real_quantity']      = $total['real_quantity'];
            $list['all_total']['total']['onroad_quantity']    = $total['onroad_quantity'];
            $list['all_total']['total']['sale_quantity']      = $total['sale_quantity'];
            $list['all_total']['total']['reserve_quantity']   = $total['reserve_quantity'];
            unset($total);
		}
		return $list;
	 }
}