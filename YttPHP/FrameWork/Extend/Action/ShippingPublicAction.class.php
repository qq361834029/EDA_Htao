<?php 

/**
 * 派送方式管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	派送管理
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-03-01
*/

class ShippingPublicAction extends RelationCommonAction {
	
	protected $_default_post	=  array('main'=>array('query'=>array('status'=>1)));  ///默认post值处理
	protected $_cacheDd 		= array(27);//对应dd表中的id 

	public function _initialize() {
		parent::_initialize(); 
		$userInfo	=	getUser(); 
		if ($userInfo['role_type']==C('SELLER_ROLE_TYPE')) {//卖家
			$_POST['main']['query']['status'] = 1;
			$this->assign("is_factory", true);
		}		
		//国家名称
		$attr_country  = S("country"); 
		foreach ($attr_country as $id => $val){
			$country[] = array('id' => $id, "name" => $val['abbr_district_name'].'-'.$val['district_name']);
		} 
		$country	   = json_encode($country);
		$this->assign("country", $country);
	}	

	public function _after_insert(){   
		$this->checkCacheDd();
		parent::_after_insert(); 
	}
	
	public function _after_update(){
		$this->checkCacheDd();
		parent::_after_update();
	} 	
	
	///列表
	public function index() { 
		if (!$_POST['search_form']) {
			$_POST	= array_merge($this->_default_post, $_POST);
		}		
		$this->_autoIndex(); 
	} 
    public function createExpressCountryTable(){
        M()->startTrans();
        set_time_limit(0);
		ini_set('memory_limit', '512M');
        $sql    = 'DROP TABLE IF EXISTS `express_country_tmp`;';
        M()->query($sql);
        //建零时表
        $sql    = ' CREATE TABLE IF NOT EXISTS `express_country_tmp` (
                    `id` int(10) unsigned NOT NULL auto_increment,
                    `express_id` int(10) unsigned NOT NULL,
                    `express_detail_id` int(10) unsigned NOT NULL,
                    `country_id` varchar(250) NOT NULL,
                    `express_detail_ids` varchar(250) NOT NULL,
                    PRIMARY KEY  (`id`)
                  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
                  ';
        //插入零时数据
        
        M()->query($sql);
        $sql    = 'INSERT INTO `express_country_tmp` (`express_id`,`express_detail_id`, `country_id`,`express_detail_ids`) (select express_id,min(id),group_concat(distinct `country_id`),group_concat(distinct `id`) from `express_detail` group by express_id,area);';
        //建派送方式国家表
        
        M()->query($sql);
        $sql    = 'DROP TABLE IF EXISTS `express_country`;';
        M()->query($sql);
        $sql    = ' CREATE TABLE IF NOT EXISTS `express_country` (
                    `id` int(10) unsigned NOT NULL auto_increment,
                    `express_id` int(10) unsigned NOT NULL,
                    `express_detail_id` int(10) unsigned NOT NULL,
                    `country_id` int(10) unsigned NOT NULL,
                    PRIMARY KEY  (`id`),
                    KEY `country_id` (country_id),
                    KEY `express_detail_id` (`express_detail_id`),
                    KEY `express_id` (`express_id`)
                  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
        M()->query($sql);
        //查询派送方式国家表数据
        $express_country    = M('express_country_tmp')->field('express_id,express_detail_id,country_id')->select();
        foreach($express_country as $value){
            $country_id_arr = explode(',', $value['country_id']);
            foreach ($country_id_arr as $c_id){
                $value['country_id']    = $c_id;
                $data[] = $value;
            }
        }
        //插入派送方式国家表数据
        M('express_country')->addAll($data);
        $sql    = 'UPDATE sale_order as s,express_country_tmp as ect set s.express_detail_id=ect.express_detail_id where find_in_set(s.express_detail_id ,ect.express_detail_ids)';
        M()->query($sql);
        //删除派送明细中重复的
        $sql    = 'DELETE  FROM `express_detail` WHERE id not in (select express_detail_id from express_country_tmp)';
        M()->query($sql);
        $sql    = 'DROP TABLE `express_country_tmp`';
        M()->query($sql);
        $sql    = 'ALTER TABLE `express_detail`
                    DROP `country_id`,
                    DROP `post_begin`,
                    DROP `post_end`';
        M()->query($sql);
        M()->commit();
        redirect(__APP__);
    }
}
?>