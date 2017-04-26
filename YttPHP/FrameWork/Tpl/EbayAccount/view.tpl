{wz}
<div class="add_box">
	<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>   
		<tr>
			<td class="width10">{$lang.ebay_account}：</td>
			<td class="t_left">{$rs.user_id}
			</td>
		</tr>   
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
			<tr>
				<td>{$lang.belongs_seller}：</td>
				<td class="t_left">{$rs.factory_name}</td>
			</tr>
		{/if}



		<tr>
			<td>{$lang.site_id}：</td>
			<td class="t_left">{$rs.site}</td>      
		</tr>    
		<tr>
			<td>{$lang.synchrodata}：</td>
			<td class="t_left">
			{if $rs.synchrodata==0}
			{L('manul')}
			{else}
			{L('auto')}
			{/if}
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