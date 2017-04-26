<form action="{'AmazonAccount/insert'|U}" method="POST"  onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" > 
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<td class="width15">{$lang.short_account}：</td>
			<td class="t_left">
				<input type="text" name="user_id" id="user_id" class="spc_input" >__*__
			</td>
		</tr>
		<tr>
			<td class="width15">{$lang.amazon_account}：</td>
			<td class="t_left">
				<input type="text" name="full_user_id" id="full_user_id" class="spc_input" >__*__
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
				<input type="hidden" name="marketplace_id" id="marketplace_id" class="spc_input" />
				<input type="text" name='site_name' url="{'AutoComplete/amazonSiteId'|U}" jqac />__*__
			</td>
		</tr> 
		<tr>
			<td>{$lang.access_key_id}：</td>
			<td class="t_left">
				<input type="text" name="access_key_id" id="access_key_id" class="spc_input" />__*__
				<span><a href="https://developer.amazonservices.de/" target="_blank">{$lang.amazon_authorization_information}</a></span>
			</td>
		</tr>  
		<tr>
			<td>{$lang.secret_acess_key_id}：</td>
			<td class="t_left">
				<input type="text" name="secret_acess_key_id" id="secret_acess_key_id" class="spc_input" />__*__
			</td>
		</tr> 
		<tr>
			<td>{$lang.merchant_id}：</td>
			<td class="t_left">
				<input type="text" name="merchant_id" id="merchant_id" class="spc_input" />__*__
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