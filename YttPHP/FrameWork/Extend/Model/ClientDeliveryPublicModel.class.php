<?php 
/**
 * 销售实际发货单欠款 object_type 124 
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class ClientDeliveryPublicModel extends AbsFundsPublicModel {
	
	
	///款项类型
	public $object_type				=	120;///销售单发货
	public $object_type_advance		=	121;///预付款
	///平账->款项类型
	public $object_type_close_out	=	122;
	///对象类型
	public $comp_type				=	1;	
	///对象款项表
	public $object_type_table		=	'client_paid_detail';	
   
	/**
	 * 销售产生的款项
	 *
	 * @param array $info $id 发货单ID
	 * @return array $vo
	 */
	public function _fund($params){    
		$id	=	$params['id'];///发货单ID
		if ($id<=0) { return ;}
		///获取对应的销售单ID 
		foreach ($params['detail'] as &$d_row) {
			if($d_row['sale_order_id']>0){
				$sale_id = $d_row['sale_order_id'];
				break;
			}
		}
		$sale_order_state	=	M('SaleOrder')->where('id='.$sale_id)->getField('sale_order_state');
	 
		if ($sale_id>0 && $sale_order_state==3){   
			///更新销售单欠款 
			$sale_funds	=	$this->saleFunds($sale_id); 	 
			if(is_array($sale_funds) && $sale_funds['id']>0) {
				$paid_for[]	=	$sale_funds['id'];
				///删除paid_for中打包关联
				$this->_deletePaidFor(intval($sale_funds['id']));
			}
			$info['advance']	=	Funds($sale_id,$this->object_type_advance,'fundInfo');///预付款信息 
			if(is_array($info['advance'])) {
				foreach ((array)$info['advance'] as $key=>$row) {
				    foreach ((array)$row as $key2=>$row2) { 
				        if($row2['id']>0) {
				       	 	$paid_for[]	=	$row2['id'];
				        }
				    }
				} 
				///删除paid_for中打包关联
				$this->_deletePaidFor(intval($sale_funds['id']));
			} 
  
			///paid_for记录
		 	if(count($paid_for)>1) { 
				///绑定记录  
	 			$this->addPaidFor($this->comp_type,$paid_for);
			}
			///把关联销售单的款项的状态都修改为已确认
			$this->updateState(' object_type in ('.$this->object_type.','.$this->object_type_advance.','.$this->object_type_close_out.') and object_id='.$sale_id,1);
			
			return ;
		}elseif ($sale_id>0 && $sale_order_state!=3 ){
			///判断销售单是否已完全发货过,如果是删除原有信息
			///删除实际发货
			$this->deleteOp($sale_id);
		} 
	}
	
	/**
	 * 删除实际发货
	 *
	 * @param int $id	销售单ID
	 */ 
	public function deleteOp($id){   	
		if($id>0) {
			///还原销售单欠款 
			$sale_funds	=	Funds($id,$this->object_type,'saleFunds');   
			if(is_array($sale_funds) && $sale_funds['id']>0) {
					$paid_for[]	=	$sale_funds['id'];
					///删除paid_for中打包关联
					$this->_deletePaidFor(intval($sale_funds['id']));
			}
			
			///获取历史预付款信息
			$info['advance']	=	Funds($id,$this->object_type_advance,'fundInfo');///预付款信息 
			if(is_array($info['advance'])) {
				foreach ((array)$info['advance'] as $key=>$row) {
				    foreach ((array)$row as $key2=>$row2) { 
				        if($row2['id']>0) {
				       	 	$paid_for[]	=	$row2['id'];
				        }
				    }
				} 
				///删除paid_for中打包关联
				$this->_deletePaidFor(intval($sale_funds['id']));
			}
			///paid_for记录
		 	if(count($paid_for)>1) { 
				///绑定记录  
	 			$this->addPaidFor($this->comp_type,$paid_for);
			}
			///把关联销售单的款项的状态都修改为已确认
			$this->updateState(' object_type in ('.$this->object_type.','.$this->object_type_advance.','.$this->object_type_close_out.') and object_id='.$id,0);
		} 
		 
	}
	
	/**
	 * 销售单欠款信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function fundInfo($id){
		
		if($id>0) {
			///销售单欠款
			$info['funds'] = _formatList($this->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1')->select());  
		} 
		///预付款信息
		$info['advance']	=	Funds($id,$this->object_type_advance,'fundInfo');
		///平帐信息
		$info['close_out']	=	Funds($id,$this->object_type_close_out,'fundInfo');
		$sale_order_paid	=	M('saleOrderPaid');
		///销售单款项信息
		$info['sale_order_paid']	=	$this->_formatArray($sale_order_paid->where('object_id='.$id)->find()); 
		return $info;
	}
	
	/**
	 * 销售单欠款
	 *
	 * @param int $sale_id	销售单ID
	 * @return array
	 */
	public function saleFunds($sale_id){
		$this->format_data = false; 
		$model	= M('deliveryDetail');
		$info	= $model->field( 'b.basic_id as basic_id,b.currency_id as currency_id,date(b.order_date) as paid_date,
								b.client_id as comp_id,'.$this->comp_type.' as comp_type,b.id as object_id,b.sale_order_no as reserve_id,
								(sum(quantity*capability*dozen*discount*price)-b.pr_money) as money, 
								c.paid_id as id,
								'.$this->object_type.' as object_type
								')
								->join('as a  
										left join sale_order as b on b.id=a.sale_order_id 
										left join '.$this->object_type_table.' as c 
											on c.object_id=a.sale_order_id and c.object_type='.$this->object_type.' 
											')
								->where('a.sale_order_id='.$sale_id.' ')
								->group('a.sale_order_id')
								->find();
		///更新销售单状态							
		$info['state']		=	1; 
		$comp_name			= SOnly('client',$info['comp_id']);
		$info['comp_name']	= $comp_name['client_name'];   
		$info['id']			= $this->_saveFunds($info);  
		return $info;
	}
	
	/**
	 * 销售单总平帐时使用的，功能删除
	 *
	 * @param int $sale_id
	 
	public function saleCloseOut($sale_id){
		
		$info	=	$this->field('*,comments as close_out_comments')
				->where('comp_type='.$this->comp_type.' and to_hide=1 and object_type='.$this->object_type_close_out.' and object_id='.$sale_id)->find();
				echo $this->getLastSql();
		存在预付款平帐
		if(is_array($info)) { 
			$info['close_out']	=	2;///平帐标示
			$info['sale_id']	=	$sale_id;///平帐标示
			$info['to_hide']	=	0;	  
		} 
	}
	 */
	/**
	 * 验证是否可修改
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkEdit($info){
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
	 * 验证多个厂家是否被对账或总平或者指定支付
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkHaveCloseOut($info){
		$error['state']	= 1;
		if(is_array($info)){
			$id	= $info['id'];
		}else{
			$id = $info;
		}

		///发货单ID
		$sale_order_id = M('delivery_detail')->where('delivery_id='.$id)->getField('sale_order_id');
		if ($sale_order_id>0) {
			///判断是否全部已经发货 
			$sale_order_state	= M('SaleOrder')->where('id='.$sale_order_id)->getField('sale_order_state');
			///验证是否被对账或者总平
			if ($sale_order_state==3) {
				///销售单删除验证
				$error = $this->_checkSaleOrder($sale_order_id); 
			}
		}
		return $error; 
	}
}
?>