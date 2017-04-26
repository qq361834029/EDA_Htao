<?php 
/**
 * dd
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	系统信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class DdModel extends Model {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'Dd'; 
	
	/**
	 * 返回单个信息
	 *
	 * @param int $id
	 * @param string $field
	 * @return array
	 */
	public function getInfo($id,$field='*'){
		if ($id<=0){ return false;}
		$info['field']	=	$field;
		$info['where']	=	'id='.$id;
		$rs				=	$this->getList($info); 
		return $rs[0]; 
	}
	
	/**
	 * 返回列表
	 *
	 * @param array $info
	 * @return array
	 */
	public function getList($info){
		extract($info);
		$field	=	$field?$field:'*';
		$where	=	$where?$where:'1'; 
		$list	=	$this->field($field)->where($where)->select();
		return $list;
	}
	
	/**
	 * 更新相对应的缓存内容
	 *
	 * @param int $id
	 * @return array
	 */
	public function addCache($id){
		$Dd		= $this->getInfo($id); 
		if (!is_array($Dd)){ return false; }  
		///获取关联表信息
		$rs			= $this->getDDTableInfo($Dd); 
		$dd_name	= 	empty($dd_name)?$Dd['dd_name']:$dd_name;   
		///压入内存
		$this->insert($dd_name,$rs);
	}
	
	/**
	 * 获取ID对应的数组
	 *
	 * @param int $id
	 * @return array
	 */
	public function getCache($id){
		$Dd		= $this->getInfo($id); 
		if (is_array($Dd)){
			$dd_name	= 	empty($dd_name)?$Dd['dd_name']:$dd_name;   
			$array		=	S($dd_name);
		} 
		return $array;
	}
	
	/**
	 * 获取DD关联表信息
	 *
	 * @param array Dd
	 * @return array
	 */
	public function getDDTableInfo(&$Dd){
		///dd_key 类似ID
		$dd_key 	=	$Dd['dd_key'];
		///模板
		$model		=	D($Dd['dd_table']); 
		$list		=	$model->field($dd_key.','.$Dd['dd_value'])->where($Dd['dd_where'])->order($dd_key)->select();
		///多维数组  
		foreach ((array)$list as $k=>$row) {  
				$pk			=	 $row[$dd_key]; 
				$rs[$pk]	=	$row; 
				unset($rs[$pk][$dd_key]);///去ID
		}
		return $rs; 
	}
	
	/**
	 * 压入内存
	 *
	 * @param string $name
	 * @param array $rs
	 */
	public function insert($dd_name,$rs){
		///判断数组是否存在
		if (is_array($rs) && !empty($dd_name)) {  
			///字典名称 
			S($dd_name,$rs);  
			unset($rs);
		} 
	}
	 
	
}