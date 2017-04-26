<?php 
/**
 * 收款指定平帐
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class ClientFundsCloseOutPublicModel extends AbsFundsPublicModel  {
	
	///款项类型
	public $object_type		=	104;///客户销售单预付款
	///对象类型
	public $comp_type		=	1;
  
	 
	/**
	 * 平帐
	 *
	 * @param array $info
	 * @return array $vo
	 */
	public function _fund($info){     
		return $this->_closeOutFunds($info); 
	}
	
	/**
	 * 删除款项
	 *
	 * @param int $id
	 * @return array
	 */
	public function deleteOp($id){ 
		///流程ID
		if($id>0) {
			$paid_id = $this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1') 
			->group('object_id')
			->getField('group_concat(id)');  
			///款项表ID
			if (!empty($paid_id)){
				$vo	=	$this->_deleteFunds($paid_id); 
				return $vo;
			}
		} 
	} 
	   
}
?>