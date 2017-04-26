{searchForm}
<div id="print">
{wz}
<div class="add_box">
<table class="add_table">
	<tr>
		<td >
			<div class="product_basic">
				<ul>
					<li class="t_right tbold">{$lang.product_no}：</li>
					<li class="t_left">{$list.total.product_no}</li>
					<li class="t_right tbold">{$lang.product_name}：</li>
					<li class="t_left">{$list.total.product_name}</li>
				</ul>
			</div>
		</td>
	</tr>
	<tr>
		<td>
		{if $smarty.get.type=='order'}
			{include file='StatProduct/orderUnload.tpl'}
		{/if}	
		{if $smarty.get.type=='load'}
			{include file='StatProduct/loadUninstock.tpl'}
		{/if}
		</td>
	</tr>
</table>
</div>
</div>