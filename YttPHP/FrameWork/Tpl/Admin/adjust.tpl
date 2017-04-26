{include file="Admin/header.tpl"}
<div class="title"> 库存调整配置，此页配置只与当前流程相关。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >显示颜色：</td>
	<td class="tLeft" ><input type="radio" name="color" value="1" {if 'adjust.color'|C==1}checked{/if}>是<input type="radio" name="color" value="2" {if 'adjust.color'|C==2}checked{/if}>否（明细中是否显示颜色输入框）</td>
</tr>
<tr>
	<td class="tRight" >显示尺码：</td>
	<td class="tLeft" ><input type="radio" name="size" value="1" {if 'adjust.size'|C==1}checked{/if}>是<input type="radio" name="size" value="2" {if 'adjust.size'|C==2}checked{/if}>否（明细中是否显示尺码输入框）</td>
</tr>
<tr>
	<td class="tRight" >显示尾箱：</td>
	<td class="tLeft" ><input type="radio" name="mantissa" value="1" {if 'adjust.mantissa'|C==1}checked{/if}>是<input type="radio" name="mantissa" value="2" {if 'adjust.mantissa'|C==2}checked{/if}>否（明细中是否显示尾箱输入框）</td>
</tr>
<tr>
	<td class="tRight" >库存规格：</td>
	<td class="tLeft" ><select name="storage_format" id="storage_format" combobox>
              <option value="1" {if 'adjust.storage_format'|C==1}selected{/if}>按数量</option>
              <option value="2" {if 'adjust.storage_format'|C==2}selected{/if}>按箱*每箱数量</option>
              <option value="3" {if 'adjust.storage_format'|C==3}selected{/if}>按箱*每箱包数*每箱数量</option>
            </select>（明细中库存数量相关输入框）</td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="adjust">
	<input type="hidden" name="type_key" value="1">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
