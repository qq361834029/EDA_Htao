<?php
/**
 * 物流入库运费
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-08-07
*/

class LogisticsInstockPublicModel extends AbsFundsPublicModel {
	///款项类型
	public $object_type	=	320;///物流入库运费
	///对象类型
	public $comp_type	=	3;
   
	/**
	 * 入库产生物流公司欠款
	 *
	 * @param int $id 入库单号
	 * @return unknown
	 */
	public function _fund($id){    
		$id	=	is_array($id)?$id['id']:$id;  
		if ($this->startUsing()==false){ return true;}///判断该类是否被启用 
		if ($id>0){
			///插入物流公司欠款
			$model	= M('instock');
		 	$info	= $model
		 			->field(''.C('main_basic_id').' as basic_id,a.currency_id as currency_id,date(a.real_arrive_date) as paid_date,
								a.logistics_id as comp_id,'.$this->comp_type.' as comp_type,a.id as object_id, instock_no as reserve_id,
								sum(a.delivery_fee) as money,c.paid_id as id,
								'.$this->object_type.' as object_type,c.have_paid
								')
							->join('as a  
									left join logistics_paid_detail as c 
										on c.object_id=a.id and c.object_type='.$this->object_type.' 
										')
							->where('a.id='.$id.' ')///过滤掉已经被指定的款项
							->group('a.id')
							->find();    		 
			if ($info['have_paid']==0 || empty($info['have_paid'])) { 
				$comp_name			=	SOnly('logistics',$info['comp_id']);
				$info['comp_name']	=	$comp_name['logistics_name'];    
				$vo	=	$this->_saveFunds($info); 		 	
			}	 
			return $vo;		
		}  
	}
	
	/**
	 * 删除款项(提供给流程使用)
	 *
	 * @param int $id 入库单号
	 * @return unknown
	 */
	public function deleteOp($id){     
		if ($this->startUsing()==false){ return true;}///判断该类是否被启用 
		$id	=	is_array($id)?$id['id']:$id;  
		///流程ID
		if($id>0) {
			$paid_id = $this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1') 
			->getField('id');   
			///款项表ID
			if ($paid_id>0){
				///删除paid_id
				$vo	=	$this->_deleteFunds($paid_id);   
				return $vo;
			}
		} 
	}
	
	/**
	 * 验证是否可修改
	 *
	 */
	public function checkEdit($info){  
		return true; 
		return $this->checkHaveCloseOut($info); 
	}
	
	/**
	 * 验证是否可删除
	 *
	 */
	public function checkDelete($info){  
		if ($this->startUsing()==false){ return true;}///判断该类是否被启用  
		return $this->checkHaveCloseOut($info);
	}
	
	/**
	 * 验证多个物流是否被对账或总平
	 */
	private function checkHaveCloseOut($info){
		$error['state']		=	1;  
		if ($this->startUsing()==false){ return $error;}///判断该类是否被启用
		///装柜单ID 
		$id	=	is_array($info)?$info['id']:$info; 
		///验证是否被对账或者总平
		if ($id>0) { 
			$model	= M($this->getCompPaidDetail($this->comp_type));
		 	$paid_info		= $model 
							->where('object_id='.$id.' and object_type='.$this->object_type.' ')
							->find();     			
			$error	=	$this->checkAccountDate($paid_info,'delete'); 
			if ($error['state']!=-1) {
				///验证是否被指定支付 
				if (is_array($paid_info)){
					$error	=	parent::checkDelete($paid_info); 
				} 
			}
		}else{ 
			$error['state']		=	-1; 
			$error['error_msg'][]	=	L('error_funds_values_error');///款项验证,参数错误,请重新操作
		}   
		return $error; 
	}
	
	/**
	 * 判断该类是否被启用
	 *
	 * @return unknown
	 */
	public function startUsing(){  
		if (C('instock.instock_logistics_funds')==1){///超管开启->入库显示运费
			return true;///开启
		}else{
			return false;///关闭
		} 
	}
	
	
	/**
	 * 过滤掉不可修改入库的厂家
	 *
	 * @param int $id
	 */
	public function EditPassInfo($id){ 
		if ($this->startUsing()==false){ return ;}///判断该类是否被启用
		$model	=	M($this->getCompPaidDetail($this->comp_type));
		$list	=	$model->field('comp_id,currency_id')
		->where('( have_paid>0 || is_close>0 ) and object_type='.$this->object_type.' and object_id='.$id)
		->select(); 
		return $list;
	}
	
	/**
	 * 插入前的业务规则验证
	 *
	 * @param array $info
	 */
	public function checkInsert($info){ 
		if ($this->startUsing()==false){ return ;}///判断该类是否被启用    
		return	$this->checkDate($info);  
	}
	
	/**
	 * 修改插入数据前的业务规则验证
	 *
	 * @param array $info
	 */
	public function checkUpdate($info){  
		if ($this->startUsing()==false){ return ;}///判断该类是否被启用
		return	$this->checkDate($info);  
	} 
	
	/**
	 * 验证某日期以前的款项是否可以被插入
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkDate($info){
		$error['state']	=	1;   
		$info['comp_type']	=	$this->comp_type;  
		if ($this->validCheckAccountDate($info['real_arrive_date'],$info)===false){
			$error['state']	=	-1;
			$error['error_msg'][]	=	$info['real_arrive_date'].L('error_input_paid_date_is_max');///已指定操作,不可删除
		} 
		return $error;
	}
	
	 
}
?>