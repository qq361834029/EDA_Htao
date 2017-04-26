<?php 
/**
 * 客户收款
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class ClientFundsPublicModel extends ObjectFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName 			= 'paid_detail';
	///表查询
	public $comp_paid_detail 		= 'client_paid_detail'; 
	///合计数量的count对应的字段id
	public $indexCountPk 			= 'id'; 
	///款项类型
	public $object_type				=	103;///客户不指定收款
	///客户平账款项类型
	public $object_type_close_out	=	104;
	///对象类型
	public $comp_type				=	1;	
	///预收款->款项类型
	public $object_type_advance		=	121;
	///
	public $sale_object_type		=	120;
	 
	 
	/**
	 * 删除前的款项验证
	 *
	 * @param array $info 数组中应包含被删除款项表中的id 已经 comp_type
	 * @param string $type
	 * @return array
	 */
	public function checkDelete($info,$type='array'){   
        	$id	=	is_array($info)?$info['id']:$info;
        	$model		=	M($this->getCompPaidDetail($this->comp_type));
        	$object_id	=	$model->where('object_type=' . $this->object_type . ' and paid_id='.$id)->getField('object_id');        
		///验证是否是卖家充值款项
		if ($object_id>0) { 
			$error['state']		= -1;
			$error['error_msg'][]	= L('error_funds_is_client_recharge');
			return $error;
		}            
		return $this->checkFundsDelete($info,$type); 
	}	
}