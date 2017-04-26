<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:51:16
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/outStockDetail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:193617866858f6c294382d60-06053958%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0df1abca5fd38d49f67eb651149d46bdc98935db' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/outStockDetail.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193617866858f6c294382d60-06053958',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'verifyType' => 0,
    'rs' => 0,
    'flow' => 0,
    'action' => 0,
    'lang' => 0,
    'index' => 0,
    'none' => 0,
    'addClass' => 0,
    'item' => 0,
    'deal_state' => 0,
    'readonly' => 0,
    'detail_state' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6c29448343',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6c29448343')) {function content_58f6c29448343($_smarty_tpl) {?><?php if (!is_callable('smarty_block_detail_table')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/block.detail_table.php';
?><?php $_smarty_tpl->tpl_vars["action"] = new Smarty_variable(array('edit'), null, 0);?>
<?php $_smarty_tpl->tpl_vars["deal_state"] = new Smarty_variable(array('sale_order_state'=>C('SALE_ORDER_OUT_DETAIL_VIEW_STATE')), null, 0);?>
<?php $_smarty_tpl->tpl_vars["detail_state"] = new Smarty_variable(array('state'=>array(4)), null, 0);?> 

<?php if ($_smarty_tpl->tpl_vars['verifyType']->value=='1'){?>
<?php $_smarty_tpl->tpl_vars["flow"] = new Smarty_variable('verify', null, 0);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars["flow"] = new Smarty_variable('sale', null, 0);?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['rs']->value['out_stock_type']>1){?>
<?php $_smarty_tpl->tpl_vars["addClass"] = new Smarty_variable('tr_background-color-out_stock', null, 0);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars["addClass"] = new Smarty_variable('', null, 0);?>
<?php }?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('detail_table', array('tfoot'=>false,'flow'=>$_smarty_tpl->tpl_vars['flow']->value,'from'=>$_smarty_tpl->tpl_vars['rs']->value['detail'],'action'=>array('view'),'op_show'=>$_smarty_tpl->tpl_vars['action']->value,'barcode'=>true,'thead'=>array($_smarty_tpl->tpl_vars['lang']->value['product_id'],$_smarty_tpl->tpl_vars['lang']->value['product_no'],$_smarty_tpl->tpl_vars['lang']->value['custom_barcode'],$_smarty_tpl->tpl_vars['lang']->value['product_name'],$_smarty_tpl->tpl_vars['lang']->value['sale_quantity'],$_smarty_tpl->tpl_vars['lang']->value['number_of_scans'],'verify_quantity'))); $_block_repeat=true; echo smarty_block_detail_table(array('tfoot'=>false,'flow'=>$_smarty_tpl->tpl_vars['flow']->value,'from'=>$_smarty_tpl->tpl_vars['rs']->value['detail'],'action'=>array('view'),'op_show'=>$_smarty_tpl->tpl_vars['action']->value,'barcode'=>true,'thead'=>array($_smarty_tpl->tpl_vars['lang']->value['product_id'],$_smarty_tpl->tpl_vars['lang']->value['product_no'],$_smarty_tpl->tpl_vars['lang']->value['custom_barcode'],$_smarty_tpl->tpl_vars['lang']->value['product_name'],$_smarty_tpl->tpl_vars['lang']->value['sale_quantity'],$_smarty_tpl->tpl_vars['lang']->value['number_of_scans'],'verify_quantity')), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>


	<tr index="<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
" class="<?php echo $_smarty_tpl->tpl_vars['none']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['addClass']->value;?>
" >
		<input type="hidden" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][id]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"> 
		<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('view'=>"product_id",'width'=>"120",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('view'=>"product_id",'width'=>"120",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		<?php echo $_smarty_tpl->tpl_vars['item']->value['product_id'];?>

		<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('view'=>"product_id",'width'=>"120",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


		<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'id'=>"span_product",'view'=>"product_no",'width'=>"320",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'id'=>"span_product",'view'=>"product_no",'width'=>"320",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

			<input type="hidden" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][product_id]" id="product_id" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['product_id'];?>
" jqproc class="w320">
			<input type="text" name="temp[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][product_no]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['product_no'];?>
" class="w320" <?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
>
		<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'id'=>"span_product",'view'=>"product_no",'width'=>"320",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

		<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('id'=>"span_custom_barcode",'view'=>"product_name",'width'=>"320",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('id'=>"span_custom_barcode",'view'=>"product_name",'width'=>"320",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		<?php echo $_smarty_tpl->tpl_vars['item']->value['custom_barcode'];?>

		<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('id'=>"span_custom_barcode",'view'=>"product_name",'width'=>"320",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

		<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('id'=>"span_product_name",'view'=>"product_name",'width'=>"320",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('id'=>"span_product_name",'view'=>"product_name",'width'=>"320",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		<?php echo $_smarty_tpl->tpl_vars['item']->value['product_name'];?>

		<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('id'=>"span_product_name",'view'=>"product_name",'width'=>"320",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


		<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'type'=>"flow_quantity",'view'=>"dml_quantity",'width'=>"100",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'type'=>"flow_quantity",'view'=>"dml_quantity",'width'=>"100",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

			<input type="text" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][quantity]" class="w80" id="quantity" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['edml_quantity'];?>
" <?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
>
		<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'type'=>"flow_quantity",'view'=>"dml_quantity",'width'=>"100",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


		<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('viewstate'=>$_smarty_tpl->tpl_vars['detail_state']->value,'type'=>"flow_real_quantity",'view'=>"dml_real_quantity",'width'=>"250",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['detail_state']->value,'type'=>"flow_real_quantity",'view'=>"dml_real_quantity",'width'=>"250",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

			<input type="text" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][real_quantity]" class="w80" id="real_quantity" value="<?php if ($_smarty_tpl->tpl_vars['item']->value['dml_real_quantity']>0){?><?php echo $_smarty_tpl->tpl_vars['item']->value['edml_real_quantity'];?>
<?php }?>" <?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
>
		<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['detail_state']->value,'type'=>"flow_real_quantity",'view'=>"dml_real_quantity",'width'=>"250",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

		
		<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('type'=>"verify_quantity",'id'=>"span_verify_quantity",'view'=>"verify_quantity",'width'=>"250",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('type'=>"verify_quantity",'id'=>"span_verify_quantity",'view'=>"verify_quantity",'width'=>"250",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

			<input type="text" class="w80" id="verify_quantity" value="" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][verify_quantity]">
		<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('type'=>"verify_quantity",'id'=>"span_verify_quantity",'view'=>"verify_quantity",'width'=>"250",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	</tr>

<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_detail_table(array('tfoot'=>false,'flow'=>$_smarty_tpl->tpl_vars['flow']->value,'from'=>$_smarty_tpl->tpl_vars['rs']->value['detail'],'action'=>array('view'),'op_show'=>$_smarty_tpl->tpl_vars['action']->value,'barcode'=>true,'thead'=>array($_smarty_tpl->tpl_vars['lang']->value['product_id'],$_smarty_tpl->tpl_vars['lang']->value['product_no'],$_smarty_tpl->tpl_vars['lang']->value['custom_barcode'],$_smarty_tpl->tpl_vars['lang']->value['product_name'],$_smarty_tpl->tpl_vars['lang']->value['sale_quantity'],$_smarty_tpl->tpl_vars['lang']->value['number_of_scans'],'verify_quantity')), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>