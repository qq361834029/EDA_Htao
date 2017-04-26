<table class="detail_list" border=0 id="product_{$pid}" style="margin-bottom:15px;">
<thead><tr>
{if $smarty.post.show_warehouse}<th width="15px">&nbsp;</th>{/if}
<th width="">{$lang.product_no}</th>
<th width="">{$lang.product_name}</th>
{if 'storage_color'|C}<th width="">{$lang.color_name}</th>{/if}
{if 'storage_size'|C}<th width="">{$lang.size_name}</th>{/if}
<th width="">{$lang.quantity}</th>
{if 'storage_format'|C>=2}<th width="">{$lang.capability}</th>{/if}
{if 'storage_format'|C>=3}<th width="">{$lang.dozen}</th>{/if}
{if 'storage_format'|C>1}<th width="">{$lang.sum_quantity}</th>{/if}
{if 'storage_mantissa'|C}<th width="">{$lang.mantissa_2}</th>{/if}
{if 'multi_storage'|C==1}<th width="">{$lang.warehouse}</th>{/if}
</tr>
</thead>
<tbody>
{foreach item=item from=$list.list}
<tr>
{if $smarty.post.show_warehouse}<td><a href="javascript:void(0)" expand="0" onclick="$.expand(this)" url="{'Ajax/storageExtend'|U}" where="{"\"product_id\":`$item.product_id`,\"color_id\":`$item.color_id`,\"size_id\":`$item.size_id`,\"capability\":`$item.capability`,\"dozen\":`$item.dozen`"|urlencode}"><span class="icon icon-pattern-plus"></span></a></td>{/if}

<td width="">{$item.product_no}{autoshow}</td>

<td width="">{$item.product_name}</td>
{if 'storage_color'|C}<td width="">{$item.color_name}</td>{/if}
{if 'storage_size'|C}<td width="">{$item.size_name}</td>{/if}
<td class="t_right">{$item.dml_quantity}</td>
{if 'storage_format'|C>=2}<td class="t_right">{$item.dml_capability}</td>{/if}
{if 'storage_format'|C>=3}<td class="t_right">{$item.dml_dozen}</td>{/if}
{if 'storage_format'|C>1}<td class="t_right">{$item.dml_real_storage}</td>{/if}
{if 'storage_mantissa'|C}<td class="t_center">{if $item.mantissa==2}√{/if}</td>{/if}
{if 'multi_storage'|C==1}<td >{$item.w_name}</td>{/if}
</tr>
{/foreach}
</tbody>
</table>
