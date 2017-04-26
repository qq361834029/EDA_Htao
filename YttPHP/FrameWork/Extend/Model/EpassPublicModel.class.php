<?php 
/**
 * Epass
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	系统信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class EpassPublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'epass';
	/// 自动验证设置
	protected $_validate	 =	 array(
				array("epass_serial",'require',"require",1),
				array("epass_serial",'',"unique",1,'unique'),///验证唯一 
				array("epass_no",'require',"require",1),
				array("epass_no",'',"unique",1,'unique'),///验证唯一 
				array("epass_key",'require',"require",1),
				array("epass_key",'',"unique",1,'unique'),///验证唯一 
				array("epass_data",'require',"require",1),
				array("epass_data",'',"unique",1,'unique'),///验证唯一  
			); 

	/**
	 * epass验证
	 *
	 * @param array $epass
	 * @param int $id
	 * @return bool
	 */
	public function checkEpass($epass,$id){ 
		$epass_list	=	S('epass');
		$user_epass	=	$epass_list[$id];    
		if ($epass['epass_no']!=$user_epass['epass_no'] || $epass['epass_data']!=$user_epass['epass_data']) {
			return false;
		}  
		return true;
	}
	
}