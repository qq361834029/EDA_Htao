<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<noscript><meta  http-equiv="refresh"  content="0;url=about:noscript"></noscript>
<title>『友拓通』</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/style.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/menu.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/jquery.ui.css" />
{js_format}
<script type="text/javascript" src="__PUBLIC__/Js/lang_cn.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.form.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.ui.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.fn.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.toolbar.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/app.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/autoShow.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/lodopFuncs.js"></script>
<script language="JavaScript">
var URL 	= '__URL__';
var APP	 	= '__APP__';
var URL_U	= '{'/Ajax/u'|U}';
var PUBLIC = '__PUBLIC__'; 
var APP_FILES="{$smarty.const.UPLOADS_PATH}";
var tab_label = "88888";
</script>
<object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="install_lodop32.exe"></embed>
</object> 
</head>
<body>
<div id="s_loading" class="save_load"></div>;
<div id="loader" class="none">页面加载中...</div>
<div id='tips' class="save_succeed"></div>
<div id='s_success' class="data_load"></div>
<div id="autoShowDiv" style="display:none;"></div> 
{literal}
<script type="text/javascript">
var $tabs;
var $index;
var $dom;
var $tab_id;
var $href;
$(function(){
	$tabs = $( "#tabs").tabs({
		tabTemplate: "<li><a href='#{href}/newtab/1'>#{label}</a> <span class='ui-icon ui-icon-close'>Remove Tab</span></li>",
		add: function( event, ui ) {
			var height = $(window).height()-110; 
			$("#"+ui.panel.id).css("height",height+"px").attr("href",$href);
			try{
				if(typeof(eval("setEpassInfo"))=="function"){
					var access = setEpassInfo();
				}
				if(access==false) 
					$tabs.tabs("remove",ui.index);
				else 
					$tabs.tabs('select', ui.index);
			}catch(e){
				$tabs.tabs('select', ui.index);
			}
		},
		cache : true,
		select: function(event, ui) {
			$index = ui.index;
			$dom = $(ui.panel);
			$tab_id = ui.panel.id;
		},
		load:function(event, ui){
			$dom.find('#search_form').find('input[jqac]').attr('search',1);
			$dom.find("input[jqac]").each(function(){$(this).initAutocomplete();});
			$dom.find("select[combobox]").each(function(){$(this).combobox();});
			$dom.find("form[id!='search_form']").sendForm();
			$dom.find('.detail_list').bandTotalMethod();//明细表绑定合计事件
			$dom.find('.detail_list').bandProductMethod();//明细表绑定合计事件
			$dom.find("#search_form").submit(function() { 
		        $(this).ajaxSubmit({beforeSubmit:function(){$dom.find("#_page_qtp").remove();},target: $dom.find("#print"),success:searchSuccess}); 
		        return false;
		    });
		    $dom.find("input").attr("autocomplete","off");
		    $dom.find('input[type=file]').each(function(){
		    	$(this).UploadFile();
		    });
		}
	});
	$(document).on( "click","#tabs span.ui-icon-close", function() {
		var index = $( "li", $tabs ).index( $( this ).parent() );
		$tabs.tabs( "remove", index );
	});
	$(".menu a").each(function(){
		var url = $(this).attr("url");
		var title = $(this).attr("title");
		if(url){
			$(this).bind("click",function(){addTab(url,title)});
		}
	});
	$("#autoShowDiv").dialog({
		autoOpen: false,
		width:750,
		height:500,
		show: "blind"
	});

})
function loadTab(){
	$tabs.tabs("load",$index);
}
function addTab(href,title) {
	$href = href;
	$tabs.tabs("add", href, title);
}
function linkTab(href,title,close){
	var index = $tabs.tabs('option', 'selected');
	if(close){
		$tabs.tabs("remove",index);
		addTab(href,title);
	}else{
		$tabs.tabs("url",index ,href);
		$tabs.tabs("load",index);
	}
}
$(document).ready(function(){ 
	$("#toolbar_remind").remind();
	$.initToolBar();
	
	$('#footpanel').css('width','450px');
	$('.menu_nav').css('width','310px');
	$('.user').css('padding-right',0);
	$(document).find("tr").on('click',".list",function(){
		if(!$(this).attr("expandTr")) $(this).toggleClass("selected_tr")
	});
})
function closeTab(){
	var index = $tabs.tabs('option', 'selected');
	$tabs.tabs( "remove",index);
}
// 设为首页
function setIndex(){
	var href = $("#"+$tab_id).attr("href");
	$.post(APP+"/Ajax/setIndex",{url:href}, function (){
		alert(lang['common']['sextindexsucc']);
	});
}
</script>
{/literal}
{if $login_user.use_usbkey>0}
<script type="text/javascript">
function setEpassInfo(){
	var url = "{'Public/checkEpass'|U}";
	return checkEpass(url);
}
</script>
{/if}
<script type="text/javascript">
$(document).ready(function(){ 
//	$.resetShortcutMenu();	

	$(document).on("keypress",'input[jqbarcode]',function(event){
		if(event.which==13) {
			$.addRowByBarcode(this);
			$(this).val('').focus();   
			event.stopPropagation(); 
			return false;
		}
	});
//	$(document).keydown(function(event){
//		var langSet	= "{$smarty.const.LANG_SET}";
//		$.langTab(event,langSet);
//	})
});

</script>