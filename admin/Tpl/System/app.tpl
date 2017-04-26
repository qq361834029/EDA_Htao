{include file="header.tpl"}
<div class="title"> 项目配置，修改后系统可正确运行，无须处理任何数据记录。</div>
<form method="POST" action="{'System/save'|U}">
<table cellpadding=3 cellspacing=3 >
	<tr>
		<td class="tRight bold"><div class="title">项目配置</div></td>
		<td class="tLeft">&nbsp;</td>
	</tr>
	<tr>
		<td class="tRight">数字小数位数：</td>
		<td class="tLeft">
		单价<input type="text" name="price_length" maxlength="1" value="{$rs.price_length}" style="width:80px!important;">；
		金额<input type="text" name="money_length" maxlength="1" value="{$rs.money_length}" style="width:80px!important;">；
		包装规格<input type="text" name="cube_length" maxlength="1" value="{$rs.cube_length}" style="width:80px!important;">
		</td>
	</tr>
	<tr>
		<td class="tRight">0库存是否显示：</td>
		<td class="tLeft">
		<input type="radio" name="storage_zero" value="1" {if $rs.storage_zero==1}checked{/if}>
		是
		<input type="radio" name="storage_zero" value="0" {if $rs.storage_zero==0}checked{/if}>
		否
		</td>
	</tr>
	<tr>
		<td class="tRight">启用条形码：</td>
		<td class="tLeft">
		<input type="radio" name="barcode" value="1" {if $rs.barcode==1}checked{/if}>
		是
		<input type="radio" name="barcode" value="0" {if $rs.barcode==0}checked{/if}>
		否
		</td>
	</tr>
	<tr>
		<td class="tRight">默认价格设置：</td>
		<td class="tLeft">
		<input type="radio" name="price_default" value="1" {if $rs.price_default==1}checked{/if}>
		预计
		<input type="radio" name="price_default" value="2" {if $rs.price_default==2}checked{/if}>
		最近一次
		<input type="radio" name="price_default" value="3" {if $rs.price_default==3}checked{/if}>
		平均 
		</td>
	</tr>
	<tr>
		<td class="tRight">是否多种客户类型：</td>
		<td class="tLeft">
		<input type="radio" name="multi_client" value="1" {if $rs.multi_client==1}checked{/if}>
		是
		<input type="radio" name="multi_client" value="0" {if $rs.multi_client==0}checked{/if}>
		否
		</td>
	</tr>
	<tr>
		<td class="tRight">新增行数：</td>
		<td class="tLeft">
		<input type="text" name="add_max_row" value="{$rs.add_max_row}">
		</td>
	</tr>
	<tr>
		<td class="tRight">显示向导：</td>
		<td class="tLeft">
		<input type="radio" name="show_guide" value="1" {if $rs.show_guide==1}checked{/if}>
		是
		<input type="radio" name="show_guide" value="0" {if $rs.show_guide==0}checked{/if}>
		否
		</td>
	</tr>
	<tr>
		<td class="tRight">列表行数：</td>
		<td class="tLeft">
		<input type="text" id="line_number" name="line_number" value="{if $rs.line_number>0}{$rs.line_number}{else}20{/if}">
		</td>
	</tr>
	<tr>
		<td class="tRight">拣货导出限制行数：</td>
		<td class="tLeft">
		<input type="text" id="line_number" name="picking_max_row" value="{if $rs.picking_max_row>0}{$rs.picking_max_row}{else}9999{/if}">
		</td>
	</tr>
  	<tr>
		<td class="tRight bold"><div class="title">项目配置</div></td>
		<td class="tLeft" >&nbsp;</td>
	</tr>
	<tr>
		<td class="tRight">E-mail：</td>
		<td class="tLeft">
		<input type="text" name="email_adder" value="{$rs.email_adder}">
		(name@domain.com)
		</td>
	</tr>
	<tr>
		<td class="tRight">密码：</td>
		<td class="tLeft">
		<input type="text" name="email_password" value="{$rs.email_password}">
		(password)
		</td>
	</tr>
	<tr>
		<td class="tRight">Host：</td>
		<td class="tLeft">
		<input type="text" name="email_host" value="{$rs.email_host}">
		(mail.yourdomain.com)
		</td>
	</tr>
	<tr>
		<td class="tRight">Port：</td>
		<td class="tLeft">
		<input type="text" name="email_port" value="{$rs.email_port}">
		(25)
		</td>
	</tr>
	<tr>
		<td class="tRight">Email抬头：</td>
		<td class="tLeft">
		<input type="text" name="email_title" value="{$rs.email_title}">
		(友拓通)
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<input type="hidden" name="config_type" value="app">
		<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
		<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
		</td>
	</tr>
</table>
</form>
{include file="footer.tpl"}