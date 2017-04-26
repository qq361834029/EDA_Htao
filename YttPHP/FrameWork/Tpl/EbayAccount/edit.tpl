<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/layer.css" />
<form action="{'EbayAccount/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" > 
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<input type="hidden" name="token" id="token" value="{$rs.token}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<td class="width10">{$lang.ebay_account}：</td>
			<td class="t_left">
				<input type="hidden" name="user_id" id="user_id" value="{$rs.user_id}" class="spc_input" >{$rs.user_id}
			</td>
		</tr>
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
			<tr>
			<td>{$lang.belongs_seller}：</td>
			<td class="t_left"> 
			<input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}"> 
			{if $rs.factory_readonly}
			{$rs.factory_name}
			{else} 
			{$rs.factory_name}
			{/if}
			</td>
			</tr>
		{/if}
		<tr>
			<td>{$lang.site_id}：</td>
			<td class="t_left">
				<input type="hidden" name="site_id" id="site_id" value="{$rs.site_id}" class="spc_input" />
				<input type="text" value="{$rs.site}" url="{'AutoComplete/ebaySiteId'|U}" jqac />__*__
			</td>
		</tr>
		<tr>
			<td>{$lang.country_range}：</td>
			<td class="t_left">
				<input type="radio" name="country_range" checked value="1"/ onchange="javascript:$dom.find('#country_name_tr').hide();">{$lang.full}
				<input type="radio" name="country_range" {if $rs.country_range==2} checked{/if} value="2"/ onchange="javascript:$dom.find('#country_name_tr').show();">{$lang.select_country}__*__
			</td>
		</tr>
		<tr id="country_name_tr" {if $rs.country_range==1}style="display:none"{/if}>
			<td>{$lang.country_name}：</td>
			<td class="t_left" id="span_country_name">
				<input type="hidden" name="detail[1][country_id]" value="{$rs.country_id}">
				<textarea name="country_name" id="country_name" onclick="selectCountry(this);return false;" readonly="readonly" style="height:40px" class="w200">{$rs.country_name}</textarea>
			</td>
		</tr>
		<tr>
			<td>{$lang.synchrodata}：</td>
			<td class="t_left">
				<input type="radio" name="synchrodata" value="1" {if $rs.synchrodata == 1} checked {/if}/>{$lang.auto}
				<input type="radio" name="synchrodata" value="0" {if $rs.synchrodata == 0} checked {/if}/>{$lang.manul}__*__
			</td>
		</tr>	
		<tr>
			<td>{$lang.token_status}：</td>
			<td class="t_left">
				{$rs.token_status}
			</td>
		</tr>	
		<tr>
			<td>{$lang.token_expiration_time}：</td>
			<td class="t_left">
				{$rs.expiration_time}
			</td>
		</tr>     			
	</tbody>
</table>  
</div>
</form>
<script type="text/javascript">
function selectCountry(obj){
	var data = {$country};
	$(obj).mulitselector({
		title:lang['basic']['select_country'],
		data:data,
		autosearch: '<input type="hidden" name="auto_country_id" id="auto_country_id">'+
			    '<input type="text" id="auto_country" name="auto_country" class="w150" url="{'AutoComplete/country'|U}" jqac>',
		splitchar:";",
		callback: ""
	});
}
</script>