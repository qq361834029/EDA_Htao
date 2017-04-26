<?php 
/**
 * 邮件
 * @copyright   Copyright (c) 2006 - 2013 TOP Union 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class EmailListPublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected 	$tableName = 'email_list'; 
	public 		$email_type = 0;

	public $email_type_array	=	array( 
									'Orders'					=> 1,
									'LoadContainer'				=> 2,
									'Instock'					=> 3,
									'SaleOrder'					=> 4,
									'Delivery'					=> 5,
                                    'StorageWarn'				=> 6,
									'CaiNiaoRequestAbnormal'	=> 7,
                                    'OutBatch'					=> 8,
        
		);

	public function set_email_type($module){
		$this->email_type	= $this->email_type_array[$module];
	}

	 
	/**
	 * 订货单
	 *
	 * @param int $id
	 * @return array
	 */
	public function Orders($id){  
		if (C('order.email_order')!=1){ return  true; }
		$today 	= date("Y-m-d H:m:s");                           /// 20010310 
		$this->set_email_type(__FUNCTION__);
		$model				=	M('orders');
		$list				=	$model->where('id='.$id)->field('id as object_id,factory_id as comp_id,'.$this->email_type.' as email_type, order_no as object_no,\''.$today.'\' as insert_time')->find();
		$this->setEmailList($id,$list); ///设置操作列表
	}
	
	
	/**
	 * 装柜单
	 *
	 * @param int $id
	 * @return array
	 */
	public function LoadContainer($id){  
		if (C('loadContainer.email_loadcontainer')!=1){ return  true; }
		$today 	= date("Y-m-d H:m:s");                           /// 20010310 
		$this->set_email_type(__FUNCTION__);
		$model				= M('load_container_details');
		$list				= $model
							->field('b.id as object_id,group_concat(d.factory_id) as comp_id,'.$this->email_type.' as email_type, load_container_no as object_no,\''.$today.'\' as insert_time')
							->join('as a 
									inner join load_container as b on a.load_container_id=b.id and b.id='.$id.' 
									inner join orders as d on a.orders_id=d.id')
							->where('a.load_container_id='.$id)
							->group('b.id')
							->find();
		$this->setEmailList($id,$list); ///设置操作列表
	}
	
	/**
	 * 入库单
	 *
	 * @param int $id
	 * @return array
	 */
	public function Instock($id){  
//		if (C('instock.email_instock')!=1){ return  true; }
		$today 	= date("Y-m-d H:m:s");                           /// 20010310 
		$this->set_email_type(__FUNCTION__);
		$model				=	M('instock');
		$list				=	$model->field('id as object_id, warehouse_id, factory_id as comp_id,'.$this->email_type.' as email_type,\''.$today.'\' as insert_time, instock_type')->find($id);
		if ($list['instock_type'] == C('CFG_INSTOCK_TYPE_INSTOCK_FOREIGN')) {
			$this->setEmailList($id,$list); ///设置操作列表
		}
	}

	/**
	 * 发货入库
	 * @param type $id
	 */
	public function InstockStorage($id){
		$instock_id	= M(__FUNCTION__)->where(array('id' => $id))->getField('instock_id');
		$this->Instock($instock_id);
	}
	
	
	/**
	 * 销售单
	 *
	 * @param int $id
	 * @return array
	 */
	public function SaleOrder($id){  
		if (C('sale.email_sale')!=1){ return  true; }
		$today 	= date("Y-m-d H:m:s");                           /// 20010310 
		$this->set_email_type(__FUNCTION__);
		$model				=	M('SaleOrder');
		$list				=	$model->where('id='.$id)->field('id as object_id,client_id as comp_id,'.$this->email_type.' as email_type, sale_order_no as object_no,\''.$today.'\' as insert_time')->find();
		$this->setEmailList($id,$list); ///设置操作列表
	}

	public function CaiNiaoRequestAbnormal($id){
		if (C('CAINIAO_REQUEST_ABNORMAL_SEND_EMAIL') != true) {return true;}
		$today 	= date("Y-m-d H:m:s");                           /// 20010310
		$this->set_email_type(__FUNCTION__);
		$exists_where	= array(
			'is_sent'	=> array('neq', 3),
			'insert_time'	=> array('egt', date('Y-m-d H:i:s', strtotime('-1days'))),
			'email_type'=> $this->email_type,
			'_string'	=> 'l.id=object_id',
		);
		$exists			= 'NOT EXISTS ' . M('email_list')->field('"1"')->where($exists_where)->buildSql();
		$where			= array(
			'id'		=> $id,
			'_string'	=> $exists,
		);
		$field			= 'l.id as object_id, l.factory_id as comp_id, '.
							$this->email_type.' as email_type,\''.$today.'\' as insert_time, ' .
							intval(C('EXPRESS_ES_WAREHOUSE_ID')) . ' as warehouse_id';
		$list			= M('CaiNiaoLog')->alias('l')->field($field)->where($where)->find();
		$this->setEmailList($id, $list); ///设置操作列表
	}

    public function OutBatch($id){		
		$today 	= date("Y-m-d H:m:s");                           /// 20010310
		$this->set_email_type(__FUNCTION__);
        $factory_id=0;
		$model				= M('OutBatch');
		$list				= $model->field('id as object_id,'.$factory_id.' as comp_id,'.$this->email_type.' as email_type,\''.$today.'\' as insert_time, warehouse_id as warehouse_id')->find($id);
		$this->setEmailList($id, $list); ///设置操作列表
	}
	
	/**
	 * 发货单
	 *
	 * @param int $id
	 * @return array
	 */
	public function Delivery($id){   
		if (C('delivery.email_delivery')!=1){ return  true; }
		$today 	= date("Y-m-d H:m:s");                           /// 20010310 
		$this->set_email_type(__FUNCTION__);
		$model				=	M('Delivery');
		$list				=	$model->where('id='.$id)->field('id as object_id,client_id as comp_id,'.$this->email_type.' as email_type, delivery_no as object_no,\''.$today.'\' as insert_time')->find();
		$this->setEmailList($id,$list); ///设置操作列表
	}

    /**
	 * 设置操作列表
	 *
	 * @param int $id
	 * @param array $list
	 */
	public function setEmailList($id,$list){
		if (is_array($list)){
			$old_list =	$this->where('is_sent=1 and to_hide=1 and email_type='.$list['email_type'].' and object_id='.$list['object_id'])->find();
			if($old_list['id']>0){
				return true;
			}
			$this->add($list);
		}else{
			$this->delete($id,$this->email_type); 
		} 
	}
	
	/**
	 * 删除
	 *
	 * @param int $id
	 * @param string $email_type
	 */
	public function delete($id,$email_type){ 
		if ($id>0 && $email_type>0){
			$this->where(' object_id='.$id.' and email_type='.$email_type)->setField('to_hide',2);	
		} 
	}
	
}
