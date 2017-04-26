{tr from=$list.list }
	{if $item.color==1}
		{assign var='td_class' value='red'}
	{else}
		{assign var='td_class' value=''}
	{/if}
	{td merge='class_name,color' class="$td_class {if $item.color==1}t_right{/if}"} 
		{if $item.color==1}
			{$item.class_name}
		{else}
			<a href="javascript:;" onclick="addTab('{$item.view_url}','{"saleStatDetail"|title:"StatSale"}',1); "> 
				{$item.class_name}
			</a>
		{/if} 
	{/td}
	{td merge='class_name,color' class="$td_class t_right"}
		{if $item.color==0} 
			<a href="javascript:;" onclick="addTab('{$item.sale_url}','{"saleStatDetail"|title:"StatSale"}',1); "> 
				{$item.dml_sale_quantity} 
			</a>
		{else}
			{$item.dml_sale_quantity}
		{/if}
	{/td}
	{td merge='class_name,color' class="$td_class t_right"} 
		{if $item.color==0}
			<a href="javascript:;" onclick="addTab('{$item.return_use_url}','{"saleStatDetail"|title:"StatSale"}',1); "> 
			{$item.return_use_quantity} 
			</a>
		{else}
			{$item.return_use_quantity}
		{/if}
	{/td}
	{td merge='class_name,color' class="$td_class t_right"} 
		{if $item.color==0}
			<a href="javascript:;" onclick="addTab('{$item.return_unuse_url}','{"saleStatDetail"|title:"StatSale"}',1); "> 
				{$item.return_unuse_quantity} 
			</a>
		{else}
			{$item.return_unuse_quantity}
		{/if}
	{/td}
	{if $client_currency!=1}
	{td class="$td_class"} {$item.currency_no} {/td}
	{/if}
	{td class="$td_class t_right"} {$item.dml_sale_money } {/td}
	{td class="$td_class t_right"} {$item.dml_return_money } {/td}
{/tr}