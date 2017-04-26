<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 05:06:19
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/noticeInfo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15478673258f6d42b627734-26845121%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e219c9bbc7ed30ede89580e7f9ee937f9b0898d4' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/noticeInfo.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15478673258f6d42b627734-26845121',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'express_api_tips' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6d42b6bc3f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6d42b6bc3f')) {function content_58f6d42b6bc3f($_smarty_tpl) {?><div class="add_box" style="text-align:center">
	<span class="tred"><?php echo L('no_sale_product_id');?>
</span>
	<?php if ($_smarty_tpl->tpl_vars['express_api_tips']->value){?>
		<div class="tred"><?php echo $_smarty_tpl->tpl_vars['express_api_tips']->value;?>
</div>
	<?php }?>
</div><?php }} ?>