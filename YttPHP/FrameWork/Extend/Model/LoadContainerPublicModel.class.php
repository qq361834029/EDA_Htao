<?php

/**
 * 订货信息管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	订货信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class LoadContainerPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'load_container';
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'load_container_id',
										'class_name'	=> 'LoadContainerDetails',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("container_no",'require','require',1),
			array("logistics_id","fund_logistics_norms",'require',0,'ifcheck','',1),
			array("load_date",'require','require',1),
			array("delivery_date",'require','require',1),
			array("delivery_date",'load_date','delivery_egt_load',2,'egtdate'), 
			array("expect_arrive_date",'require','require',1),
			array("expect_arrive_date",'delivery_date','expect_egt_delivery',2,'egtdate'), 
			array("",'_validDetail','require',1,'validDetail'),
			array("class_name",'validDetailUnique','require',1,'callbacks'), 	 
		);
	/// 验证产品是否重复
	protected $_validDetailUnique	 =	 array(
			array("product_id",'z_integer','unique',1), 
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("order_details_id",'require','require',1),
			array("orders_id",'require','require',1),
			array("currency_id",'require','require',1),
			array("product_id",'require','require',1),
			array("color_id",'require','require',0),
			array("size_id",'require','require',0),
			array("quantity",'pst_integer','pst_integer',1),
			array("capability",'pst_integer','pst_integer',0),
			array("dozen",'pst_integer','pst_integer',0),
			array("price",'double','double',1),
		);	
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);
	/**
	 * 验证产品ID不可以重复
	 *
	 * @param  array $data
	 * @return bool
	 */
	public function validDetailUnique($data){  
		$_moduleValidate	=	'_validDetailUnique';
		$info				=	$data;
		$product			=	array();
		$check				=	array('orders_id','product_id','size_id','color_id','capability','dozen','mantissa');
		foreach ((array)$info['detail'] as $key=>$value){ //循环验证明细  
			if ($value['product_id']>0){ 
				if (isset($value['mantissa']) && $value['mantissa']==2) {
					continue;
				}
				$real_key	=	'';	
				foreach ((array)$check as $k=>$v){ //循环验证明细  
					if (isset($value[$v])){
						$real_key	.=	'_'.$value[$v];
					} 
				} 
				if (isset($product[$real_key])){
					$info['detail'][$key]['product_id']	=	'a';//特殊处理
					continue;
				}
				$product[$real_key]	=	2; 
			}
		}   
		$this->_moduleValidationDetail($this,$info,'detail',$_moduleValidate);    
	}
	
	/**
	 * 设置订货入库信息数组
	 *
	 * @return  array
	 */
	public function setPost(){
		if ($_POST['submit_type']==2) {
			$_POST['load_state'] = 2;
		}else {
			$_POST['load_state'] = 1;
		}
		/// 尾箱时不需要被全信息
		$attr = getModuleSpec('order');
		foreach ($_POST['detail'] as $key => &$value) {
			if(empty($value['product_id']) || empty($value['orders_id'])) continue;
			if (isset($value['mantissa']) && $value['mantissa']==2) {
				$value['order_details_id'] = 0;
				continue;
			}
			$str_where = '';
			foreach ($attr as $field) {
				$str_where[] = $field.'='.intval($value[$field]);
			}
			$o_where = 'orders_id='.$value['orders_id'].' and '.implode(' and ',$str_where);
			$rs = M('OrderDetails')->where($o_where)->field('id')->select();
			if (count($rs)>1 || count($rs)==0) {
				throw_json(L('product_no').'“'.$_POST['temp'][$key]['product_no'].'”'.L('no_orders'));
			}
			$value['order_details_id'] = $rs[0]['id'];
		}
		return $_POST;
	}
	
	/**
	 * 订货单修改前置操作
	 *
	 * @param   $info
	 * @return  bool
	 */
	public function _beforeModel(&$info){
		if (ACTION_NAME=='insert') { return true;}
		/// 修改时还原所有关联的订货单已装柜数量
		$list = M('LoadContainerDetails')->field('order_details_id,orders_id,sum(quantity*capability*dozen*-1) as load_quantity,sum(quantity*-1) as load_capability')->where('load_container_id='.$info['id'])->group('order_details_id')->select();
		foreach ($list as $value) {
			D('Orders')->updateLoadQuantity($value['order_details_id'],$value['load_quantity'],$value['load_capability']);
			$info['before_orders_id'][] = $value['orders_id'];
			$info['before_order_details_id'][] = $value['order_details_id'];
		}
		return true;
		
	}
	 
	/**
	 * 装柜列表
	 *
	 * @return  array
	 */
	function indexSql(){ 
		return $this->getLcListSql('(load_state!=2)'); 
	}
	
	/**
	 * 待装柜列表
	 *
	 * @return  array
	 */
	public function alistUndeliverySql(){
		return $this->getLcListSql('load_state=2'); 
	}
	
	/**
	 * 获取订货列表sql数组
	 *
	 * @param  string $where
	 * @return  array
	 */
	private function getLcListSql($where=null){
		$where && $where = ' and '.$where;
		$count 	= $this->exists('select 1 from load_container_details where load_container_id=load_container.id and '.getWhere($_POST['detail']).' and exists(select 1 from orders where '.getWhere($_POST['order']).')',array_merge_recursive($_POST['detail'],$_POST['order']))->where(getWhere($_POST['main']).$where)->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from load_container_details where load_container_id=load_container.id and '.getWhere($_POST['detail']).' and EXISTS(select 1 from orders where '.getWhere($_POST['order']).' and id=load_container_details.orders_id)',array_merge_recursive($_POST['detail'],$_POST['order']))->where(getWhere($_POST['main']).$where)->order('load_container_no desc')->page()->selectIds();
		$info['from'] 	= 'load_container a left join load_container_details b on(a.id=b.load_container_id) left join order_details c on(b.order_details_id=c.id)';
		$info['group'] 	= ' group by a.id order by a.load_container_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.*,a.id as loadContainer_id,count(distinct b.product_id) as product_qn,
						sum(b.quantity) as total_quantity,
						sum(b.quantity*b.capability*b.dozen) as sum_quantity';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
	/**
	 * 编辑订货信息
	 *
	 * @return  array
	 */
	public function edit(){
		return $this->getInfo(intval($_GET['id']));
	}
	
	/**
	 * 查看是取数量
	 *
	 * @param  int $id
	 * @return array
	 */
	public function view(){
		return $this->getInfo(intval($_GET['id']));
	}
	
	/**
	 * 获取指定订货信息记录
	 *
	 * @param  int $id
	 * @return  array
	 */
	public function getInfo($id){
		$rs = $this->find($id);
		/// 判断是否为厂家应付款来源链接如果是根据厂家及币种查询
		if ($_GET['comp_id']) {
			$where .= ' and c.factory_id='.$_GET['comp_id'];
		}
		/// 判断是否为厂家应付款来源链接如果是根据厂家及币种查询
		if ($_GET['currency_id']) {
			$where .= ' and c.currency_id='.$_GET['currency_id'];
		}
		$sql = 'select 
					a.*,a.quantity*a.capability*a.dozen as sum_quantity,a.quantity*a.capability*a.dozen*a.price as money,
					a.quantity*a.per_size as real_per_szie,a.quantity*a.per_capability as real_per_capability,
					c.order_no,c.currency_id,c.factory_id,
					b.quantity*b.capability*b.dozen as order_quantity,
					b.quantity*b.capability*b.dozen-b.load_quantity as load_quantity 
					from load_container_details a 
					left join order_details b on(a.order_details_id=b.id) 
					left join orders c on(b.orders_id=c.id) 
					where a.load_container_id='.$id.$where;
		$rs['detail'] = $this->db->query($sql);
		$rs	= _formatListRelation($rs);
		/// 计算尺寸和重量
		foreach((array)$rs['detail'] as $key=>$val){
			$rs['detail_total']['total_size']	+= $val['quantity']*$val['per_size'];
			$rs['detail_total']['total_capability']+= $val['quantity']*$val['per_capability'];
		}
		$rs['detail_total']['dml_total_size']	= moneyFormat($rs['detail_total']['total_size'],0,C('MONEY_LENGTH'));
		$rs['detail_total']['dml_total_capability']= moneyFormat($rs['detail_total']['total_capability'],0,C('MONEY_LENGTH'));
		return $rs;
	}
	
	/**
	 * 待装柜的订货信息
	 *
	 * @return  array
	 */
	public function waitLoadContainer(){
		$model	= M('Orders');
		$count 	= $model->exists('select 1 from order_details where orders_id=orders.id and '.getWhere($_POST['detail']),$_POST['detail'])->where('order_state<=2 and '.getWhere($_POST['main']))->count();
		$model->setPage($count);
		$ids	= $model->field('id')->exists('select 1 from order_details where orders_id=orders.id and '.getWhere($_POST['detail']),$_POST['detail'])->where('order_state<=2 and '.getWhere($_POST['main']))->order('order_no desc')->page()->selectIds();
		$info['from'] 	= 'orders a left join order_details b on(a.id=b.orders_id)';
		$info['group'] 	= ' group by a.id order by a.order_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.*,a.id as orders_id,count(distinct b.product_id) as product_qn,
						sum(b.quantity) as sum_capability,
						sum(b.quantity*b.capability*b.dozen) as sun_quantity, 
						sum(b.quantity*b.capability*b.dozen*b.price) as money, 
						sum(load_capability) as load_capability, 
						sum(load_quantity) as load_quantity';
		$sql =  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
		return $this->indexList('',$sql);
	}
	
	/**
	 * 装柜时查询未完成的订货信息
	 *
	 * @param  string$where
	 * @return  array
	 */
	public function getDetail($where){
		$sql	= '
			select a.*,a.id as orders_id,(b.quantity*b.capability*b.dozen) as sum_capability,b.id as detial_id,b.product_id,
						ifnull(b.quantity*b.capability*b.dozen,0)-if(d.load_state=2,0,IFNULL(sum(c.quantity*c.capability*c.dozen),0)) as min_capability,
				    	p.weight,(p.cube_long*p.cube_wide*p.cube_high) as per_size,
						b.color_id,b.size_id,b.price,b.capability as order_capability,b.dozen as order_dozen,b.quantity
			from orders a left join order_details b on(a.id=b.orders_id) 
						left join load_container_details c on(b.id=c.order_details_id) 
						left join load_container d on(c.load_container_id=d.id)
						left join product as p on(b.product_id=p.id and p.to_hide=1)
			where '.$where.' group by b.id
			';
		$list	= $this->indexList('',$sql);
		return $list['list'];
	}
	
	/**
	 * 修改装柜单计算厂家小计
	 *
	 * @return  array
	 */
	function getFactoryDetail($detail){
		foreach ((array)$detail as $k=>$v){
			$list[$v['factory_id']]['factory_name']		= $v['factory_name'];
			$list[$v['factory_id']]['factory_id']		= $v['factory_id'];
			$list[$v['factory_id']]['currency_id']		= $v['currency_id'];
			$list[$v['factory_id']]['quantity']			+= $v['quantity'];
			$list[$v['factory_id']]['capability']		+= $v['quantity']*$v['capability']*$v['dozen'];
			$list[$v['factory_id']]['price']			+= $v['quantity']*$v['capability']*$v['dozen']*$v['price'];
		}
		return _formatList($list);
	}
}