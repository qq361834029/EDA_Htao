<?php 
/**
 * 快递公司欠款(销售单发货之派送成本) object_type 220 
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-05-30
 */

class FactoryInstockPublicModel extends AbsFundsPublicModel {
	//款项类型
	public $object_type	=	220;//快递公司欠款(销售单发货之派送成本)
	//对象类型
	public $comp_type	=	3;//1 卖家 2 物流公司 3 快递公司
   
	/**
	 * 快递公司欠款(销售单发货之派送成本)
	 *
	 * @param int $info
	 * @return array
	 */
	public function _fund($info){
		$funds					= $info['funds'];
		$funds['comp_id']		= M('Express')->where('id=' . $funds['express_id'])->getField('company_id');
		$funds['comp_name']		= SOnly('express', $funds['comp_id'], 'express_name'); 
		$funds['comp_type']		= $this->comp_type;
		$funds['object_type']	= $this->object_type;
		$funds['money']			= $info['express_detail']['cost'] + ($funds['is_registered'] == 1 ? $info['express_detail']['registration_cost'] : 0);
		unset($funds['express_id'], $funds['express_detail_id'], $funds['is_registered'], $funds['package_id'], $funds['weight']);
		$funds_id	= $this->where('object_id=' . $funds['object_id'] . ' and object_type=' . $funds['object_type'] . ' and pay_class_id=' . $funds['pay_class_id'])->getField('id');
		if ($funds_id > 0) {
			unset($funds['paid_date']);
			$funds['id']	= $funds_id;
		}		
		$funds['id']			= $this->_saveFunds($funds);
		return $funds;
	}
	
	/**
	 * 删除
	 *
	 * @param int $id 入库单号
	 * @return array
	 */
	public function deleteOp($id){ 
		$id	=	is_array($id)?$id['id']:$id;
		//入库ID
		if($id>0) {
			//获取上次款项表中的ID
			$paid_array	=	$this->getBeforPaidIdArray($id); 
			if(count($paid_array)>0) { 
				//款项表ID 
				$vo	=	$this->_deleteFunds($paid_array); 
				return $vo; 
			}
		} 
	}
	 
	/**
	 * 验证是否可修改
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkEdit($info){ 
		return true;
		return $this->checkHaveCloseOut($info); 
	}
	 
	/**
	 * 验证是否可删除
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkDelete($info){  
		return $this->checkHaveCloseOut($info);
	}
	 
	/**
	 * 验证多个厂家是否被对账或总平
	 *
	 * @param array $info
	 * @return array
	 */
	private function checkHaveCloseOut($info){
		$error['state']	=	1;
		//装柜单ID 
		$id	=	is_array($info)?$info['id']:$info; 
		//验证是否被对账或者总平
		if ($id>0) {
			$model		= M($this->getCompPaidDetail($this->comp_type));
		 	$paid_info	= $model 
							->where('object_id='.$id.' and object_type='.$this->object_type.' ')
							->select();  
			//插入(修改)多个厂家欠款
			foreach ((array)$paid_info as $key=>$row) {  
				//验证是否被总平或者对账
				$error				=	$this->checkAccountDate($row,'delete');
				if ($error['state']==-1) {
					break;
				}
				//验证是否被指定支付
				$error	=	parent::checkDelete($row);
				if ($error['state']==-1) {
					break;
				}
			} 
		}else{
			$error['state']			=	-1; 
			$error['error_msg'][]	=	L('error_funds_values_error');//款项验证,参数错误,请重新操作
		}   
		return $error; 
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
	 * 验证某日期以前的款项是否可以被插入
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkFactoryDate($info){
		$error['state']	=	1;   
		$info['comp_type']	=	$this->comp_type; 
		if ($this->validCheckAccountDate($info['real_arrive_date'],$info)===false){
			$error['state']	=	-1;
			$error['error_msg'][]	=	$info['real_arrive_date'].L('error_input_paid_date_is_max');//已指定操作,不可删除
		} 
		return $error;
	}
	 
	/**
	 * 过滤掉不可修改入库的厂家
	 *
	 * @param int $id
	 * @return array
	 */
	public function EditPassInfo($id){ 
		$model	=	M($this->getCompPaidDetail($this->comp_type));
		$list	=	$model->field('comp_id,currency_id')
		->where('( have_paid>0 || is_close>0 ) and object_type='.$this->object_type.' and object_id='.$id)
		->select(); 
		return $list;
	}
	
	
}
?>