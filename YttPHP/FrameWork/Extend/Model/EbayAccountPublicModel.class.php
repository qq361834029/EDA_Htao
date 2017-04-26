<?php

/**
 * Ebay账号信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */
class EbayAccountPublicModel extends RelationCommonModel {
	public    $_asc 	 = true;  	        //默认排序
	public    $_sortBy 	 = 'user_id';       //默认排序字段
	protected $tableName = 'ebay_site';

	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'ebay_site_id',
										'class_name'	=> 'ebay_country',
									),
								);
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("user_id",'is_accounts',"is_accounts",1), 	//账号
		array("user_id",'',"unique",1,'unique'),//验证唯一
		array("country_range",'require',"require",0),  //所属卖家 
		array("factory_id",'require',"require",0),  //所属卖家 
		array("site_id",'require',"require",1),     //名称 
	);

	///EBAY国家明细验证
	protected $_validDetail	 =	 array(
			array("ebay_site_id",'require','require',1),
			array("abbr_district_name",'require','require',1),
	);

	/// 查看
	public function view(){   
		return _formatArray($this->getInfo($this->id));
	}
	
	public function getInfo($id){
		$where	= 'id=' . (int)$id . getBelongsWhere();
		$rs		= $this->where($where)->find();
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
		$detail = M('ebay_country');
		$rs['detail'] = $detail->where('ebay_site_id='.$id)->getField('country_id',true);
		$country		= S('country');
		foreach($rs['detail'] as $value) {
			$country_info	= $country[$value];
			$rs['country_name'][]	= $country_info['full_country_name'];
		}
		$rs['country_id']	= implode(',',$rs['detail']);
		$rs['country_name']	= ACTION_NAME=='view' ? implode('<br />',$rs['country_name']) : implode(';',$rs['country_name']);
		if(is_array($rs)&&$rs){
			$cache_site			   = S('SiteDetails');
			$rs['site']			   = $cache_site[$rs['site_id']];
			$rs['token_status']    = $rs['token_status']==0?L('no_auth'):($rs['token_status']==1?L('yes_auth'):L('fail_auth'));
		}
		return $rs;
	}

	//重组明细
	public function setPost($info){
		if (empty($info))	$info =	$_POST;
		if($info['site_id']){
			//获取链接
			$cache_URLDetails	   = S('URLDetails'.$info['site_id']);
			//查询地址
			$info['site_domain']  = $cache_URLDetails['ViewItemURL'];
			//评价地址
			$info['feedback_url'] = $cache_URLDetails['ViewUserURL'];
		}
		$contrast = $insert = array();
		if (ACTION_NAME == 'update'  && $info['country_range'] == 2) {
			$id_array		= array();
			$express_detail = M('ebay_country');
			$detail	        = $express_detail->where('ebay_site_id='.$info['id'])->select(); 
			foreach((array)$detail as $k => $v){
				$contrast[$v['country_id']]	= $v['id'];
			}
		}
		///只有抓取范围设置为选择国家时才处理
		if (ACTION_NAME != 'delete' && $info['country_range'] == 2) {
			$country		= S('country');
			foreach ((array)$info['detail'] as $value) {
				$countrys = explode(',', $value['country_id']);
				foreach($countrys as $country_id){
					$value['id']         = '';
					if (ACTION_NAME == 'update') {
						if(array_key_exists($country_id, $contrast)){
							$value['id'] = $contrast[$value['country_id']];
						}
					}
					$value['abbr_district_name'] = $country[$country_id]['abbr_district_name'];
					$value['country_id'] = $country_id;
					$insert['detail'][]  = $value;  
				}
			}
			$info['detail'] = $insert['detail'];
		}else{
			$info['detail'] = array();
		}
		return $info;
	}
}