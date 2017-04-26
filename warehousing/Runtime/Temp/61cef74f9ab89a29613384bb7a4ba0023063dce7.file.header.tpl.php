<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:30:45
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Public/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:191006978358f6bdc547f7b8-52986617%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '61cef74f9ab89a29613384bb7a4ba0023063dce7' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Public/header.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '191006978358f6bdc547f7b8-52986617',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'login_user' => 0,
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bdc55a215',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bdc55a215')) {function content_58f6bdc55a215($_smarty_tpl) {?><?php if (!is_callable('smarty_function_js_format')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.js_format.php';
if (!is_callable('smarty_function_js_system')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.js_system.php';
if (!is_callable('smarty_function_css_system')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.css_system.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<noscript><meta  http-equiv="refresh"  content="0;url=about:noscript"></noscript>
<title>『友拓通』</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/style.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/menu.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/jquery.ui.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Js/ScrollBar/jquery.mCustomScrollbar.css" />
<?php echo smarty_function_js_format(array(),$_smarty_tpl);?>

<script language="JavaScript">
var URL 	= '__URL__';
var APP	 	= '__APP__';
var PUBLIC = '__PUBLIC__';
var APP_FILES="<?php echo @UPLOADS_PATH;?>
";
var tab_label = "88888";
var langSet	= "<?php echo @LANG_SET;?>
";
</script>
<script type="text/javascript" src="__PUBLIC__/Js/lang_<?php echo @LANG_SET;?>
.js?v=2"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/common.js?v1383"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.form.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.ui.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.fn.js?v=3"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.toolbar.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/app.js?v=4"></script>
<script type="text/javascript" src="__PUBLIC__/Js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/autoShow.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/lodopFuncs.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/ZeroClipboard/ZeroClipboard.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/mulitselector.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/json2.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/ScrollBar/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/ScrollBar/jquery.mousewheel.min.js"></script>
<?php echo smarty_function_js_system(array(),$_smarty_tpl);?>

<?php echo smarty_function_css_system(array(),$_smarty_tpl);?>

<object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="install_lodop32.exe"></embed>
</object> 
</head>
<body>
<div id="s_loading" class="save_load"></div>
<div id="loader" class="none">页面加载中...</div>
<div id='tips' class="save_succeed"></div>
<div id='s_success' class="data_load"></div>
<div id="autoShowDiv" style="display:none;"></div> 
<div id="progressbar" class="progressbar"></div>
<script type="text/javascript">
<?php if ($_smarty_tpl->tpl_vars['login_user']->value['use_usbkey']>0){?>
function setEpassInfo(){
	var url = "<?php echo U('Public/checkEpass');?>
";
	return checkEpass(url);
}
<?php }else{ ?>
var setEpassInfo='';
<?php }?>

$(document).ready(function(){ 

	$(document).on("keypress",'#input_product_id',function(event){
		if(event.which==13) {
			verifyQuantity($(this).val());
			return false;
		}
	});

	$(document).on("keyup",'#verify_quantity',function(event){
		$v_val	       = $(this).val().replace(/\D/g,'');
		$(this).val($v_val);
		var $quantity  = $(this).parents('tr:first').find('#quantity');
		var $q_val     = $quantity.val();
		if($v_val>$q_val){
			$(this).val($q_val);
		}
		return false;	
	})
})

</script>

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
			var height = $(window).height()-146;
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
			if (langSet == 'de' || langSet == 'it' || langSet == 'es' || langSet == 'en' || langSet == 'fr') {
				$dom.find(".basic_tb").addClass('de_css');
				$dom.find(".search_left").addClass('de_css');
			}
			$dom.find("input[jqac]").each(function(){$(this).initAutocomplete();});
			$dom.find("select[combobox]").each(function(){$(this).combobox();});
			$dom.find("form[id!='search_form']").sendForm();
			var detail_list = $('.detail_list');
			if(detail_list){
				detail_list.bandCache();
				detail_list.bandTotalMethod();//明细表绑定合计事件
				detail_list.bandProductMethod();//明细表绑定合计事件
			}
			$dom.find('.list').tableClick();
			var search_form = $dom.find('#search_form');
			if(search_form){
				search_form.find('input[jqac]').attr('search',1);
				var validity_function = 'searchSuccess';
				if($(search_form).attr("validity") && $.isFunction(eval($(search_form).attr("validity")))){
					validity_function = $(search_form).attr("validity");
				}
                var options = {target: $dom.find("#print:first"),success:eval(validity_function)};				
                options['beforeSubmit'] = function(){
                            if(search_form.attr('beforeSubmit') && $.isFunction(eval(search_form.attr("beforeSubmit")))){//added by jp 20131025
                                var beforeSubmit	= eval(search_form.attr("beforeSubmit"));     
                                if (beforeSubmit && beforeSubmit(search_form.formToArray(), search_form, options) === false) {
                                    return false;
                                }                                
                            }
                            $dom.find("#_page_qtp").remove();
                            $.loading();
                        };
				search_form.submit(function() {
					$(this).ajaxSubmit(options);
					return false;
				 });
			 }
			$dom.find('input[type=file]').each(function(){
		    		$(this).UploadFile();
			});
			$("#tips").fadeOut(100);
			$.removeLoading();
		}
	});

	$(document).on("click","#tabs span.ui-icon-close", function() {
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
})
function closeTab(){
	var index = $tabs.tabs('option', 'selected');
	$tabs.tabs("remove",index);
}
// 设为首页
function setIndex(){
	var href = $("#"+$tab_id).attr("href");
	$.post(APP+"/Ajax/setIndex",{url:href}, function (){
		alert(lang['common']['sextindexsucc']);
	});
}
</script>

<script type="text/javascript">
$(document).ready(function(){ 
	$.resetShortcutMenu();	
	<?php if ($_smarty_tpl->tpl_vars['login_user']->value['index']){?>
	addTab('<?php echo $_smarty_tpl->tpl_vars['login_user']->value['index'];?>
',lang['common']['index']);
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['login_user']->value['guide']!=2&&C('show_guide')==1){?>
	addTab('<?php echo U("Guide/index");?>
', '<?php echo $_smarty_tpl->tpl_vars['lang']->value['title_wizard'];?>
',1);
	<?php }?>
	<?php if (C('barcode')==1){?>
	$(document).on("keypress",'input[jqbarcode]',function(event){
		if(event.which==13) {

            $.addQuantityByBarcode(this);
			$(this).val('').focus();   
			event.stopPropagation(); 
			return false;
		}
	});
	<?php }?>
	$(document).keydown(function(event){
		$.langTab(event,langSet);
	})
});
</script><?php }} ?>