{include file="header.tpl"}
<div class="title"> 新增菜单详细信息。</div>
<form method="POST" action="{'Develop/saveNode'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >菜单名称：</td>
	<td class="tLeft" ><input type="text" name="title" value=""></td>
</tr>
</tr>
<tr>
	<td class="tRight" >模块：</td>
	<td class="tLeft" ><input type="text" name="module" value=""></td>
</tr>
<tr>
	<td class="tRight" >排序：</td>
	<td class="tLeft" ><input type="text" name="sort" value=""></td>
</tr>
<tr>
	<td class="tRight" >所属模块：</td>
	<td class="tLeft" ><input type="hidden" name="parent_id" value="{$rs.parent_id}">
	<input type="text" name="sdfsdf" url="{'/AutoComplete/node'|U}" value="" jqac>（
	当前菜单所属关系）</td>
</tr>
<tr>
	<td class="tRight" >显示位置：</td>
	<td class="tLeft" ><input type="hidden" name="group_id" value="{$rs.group_id}"><input type="text" name="dfsdf" url="{'/AutoComplete/node'|U}" value="" jqac>（当前菜单显示所属关系）</td>
</tr>
<tr>
	<td class="tRight" >菜单级别：</td>
	<td class="tLeft" ><input type="text" name="level" value=""></td>
</tr>

<tr>
	<td class="tRight" >项目可见：</td>
	<td class="tLeft" ><input type="text" name="is_user" value="">（项目中是否可见）</td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="once">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="footer.tpl"}
