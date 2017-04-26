<?php 
/**
 * 客户/厂家/物流初始化款项信息公共类
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class FundsIniPublicModel extends AbsFundsPublicModel {
	
	/// 模型名与数据表名不一致，需要指定
	public $tableName 	= 	'';
	///款项类型
	public $object_type		=	'';///物流其他应收款
	///对象类型
	public $comp_type		=	0;

	public $indexTableName	=	''; ///列表查询的表的名字
	 
	/// 自动验证设置
	protected $_validate	 =	 array( 
										array("",'validIniInfo','require',1,'callbacks'), 	 
										
	); 
	
	/**
	 * 类别验证
	 *
	 * @param array $data
	 * @return array
	 */
	public function validIniInfo($data){   
		$_validate	 =	 array( 
										array("comp_id",'require',"require",1),
										array("basic_id",'require',"require",1),
										array("currency_id",'pst_integer',"require",1),
										array("comp_id",'repeat',"repeat",1,'unique_sp','',array('object_type'=>$this->object_type,'currency_id'=>$data['currency_id'],'basic_id'=>$data['basic_id'],'comp_id'=>$data['comp_id'],'to_hide'=>1)),///验证唯一
										array("paid_date",'require',"require",1), 
										array("money",'require',"require",1),
										array("money",'money',"money_error",1),  
										
	);    
		return $this->_validSubmit($data,$_validate);     
	}
	

	/**
	 * 处理物流期初期初欠款(插入/修改);
	 *
	 * @param array $info
	 * @return array
	 */
	public function _fund($info){  
		$this->_beforeFund($info);
		$vo	= $this->_saveFunds($info);
		return $vo;
	}
	 
	/**
	 * 插入前的业务规则验证
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkInsert($info){   
		return	$this->checkPaidDate($info,'paid_date');  
	} 
	 

}