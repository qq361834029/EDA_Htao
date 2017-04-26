<?php
/**
 * 款项
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class FundsPublicBehavior extends Behavior {
	
	public function run(&$params){   
		
	} 
	
	public function insert($params){    
		$module_name	=	(empty($params['module_name']))?MODULE_NAME:$params['module_name'];  
		$this->checkFundsAction($params,'checkInsert',$module_name);          
	}
	
	/**
	 * 更新
	 *
	 * @param array $params
	 */
	public function update($params){   
		$module_name	=	(empty($params['module_name']))?MODULE_NAME:$params['module_name'];  
		$this->checkFundsAction($params,'checkUpdate',$module_name);       
	}
	
	
	
	/**
	 * 修改
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	public  function edit($params){  
		$module_name	=	(empty($params['module_name']))?MODULE_NAME:$params['module_name'];  
		$this->checkFundsAction($params,'checkEdit',$module_name);      
	}
	 
	/**
	 * 删除前置验证，自动调用同名方法
	 *
	 * @param uget post 数组合并结果，自动传参$params
	 */
	public  function delete($params){  
		$id		=	$params['id'];  
		$module_name	=	(empty($params['module_name']))?MODULE_NAME:$params['module_name'];
		if ($id>0){    
			$this->checkFundsAction($id,'checkDelete',$module_name);      
		}else{
			throw_json('参数错误不可操作！');
		}
	}
	
	/**
	 * 根据模块操作验证数据可操作性
	 *
	 * @param array $action
	 * @param string $action
	 * @param string $action
	 */
	public function checkFundsAction($info,$action='',$module_name=''){
		if (empty($action)){ return ;}   
		///插入数据前的业务规则验证  
		$object_type	=	$this->getModel($module_name);  
		if (is_array($object_type)){
			foreach ((array)$object_type as $key=>$row) {  
				$error	=	Funds($info,$row,$action);     
				$this->FundsError($error);
			} 
		}else{ 
			$error	=	Funds($info,$object_type,$action);    
			$this->FundsError($error);
		}   
	}
	
	
	/**
	 * 错误提示
	 *
	 * @param array $error
	 */
	public function FundsError($error){
		if ($error['state']==-1) { 
				$str= join(',',$error['error_msg']); 
				throw_json($str);
		} 
	}
	
	
	/**
	 * 模块名称
	 *
	 * @param string $module_name
	 * @return string
	 */
	function getModel($module_name){ 
		$modelId	=	array( 
							'ComCashIni'			=>1,///公司现金期初 
							
							'ClientIni'				=>101,///客户期初欠款 
							'ClientOtherArrearages'	=>102,///客户其他欠款
							'ClientFunds'			=>103,///客户不指定收款
							'ClientFundsCloseOut'	=>104,///客户付款平帐 
							'ClientRecharge'		=>103,///客户付款平帐 
							
///							'ClientSale'			=>120,///销售单客户欠款 
							'ClientSaleAdvance'		=>121,///销售单预收款
							'ClientSaleCloseOut'	=>122,///销售单指定平帐
							'ClientReturnSale'		=>123,///退货
///							'ClientSaleDelivery'	=>124,///销售单实际发货 
							'ClientCheckAccount'	=>129,/// 客户对账 
                            'ClientPriceAdjust'     =>130,///调价 added by jp 20131216
							
							
							'FactoryIni'			=>201,
							'FactoryOtherArrearages'=>202,
							'FactoryFunds'			=>203,
							'FactoryFundsCloseOut'	=>204,
							
							'FactoryInstock'		=>220,///入库欠款 
							'FactoryOnRoad'			=>221,///厂家装柜在路上的款项 
							'FactoryCheckAccount'	=>229,/// 厂家对账
							
							
							'LogisticsIni'				=>301,///物流期初欠款
							'LogisticsOtherArrearages'	=>302,///物流其他欠款
							'LogisticsFunds'			=>303,///物流不指定收款 
							'LogisticsFundsCloseOut'	=>304,///物流付款平帐
							
							'LogisticsInstock'			=>320,///物流入库欠款 
							'LogisticsCheckAccount'		=>329,///物流公司对账
							
							'ComOtherExpenses'			=>800,///公司其他支出 
							'ComOtherRevenue'			=>801,///公司其他收入
							);   
		$object_type	=	$modelId[$module_name]; 
		if ($object_type<=0){
			$object_type	=	$this->getFlowModel($module_name);
		}  
		return $object_type;
	}
	
	/**
	 * 流程调用
	 *
	 * @return unknown
	 */
	function getFlowModel($module_name){
		$ModuleName	=	array(  
							'SaleOrder'				=>120,///销售单客户欠款 
							'LoadContainer'			=>221,///厂家装柜在路上的款项 
							'Instock'				=>array(220,320),///入库欠款;///物流入库欠款
							'Delivery'				=>124,///销售单实际发货
							'ReturnSaleOrder'		=>array(123),///销售单实际发货
                            'PriceAdjust'           =>130,///调价 added by jp 20131216
							);   
		$object_type	=	$ModuleName[$module_name];		 
		return $object_type;
							
	}
	
	
}