<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:38:33
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:65226729458f6bf994c5b39-14189983%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '47c865dea7d337361fb75e26ac307fe1f9606cbb' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/list.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65226729458f6bf994c5b39-14189983',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'login_user' => 0,
    'list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bf995ed1a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bf995ed1a')) {function content_58f6bf995ed1a($_smarty_tpl) {?><?php if (!is_callable('smarty_function_ytt_table')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.ytt_table.php';
?><?php echo smarty_function_ytt_table(array('tr_attr'=>array('class'=>array("out_stock_type"=>array("3"=>"tr_background-color","2"=>"tr_background-color"),"sale_order_state"=>array("13"=>"tr_background-color-deleted"),"is_background"=>array("1"=>"tr_background-color_ffd1a4"))),'show'=>array(array("value"=>"sale_order_no","title"=>$_smarty_tpl->tpl_vars['lang']->value['deal_no'],"link"=>array("url"=>"SaleOrder/view","link_id"=>"id"),"class"=>array("sale_order_state"=>array(1=>"red","2"=>"green")),"width"=>"10%"),array("value"=>"order_no","title"=>$_smarty_tpl->tpl_vars['lang']->value['orderno'],"link"=>array("url"=>"SaleOrder/view","link_id"=>"id"),"font_class"=>array("order_state"=>array(2=>"red","1"=>"green")),"editCell"=>array("link_id"=>"id"),"width"=>"15%"),array("value"=>"factory_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['belongs_seller'],'show'=>$_smarty_tpl->tpl_vars['login_user']->value['role_type']!=C('SELLER_ROLE_TYPE'),"link"=>array('url'=>'Factory/view',"link_id"=>array('id'=>'factory_id')),"width"=>"5%"),array("value"=>"client_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['clientname'],"width"=>"5%"),array("value"=>"country_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['belongs_country'],"width"=>"5%"),array("value"=>"fmd_order_date","title"=>$_smarty_tpl->tpl_vars['lang']->value['sale_date'],"width"=>"5%"),array("value"=>"fmd_go_date","title"=>$_smarty_tpl->tpl_vars['lang']->value['out_stock_date'],"width"=>"5%"),array("value"=>"order_type_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['order_type'],"width"=>"5%"),array("value"=>"dd_sale_order_state","title"=>$_smarty_tpl->tpl_vars['lang']->value['sale_order_state'],"width"=>"5%",'span'=>array('onclick'=>"$".".autoShow(this,'SaleOrder','state_log')"),'hidden'=>array(array('name'=>'sale_order_id','id'=>'sale_order_id','value'=>'id'),array('name'=>'factory_id','id'=>'factory_id','value'=>'factory_id'),array('name'=>'merge_address','id'=>'merge_address','value'=>'merge_address'),array('name'=>'post_code','id'=>'post_code','value'=>'post_code'),array('name'=>'object_id','id'=>'object_id','value'=>'id'))),array("value"=>"product_detail_info","title"=>$_smarty_tpl->tpl_vars['lang']->value['simple_product_info'],'type'=>'simple_product_info',"width"=>"20%"),array("value"=>"dml_weight","title"=>$_smarty_tpl->tpl_vars['lang']->value['sale_order_weight'],"width"=>"8%"),array("value"=>"ship_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['express_way'],"width"=>"5%"),array("value"=>"dml_delivery_fee","title"=>$_smarty_tpl->tpl_vars['lang']->value['delivery_costs'],'show'=>!in_array($_smarty_tpl->tpl_vars['login_user']->value['role_id'],explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID'))),"width"=>"5%"),array("value"=>"dml_process_fee","title"=>$_smarty_tpl->tpl_vars['lang']->value['process_fee'],'show'=>!in_array($_smarty_tpl->tpl_vars['login_user']->value['role_id'],explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID'))),"width"=>"5%"),array("value"=>"dml_package_fee","title"=>$_smarty_tpl->tpl_vars['lang']->value['package_fee'],'show'=>!in_array($_smarty_tpl->tpl_vars['login_user']->value['role_id'],explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID'))),"width"=>"5%"),array("value"=>"w_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['shipping_warehouse'],"width"=>"5%"),array("value"=>"track_no","title"=>$_smarty_tpl->tpl_vars['lang']->value['track_no'],"width"=>"10%")),'listType'=>'flow','flow'=>"sale",'from'=>$_smarty_tpl->tpl_vars['list']->value['list'],'addTab'=>true,'expand_operate_show'=>array(array("role"=>'deleteShipmentDD','class'=>'icon icon-list-hand','onclick'=>'$.cancel(this)','show_field'=>'express_api_delete'))),$_smarty_tpl);?>
<?php }} ?>