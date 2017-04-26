<?php

/**
 * 上传附件
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Behavior
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class GalleryPublicBehavior extends Behavior {
	
	public function run(&$params){
		if(ACTION_NAME=='insert'){
			$id	= $params['id'];
			D('Gallery')->update($id,$params['tocken']);//更新产品图片关联信息
		}
	}
}