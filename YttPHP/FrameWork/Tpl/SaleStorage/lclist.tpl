<table id="index" class="list" border=0>
<thead><tr>
<th width="">{$lang.product_no}</th>
<th width="">{$lang.product_name}</th>
{if 'loadContainer.color'|C==1}<th width="">{$lang.color_name}</th>{/if}
{if 'loadContainer.size'|C==1}<th width="">{$lang.size_name}</th>{/if}
<th width="">{$lang.container_no}</th>
<th width="">{$lang.quantity}</th>
{if 'loadContainer.storage_format'|C>=2}<th width="">{$lang.capability}</th>{/if}
{if 'loadContainer.storage_format'|C>=3}<th width="">{$lang.dozen}</th>{/if}
{if 'loadContainer.storage_format'|C>1}<th width="">{$lang.sum_quantity}</th>{/if}
{if 'loadContainer.mantissa'|C==1}<th width="">{$lang.mantissa_2}</th>{/if}
</tr>
</thead>
<tbody>
{foreach item=item from=$list.list}
<tr>

<td {if $item.product_no==''}class="b_top_load">&nbsp;{else}>{$item.product_no}{autoshow}{/if}</td>
<td width="" {if $item.product_name==''}class="b_top_load"{/if}>{$item.product_name}</td>

{if 'loadContainer.color'|C==1}<td width="">{$item.color_name}</td>{/if}
{if 'loadContainer.size'|C==1}<td width="">{$item.size_name}</td>{/if}
<td width="">{$item.container_no}</td>
<td  class="t_right">{$item.dml_quantity}</td>
{if 'loadContainer.storage_format'|C>=2}<td  class="t_right">{$item.dml_capability}</td>{/if}
{if 'loadContainer.storage_format'|C>=3}<td  class="t_right">{$item.dml_dozen}</td>{/if}
{if 'loadContainer.storage_format'|C>1}<td  class="t_right">{$item.dml_sum_quantity}</td>{/if}
{if 'loadContainer.mantissa'|C==1}<td  class="t_center">{if $item.mantissa==2}√{/if}</td>{/if}
</tr>
{/foreach}
</tbody>
</table>