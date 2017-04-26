<?php 
/**
 * 包装管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	包装信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2014/1/15 16:11:23
 */

class PackagePublicModel extends RelationModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'package';
	public $_asc 		 = true;  	        //默认排序
	public $_sortBy		 = 'package_name';
	/// 自动验证设置
	protected $_validate = array(
		array("package_name",'require',"require",1),
        array("warehouse_id",'require',"require",1),
		array("package_name",'repeat',"repeat",1,'unique'),//验证唯一  
		array("cube_long",'double',"double",2), 	
		array("cube_wide",'double',"double",2), 	
		array("cube_high",'double',"double",2), 
		array("weight",'double',"double",2),	
		array("price",'double',"double",2),	
	);	
	
	public function getInfo($id){
		$model				= M('Package');
		$vo					= _formatList($model->field('p.id,p.package_name,p.cube_high,p.cube_wide,p.cube_long,p.cube_high*cube_wide*cube_long as cube,p.weight,p.price,p.comments,p.to_hide,p.lock_version,p.warehouse_id,w.currency_id')->join('p left join warehouse w on p.warehouse_id=w.id')->where('p.id='.$id)->select());
		$data				= $vo['list'][0];
		$data['is_update']	= getUser('role_type')==C('SELLER_ROLE_TYPE') ? 0:1;
        return $data;
	}
}