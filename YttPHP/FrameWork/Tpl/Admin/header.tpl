<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>『友拓通－管理平台』</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/admin.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/jquery.ui.css" />
{js_format}
<script type="text/javascript" src="__PUBLIC__/Js/lang_cn.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.form.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.ui.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.fn.js"></script>
<script language="JavaScript">
var URL = '__URL__';
var APP	 =	 '__APP__';
var PUBLIC = '__PUBLIC__';
var $tab_id = 'autocomplete_show';
var $dom = $(this);
$(document).ready(function(){
	$("input[jqac]").each(function(){ $(this).initAutocomplete();});
	$("select[combobox]").each(function(){ $(this).combobox();});
})
</script>
</head>
<body>
<div id="autocomplete_show"></div>
<!--<div id="loader" >页面加载中...</div>-->