<?php 
/**
 * 厂家在路上的款项 object_type 221 
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class FactoryOnRoadPublicModel extends AbsFundsPublicModel {
	///款项类型
	public $object_type	=	221;///厂家在路上的款项
	///对象类型
	public $comp_type	=	2;	
   
	/**
	 * 厂家在路上的款项
	 *
	 * @param int $id
	 * @return array
	 */
	public function _fund($id){  
		$id	=	is_array($id)?$id['id']:$id;
///		echo $id;  
		if($id<=0){
			return ;
		} 
		///上次生成的款项ID
		$old_id_array	=	$this->getBeforPaidIdArray($id); 
 		
		$model	= M('load_container_details');
	 	$info	= $model
	 			->field( 	''.C('main_basic_id').' as basic_id,d.currency_id as currency_id,date(b.load_date) as paid_date,
							d.factory_id as comp_id,'.$this->comp_type.' as comp_type,a.load_container_id as object_id,0 as state,
							sum(a.quantity*a.capability*a.dozen*a.price) as money,c.id as id,b.load_container_no  as reserve_id,
							'.$this->object_type.' as object_type
							')
						->join('as a 
								left join load_container as b on a.load_container_id=b.id and b.id='.$id.' 
								left join orders as d on a.orders_id=d.id  
								left join paid_detail as c 
									on c.object_id=a.load_container_id 
									and d.factory_id=c.comp_id 
									and comp_type='.$this->comp_type.' 
									and object_type='.$this->object_type.'
									and c.currency_id=d.currency_id 
									and c.to_hide=1 
									')
						->where('a.load_container_id='.$id.' and b.load_state=1 ')
						->group('d.factory_id,d.currency_id')
						->select();  
		$this->format_data = false; 
		///插入(修改)多个厂家欠款 
		foreach ((array)$info as $key=>$row) { 
		    $comp_name			=	SOnly('factory',$row['comp_id']);
			$row['comp_name']	=	$comp_name['factory_name']; 
			$vo[]	=	$this->_saveFunds($row);
		} 
		///删除款项id差集
		$this->array_diff_id_key($old_id_array,$info); 
		///预付款 
		return $vo;
	}
	
	/**
	 * 删除销售单客户欠款
	 *
	 * @param int $id 入库单号
	 * @return array
	 */
	public function deleteOp($id){ 
		 
		///销售单ID
		if($id>0) {
			///获取上次款项表中的ID
			$paid_array	=	$this->getBeforPaidIdArray($id); 
			if(count($paid_array)>0) {
				///款项表ID 
				$vo	=	$this->_deleteFunds($paid_array); 
				return $vo; 
			} 
		} 
	}
	 
	/**
	 * 插入前的业务规则验证
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkInsert($info){   
		return	$this->checkFactoryDate($info);  
	}
	 
	/**
	 * 修改插入数据前的业务规则验证
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkUpdate($info){  
			return	$this->checkFactoryDate($info);  
	} 
	 
	/**
	 * 删除入库单(不需要验证)
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkDelete($info){   
		return	true;  
	}
	
	/**
	 * 验证某日期以前的款项是否可以被插入
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkFactoryDate($info){
		$error['state']	=	1; 
		if ($this->validCheckAccountDate($info['load_date'],$info)===false){
			$error['state']	=	-1;
			$error['error_msg'][]	=	$info['load_date'].L('error_input_paid_date_is_max');///已指定操作,不可删除
		}
		return $error;
	} 
 
}
?>