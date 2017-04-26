<?php
/**
 * 系统全局Css变量
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category    扩展
 * @package   Smarty
 * @author    jph
 * @version  2.1,2013-12-18
 */

function smarty_function_css_system(){
    $css_path   = '/Public/Css/system.css';
    $css_file = dirname($_SERVER["SCRIPT_FILENAME"]).$css_path;
    if(file_exists($css_file))  {
		$output		= '<link rel="stylesheet" type="text/css" href="'.__APP_ROOT__.$css_path.'" />';
    }
    //mod by ljw 20150728-start
    //当语言为意大利文时加载对应样式文件
	$css_path	= 'Css/' . LANG_SET . '_style.css';
	$css_file = THINK_PATH.'../Public/'.$css_path;
    if(file_exists($css_file))  {
		$output		.= '<link rel="stylesheet" type="text/css" href="'.PUBLIC_PATH.$css_path.'" />';
    }
    //mod by ljw 20150728-end
    return $output;
}