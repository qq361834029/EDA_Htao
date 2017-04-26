{include file="header.tpl"}
<div class="title"> 该页面配置提交后不可修改，请确认无误后再提交。</div>
<form method="POST" action="{'System/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >是否多仓库：</td>
	<td class="tLeft" ><input type="radio" name="multi_storage" value="1" {if $rs.multi_storage==1}checked{/if}>是<input type="radio" name="multi_storage" value="2" {if $rs.multi_storage==2}checked{/if}>否</td>
</tr>
<tr>
	<td class="tRight" >汇率设置：</td>
	<td class="tLeft" ><select name="set_rate_type" combobox ><option value="2" {if $rs.set_rate_type==2}selected{/if}>按月</option><option value="3" {if $rs.set_rate_type==3}selected{/if}>按单据日期</option></select>（无法获取设置汇率时取固定汇率同时记录汇率异常）</td>
</tr>
<tr>
	<td class="tRight" >本位币：</td>
	<td class="tLeft" >
	{currency data='1,2,3,4,5' name="currency" value="{C('currency')}" empty=true combobox=1}</td>
</tr>
<tr>
	<td class="tRight" >银行存款关联现金：</td>
	<td class="tLeft" ><input type="radio" name="bank_cash" value="1" {if $rs.bank_cash==1}checked{/if}>是<input type="radio" name="bank_cash" value="2" {if $rs.bank_cash==2}checked{/if}>否</td>
</tr>
<tr>
	<td class="tRight" >发送客户应付款：</td>
	<td class="tLeft" ><input type="radio" name="client_stat_sent_email" value="1" {if $rs.client_stat_sent_email==1}checked{/if}>是<input type="radio" name="client_stat_sent_email" value="2" {if $rs.client_stat_sent_email==2}checked{/if}>否</td>
</tr>
<tr>
	<td class="tRight" >订货时区配置：</td>
    <td class="tLeft"><select name="orders_timezone" combobox >
    <option value="Asia/Shanghai" {if $rs.orders_timezone=='Asia/Shanghai'}selected{/if}>中国/上海</option>
    <option value="America/New_York" {if $rs.orders_timezone=='America/New_York'}selected{/if}>美国/纽约</option>
    <option value="Europe/Berlin" {if $rs.orders_timezone=='Europe/Berlin'}selected{/if}>欧洲/柏林</option>
    <option value="Europe/Rome" {if $rs.orders_timezone=='Europe/Rome'}selected{/if}>欧洲/罗马</option>
    </select></td>
</tr>
<tr>
	<td class="tRight" >销售时区配置：</td>
    <td class="tLeft"><select name="sale_timezone" combobox >
    <option value="Asia/Shanghai" {if $rs.sale_timezone=='Asia/Shanghai'}selected{/if}>中国/上海</option>
    <option value="America/New_York" {if $rs.sale_timezone=='America/New_York'}selected{/if}>美国/纽约</option>
    <option value="Europe/Berlin" {if $rs.sale_timezone=='Europe/Berlin'}selected{/if}>欧洲/柏林</option>
    <option value="Europe/Rome" {if $rs.sale_timezone=='Europe/Rome'}selected{/if}>欧洲/罗马</option>
    </select></td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="config_type" value="once">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="footer.tpl"}
