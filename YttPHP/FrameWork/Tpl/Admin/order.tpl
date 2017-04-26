{include file="Admin/header.tpl"}
<div class="title"> 订货配置，颜色，尺码，规格配置必须与装柜一致。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >显示颜色：</td>
	<td class="tLeft" ><input type="radio" name="color" value="1" {if 'order.color'|C==1}checked{/if}>是<input type="radio" name="color" value="2" {if 'order.color'|C==2}checked{/if}>否（明细中是否显示颜色输入框）</td>
</tr>
<tr>
	<td class="tRight" >显示尺码：</td>
	<td class="tLeft" ><input type="radio" name="size" value="1" {if 'order.size'|C==1}checked{/if}>是<input type="radio" name="size" value="2" {if 'order.size'|C==2}checked{/if}>否（明细中是否显示尺码输入框）</td>
</tr>
<tr>
	<td class="tRight" >库存规格：</td>
	<td class="tLeft" ><select name="storage_format" id="storage_format" combobox>
              <option value="1" {if 'order.storage_format'|C==1}selected{/if}>按数量</option>
              <option value="2" {if 'order.storage_format'|C==2}selected{/if}>按箱*每箱数量</option>
              <option value="3" {if 'order.storage_format'|C==3}selected{/if}>按箱*每箱包数*每箱数量</option>
            </select>（明细中库存数量相关输入框）</td>
</tr>
<tr>
	<td class="tRight" >邮件发送：</td>
	<td class="tLeft" ><input type="radio" name="email_order" value="1" {if 'order.email_order'|C==1}checked{/if}>是<input type="radio" name="email_order" value="2" {if 'order.email_order'|C==2}checked{/if}>否</td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="order">
	<input type="hidden" name="type_key" value="1">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
