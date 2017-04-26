<?php

/**
 * 系统全局JS变量
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category    扩展
 * @package   Smarty
 * @author    何剑波
 * @version  2.1,2013-07-22
 */

function smarty_function_js_system(){
	 $js_file = dirname($_SERVER["SCRIPT_FILENAME"]).'/Public/Js/system.js';
	 if(file_exists($js_file))  {
		$output		 = '<script type="text/javascript" src="'.__APP_ROOT__.'/Public/Js/system.js">';
		$output		.= '</script>';
		return $output;
	 }
}