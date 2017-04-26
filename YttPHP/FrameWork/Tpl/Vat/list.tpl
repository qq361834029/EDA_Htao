<table  class="list" border="1">
	<tr>
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}<th>{$lang.belongs_seller}</th>{/if}
		{if $login_user.role_type!=C('WAREHOUSE_ROLE_TYPE')}<th>{$lang.belongs_country}</th>{/if}
		<th>{$lang.vat}</th>
		<th>{$lang.attachment}</th>
		<th>{$lang.confirm_status}</th>
		<th>{$lang.operation}</th>
	</tr>
	{tr from=$list.list }
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
			<td><a  href="javascript:;" onclick="addTab('{"/Factory/view/id/`$item.factory_id`"|U}','{"view"|title:"Factory"}',1)">{$item.factory_name}</a></td>
		{/if}
		{if $login_user.role_type!=C('WAREHOUSE_ROLE_TYPE')}<td>{$item.district_name}</td>{/if}
		{td link=['url'=>'Vat/view','link_id'=>['id'=>'id']]}
			{$item.vat_no}
		{/td}
		<td class="t_center">{$item.attachment}</td>
		<td class="t_center">{$item.dd_confirm_status}</td>
		<td class="operate">
			{if $login_user.role_type==C('SELLER_ROLE_TYPE') && $item.confirm_status!=3}
				<span class="icon icon-list-edit" onclick="$.edit(this);" title="{"edit"|title}" url="__URL__/edit/id/{$item.id}"></span>
				<span class="icon icon-list-del" onclick="$.cancel(this);" title="{"delete"|title}" url="__URL__/delete/id/{$item.id}"></span>
			{/if}
			{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
				<span class="icon icon-list-hand" onclick="$.edit(this);" title="{"check"|title}" url="__URL__/edit/id/{$item.id}"></span>
			{/if}
		</td>
	{/tr}
</table>