{include file="Admin/header.tpl"}
<div class="title"> 发货配置，此页配置只与当前流程相关。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >显示颜色：</td>
	<td class="tLeft" ><input type="radio" name="color" value="1" {if 'delivery.color'|C==1}checked{/if}>是<input type="radio" name="color" value="2" {if 'delivery.color'|C==2}checked{/if}>否（明细中是否显示颜色输入框）</td>
</tr>
<tr>
	<td class="tRight" >显示尺码：</td>
	<td class="tLeft" ><input type="radio" name="size" value="1" {if 'delivery.size'|C==1}checked{/if}>是<input type="radio" name="size" value="2" {if 'delivery.size'|C==2}checked{/if}>否（明细中是否显示尺码输入框）</td>
</tr>
<tr>
	<td class="tRight" >显示尾箱：</td>
	<td class="tLeft" ><input type="radio" name="mantissa" value="1" {if 'delivery.mantissa'|C==1}checked{/if}>是<input type="radio" name="mantissa" value="2" {if 'delivery.mantissa'|C==2}checked{/if}>否（明细中是否显示尾箱输入框）</td>
</tr>
<tr>
	<td class="tRight" >库存规格：</td>
	<td class="tLeft" ><select name="storage_format" id="storage_format" combobox>
              <option value="1" {if 'delivery.storage_format'|C==1}selected{/if}>按数量</option>
              <option value="2" {if 'delivery.storage_format'|C==2}selected{/if}>按箱*每箱数量</option>
              <option value="3" {if 'delivery.storage_format'|C==3}selected{/if}>按箱*每箱包数*每箱数量</option>
            </select>（明细中库存数量相关输入框）</td>
</tr>
<tr>
	<td class="tRight" >是否关联配货：</td>
	<td class="tLeft" ><input type="radio" name="relation_predelivery" value="1" {if 'delivery.relation_predelivery'|C==1}checked{/if}>是<input type="radio" name="relation_predelivery" value="2" {if 'delivery.relation_predelivery'|C==2}checked{/if}>否（是 只能装已配货未发货完产品，否 只能发销售单中产品）</td>
</tr>
<tr>
	<td class="tRight" >多次发货：</td>
	<td class="tLeft" ><input type="radio" name="multi_delivery" value="1" {if 'delivery.multi_delivery'|C==1}checked{/if}>是<input type="radio" name="multi_delivery" value="2" {if 'delivery.multi_delivery'|C==2}checked{/if}>否</td>
</tr>
<tr>
	<td class="tRight" >显示折扣：</td>
	<td class="tLeft" ><input type="radio" name="delivery_price_show" value="1" {if 'delivery.delivery_price_show'|C==1}checked{/if}>是<input type="radio" name="delivery_price_show" value="2" {if 'delivery.delivery_price_show'|C==2}checked{/if}>否（明细时是否显示折扣，折后金额）</td>
</tr>
<tr>
	<td class="tRight" >显示发货状态：</td>
	<td class="tLeft" ><input type="radio" name="show_delivery_status" value="1" {if $rs.show_delivery_status==1}checked{/if}>是<input type="radio" name="show_delivery_status" value="2" {if $rs.show_delivery_status==2}checked{/if}>否（统计-客户应收款明细）</td>
</tr>
<tr>
	<td class="tRight" >邮件发送：</td>
	<td class="tLeft" ><input type="radio" name="email_delivery" value="1" {if 'delivery.email_delivery'|C==1}checked{/if}>是<input type="radio" name="email_delivery" value="2" {if 'delivery.email_delivery'|C==2}checked{/if}>否</td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="delivery">
	<input type="hidden" name="type_key" value="1">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
