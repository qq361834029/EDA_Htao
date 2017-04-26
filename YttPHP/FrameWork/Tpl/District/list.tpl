{*{ytt_table
	show=[
		['value'=>'abbr_district_name','title'=>$lang.country_no,'width'=>'30%'],
		["value"=>"a_name","title"=>L('country_name'),'width'=>'50%',"link"=>["url"=>"District/view","link_id"=>['id'=>"id"]]]
	]
	expand=true
	expandAction="getDistrictList"	
	from=$list.list
	sort=["a_name"=>["sort_by"=>0,"sort_action"=>"index"],"abbr_district_name"=>["sort_by"=>0,"sort_action"=>"index"]]
	operate=$login_user.role_type==C('WAREHOUSE_ROLE_TYPE')
	operate_show=[
		["role"=>'update','show'=>$login_user.role_type==C('WAREHOUSE_ROLE_TYPE'),'class'=>'icon icon-list-edit','url'=>"{$smarty.const.MODULE_NAME}/edit",'link_id'=>['id'=>'id'],'onclick'=>'$.edit(this)','title'=>$lang.edit]
	]
}*}
<table  class="list" border="1">
	<tr>
		<th class="width10">&nbsp;</th>
		<th class="width30">{$lang.country_no}</th>
		<th class="width50">{$lang.country_name}</th>
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}<th>{$lang.operation}</th>{/if}
	</tr>
	{tr name='{$key+1}' id="index_{$item.id}_{$key+1}" expand="1" from=$list.list }
		<td id="expand" class="operate" width="100" align="center" expand="1">
			<a href="javascript:void(0)" onclick="$.showExpand('getDistrictList','index_{$item.id}_{$key+1}',{$item.id});"><span class="icon icon-pattern-plus"></span></a>
		</td>
		<td>{$item.abbr_district_name}</td>
		{td link=['url'=>'District/view','link_id'=>['id'=>'id']]}
			{$item.a_name}
		{/td}
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
		<td class="operate">
			{if $login_user.role_type!=C('WAREHOUSE_ROLE_TYPE')}
				<span class="icon icon-list-edit" onclick="$.edit(this);" title="{"edit"|title}" url="__URL__/edit/id/{$item.id}"></span>
			{else if $login_user.role_type==C('WAREHOUSE_ROLE_TYPE') && $item.id==$ware_country_id}
				<span class="icon icon-list-edit" onclick="$.edit(this);" title="{"edit"|title}" url="__URL__/edit/id/{$item.id}"></span>
			{/if}
		</td>
		{/if}
	{/tr}
</table>