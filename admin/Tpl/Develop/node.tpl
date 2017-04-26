{include file="header.tpl"}
<script>
	function deleteNode(url){
		if (confirm("请确认是否删除？")) {
			location.href	= url;
		}
	}
</script>
<br>
<table id="index" class="list" border=1>
<div align="right" style="margin-right:15px;"><a href="{'Develop/addnote'|U}" style="border-bottom:none"><div class="impBtn fRight btn14">新增</div></a></div>
<thead><tr><th width="">名称</th><th width="">模块</th><th width="">操作</th></thead>
<tbody>
{foreach item=item from=$node}
	<tr><td>{$item.title}</td><td>{$item.module}</td><td>{if $item.level<3}<a href="__URL__/node/id/{$item.id}">明细</a>{/if} <a href="__URL__/editnode/id/{$item.id}">修改</a> <a href="javascript: deleteNode('__URL__/delNode/id/{$item.id}')">删除{if $item.level<3}(包括子节点){/if}</a></td></tr>
{/foreach}
</tbody>
</table>
{include file="footer.tpl"}