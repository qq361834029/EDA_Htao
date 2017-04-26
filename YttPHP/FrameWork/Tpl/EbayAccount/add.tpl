<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/layer.css" />
<form action="{'EbayAccount/insert'|U}" method="POST"  onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" > 
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<td class="width10">{$lang.ebay_account}：</td>
			<td class="t_left">
				<input type="text" name="user_id" id="user_id" class="spc_input" >__*__
			</td>
		</tr>
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
			<tr>
				<td>{$lang.belongs_seller}：</td>
				<td class="t_left">
				<input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
				<input id="factory_name" name="temp[factory_name]" value="{$fac_name}" url="{'/AutoComplete/factory'|U}" jqac>__*__
				</td>
			</tr>    
			{else}
			<input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
		{/if}
		<tr>
			<td>{$lang.site_id}：</td>
			<td class="t_left">
				<input type="hidden" name="site_id" id="site_id" class="spc_input" />
				<input type="text" url="{'AutoComplete/ebaySiteId'|U}" jqac />__*__
			</td>
		</tr>
		<tr>
			<td>{$lang.country_range}：</td>
			<td class="t_left">
				<input type="radio" name="country_range" checked value="1"/ onchange="javascript:$dom.find('#country_name_tr').hide();">{$lang.full}
				<input type="radio" name="country_range" value="2"/ onchange="javascript:$dom.find('#country_name_tr').show();">{$lang.select_country}__*__
			</td>
		</tr>
		<tr id="country_name_tr" style="display:none">
			<td>{$lang.country_name}：</td>
			<td class="t_left" id="span_country_name">
				<input type="hidden" name="detail[1][country_id]" value="">
				<textarea name="country_name" id="country_name" onclick="selectCountry(this);return false;" readonly="readonly" style="height:40px" class="w320">{$item.country_name}</textarea>
			</td>
		</tr>
		<tr>
			<td>{$lang.synchrodata}：</td>
			<td class="t_left">
				<input type="radio" name="synchrodata" checked value="1"/>{$lang.auto}
				<input type="radio" name="synchrodata" value="0"/>{$lang.manul}__*__
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