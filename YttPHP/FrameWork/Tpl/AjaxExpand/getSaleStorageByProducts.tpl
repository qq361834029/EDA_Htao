<table id="index" class="list" border=0>
<thead><tr>
<th width="">{$lang.product_no}</th>
<th width="">{$lang.product_name}</th>
{if 'storage_color'|C}<th width="">{$lang.color_name}</th>{/if}
{if 'storage_size'|C}<th width="">{$lang.size_name}</th>{/if}
<th width="">{$lang.quantity}</th>
{if 'storage_format'|C>=2}<th width="">{$lang.capability}</th>{/if}
{if 'storage_format'|C>=3}<th width="">{$lang.dozen}</th>{/if}
{if 'storage_format'|C>1}<th width="">{$lang.sum_quantity}</th>{/if}
{if 'storage_mantissa'|C}<th width="">{$lang.mantissa_2}</th>{/if}
</tr>
</thead>
<tbody>
{foreach item=item from=$list.list}
<tr>

<td width="" {if $item.product_no==''}class="b_top_load"{/if}>{$item.product_no}{if $item.product_no!=''}{autoshow}{/if}</td>

<td width="" {if $item.product_name==''}class="b_top_load"{/if}>{$item.product_name}</td>
{if 'storage_color'|C}<td width="" {if $item.color_name==''}class="b_top_load"{/if}>{$item.color_name}</td>{/if}
{if 'storage_size'|C}<td width="" {if $item.size_name==''}class="b_top_load"{/if}>{$item.size_name}</td>{/if}
<td  class="t_right">{$item.dml_quantity}</td>
{if 'storage_format'|C>=2}<td  class="t_right">{$item.dml_capability}</td>{/if}
{if 'storage_format'|C>=3}<td  class="t_right">{$item.dml_dozen}</td>{/if}
{if 'storage_format'|C>1}<td  class="t_right">{$item.dml_sale_storage}</td>{/if}
{if 'storage_mantissa'|C}<td class="t_center">{if $item.mantissa==2}√{/if}</td>{/if}
</tr>
{/foreach}
</tbody>
</table>