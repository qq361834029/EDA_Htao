{include file="Admin/header.tpl"}
<center><a href="{'/Admin/saveTempleteAll'|U}">生成所有</a><br><br></center>
<table width="98%" id="" class="detail_list" border="1" cellpadding=0 cellspacing=0 ><tr class="row" >
<th>模块名称</th><th>文件名</th><th  class="operate">操作</th></tr>
{foreach key=key item=item from=$list}
<tr>
<td >{$lang[$key|strtolower]}</td>
<td >{$key}</td>
<td class="operate"><a href='{"/Admin/saveTemplete/key/`$key`"|U}'>生成</a></td>
</tr>
{/foreach}

</table>