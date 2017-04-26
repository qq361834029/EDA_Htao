<?php

/**
 * 角色信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	角色信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class RolePublicModel extends RelationModel {
	// 模型名与数据表名不一致，需要指定
	protected $tableName = 'role';
	
	// 定义关联属性
	public $_link = array(
	 	'access'=>array(
	 		'mapping_type'	=> HAS_MANY,
	 		'foreign_key'	=> 'role_id',
	 		'class_name'	=> 'access'
	 	)
	);

	// 自动验证设置
	protected $_validate	 =	 array(
				array("role_name",'require',"require",1),
				array("role_name",'',"unique",1,'unique'),//验证唯一  
				array("is_admin",'require',"require",0),
				array("role_type",'require',"require",1),
				
	);
	
	/**
	 * 获取可用的节点信息
	 *
	 * @return  array
	 */
	public function getNode(){
		$node = M(C('RBAC_NODE_TABLE'))->where('status=1')->order('group_id asc,sort asc')->select();
		return $node;
	}
	
	/**
	 * 保存之前自动调用的POST数据整理方法
	 *
	 * @return  bool
	 */
	public function setPost(){
		$flow = $_POST['flow'];
		if (empty($flow)){return ;}
		$access = array();
		if (C('rights_level')==3) {
			foreach ($flow as $node_id=>$bool) {
				$this->addParentNode($node_id,$access);
				$access[$node_id] = array('node_id'=>$node_id,'data_rights'=>$_POST['data_rights'][$node_id]);
			}
		}else{
			// 设置已选菜单的下级权限
			foreach ($flow as $node_id=>$bool) {
				$this->addParentNode($node_id,$access);
				$access[$node_id] = array('node_id'=>$node_id,'data_rights'=>$_POST['data_rights'][$node_id]);
				$this->addSubNode($node_id,$access);
			}
		}
		$_POST['access'] = $access;
		return $_POST;
	}
	
	/**
	 * 添加勾选权限的上级权限
	 *
	 * @param  ing $node_id
	 * @param  array $access	 页面中勾选的权限数组
	 * @return  bool
	 */
	private function addParentNode($node_id,&$access){
		$self 	= M(C('RBAC_NODE_TABLE'))->find($node_id);
		if($self['parent_id']<=0) return true;
		$parent = M(C('RBAC_NODE_TABLE'))->find($self['parent_id']);
		!isset($access[$parent['id']]) && $access[$parent['id']] = array('node_id'=>$parent['id'],'data_rights'=>$_POST['data_rights'][$parent['id']]);
		if ($parent['parent_id']) {
			$this->addParentNode($parent['id'],$access);
		}
	}
	
	/**
	 * 添加勾选权限的下级权限
	 *
	 * @param  ing $node_id
	 * @param  array $access	 页面中勾选的权限数组
	 * @return  bool
	 */
	private function addSubNode($node_id,&$access){
		$list = M(C('RBAC_NODE_TABLE'))->where('status=1 and parent_id='.$node_id)->select();
		foreach ((array)$list as $value) {
			$access[$value['id']] = array('node_id'=>$value['id'],'data_rights'=>$_POST['data_rights'][$node_id]);
		}
	}
}