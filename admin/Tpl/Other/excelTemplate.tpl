{include file="header.tpl"}

<div  align="right" style="margin:10px 15px 5px 10px;"><a href="{'/Other/saveTempleteAll'|U}" style="border-bottom:none"><div class="impBtn fRight btn14" style="width:80px">生成所有</div></a></div>

<table width="98%" id="" class="list" border="1" cellpadding=0 cellspacing=0 >
<thead>
<tr class="row" >
<th>模块名称</th><th>文件名</th><th  class="operate">操作</th></tr>
</thead>
<tbody>
{foreach key=key item=item from=$list}
<tr>
<td >{$lang[$key|strtolower]}</td>
<td >{$key}</td>
<td class="operate"><a href='{"/Other/saveTemplete/key/`$key`"|U}'>生成</a></td>
</tr>
{/foreach}
</tbody>
</table>