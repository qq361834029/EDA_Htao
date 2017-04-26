<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:47:07
         compiled from "/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/PickingImport/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:187461060158f6c19bd9beb0-95444742%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'affd4989f4234f35b03a1dfd0e871d171ede358c' => 
    array (
      0 => '/home/wsl/EDA_HTao/YttPHP/FrameWork/Tpl/PickingImport/add.tpl',
      1 => 1492482589,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '187461060158f6c19bd9beb0-95444742',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'file_tocken' => 0,
    'lang' => 0,
    'import_key' => 0,
    'sid' => 0,
    'rs' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6c19be61e8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6c19be61e8')) {function content_58f6c19be61e8($_smarty_tpl) {?><?php if (!is_callable('smarty_function_wz')) include '/home/wsl/EDA_HTao/YttPHP/FrameWork/Extend/Vendor/Smarty/plugins/function.wz.php';
?><form action="<?php echo U('PickingImport/insert');?>
" method="POST" onsubmit="return false">
<?php echo smarty_function_wz(array('action'=>"save,list,reset"),$_smarty_tpl);?>

<input type="hidden" name="file_tocken" value="<?php echo $_smarty_tpl->tpl_vars['file_tocken']->value;?>
">
<input type="hidden" name="flow" id="flow" value="pickingImport">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th colspan="4"><?php echo $_smarty_tpl->tpl_vars['lang']->value['basic_info'];?>
</th>
		</tr>
		<tr>
			<td colspan="4">
				<div class="basic_tb">  
					<?php $_smarty_tpl->tpl_vars["import_key"] = new Smarty_variable("PickingImport", null, 0);?>
					<ul> 
						<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['picking_no'];?>
：
							<input type="text" id="file_list_no" name="picking_no" class="spc_input" url="<?php echo U('/AutoComplete/unImportPickingNo');?>
" jqac>__*__	
						</li>							
                                                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?php echo $_smarty_tpl->tpl_vars['lang']->value['download_import_template'];?>
：
							<a href="<?php echo @APP_EXCEL_PATH;?>
/<?php echo $_smarty_tpl->tpl_vars['import_key']->value;?>
.xls"><?php echo $_smarty_tpl->tpl_vars['lang']->value['download_template'];?>
</a>
						</li>		
						<li><?php echo $_smarty_tpl->tpl_vars['lang']->value['select_file'];?>
：
								<?php echo smarty_function_upload(array('tocken'=>$_smarty_tpl->tpl_vars['file_tocken']->value,'sid'=>$_smarty_tpl->tpl_vars['sid']->value,'type'=>16,'allowTypes'=>"xls,xlsx"),$_smarty_tpl);?>

								<input type="hidden" id="file_name" name="file_name">
								<input type="hidden" name="sheet" value="0">
								<input type="hidden" name="import_key" value="<?php echo $_smarty_tpl->tpl_vars['import_key']->value;?>
">
						</li>		
					</ul>
				</div>
  			</td>
  		</tr> 
    	<tr>
    		<th colspan="4"><?php echo $_smarty_tpl->tpl_vars['lang']->value['detail_info'];?>
</th>
		</tr>		
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%"><?php echo $_smarty_tpl->tpl_vars['lang']->value['comments'];?>
：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="comments" id="comments" class="textarea_height80"><?php echo $_smarty_tpl->tpl_vars['rs']->value['edit_comments'];?>
</textarea> </td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 	 		
    </tbody>
</table>
<?php echo smarty_function_staff(array(),$_smarty_tpl);?>

</div>
</form>
<?php }} ?>