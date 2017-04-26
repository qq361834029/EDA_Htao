<table border="0" cellspacing="0" cellpadding="0" style="width:100%;font-size:12px;">
  <tr id="total_factory">
    <td style="border:1px solid #CCCCCC;background-color: #F6F5F5;height:26px; line-height:26px;text-align:center;padding:0 3px;font-weight: bold;border-right-style:none;">{$lang.factory_name}</td>
    {if C('loadContainer.storage_format')>1}
    	<td  style="border:1px solid #CCCCCC;background-color: #F6F5F5;height:26px; line-height:26px;text-align:center;padding:0 3px;font-weight: bold;border-right-style:none;" width="100">{$lang.load_quantity}</td>
    {/if}
    <td  style="border:1px solid #CCCCCC;background-color: #F6F5F5;height:26px; line-height:26px;text-align:center;padding:0 3px;font-weight: bold;border-right-style:none;" width="100">{$lang.load_sum_quantity}</td>
    <td  style="border:1px solid #CCCCCC;background-color: #F6F5F5;height:26px; line-height:26px;text-align:center;padding:0 3px;font-weight: bold;" width="150">{$lang.load_money}</td> 
  </tr> 
  {foreach item=item from=$factory_list.list}
  	<tr id="{$item.factory_id}_{$item.currency_id}_tr">
  		<td id="{$item.factory_id}_{$item.currency_id}_factory"  style="border:1px solid #CCCCCC;height:26px; line-height:26px;text-align:left;padding:0 3px;border-right-style:none;border-top-style:none;">{$item.factory_name}</td>
  			<td id="{$item.factory_id}_{$item.currency_id}_quantity" style="border:1px solid #CCCCCC;height:26px; line-height:26px;text-align:right;padding:0 3px;border-right-style:none;border-top-style:none;">{$item.dml_quantity}</td>
  		{if C('loadContainer.storage_format')>1}
  			<td id="{$item.factory_id}_{$item.currency_id}_sumquantity" style="border:1px solid #CCCCCC;height:26px; line-height:26px;text-align:right;padding:0 3px;border-right-style:none;border-top-style:none;">{$item.dml_capability}</td>
  		{/if}
  		<td id="{$item.factory_id}_{$item.currency_id}_money" style="border:1px solid #CCCCCC;height:26px; line-height:26px;text-align:right;padding:0 3px;border-top-style:none;">{$item.dml_price}</td>
  	</tr>
  {/foreach}
	  <tr>
	    <td style="border:1px solid #CCCCCC;height:26px; line-height:26px;text-align:right;padding:0 3px;font-weight:bold;border-right-style:none;border-top-style:none;">{$lang.total}：</td>
	    	<td style="border:1px solid #CCCCCC;height:26px; line-height:26px;text-align:right;padding:0 3px;font-weight:bold;color:#ff0000;border-right-style:none;border-top-style:none;" id="total_factory_quantity" >{$rs.detail_total.dml_quantity}</td>
	    {if C('loadContainer.storage_format')>1}
	    	<td style="border:1px solid #CCCCCC;height:26px; line-height:26px;text-align:right;padding:0 3px;font-weight:bold;color:#ff0000;border-right-style:none;border-top-style:none;" class="t_right_red" id="total_factory_sumquantity" >{$rs.detail_total.dml_sum_quantity}</td>
	    {/if}
	    	<td style="border:1px solid #CCCCCC;height:26px; line-height:26px;text-align:right;padding:0 3px;font-weight:bold;color:#ff0000;border-top-style:none;" class="t_right_red" id="total_factory_money" >{$rs.detail_total.dml_money}</td> 
	  </tr>
</table>