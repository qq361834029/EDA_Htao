<table id="index" class="list" border=1>
<thead><tr>
<th width="">{$lang.product_no}</th>
<th width="">{$lang.product_name}</th>
{if 'storage_color'|C==1}<th width="">{$lang.color_name}</th>{/if}
{if 'storage_color'|C==1}<th width="">{$lang.size_name}</th>{/if}
<th width="">{$lang.container_no}</th>
<th width="">{$lang.quantity}</th>
{if 'storage_format'|C>=2}<th width="">{$lang.capability}</th>{/if}
{if 'storage_format'|C>=3}<th width="">{$lang.dozen}</th>{/if}
<th width="">{$lang.sum_quantity}</th>
<th width="">{$lang.type}</th>
</tr>
</thead>
<tbody>
{foreach item=item from=$list.list}
<tr>
<td width="">{$item.product_no}</td>
<td width="">{$item.product_name}</td>
{if 'storage_color'|C==1}<td width="">{$item.color_name}</td>{/if}
{if 'storage_color'|C==1}<td width="">{$item.size_name}</td>{/if}
<td width=""><a href="javascript:;" onclick="addTab('{"/LoadContainer/view/id/`$item.load_container_id`"|U}','{"view"|title:"LoadContainer"}')">{$item.container_no}</a></td>
<td width="">{$item.quantity}</td>
{if 'storage_format'|C>=2}<td width="">{$item.capability}</td>{/if}
{if 'storage_format'|C>=3}<td width="">{$item.dozen}</td>{/if}
<td width="">{$item.sum_quantity}</td>
<td width="">{$item.dd_mantissa}</td>
</tr>
{/foreach}
</tbody>
</table>