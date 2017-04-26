{include file="Admin/header.tpl"}
<div class="title"> 发票配置，此页配置只与发票流程相关。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >显示产品号：</td>
	<td class="tLeft" >
		<input type="radio" name="product" value="1" {if 'invoice.product'|C==1}checked{/if}>是
		<input type="radio" name="product" value="2" {if 'invoice.product'|C==2}checked{/if}>否
	</td>
</tr>
<tr>
	<td class="tRight" >产品号唯一：</td>
	<td class="tLeft" >
		<input type="radio" name="product_unique" value="1" {if 'invoice.product_unique'|C==1}checked{/if}>是
		<input type="radio" name="product_unique" value="2" {if 'invoice.product_unique'|C==2}checked{/if}>否
	</td>
</tr>

<tr>
	<td class="tRight" >显示成分：</td>
	<td class="tLeft" >
		<input type="radio" name="ingredient" value="1" {if 'invoice.ingredient'|C==1}checked{/if}>是
		<input type="radio" name="ingredient" value="2" {if 'invoice.ingredient'|C==2}checked{/if}>否
	</td>
</tr>
<tr>
	<td class="tRight" >检查库存：</td>
	<td class="tLeft" >
		<input type="radio" name="storage_check" value="1" {if 'invoice.storage_check'|C==1}checked{/if}>是
		<input type="radio" name="storage_check" value="2" {if 'invoice.storage_check'|C==2}checked{/if}>否
	</td>
</tr>
<tr>
	<td class="tRight" >设置周末：</td>
	<td class="tLeft" >
		<input type="checkbox" value="1" name="weekend[]" {if 1|in_array:$weekend}checked{/if}>周一
		<input type="checkbox" value="2" name="weekend[]" {if 2|in_array:$weekend}checked{/if}>周二
		<input type="checkbox" value="3" name="weekend[]" {if 3|in_array:$weekend}checked{/if}>周三
		<input type="checkbox" value="4" name="weekend[]" {if 4|in_array:$weekend}checked{/if}>周四
		<input type="checkbox" value="5" name="weekend[]" {if 5|in_array:$weekend}checked{/if}>周五
		<input type="checkbox" value="6" name="weekend[]" {if 6|in_array:$weekend}checked{/if}>周六
		<input type="checkbox" value="7" name="weekend[]" {if 7|in_array:$weekend}checked{/if}>周日
	</td>
</tr>
<tr>
	<td class="tRight" >出发票显示折扣：</td>
	<td class="tLeft" >
		<input type="radio" name="discount_money" value="1" {if 'invoice.discount_money'|C==1}checked{/if}>是
		<input type="radio" name="discount_money" value="2" {if 'invoice.discount_money'|C==2}checked{/if}>否
	</td>
</tr>
<tr>
	<td class="tRight">数据导入：</td>
	<td class="tLeft">
		<input type="radio" name="import" value="1" {if 'invoice.import'|C==1}checked{/if}>是
		<input type='radio' name="import" value="2" {if 'invoice.import'|C==2}checked{/if}>否
	</td>
</tr>
<tr>
	<td class="tRight">是否开启退货发票</td>
	<td class="rLeft">
		<input type="radio" name="invoice_return_show" value="1" {if 'invoice.invoice_return_show'|C==1}checked{/if}>是
		<input type="radio" name="invoice_return_show" value="2" {if 'invoice.invoice_return_show'|C==2}checked{/if}>否
	</td>
</tr>
<tr>
	<td class="tRight" >产品来源：</td>
	<td class="tLeft" >
		<input type="radio" name="product_from" value="1" {if 'invoice.product_from'|C==1}checked{/if}>产品列表
		<input type="radio" name="product_from" value="2" {if 'invoice.product_from'|C==2}checked{/if}>独立产品
	</td>
</tr>
<tr>
	<td class="tRight" >客户来源：</td>
	<td class="tLeft" >
		<input type="radio" name="client_from" value="1" {if 'invoice.client_from'|C==1}checked{/if}>客户列表
		<input type="radio" name="client_from" value="2" {if 'invoice.client_from'|C==2}checked{/if}>独立客户
	</td>
</tr>
<tr>
	<td class="tRight" >厂家来源：</td>
	<td class="tLeft" >
		<input type="radio" name="factory_from" value="1" {if 'invoice.factory_from'|C==1}checked{/if}>厂家列表
		<input type="radio" name="factory_from" value="2" {if 'invoice.factory_from'|C==2}checked{/if}>独立厂家
	</td>
</tr>
<tr>
	<td class="tRight" >公司来源：</td>
	<td class="tLeft" >
		<input type="radio" name="company_from" value="1" {if 'invoice.company_from'|C==1}checked{/if}>公司列表
		<input type="radio" name="company_from" value="2" {if 'invoice.company_from'|C==2}checked{/if}>独立公司
	</td>
</tr>
<tr>
	<td class="tRight">进发票报表显示备注：</td>
	<td class="tLeft">
		<textarea name="in_comments" rows="5" cols="100">{'invoice.in_comments'|C|stripcslashes}</textarea>
	</td>
</tr>
<tr>
	<td class="tRight">出发票报表显示备注：</td>
	<td class="tLeft">
		<textarea name="out_comments" rows="5" cols="100">{'invoice.out_comments'|C|stripcslashes}</textarea>
	</td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="invoice">
	<input type="hidden" name="type_key" value="1">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
