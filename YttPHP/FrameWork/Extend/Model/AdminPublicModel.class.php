<?php
/**
 * 项目配置管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	项目配置
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-08-06
*/

class AdminPublicModel extends Model {
	// 指定表名
	protected $tableName = 'config';
	
	protected $_validate	 =	 array(
			array("price_length",'z_integer',"z_integer",2), 	
			array("money_length",'z_integer',"z_integer",2), 	
			array("cube_length",'z_integer',"z_integer",2), 	
			array("add_max_row",'pst_integer',"pst_integer",2), 	
			array("line_number",'pst_integer',"pst_integer",2), 	
			array("fit_max_row",'z_integer',"z_integer",2), 	
			array("fit_max_cols",'z_integer',"z_integer",2),
			array("dhl_shipper_name1",'require',"require",self::EXISTS_VAILIDATE),
			array("dhl_shipper_streetname",'require',"require",self::EXISTS_VAILIDATE),
			array("dhl_shipper_streetnumber",'require',"require",self::EXISTS_VAILIDATE),
			array("dhl_shipper_post_code",'require',"require",self::EXISTS_VAILIDATE),
			array("dhl_shipper_city",'require',"require",self::EXISTS_VAILIDATE),
			array("dhl_shipper_country_id",'pst_integer',"require",self::EXISTS_VAILIDATE),
			array("correos_shipper_name",'require',"require",self::EXISTS_VAILIDATE),
			array("correos_shipper_streetname",'require',"require",self::EXISTS_VAILIDATE),
			array("correos_shipper_post_code",'require',"require",self::EXISTS_VAILIDATE),
			array("correos_shipper_city",'require',"require",self::EXISTS_VAILIDATE),
			array("correos_shipper_country_id",'pst_integer',"require",self::EXISTS_VAILIDATE),
			array("",'validGlsConfig','',1,'callbacks'),
		);
	protected function validGlsConfig($data){
		$_validGlsConfig = array(
			array("ip",'require',"require",self::EXISTS_VAILIDATE),
			array("port",'require',"require",self::EXISTS_VAILIDATE),
			array("user_account",'require',"require",self::EXISTS_VAILIDATE),
			array("receive_station_code",'require',"require",self::EXISTS_VAILIDATE),
			array("contact_id",'require',"require",self::EXISTS_VAILIDATE),
			array("customer_id",'require',"require",self::EXISTS_VAILIDATE),
			array("shipper_name",'require',"require",self::EXISTS_VAILIDATE),
			array("shipper_address",'require',"require",self::EXISTS_VAILIDATE),
			array("shipper_country_code",'require',"require",self::EXISTS_VAILIDATE),
			array("shipper_postcode",'require',"require",self::EXISTS_VAILIDATE),
			array("shipper_city",'require',"require",self::EXISTS_VAILIDATE),
			array("package_no_start",'require',"require",self::EXISTS_VAILIDATE),
			array("package_no_end",'require',"require",self::EXISTS_VAILIDATE),
		);
		return $this->_moduleValidationDetail($this,$data,'gls',$_validGlsConfig);
	}
	/**
	 * 保存配置信息
	 *
	 */
	public function saveConfig(){
		$config_type	= $_POST['config_type'];
    	$type_key		= intval($_POST['type_key']);
    	if(empty($config_type)) halt('无法获取配置类型，请检查config_type值是否正确。');
    	unset($_POST['config_type'],$_POST['type_key'],$_POST['__hash__'],$_POST['submit_type'],$_POST['referer']);
    	$this->where('config_type=\''.$type.'\'')->delete();
    	foreach ($_POST as $key => $value) {
    		if (is_array($value) && !empty($value)) {
    			$value = implode(',',$value);
    		}
    		$this->add(array('config_key'=>$key,'config_value'=>$value,'config_type'=>$config_type,'type_key'=>$type_key));
    	}
    	@unlink(RUNTIME_FILE);
    	$this->updateConfig();
	}

	public function updateConfig(){
		$list = $this->select();
		$config = array();
		foreach ($list as $value) {
			if ($value['type_key']==1) {
				$config[$value['config_type']][$value['config_key']] = $value['config_value'];
			}else {
				$config[$value['config_key']] = $value['config_value'];
			}
		}
		/// 删除缓存的runtime文件
		@unlink(RUNTIME_FILE);
		file_put_contents(CONFIG_FILE,'<?php return '.var_export($config,true).';?>');
	}
	public function deleteGlsConfig($delete_gls_config){
		$config_key	= array('w_id', 'ip', 'port', 'user_account', 'receive_station_code', 'contact_id', 'customer_id', 'shipper_name', 'shipper_name2', 'shipper_name3',
			'shipper_address', 'shipper_country_code', 'shipper_postcode', 'shipper_city', 'package_no_start', 'package_no_end',
		);
		foreach ($delete_gls_config as $w_id=>$v) {
			if(C('gls_w_id_'.$w_id)){
				foreach ($config_key as $value){
					$key_where[]	= 'gls_'.$value.'_'.$w_id;
				}
				$where['config_key']	= array('in',  implode(',', $key_where));
				M('Config')->where($where)->delete();
			}
		}
		@unlink(RUNTIME_FILE);
		$this->updateConfig();
	}
}