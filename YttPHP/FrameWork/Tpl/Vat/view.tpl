{wz is_update=!($rs.confirm_status==3&&$login_user.role_type==C('SELLER_ROLE_TYPE'))}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
    	<tr>
			<input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}">
      		<td>{$lang.factory_name}：</td>
      		<td class="t_left">{$rs.factory_name}</td>
    	</tr>
		<tr>
      		<td>{$lang.belongs_country}：</td>
      		<td class="t_left">{$rs.full_country_name}</td>
    	</tr>
		<tr>
      		<td >{$lang.vat}：</td>
      		<td class="t_left">{$rs.vat_no}</td>
    	</tr>
		<tr>
			<td>{$lang.confirm_status}：</td>
			<td class="t_left">{$rs.dd_confirm_status}</td>
		</tr>
		{if $rs.vat_file}
			<tr>
				<td>{$lang.attachment}：</td>
				<td class="t_left">
					{foreach $rs.vat_file as $val}
						<div id="file_view_{$val.id}">
							<a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
						</div>
					{/foreach}
				<td>
			</tr>
		{/if}
	</tbody>
</table>
</div>
