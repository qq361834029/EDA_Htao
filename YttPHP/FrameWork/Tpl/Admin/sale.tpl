{include file="Admin/header.tpl"}
<div class="title"> 销售配置，此页配置只与当前流程相关。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >显示颜色：</td>
	<td class="tLeft" ><input type="radio" name="color" value="1" {if 'sale.color'|C==1}checked{/if}>是<input type="radio" name="color" value="2" {if 'sale.color'|C==2}checked{/if}>否（明细中是否显示颜色输入框）</td>
</tr>
<tr>
	<td class="tRight" >显示尺码：</td>
	<td class="tLeft" ><input type="radio" name="size" value="1" {if 'sale.size'|C==1}checked{/if}>是<input type="radio" name="size" value="2" {if 'sale.size'|C==2}checked{/if}>否（明细中是否显示尺码输入框）</td>
</tr>
<tr>
	<td class="tRight" >显示尾箱：</td>
	<td class="tLeft" ><input type="radio" name="mantissa" value="1" {if 'sale.mantissa'|C==1}checked{/if}>是<input type="radio" name="mantissa" value="2" {if 'sale.mantissa'|C==2}checked{/if}>否（明细中是否显示尾箱输入框）</td>
</tr>
<tr>
	<td class="tRight" >库存规格：</td>
	<td class="tLeft" ><select name="storage_format" id="storage_format" combobox>
              <option value="1" {if 'sale.storage_format'|C==1}selected{/if}>按数量</option>
              <option value="2" {if 'sale.storage_format'|C==2}selected{/if}>按箱*每箱数量</option>
              <option value="3" {if 'sale.storage_format'|C==3}selected{/if}>按箱*每箱包数*每箱数量</option>
            </select>（明细中库存数量相关输入框）</td>
</tr>
<tr>
	<td class="tRight" >销售后续流程：</td>
	<td class="tLeft" ><input type="radio" name="relation_sale_follow_up" value="1" {if 'sale.relation_sale_follow_up'|C==1}checked{/if}>是<input type="radio" name="relation_sale_follow_up" value="2" {if 'sale.relation_sale_follow_up'|C==2}checked{/if}>否(例如 配货,发货)</td>
</tr>
<tr>
	<td class="tRight" >销售收款：</td>
	<td class="tLeft" ><input type="radio" name="show_sale_advance" value="1" {if 'sale.show_sale_advance'|C==1}checked{/if}>是<input type="radio" name="show_sale_advance" value="2" {if 'sale.show_sale_advance'|C==2}checked{/if}>否（是否显示收款输入表单）</td>
</tr>
<tr>
	<td class="tRight" >销售显示客户欠款：</td>
	<td class="tLeft" ><input type="radio" name="need_pay" value="1" {if 'sale.need_pay'|C==1}checked{/if}>是<input type="radio" name="need_pay" value="2" {if 'sale.need_pay'|C==2}checked{/if}>否（选择客户后是否显示客户总欠款）</td>
</tr>
<tr>
	<td class="tRight" >显示折扣：</td>
	<td class="tLeft" ><input type="radio" name="sale_client_count_money" value="1" {if 'sale.sale_client_count_money'|C==1}checked{/if}>是<input type="radio" name="sale_client_count_money" value="2" {if 'sale.sale_client_count_money'|C==2}checked{/if}>否（明细时是否显示折扣，折后金额）</td>
</tr>
<tr>
	<td class="tRight">显示发票号：</td>
	<td class="tLeft">
		<input type="radio" name="show_invoice" value="1" {if 'sale.show_invoice'|C==1}checked{/if}>是
		<input type="radio" name="show_invoice" value="2" {if 'sale.show_invoice'|C==2}checked{/if}>否
	</td>
</tr>
<tr>
	<td class="tRight" >邮件发送：</td>
	<td class="tLeft" ><input type="radio" name="email_sale" value="1" {if 'sale.email_sale'|C==1}checked{/if}>是<input type="radio" name="email_sale" value="2" {if 'sale.email_sale'|C==2}checked{/if}>否</td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="sale">
	<input type="hidden" name="type_key" value="1">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
