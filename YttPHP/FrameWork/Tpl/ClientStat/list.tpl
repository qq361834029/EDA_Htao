{assign var='colspan' value=0}
<table  class="list" border="1">
	<tr>
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		{assign var='colspan' value=$colspan+4}
		<th rowspan="1">{$lang.factory_name}</th> 
		<th rowspan="1">{$lang.contact}</th> 
		<th rowspan="1">{$lang.mobile}</th> 
		<th rowspan="1">{$lang.email}</th>  
		{/if}
		{* 当客户交易币种只有一种时不显示“币种编号”列 *}
		{if client_currency_count|C>1}
		{assign var='colspan' value=$colspan+1}
		<th rowspan="1">{$lang.currency_no}</th>
		{/if}
		{* 配置多公司才显示 总金额 *}
		{if show_many_basic|C==1}
		{assign var='colspan' value=$colspan+2}
		<th rowspan="1">{$lang.total_money}</th> 
		<th rowspan="1">{$lang.basic_name}</th>
		{/if}
		<th rowspan="1">{$lang.money}</th> 
	</tr> 
	{if $list.list}
	{tr from=$list.list}
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		{td merge='comp_id' title="{$lang.total}" class="t_left"}
			{$item.factory_name}
		{/td}
		{td merge='comp_id' class="t_left"}
			{$item.contact}
		{/td}
		{td merge='comp_id' class="t_left"}
			{$item.mobile}
		{/td}
		{td merge='comp_id' class="t_left"}
			{$item.email}
		{/td}
		{/if}
		{* 当客户交易币种只有一种时不显示“币种编号”列 *}
		{if client_currency_count|C>1}
		{td merge='comp_id,currency_id'}
			{$item.currency_no}
		{/td} 
		{/if}
		{* 配置多公司才显示 总金额 *}
		{if show_many_basic|C==1}
		{td merge='comp_id,currency_id' class="t_right"}
			{$item.dml_total_comp_need_paid}
		{/td}
		{td  merge='comp_id,currency_id,basic_id' class="t_left"}
			{$item.basic_name}
		{/td} 
		{/if}
		{td total_link=false class="t_right"} 
			<a href="javascript:;" onclick="addTab('{$item.detail_url}','{$lang.view_detail}',1); ">
			{$item.dml_total_need_paid}
			</a>
		{/td}
	{/tr}
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
	<tr class="red">  
		<td class="t_right" colspan="{$colspan}">{$lang.page_total}：</td>
		<td class="t_right" colspan="{$colspan}">{$list.total.total_currency_info_0}</td>
	</tr>
	<tr class="red">  
		<td class="t_right" colspan="{$colspan}">{$lang.total}：</td>
		<td class="t_right" colspan="{$colspan}">{$list.page_total.total.total_currency_info_0}</td>
	</tr>
	{/if}
	{else}
		{assign var=cols_num value=5}
		{if client_currency_count|C>1}
			{assign var=cols_num value=$cols_num+1}
		{/if}
		{if show_many_basic|C==1}
			{assign var=cols_num value=$cols_num+2}
		{/if}
		<tr><td colspan="{$cols_num}">{$lang.no_record_for_search}</td></tr>
	{/if}
</table>
<br><br>