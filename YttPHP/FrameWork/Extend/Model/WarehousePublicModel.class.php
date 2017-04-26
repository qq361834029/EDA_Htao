<?php

/**
 * 仓库信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     jph
 * @version  2.1,2014-01-17
 */

class WarehousePublicModel extends CommonModel {

	protected $tableName = 'warehouse';

	// 自动验证设置
	protected $_validate	 =	 array(
			array("w_no",'require',"require",1), //仓库编号
			array("w_no",'is_no',"valid_error",1),
			array("w_no",'repeat',"repeat",1,'unique'),//验证唯一
			array("w_no",'zone_no',"valid_zone_no",1),//不超过3位的字母或数字
			array("w_name",'require',"require",1), //仓库名称
			array("w_name",'repeat',"repeat",1,'unique'), //仓库名称
			array("basic_id",'require',"require",1), //所属公司
			array("area",'double',"double",2),
			array("currency_id",'require',"require",self::MUST_VALIDATE),
			array("country_id",'pst_integer',"require",1), //仓库所属国家 20160803
            array("",'validRelation','require',1,'callbacks'),
	);
    public function validRelation($data){
        if($data['is_return_sold'] == C('NO_RETURN_SOLD')){
            $relation_warehouse[]   = array("relation_warehouse_id", 'require', "require", 0);
            return $this->_validSubmit($data, $relation_warehouse);
        }
    }
    public function getById($id){
        $info   = M('warehouse')->where('id='.$id)->find();
        $info['relation_warehouse_name']  = SOnly('warehouse',$info['relation_warehouse_id'],'w_name');;
        return $info;
    }
    public function _before_update(&$data, $options) {
        parent::_before_update($data, $options);
        $this->_brf();
    }
    public function _brf(){
		// 业务规则检查
        $all_tags 	 	= C('extends');
        $action_tag_name = $this->_module.'^'.$this->_action;
        if (isset($all_tags[$action_tag_name])) {
        	// 添加关联类的模块信息
			$_POST['_module'] = $this->_module;
			$_POST['_action'] = $this->_action;
        	tag($action_tag_name,array_merge($_GET,$_POST));
        }
	}
}