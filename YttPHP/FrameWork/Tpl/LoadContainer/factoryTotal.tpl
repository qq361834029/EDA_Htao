<table border="0" cellspacing="0" cellpadding="0" class="load_list">
  <tr id="total_factory" bgcolor="#F6F5F5">
    <td class="t_center tbold">{$lang.factory_name}</td>
    {if C('loadContainer.storage_format')>1}
    	<td class="t_center tbold" width="100">{$lang.load_quantity}</td>
    {/if}
    <td class="t_center tbold" width="100">{$lang.load_sum_quantity}</td>
    <td class="t_center tbold" width="150">{$lang.load_money}</td> 
  </tr> 
  {foreach item=item from=$factory_list.list}
  	<tr id="{$item.factory_id}_{$item.currency_id}_tr">
  		<td id="{$item.factory_id}_{$item.currency_id}_factory"  class="t_left">{$item.factory_name}</td>
  			<td id="{$item.factory_id}_{$item.currency_id}_quantity">{$item.dml_quantity}</td>
  		{if C('loadContainer.storage_format')>1}
  			<td id="{$item.factory_id}_{$item.currency_id}_sumquantity">{$item.dml_capability}</td>
  		{/if}
  		<td id="{$item.factory_id}_{$item.currency_id}_money">{$item.dml_price}</td>
  	</tr>
  {/foreach}
	  <tr>
	    <td>{$lang.total}：</td>
	    	<td class="t_right_red" id="total_factory_quantity" >{$rs.detail_total.dml_quantity}</td>
	    {if C('loadContainer.storage_format')>1}
	    	<td class="t_right_red" id="total_factory_sumquantity" >{$rs.detail_total.dml_sum_quantity}</td>
	    {/if}
	    	<td class="t_right_red" id="total_factory_money" >{$rs.detail_total.dml_money}</td> 
	  </tr>
</table>