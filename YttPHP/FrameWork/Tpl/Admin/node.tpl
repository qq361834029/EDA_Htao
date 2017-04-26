{include file="Admin/header.tpl"}
<table id="index" class="list" border=1>
<div align="right" style="margin-right:15px;"><a href="{'Develop/addnote'|U}" style="border-bottom:none"><div class="impBtn fRight btn14">新增</div></a></div>
<thead><tr><th width="">名称</th><th width="">模块</th><th width="">操作</th></thead>
<tbody>
{foreach item=item from=$node}
<tr><td>{$item.title}</td><td>{$item.module}</td><td>{if $item.level<3}<a href="__URL__/node/id/{$item.id}">明细</a>{/if} <a href="__URL__/editnode/id/{$item.id}">修改</a></td></tr>
{/foreach}
</tbody>
{include file="Admin/footer.tpl"}