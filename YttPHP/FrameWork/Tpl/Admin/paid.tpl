{include file="Admin/header.tpl"}
<div class="title"> 款项配置，修改后系统可正确运行，无须处理任何数据记录。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >默认显示款项信息：</td>
	<td class="tLeft" ><input type="radio" name="how_assign_info" value="1" {if 'how_assign_info'|C==1}checked{/if}>是<input type="radio" name="how_assign_info" value="2" {if 'how_assign_info'|C==2}checked{/if}>否（新客户收款默认选择是，否）</td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="paid">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
