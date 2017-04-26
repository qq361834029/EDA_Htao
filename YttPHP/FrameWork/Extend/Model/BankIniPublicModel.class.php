<?php 
/**
 * 银行期初款项
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-08-06
 */

class BankIniPublicModel extends AbsBankPublicModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName 		= 	'bank_center';
	///银行类型
	public $bank_object_type	=	1;///银行期初存款

	public $paid_object_type	=	1001;///银行期初存款

	///对象类型
	public $comp_type			=	0;

	public $indexTableName	= 'bank_center'; ///列表查询的表的名字
	 
	/// 自动验证设置
	protected $_validate	= array(
								array("delivery_date",'require',"require",1),
								array("currency_id",'require',"require",1),
								array("money",'require',"require",1),				
								array("money",'money',"money_error",1),
								array("",'validBank','',1,'callbacks'), 
						);

	/**
	 * 自定义验证规则，用于验证选择银行类型后有可能的必填项
	 *
	 * @param  array $data
	 * @return  array
	 */
	protected function validBank($data){
		// 用户类型为 厂家/客户 时所属公司必填
		if ($data['paid_type']==3) {
			$vasd = array(array("bank_id",'require',"require",1),
							array("bank_id",'',"unique",1,'unique','',array('bank_object_type'=>1,'to_hide'=>1))///验证唯一
			);
			return $this->_validSubmit($data,$vasd);
		}
	}
}