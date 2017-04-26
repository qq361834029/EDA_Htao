<table id="index" class="list" border=0>
<thead><tr>
<th width="16%">{$lang.module}</th>
<th width="40%">{'SYSTEM_LANG.cn'|C}</th>
<th width="">{'SYSTEM_LANG.de'|C}</th>
{if $module_access.LANG.UPDATE}<th width="60px">{$lang.operation}</th>{/if}
</tr>
</thead>
<tbody>
{foreach item=item from=$list}
<tr>
<td>{$lang["module_`$item.module`"]}</td>
<td>{$item.lang_value_cn}</td>
<td>{$item.lang_value_de}</td>
{if $module_access.LANG.UPDATE}
<td class="operate"><span onclick="$.edit(this)" url="__URL__/edit/id/{$item.id}" class="icon icon-list-edit"></span></td>
{/if}

</tr>
{/foreach}
</tbody>
</table>