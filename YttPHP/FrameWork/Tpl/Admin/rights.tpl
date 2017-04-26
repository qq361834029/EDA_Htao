{include file="Admin/header.tpl"}
<div class="title"> 权限配置，修改后需要重新编辑系统中已存在角色，否则权限将出错。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >权限设置级别：</td>
	<td class="tLeft" ><select name="rights_level" combobox>
            <option value="2" {if rights_level|C==2}selected{/if}>二级菜单</option>
            <option value="3" {if rights_level|C==3}selected{/if}>具体操作</option>
          </select>（不同级别影响角色需要勾选的模块的明细程度）
     </td>
</tr>
<tr>
	<td class="tRight" >权限范围：</td>
	<td class="tLeft" ><input type="radio" name="show_data_right" value="1" {if show_data_right|C==1}checked{/if}>是 <input type="radio" name="show_data_right" value="2" {if show_data_right|C==2}checked{/if}>否（决定对应数据记录操作权限，不同权限范围影响角色需要勾选的模块的明细程度）
     </td>
</tr>
<tr>
	<td class="tRight" >权限实时生效：</td>
	<td class="tLeft" ><input type="radio" name="access_type" value="1" {if access_type|C==1}checked{/if}>是 <input type="radio" name="access_type" value="2" {if access_type|C==2}checked{/if}>否（是，角色修改后权限立即生效[执行效率较低，影响任何操作]，否，登陆时获取一次权限）<br>
	特别说明：修改后需要重登陆才生效。
     </td>
</tr>
<tr>
	<td colspan="2">
	<input type="hidden" name="type" value="rights">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}