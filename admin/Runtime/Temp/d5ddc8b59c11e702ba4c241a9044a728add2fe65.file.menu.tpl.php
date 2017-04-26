<?php /* Smarty version Smarty-3.1.6, created on 2017-04-19 03:30:48
         compiled from "../admin/Tpl/Index/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:36948676158f6bdc89d84f9-83969868%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5ddc8b59c11e702ba4c241a9044a728add2fe65' => 
    array (
      0 => '../admin/Tpl/Index/menu.tpl',
      1 => 1492483003,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '36948676158f6bdc89d84f9-83969868',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu' => 0,
    'link_module' => 0,
    'item' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_58f6bdc8a31e3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58f6bdc8a31e3')) {function content_58f6bdc8a31e3($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
            <style>
                html{ overflow-x : hidden;}
				body{ width:100%;}
            </style>
            <base target="main" />
    </head>

    <body >
        <div id="menu" class="menu">
            <table class="list shadow" cellpadding=0 cellspacing=0 >
                <tr>
                    <td height='5' colspan=7 class="topTd" ></td>
                </tr>
                <tr class="row" >
                    <th class="tCenter space"><img SRC="__PUBLIC__/Images/Admin/home.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align="absmiddle"> <?php if ($_GET['title']){?> <?php echo $_GET['title'];?>
<?php }else{ ?>后台首页<?php }?> </th>
                </tr>
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                                    <tr class="row " >
                                        <td><div style="margin:0px 5px"><img SRC="__PUBLIC__/Images/Admin/arrow.gif" WIDTH="9" HEIGHT="9" BORDER="0" align="absmiddle" ALT=""> <a href="__APP__/<?php echo $_smarty_tpl->tpl_vars['link_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['module'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" target="main"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a></div></td>
                                    </tr>
                    <?php } ?>
                <tr>
                    <td height='5' colspan=7 class="bottomTd"></td>
                </tr>
            </table>
        </div>
        <script language="JavaScript">
            function refreshMainFrame(url){
                parent.main.document.location = url;
            }
            if (document.anchors[0]){
                refreshMainFrame(document.anchors[0].href);
            }
        </script>
    </body>
</html><?php }} ?>