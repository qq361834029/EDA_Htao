<?php

/**
* 产品详细信息
* @param array $params
* @see 函数 
* @param 
* - string flow 流程配置
* - string type 标签类型
* - string value 显示值
* - string url url地址
* - string title 标题
* - string module 模块
* @return string
*/

function smarty_function_stat_product($params){
	foreach($params as $key=>$val){
		switch ($key){
			case 'flow':
				$$key	= $val;break;
			case 'type':
				$$key	= $val;break;
			case 'value':
				$$key	= $val;break;
			case 'url':
				$$key	= $val;break;
			case 'title':
				$$key	= $val;break;
			case 'module':
				$$key	= $val;break;
			default:
				$extra	.= $key.'="'.$val.'"';break;
		}
	}
	switch($params['flow']){
		case 'color':
			if(!C('storage_color')){
				return ;
			}
			break;
		case 'size':
			if(!C('storage_size')){
				return ;
			}
			break;
		case 'storage_mantissa':
			if(!C('storage_mantissa')){
				return ;
			}
			break;
		case 'warehouse':
			if(C('multi_storage')==2){
				return ;
			}
			break;
		case 'storage_format':
		
			if(C($module.'.'.$params['flow'])==1){
				return ;
			}
			break;
		default:
			
			break;
	}
	if(!empty($url)){
		$value='<a href="javascript:;" onclick="addTab(\''.$url.'\',\''.$title.'\')">'.$value.'</a>';
	}
	$str	= '<'.$type.' '.$extra.'>'.$value.'</'.$type.'>';
	return $str;
}