{include file="header.tpl"}
<br>
<table id="index" class="list" border=1>
<thead><tr>
<th width="15%">字典名称</th>
<th width="15%">字典文件名</th>
<th width="">字典值字段</th>
<th width="15%">字典值表名</th>
<th width="15%">字典查询条件</th></thead>
<tbody>
{foreach item=item from=$dd}
<tr>
<td>{$item.dd_caption}</td>
<td>{$item.dd_name}</td>
<td>{$item.dd_value}</td>
<td>{$item.dd_table}</td>
<td>{$item.dd_where}</td>
{/foreach}
</tbody>
</table>
{include file="footer.tpl"}
