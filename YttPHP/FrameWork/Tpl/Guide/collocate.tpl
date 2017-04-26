<div class="f14bold sy_height">
{if $rights.role.add || $rights.user.add || $admin_auth_key}
<p class="fwg">{$lang.guide_title_1}</p><br><br>
<table width="300" border="0" cellspacing="0" cellpadding="0" >
  <tr>
  	{if $rights.role.add || $admin_auth_key}
    <td align="center" width="50%" class="f14bold">
	<a href="javascript:;" onclick="addTab('{"Role/add"|U}','{"guide_new_role"|L}',1);"><img src="__PUBLIC__/Images/Guide/newrole.gif" width="32" height="32" /><br /><br />{$lang.guide_new_role}</a></td>
	{/if}
	{if $rights.user.add || $admin_auth_key}
    <td align="center" class="f14bold">
	<a href="javascript:;" onclick="addTab('{"User/add"|U}','{"guide_new_user"|L}',1);" ><img src="__PUBLIC__/Images/Guide/newuser.gif" width="32" height="32" /><br /><br />{$lang.guide_new_user}</a></td>
	{/if}
  </tr>
</table>
{/if}
</div>

