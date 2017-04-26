<?php

/**
 * 上传附件
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class GalleryPublicModel extends Model {
	protected $tableName = 'gallery';
	/**
	 * 根据tocken值，更新图片关联信息
	 * @param int $relation_id
	 * @param string $tocken
	 * @return bool
	 */
	function update($relation_id,$tocken,$where=''){
		$sql = 'update __TABLE__ set relation_id='.$relation_id.',tocken=\'\' where tocken=\''.$tocken.'\''.$where;
		return $this->execute($sql);
	}
	
	/**
	 * 获取图片信息数组
	 * @param int $relation_id
	 * @param string $relation_type
	 * @return array
	 */
	function getAry($relation_id,$relation_type, $quantity = 0){
		$where	= array(
					'relation_type'	=> $relation_type,
					'relation_id'	=> $relation_id,
				);
		if ($quantity > 0) {
			if ($quantity == 1) {
				return $this->where($where)->find();
			} else {
				return $this->where($where)->limit($quantity)->select();
			}
		}
		return $this->where($where)->select();
	}
	
}