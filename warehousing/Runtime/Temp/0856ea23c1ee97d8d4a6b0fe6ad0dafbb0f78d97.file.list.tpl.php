<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:38:18
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Picking/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:202091511058f6bf8acb0b68-07569784%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0856ea23c1ee97d8d4a6b0fe6ad0dafbb0f78d97' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/Picking/list.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '202091511058f6bf8acb0b68-07569784',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bf8ad27a0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bf8ad27a0')) {function content_58f6bf8ad27a0($_smarty_tpl) {?><?php if (!is_callable('smarty_function_ytt_table')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.ytt_table.php';
?><?php echo smarty_function_ytt_table(array('show'=>array(array("value"=>"file_list_no","title"=>$_smarty_tpl->tpl_vars['lang']->value['picking_no'],"link"=>array("file_url"=>'file_url')),array("value"=>"sale_order_list","title"=>$_smarty_tpl->tpl_vars['lang']->value['deal_no'],'td'=>array('class'=>'t_center'),"show"=>false),array("value"=>"relation_no","title"=>$_smarty_tpl->tpl_vars['lang']->value['picking_import_no'],'td'=>array('class'=>'t_center')),array("value"=>"w_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['warehouse_name']),array("value"=>"fmd_create_time","title"=>$_smarty_tpl->tpl_vars['lang']->value['doc_date']),array("value"=>"add_real_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['doc_staff']),array("value"=>"dml_product_count","title"=>$_smarty_tpl->tpl_vars['lang']->value['product_count']),array("value"=>"dml_quantity","title"=>$_smarty_tpl->tpl_vars['lang']->value['product_sum_quantity']),array("value"=>"edit_comments","title"=>$_smarty_tpl->tpl_vars['lang']->value['comments'])),'listType'=>'flow','from'=>$_smarty_tpl->tpl_vars['list']->value['list']),$_smarty_tpl);?>
<?php }} ?>