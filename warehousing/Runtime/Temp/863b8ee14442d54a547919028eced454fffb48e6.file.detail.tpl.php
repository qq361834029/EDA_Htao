<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 05:15:28
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:50116722058f6d6502742c6-06133785%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '863b8ee14442d54a547919028eced454fffb48e6' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/SaleOrder/detail.tpl',
      1 => 1492482590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50116722058f6d6502742c6-06133785',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'login_user' => 0,
    'rs' => 0,
    'action' => 0,
    'lang' => 0,
    'index' => 0,
    'none' => 0,
    'item' => 0,
    'deal_state' => 0,
    'readonly' => 0,
    'splitPackage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6d65045869',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6d65045869')) {function content_58f6d65045869($_smarty_tpl) {?><?php if (!is_callable('smarty_block_detail_table')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/block.detail_table.php';
?><?php if ($_smarty_tpl->tpl_vars['login_user']->value['role_type']==C('SELLER_ROLE_TYPE')){?>
    <?php if (in_array($_smarty_tpl->tpl_vars['rs']->value['sale_order_state'],array(1,2))){?>
        <?php $_smarty_tpl->tpl_vars["action"] = new Smarty_variable(array('add','edit'), null, 0);?>
        <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars["action"] = new Smarty_variable(array('add'), null, 0);?>
    <?php }?>
<?php $_smarty_tpl->tpl_vars["deal_state"] = new Smarty_variable(array('sale_order_state'=>C('SALE_ORDER_DETAIL_VIEW_STATE_SELLER')), null, 0);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars["action"] = new Smarty_variable(array('add'), null, 0);?>
<?php $_smarty_tpl->tpl_vars["deal_state"] = new Smarty_variable(array('sale_order_state'=>C('SALE_ORDER_DETAIL_VIEW_STATE')), null, 0);?>
<?php }?>
<?php $_smarty_tpl->tpl_vars["splitPackage"] = new Smarty_variable(array('sale_order_state'=>C('SALE_ORDER_DETAIL_SPLIT_PACKAGE')), null, 0);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('detail_table', array('id'=>'detail_table','flow'=>'sale','from'=>$_smarty_tpl->tpl_vars['rs']->value['detail'],'action'=>array('view'),'op_show'=>$_smarty_tpl->tpl_vars['action']->value,'thead'=>array('p_id',$_smarty_tpl->tpl_vars['lang']->value['product_no'],$_smarty_tpl->tpl_vars['lang']->value['custom_barcode'],$_smarty_tpl->tpl_vars['lang']->value['product_name'],$_smarty_tpl->tpl_vars['lang']->value['import_sku'],$_smarty_tpl->tpl_vars['lang']->value['sale_quantity'],$_smarty_tpl->tpl_vars['lang']->value['express_way'],$_smarty_tpl->tpl_vars['lang']->value['package_bg'],$_smarty_tpl->tpl_vars['lang']->value['weight_detail'],$_smarty_tpl->tpl_vars['lang']->value['spec_detail']))); $_block_repeat=true; echo smarty_block_detail_table(array('id'=>'detail_table','flow'=>'sale','from'=>$_smarty_tpl->tpl_vars['rs']->value['detail'],'action'=>array('view'),'op_show'=>$_smarty_tpl->tpl_vars['action']->value,'thead'=>array('p_id',$_smarty_tpl->tpl_vars['lang']->value['product_no'],$_smarty_tpl->tpl_vars['lang']->value['custom_barcode'],$_smarty_tpl->tpl_vars['lang']->value['product_name'],$_smarty_tpl->tpl_vars['lang']->value['import_sku'],$_smarty_tpl->tpl_vars['lang']->value['sale_quantity'],$_smarty_tpl->tpl_vars['lang']->value['express_way'],$_smarty_tpl->tpl_vars['lang']->value['package_bg'],$_smarty_tpl->tpl_vars['lang']->value['weight_detail'],$_smarty_tpl->tpl_vars['lang']->value['spec_detail'])), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<tr index="<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
" class="<?php echo $_smarty_tpl->tpl_vars['none']->value;?>
" >
	<input type="hidden" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][id]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"> 
	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('type'=>"p_id",'id'=>"span_product_id",'view'=>"product_id",'width'=>'','class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('type'=>"p_id",'id'=>"span_product_id",'view'=>"product_id",'width'=>'','class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

	 <?php echo $_smarty_tpl->tpl_vars['item']->value['product_id'];?>

	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('type'=>"p_id",'id'=>"span_product_id",'view'=>"product_id",'width'=>'','class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'id'=>"span_product",'view'=>"product_no",'width'=>"160",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'id'=>"span_product",'view'=>"product_no",'width'=>"160",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		<input type="hidden" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][product_id]" id="product_id" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['product_id'];?>
" jqproc class="w200">
		<input type="text" name="temp[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][product_no]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['product_no'];?>
" url="<?php echo U('AutoComplete/product');?>
" jqac class="w200<?php if (!$_smarty_tpl->tpl_vars['rs']->value&&$_smarty_tpl->tpl_vars['login_user']->value['role_type']!=C('SELLER_ROLE_TYPE')){?> disabled <?php }?>" <?php if (!$_smarty_tpl->tpl_vars['rs']->value&&$_smarty_tpl->tpl_vars['login_user']->value['role_type']!=C('SELLER_ROLE_TYPE')){?> disabled <?php }?> <?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
>
	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'id'=>"span_product",'view'=>"product_no",'width'=>"160",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('id'=>"span_custom_barcode",'view'=>"custom_barcode",'width'=>"160",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('id'=>"span_custom_barcode",'view'=>"custom_barcode",'width'=>"160",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

	  <?php echo $_smarty_tpl->tpl_vars['item']->value['custom_barcode'];?>

	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('id'=>"span_custom_barcode",'view'=>"custom_barcode",'width'=>"160",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('id'=>"span_product_name",'view'=>"product_name",'width'=>"320",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('id'=>"span_product_name",'view'=>"product_name",'width'=>"320",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

	 <?php echo $_smarty_tpl->tpl_vars['item']->value['product_name'];?>

	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('id'=>"span_product_name",'view'=>"product_name",'width'=>"320",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('type'=>"import_sku",'id'=>"import_sku",'view'=>"import_sku",'width'=>"160",'class'=>"t_left")); $_block_repeat=true; echo smarty_block_td(array('type'=>"import_sku",'id'=>"import_sku",'view'=>"import_sku",'width'=>"160",'class'=>"t_left"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		<?php echo $_smarty_tpl->tpl_vars['item']->value['import_sku'];?>

	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('type'=>"import_sku",'id'=>"import_sku",'view'=>"import_sku",'width'=>"160",'class'=>"t_left"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'type'=>"flow_quantity",'view'=>"dml_quantity",'width'=>"56",'tfoot'=>array('total_quantity'=>''),'tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['dml_quantity']),'tfoot_id'=>"total_quantity",'class'=>"t_right")); $_block_repeat=true; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'type'=>"flow_quantity",'view'=>"dml_quantity",'width'=>"56",'tfoot'=>array('total_quantity'=>''),'tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['dml_quantity']),'tfoot_id'=>"total_quantity",'class'=>"t_right"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		<input type="text" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][quantity]" class="w50" id="quantity" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['edml_quantity'];?>
" row_total <?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
>
	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['deal_state']->value,'type'=>"flow_quantity",'view'=>"dml_quantity",'width'=>"56",'tfoot'=>array('total_quantity'=>''),'tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['dml_quantity']),'tfoot_id'=>"total_quantity",'class'=>"t_right"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    <?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('viewstate'=>$_smarty_tpl->tpl_vars['splitPackage']->value,'view'=>"ship_name",'width'=>"90",'class'=>"t_right")); $_block_repeat=true; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['splitPackage']->value,'view'=>"ship_name",'width'=>"90",'class'=>"t_right"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

        <span id="express_way">
                <input type="hidden" id="express_id" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][express_id]" onchange="getDetailExpressInfo();" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['express_id'];?>
">
                <input type="text" name="temp[ship_name]" url="<?php echo U('AutoComplete/shippingUse');?>
" where="<?php echo urlencode("warehouse_id='".($_smarty_tpl->tpl_vars['rs']->value['warehouse_id'])."'");?>
" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['ship_name'];?>
" jqac <?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
>
        </span>
        <img pid="<?php echo $_smarty_tpl->tpl_vars['rs']->value['express_id'];?>
" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
    <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['splitPackage']->value,'view'=>"ship_name",'width'=>"90",'class'=>"t_right"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('type'=>"package_bg",'view'=>"package_bg",'width'=>"56",'class'=>"t_right")); $_block_repeat=true; echo smarty_block_td(array('type'=>"package_bg",'view'=>"package_bg",'width'=>"56",'class'=>"t_right"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

        <?php if (in_array($_smarty_tpl->tpl_vars['rs']->value['sale_order_state'],explode(',',C('SALE_CAN_ADD_STATE')))||@ACTION_NAME=='add'){?>
            <input type="text" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][package_bg]" class="w50" id="package_bg" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['package_bg'];?>
">
        <?php }else{ ?>
            <input type="text" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][package_bg]" class="w50 disabled" readonly id="package_bg" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['package_bg'];?>
">
        <?php }?>
    <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('type'=>"package_bg",'view'=>"package_bg",'width'=>"56",'class'=>"t_right"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    <?php if (C('IS_PRODUCT_TYPE')){?>
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('viewstate'=>$_smarty_tpl->tpl_vars['splitPackage']->value,'view'=>"ship_name",'width'=>"90",'class'=>"t_right")); $_block_repeat=true; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['splitPackage']->value,'view'=>"ship_name",'width'=>"90",'class'=>"t_right"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

            <span id="express_way">
                <?php if ($_smarty_tpl->tpl_vars['rs']->value['express_id']){?>
                    <input type="hidden" id="express_id" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][express_id]" onchange="getDetailExpressInfo();" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['express_id'];?>
">
                    <input type="text" name="temp[ship_name]" url="<?php echo U('AutoComplete/shippingUse');?>
" where="<?php echo urlencode("warehouse_id='".($_smarty_tpl->tpl_vars['rs']->value['warehouse_id'])."'");?>
" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['ship_name'];?>
" jqac <?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
>
                <?php }?>
            </span>
            <img pid="<?php echo $_smarty_tpl->tpl_vars['rs']->value['express_id'];?>
" id="express_img" style="vertical-align:middle;cursor:pointer;}" onclick="$.autoShow(this,'SaleOrderShipping')" src="__PUBLIC__/Images/Default/atshow_ico.gif">
        <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['splitPackage']->value,'view'=>"ship_name",'width'=>"90",'class'=>"t_right"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

        <?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('viewstate'=>$_smarty_tpl->tpl_vars['splitPackage']->value,'view'=>"package_bg",'class'=>"t_right",'width'=>"56")); $_block_repeat=true; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['splitPackage']->value,'view'=>"package_bg",'class'=>"t_right",'width'=>"56"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

			<?php if ($_smarty_tpl->tpl_vars['rs']->value['disabled_package']==1){?>
				<?php echo $_smarty_tpl->tpl_vars['rs']->value['package_bg'];?>

			<?php }else{ ?>
				<input type="text" name="detail[<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
][package_bg]" class="w50" id="package_bg" value="<?php echo $_smarty_tpl->tpl_vars['rs']->value['package_bg'];?>
" <?php echo $_smarty_tpl->tpl_vars['readonly']->value;?>
 >
			<?php }?>
        <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('viewstate'=>$_smarty_tpl->tpl_vars['splitPackage']->value,'view'=>"package_bg",'class'=>"t_right",'width'=>"56"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    <?php }?>
	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('width'=>"90",'type'=>"flow_row_total",'view'=>"dml_quantity",'tfoot'=>array('total_col_qn'=>''),'tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['dml_quantity']),'total_row_qn'=>'','class'=>"t_right")); $_block_repeat=true; echo smarty_block_td(array('width'=>"90",'type'=>"flow_row_total",'view'=>"dml_quantity",'tfoot'=>array('total_col_qn'=>''),'tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['dml_quantity']),'total_row_qn'=>'','class'=>"t_right"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		<?php echo $_smarty_tpl->tpl_vars['item']->value['edml_quantity'];?>

	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('width'=>"90",'type'=>"flow_row_total",'view'=>"dml_quantity",'tfoot'=>array('total_col_qn'=>''),'tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['dml_quantity']),'total_row_qn'=>'','class'=>"t_right"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('id'=>"span_product_weight",'tfoot'=>array('total_col_weight'=>''),'total_row_weight'=>'','tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['s_weight']),'width'=>"150",'class'=>"t_right")); $_block_repeat=true; echo smarty_block_td(array('id'=>"span_product_weight",'tfoot'=>array('total_col_weight'=>''),'total_row_weight'=>'','tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['s_weight']),'width'=>"150",'class'=>"t_right"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		<?php echo $_smarty_tpl->tpl_vars['item']->value['s_weight'];?>

	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('id'=>"span_product_weight",'tfoot'=>array('total_col_weight'=>''),'total_row_weight'=>'','tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['s_weight']),'width'=>"150",'class'=>"t_right"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<input type="hidden" id="weight" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['weight'];?>
" weight> 
	<?php $_smarty_tpl->smarty->_tag_stack[] = array('td', array('id'=>"span_product_cube",'tfoot'=>array('total_col_cube'=>''),'total_row_cube'=>'','width'=>"320",'tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['s_cube']),'class'=>"t_right")); $_block_repeat=true; echo smarty_block_td(array('id'=>"span_product_cube",'tfoot'=>array('total_col_cube'=>''),'total_row_cube'=>'','width'=>"320",'tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['s_cube']),'class'=>"t_right"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		<?php echo $_smarty_tpl->tpl_vars['item']->value['s_cube'];?>

	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_td(array('id'=>"span_product_cube",'tfoot'=>array('total_col_cube'=>''),'total_row_cube'=>'','width'=>"320",'tfoot_value'=>($_smarty_tpl->tpl_vars['rs']->value['detail_total']['s_cube']),'class'=>"t_right"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<input type="hidden" id="cube_long" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['cube_long'];?>
">
	<input type="hidden" id="cube_wide" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['cube_wide'];?>
">
	<input type="hidden" id="cube_high" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['cube_high'];?>
"> 
	<?php echo smarty_function_detail_operation(array(),$_smarty_tpl);?>

</tr>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_detail_table(array('id'=>'detail_table','flow'=>'sale','from'=>$_smarty_tpl->tpl_vars['rs']->value['detail'],'action'=>array('view'),'op_show'=>$_smarty_tpl->tpl_vars['action']->value,'thead'=>array('p_id',$_smarty_tpl->tpl_vars['lang']->value['product_no'],$_smarty_tpl->tpl_vars['lang']->value['custom_barcode'],$_smarty_tpl->tpl_vars['lang']->value['product_name'],$_smarty_tpl->tpl_vars['lang']->value['import_sku'],$_smarty_tpl->tpl_vars['lang']->value['sale_quantity'],$_smarty_tpl->tpl_vars['lang']->value['express_way'],$_smarty_tpl->tpl_vars['lang']->value['package_bg'],$_smarty_tpl->tpl_vars['lang']->value['weight_detail'],$_smarty_tpl->tpl_vars['lang']->value['spec_detail'])), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>