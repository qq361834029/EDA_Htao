{searchForm}
<div id="print">
{wz print=true printid=".add_box"}
<div class="add_box">
<table class="add_table">
	<tr>
		<td >
			<div class="product_basic">
				<ul>
					<li class="t_right tbold">{$lang.product_no}：</li>
					<li class="t_left">{$list.product.product_no}</li>
					<li class="t_right tbold">{$lang.product_name}：</li>
					<li class="t_left">{$list.product.product_name}</li>
				</ul>
			</div>
		</td>
	</tr>
	<tr>
		<td>
        {if $smarty.get.type=='Onroad'}
			{include file="StatProduct/productOnroad.tpl"}
		{/if}
		{if $smarty.get.type=='Instock'}
			{include file='StatProduct/productInstockDetail.tpl'}
		{/if}
		{if $smarty.get.type=='Sale'|| $smarty.get.type=='OutStock' }
			{include file='StatProduct/productSaleDetail.tpl'}
		{/if}
		{if $smarty.get.type=='Return'}
			{include file='StatProduct/productReturnDetail.tpl'}
		{/if}
        {if $smarty.get.type=='ReturnStorage'}
			{include file='StatProduct/productReturnStorage.tpl'}
		{/if}
		{if $smarty.get.type=='Adjust'}
			{include file='StatProduct/productAdjustDetail.tpl'}
		{/if}			
        {if $smarty.get.type=='Undeal'}
			{include file='StatProduct/productUndeal.tpl'}
		{/if}	
        {if $smarty.get.type=='Backshelves'}
			{include file='StatProduct/productBackshelves.tpl'}
		{/if}	
        {if $smarty.get.type=='OutBatch'}
			{include file='StatProduct/productOutBatch.tpl'}
		{/if}	
        {if $smarty.get.type=='Dropped'}
			{include file='StatProduct/productDropped.tpl'}
		{/if}	
		 {if $smarty.get.type=='ShiftWarehouse'}
			{include file='StatProduct/productShiftWarehouse.tpl'}
		{/if}
		</td>
	</tr>
</table>
</div>
</div>