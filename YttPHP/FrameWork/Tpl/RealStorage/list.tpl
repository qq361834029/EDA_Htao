<table id="index" class="list" border=0>
<thead>
	<tr>
		<th>&nbsp;</th>
		<th>{$lang.class_name}</th>
		{if 'storage_format'|C>=2}<th width="">{$lang.index_sum_quantity}</th>{/if}
		<th>{$lang.sum_quantity}</th>
	</tr>
</thead>
<tbody>
{foreach item=item from=$list.list}
<tr id="index_{$item.product_class_id}_{$key}" expand="1">
<td expand="1" width="30" align="center" id="expand"><a href="javascript:void(0)" onclick="$.showExpand('getRealStorageByProducts','index_{$item.product_class_id}_{$key}','{$item.product_class_id}');"><span class="icon icon-pattern-plus"></span></a></td>
<td>{$item.class_name}</td>
{if 'storage_format'|C>=2}<td class="t_right">{$item.dml_quantity}</td>{/if}
<td class="t_right">{$item.dml_real_storage}</td>
</tr>
{/foreach}
</tbody>
<tfoot>
<tr class="red">
    <td>&nbsp;</td>
    <td>{$lang.total}</td>
   {if 'storage_format'|C>=2} <td class="t_right">{$list.total.dml_quantity}</td>{/if}
    <td class="t_right">{$list.total.dml_real_storage}</td>
</tr>
</tfoot>
</table>
<script>
$(document).ready(function(){
	{assign var=product_id value="a.product_id"}
	var auto_open = {if $smarty.post.query.$product_id>0}true{else}false{/if};
	if(auto_open == true){
		$dom.find('.list tbody').find('tr').each(function(){
		$(this).find('a').trigger('click');
		});
	}
});
</script>