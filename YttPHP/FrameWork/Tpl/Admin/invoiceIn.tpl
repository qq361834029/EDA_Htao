{include file="Admin/header.tpl"}
<div class="title"> 发票配置，此页配置只与发票流程相关。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >发票号编号：</td>
	<td class="tLeft" >
		<input type="radio" name="invoice_no" value="1" {if 'invoiceIn.invoice_no'|C==1}checked{/if}>自动生成
		<input type="radio" name="invoice_no" value="2" {if 'invoiceIn.invoice_no'|C==2}checked{/if}>手动填写
	</td>
</tr>
<tr>
	<td class="tRight" >发票号前缀：</td>
	<td class="tLeft" >
		<input type='text' name="prefix" value="{'invoiceIn.prefix'|C}">
		(任意小于或者等于2位字符仅限英文和数字组合)
	</td>
</tr>

<tr>
	<td class="tRight" >生成方式：</td>
	<td class="tLeft" >
		<input type="radio" name="create_method" value="1" {if 'invoiceIn.create_method'|C==1}checked{/if}>序列号
		<input type="radio" name="create_method" value="2" {if 'invoiceIn.create_method'|C==2}checked{/if}>年月日+序列号
	</td>
</tr>
<tr>
	<td class="tRight" >序列号位数：</td>
	<td class="tLeft" >
		<input type="text" name="serial" value="{'invoiceIn.serial'|C}">
		(发票编号设置为自动生成时，必须输入序列号位数)
	</td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="invoiceIn">
	<input type="hidden" name="type_key" value="1">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
