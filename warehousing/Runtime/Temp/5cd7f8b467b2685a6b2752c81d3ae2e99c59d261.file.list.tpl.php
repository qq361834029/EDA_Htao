<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:38:20
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/PickingImport/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:40783392758f6bf8cea9d87-96857792%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5cd7f8b467b2685a6b2752c81d3ae2e99c59d261' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/PickingImport/list.tpl',
      1 => 1492482589,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40783392758f6bf8cea9d87-96857792',
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
  'unifunc' => 'content_58f6bf8cf26a9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bf8cf26a9')) {function content_58f6bf8cf26a9($_smarty_tpl) {?><?php if (!is_callable('smarty_function_ytt_table')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.ytt_table.php';
?><?php echo smarty_function_ytt_table(array('show'=>array(array("value"=>"file_list_no","title"=>$_smarty_tpl->tpl_vars['lang']->value['picking_import_no'],"link"=>array("file_url"=>'file_url')),array("value"=>"sale_order_list","title"=>$_smarty_tpl->tpl_vars['lang']->value['deal_no'],'td'=>array('class'=>'t_center'),"show"=>false),array("value"=>"relation_no","title"=>$_smarty_tpl->tpl_vars['lang']->value['picking_no'],'td'=>array('class'=>'t_center')),array("value"=>"w_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['warehouse_name']),array("value"=>"fmd_create_time","title"=>$_smarty_tpl->tpl_vars['lang']->value['doc_date']),array("value"=>"add_real_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['doc_staff']),array("value"=>"dml_product_count","title"=>$_smarty_tpl->tpl_vars['lang']->value['product_count']),array("value"=>"dml_quantity","title"=>$_smarty_tpl->tpl_vars['lang']->value['product_sum_quantity']),array("value"=>"dml_product_error_count","title"=>$_smarty_tpl->tpl_vars['lang']->value['product_error_count']),array("value"=>"dml_error_quantity","title"=>$_smarty_tpl->tpl_vars['lang']->value['error_quantity']),array("value"=>"edit_comments","title"=>$_smarty_tpl->tpl_vars['lang']->value['comments']),array("value"=>"dml_undeal_quantity","title"=>$_smarty_tpl->tpl_vars['lang']->value['undeal_quantity'],"autoshow"=>array("module"=>"UndealQuantity","field"=>"id"),"font_class"=>array("can_backShelves"=>array("0"=>'',"1"=>"font_red")))),'listType'=>'flow','from'=>$_smarty_tpl->tpl_vars['list']->value['list']),$_smarty_tpl);?>
<?php }} ?>