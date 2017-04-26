{include file="header.tpl"}
<div class="title"> 款项配置，修改后系统可正确运行，无须处理任何数据记录。</div>
<form method="POST" action="{'System/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >默认显示款项信息：</td>
	<td class="tLeft" ><input type="radio" name="how_assign_info" value="1" {if $rs.how_assign_info==1}checked{/if}>是<input type="radio" name="how_assign_info" value="2" {if $rs.how_assign_info==2}checked{/if}>否（新客户收款默认选择是，否）</td>
</tr>
 <tr>
	<td class="tRight" >未结清明细显示方式：</td>
	<td class="tLeft" ><input type="radio" name="unpaid_arrearage_details" value="1" {if $rs.unpaid_arrearage_details==1}checked{/if}>按日期<input type="radio" name="unpaid_arrearage_details" value="2" {if $rs.unpaid_arrearage_details==2}checked{/if}>按类型<input type="radio" name="unpaid_arrearage_details" value="3" {if $rs.unpaid_arrearage_details==3}checked{/if}>全部</td>
</tr>
<tr>
	<td class="tRight" >全部款项明细显示方式：</td>
	<td class="tLeft" ><input type="radio" name="all_arrearage_detail" value="1" {if $rs.all_arrearage_detail==1}checked{/if}>按日期<input type="radio" name="all_arrearage_detail" value="2" {if $rs.all_arrearage_detail==2}checked{/if}>按类型<input type="radio" name="all_arrearage_detail" value="3" {if $rs.all_arrearage_detail==3}checked{/if}>全部</td>
</tr>
<tr>
	<td class="tRight" >平账/对账后欠款明细显示方式：</td>
	<td class="tLeft" ><input type="radio" name="arrearage_details_afcloseout" value="1" {if $rs.arrearage_details_afcloseout==1}checked{/if}>按日期<input type="radio" name="arrearage_details_afcloseout" value="2" {if $rs.arrearage_details_afcloseout==2}checked{/if}>按类型<input type="radio" name="arrearage_details_afcloseout" value="3" {if $rs.arrearage_details_afcloseout==3}checked{/if}>全部</td>
</tr>
<tr>
	<td colspan="2">
	<input type="hidden" name="config_type" value="paid">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="footer.tpl"}
