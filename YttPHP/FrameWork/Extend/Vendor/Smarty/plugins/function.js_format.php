<?php

/**
 * 系统全局JS变量
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    扩展
 * @package   Smarty
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

function smarty_function_js_format(){
	$digital_format		= C('DIGITAL_FORMAT');
	$js_date_fmt 		= $digital_format=='eur' ? 'dd/MM/yy' : 'yyyy-MM-dd'; 
	$price_length		= C('PRICE_LENGTH');
	$money_length		= C('MONEY_LENGTH');
	$int_length			= 0;
	$cube_length		= C('CUBE_LENGTH');
	$show_date_right	= (IS_ADMIN || SUPER_ADMIN)? 0 : C('SHOW_DATA_RIGHT');
	$output		 = '<script type="text/javascript">';
	$output		.= 'var dateFmt="'.$js_date_fmt.'";';
	$output		.= 'var digital_format="'.$digital_format.'";';
	$output		.= 'var price_length="'.$price_length.'";';
	$output		.= 'var money_length="'.$money_length.'";';
	$output		.= 'var cube_length="'.$cube_length.'";';
	$output		.= 'var int_length="'.$int_length.'";';
	$output		.= 'var show_data_right="'.$show_date_right.'";';
	$output		.= '</script>';
	return $output;
}