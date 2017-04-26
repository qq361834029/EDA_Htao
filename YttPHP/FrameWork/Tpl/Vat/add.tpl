<form action="{'Vat/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="comp_type" value="1">
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<table cellspacing="0" cellpadding="0" class="add_table" align="center">
    <tbody>
		<tr>
      		<td>{$lang.factory_name}：</td>
      		<td class="t_left">
				<input type="hidden" name="factory_id" id="factory_id" value="{if $login_user.role_type==C('SELLER_ROLE_TYPE')}{$login_user.company_id}{/if}">
				{if $login_user.role_type==C('SELLER_ROLE_TYPE')}
				<input type="text" name="comp_name" class="spc_input disabled" value="{$login_user.user_name}" readonly>__*__
				{else}
				<input type="text" name="comp_name" value="" url="{'AutoComplete/factory'|U}" jqac />__*__
				{/if}
      		</td>
    	</tr>
		<tr>
      		<td>{$lang.belongs_country}：</td>
      		<td class="t_left">
			<input type="hidden" name="country_id" id="country_id" value="{$country_id}">
			<input type="text" name="temp[full_country_name]" {if $login_user.role_type==C('WAREHOUSE_ROLE_TYPE')}value="{$country_name}" class="spc_input disabled" readonly{else}url="{'AutoComplete/country'|U}" jqac{/if}>__*__
      		</td>
    	</tr>
		<tr>
      		<td >{$lang.vat}：</td>
      		<td class="t_left">
      			<input type="text" name="vat_no" value="" class="spc_input" >__*__
      		</td>
    	</tr>
		<tr>
			<td>{$lang.upload_vat_file}：</td>
			<td class="t_left">
				{upload tocken=$file_tocken multi=true sid=$fid type=32 allowTypes="all"}
			</td>
		</tr>
	</tbody>
</table>
</div>
</form>