{wz}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <tr>
	<td class="width15">{$lang.short_account}：</td>
	<td class="t_left">
		{$rs.user_id}
	</td>
    </tr>
    <tr>
      <td class="width15">{$lang.amazon_account}：</td>
      <td class="t_left">{$rs.full_user_id}
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
		<td>{$lang.access_key_id}：</td>
		<td class="t_left">
			{$rs.access_key_id}
		</td>
	</tr>  
	<tr>
		<td>{$lang.secret_acess_key_id}：</td>
		<td class="t_left">
			{$rs.secret_acess_key_id}
		</td>
	</tr> 
	<tr>
		<td>{$lang.merchant_id}：</td>
		<td class="t_left">
			{$rs.merchant_id}
		</td>
	</tr>  	
	<tr>
		<td>{$lang.marketplace_id}：</td>
		<td class="t_left">
			{$rs.marketplace_id}
		</td>
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
    </tbody>
  </table> 
</div>