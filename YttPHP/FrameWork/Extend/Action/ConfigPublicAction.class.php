<?php

/**
 * 项目配置
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	项目配置
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class ConfigPublicAction extends Action {
    /// 项目配置首页
    public function index(){
        if ($_POST) {
            $model = D('Admin');
            if (false === $model->create($_POST)) {  
                $this->error( $model->getError(),2);
            } 
            $data	= $this->resetGlsConfig();//gls_config
			$gls_config			= $_POST['gls'];
			unset($_POST['gls']);
            D('Admin')->saveConfig();
			D('Admin')->deleteGlsConfig($data['delete_gls_config']);
            $this->setGlsPackageInterval($gls_config, $data['max_package_array']);
            $this->success(L('_OPERATION_SUCCESS_'));
        }else{
            $warehouse  = M('warehouse')->where('to_hide=1 and is_use=1')->field('id,w_name')->select();
            $gls_config = array();
            foreach ($warehouse as $v){
                $w_id   = $v['id'];
                if(C('gls_w_id_'.$w_id)>0){
					$gls_config[$w_id]	= $this->getGlsConfig($w_id);
					$gls_config[$w_id]['w_name']	= $v['w_name'];
                }
            }
            if(empty($gls_config)){
                $gls_config[0] = $this->getGlsConfig();
            }
            $this->assign('gls_config',$gls_config);
        }
        $this->display();
    }
    public function resetGlsConfig(){
		$warehouse  = M('warehouse')->where('to_hide=1 and is_use=1')->getField('id,w_name');
        foreach ($_POST['gls'] as $k=>$config){
            $w_id   = $config['w_id'];
            if(empty($w_id)){
				unset($_POST['gls'][$k]);
                continue;
            }
			//验证最大追踪单号st
			$gls_max_package_no	= S('GLS_MAX_PACKAGE_NO_'.$w_id);
			if(empty($gls_max_package_no)){
                $gls_max_package_no	= M('SaleOrder')->where('warehouse_id='.$w_id.' and EXISTS(select 1 from express e where e.id=sale_order.express_id and e.company_id in('.implode(',',C('GLS_API_EXPRESS_ID')).') )')->max('track_no');
				$gls_max_package_no	= floor($gls_max_package_no/10);
            }
            if($config['package_no_end']!=C('GLS_PACKAGE_NO_END_'.$w_id)){
                if ($gls_max_package_no && $gls_max_package_no>$config['package_no_end']-1){
                    $this->error('GLS('.$config['warehouse_name'].')已用最大追踪单号大于所设区间,请确认!');
                }
            }
			$max_package_array[$w_id]	= $gls_max_package_no;
			unset($config['warehouse_name'],$warehouse[$w_id]);
			//验证最大追踪单号ed
            foreach ($config as $key=>$val){
				if(!empty($val)){
					$_POST['gls_'.$key.'_'.$w_id]   = $val;
				}
            }
        }
		return array('max_package_array'=>$max_package_array, 'delete_gls_config'=>$warehouse);
    }
	public function setGlsPackageInterval($gls_config,$max_package_array){
		foreach ($gls_config as $config){
			$w_id   = $config['w_id'];
			$gls_max_package_no	= $max_package_array[$w_id];
			if($config['package_no_start']!=C('GLS_PACKAGE_NO_START_'.$w_id)){
                if($gls_max_package_no && $gls_max_package_no<$config['package_no_start']-1){
                    S('GLS_MAX_PACKAGE_NO_'.$w_id, $config['package_no_start']-1);
                }
            }
		}
	}
	public function getGlsConfig($w_id){
		$field	= array(
			'w_id', 'w_name', 'ip', 'port', 'user_account', 'receive_station_code',
			'contact_id', 'customer_id', 'shipper_name', 'shipper_name2', 'shipper_name3',
			'shipper_address', 'shipper_country_code', 'shipper_postcode', 'shipper_city', 'package_no_start', 'package_no_end',
		);
		foreach ($field as $value){
			$config[$value]	= ($w_id>0)?C('gls_'.$value.'_'.$w_id):'';
		}
		return $config;
	}
}