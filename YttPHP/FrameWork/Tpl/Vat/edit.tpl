<form action="{'Vat/update'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<input type="hidden" name="id" id="id" value="{$rs.id}">
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
{*<input type="hidden" name="role_id" id="role_id" value="{C('SELLER_ROLE_ID')}" />*}
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    	<tr>
			<input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}">
      		<td>{$lang.factory_name}：</td>
      		<td class="t_left">
				<input type="text" name="comp_name" class="spc_input disabled" value="{$rs.factory_name}" readonly>__*__
      		</td>
    	</tr>
		<tr>
      		<td>{$lang.belongs_country}：</td>
      		<td class="t_left">
				<input type="hidden" name="country_id" id="country_id" value="{$rs.country_id}">
				<input type="text" name="temp[full_country_name]" value="{$rs.full_country_name}" {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}class="spc_input disabled" readonly{else}url="{'AutoComplete/country'|U}" jqac{/if}>__*__
      		</td>
    	</tr>
		<tr>
      		<td >{$lang.vat}：</td>
      		<td class="t_left">
      			<input type="text" name="vat_no" value="{$rs.vat_no}" {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}class="spc_input disabled" readonly{else}class="spc_input"{/if}>__*__
      		</td>
    	</tr>
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
		<tr>
			<td>{$lang.confirm_status}：</td>
			<td class="t_left">
				{select data=C('VAT_CONFIRM_STATUS') name="confirm_status" id="confirm_status" initvalue=$rs.confirm_status combobox=1 empty=true}__*__
			</td>
		</tr>
		{else}
			<tr><input type="hidden" name="confirm_status" id="confirm_status" value="{$rs.confirm_status}">
				<td>{$lang.confirm_status}：</td><td class="t_left">{$rs.dd_confirm_status}</td>
			</tr>
			<tr>
				<td>{$lang.upload_vat_file}：</td>
				<td class="t_left">{upload tocken=$file_tocken multi=true sid=$fid type=32 allowTypes="all"}</td>
			</tr>
		{/if}
		{if $rs.vat_file}
		<tr id='vat_file_show'>
			<td>{$lang.attachment}：</td>
			<td class="t_left">
				{foreach $rs.vat_file as $val}
					<div id="file_view_{$val.id}">
						<a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
						{if $login_user.role_type==C('SELLER_ROLE_TYPE')}
						<a onclick="$.deleteFile({$val.id})" href="javascript:;">
							<img border="0" src="__PUBLIC__/Images/Default/close_gray.png">
						</a>
						{/if}
					</div>
				{/foreach}
			<td>
		</tr>
		{/if}
	</tbody>
</table>
</div>
</form>

