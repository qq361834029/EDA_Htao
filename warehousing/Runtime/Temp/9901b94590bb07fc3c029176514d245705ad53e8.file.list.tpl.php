<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:49:53
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/ComplexOrder/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:156108320458f6c2411e3049-33030374%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9901b94590bb07fc3c029176514d245705ad53e8' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/ComplexOrder/list.tpl',
      1 => 1492482591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '156108320458f6c2411e3049-33030374',
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
  'unifunc' => 'content_58f6c24123c27',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6c24123c27')) {function content_58f6c24123c27($_smarty_tpl) {?><?php if (!is_callable('smarty_function_ytt_table')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.ytt_table.php';
?><?php echo smarty_function_ytt_table(array('show'=>array(array("value"=>"sale_order_no","title"=>$_smarty_tpl->tpl_vars['lang']->value['deal_no'],"link"=>array("url"=>"ComplexOrder/view","link_id"=>"id"),"font_class"=>array("order_state"=>array(2=>"red","1"=>"green"))),array("value"=>"order_no","title"=>$_smarty_tpl->tpl_vars['lang']->value['orderno'],"link"=>array("url"=>"ComplexOrder/view","link_id"=>"id"),"font_class"=>array("order_state"=>array(2=>"red","1"=>"green"))),array("value"=>"w_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['warehouse_name']),array("value"=>"product_detail_info","title"=>$_smarty_tpl->tpl_vars['lang']->value['outstock_product_detail_info']),array("value"=>"ship_name","title"=>$_smarty_tpl->tpl_vars['lang']->value['express_way'])),'listType'=>'flow','flow'=>"sale",'from'=>$_smarty_tpl->tpl_vars['list']->value['list']),$_smarty_tpl);?>
<?php }} ?>