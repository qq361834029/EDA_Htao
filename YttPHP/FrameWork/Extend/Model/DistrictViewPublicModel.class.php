<?php

/**
 * 国家信息管理视图模型
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class DistrictViewPublicModel extends ViewModel {
	public  $viewFields  = array(
		'a' => array('id'=>'id','district_name' => 'a_name','abbr_district_name'=>'abbr_district_name','parent_id' => 'a_parent_id','to_hide' => 'to_hide', '_as' => 'a', '_type' => 'LEFT', '_table' => 'district','_main' => 1),
		'b' => array('district_name' => 'b_name', '_as' => 'b', '_type' => 'LEFT', '_on' => 'a.id = b.parent_id', '_table' => 'district'),  
	); 
}
