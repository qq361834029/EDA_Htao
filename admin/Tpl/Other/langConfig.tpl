{include file="header.tpl"}
<div class="title"> 语言包管理。</div>
<form action="{'Other/langConfig'|U}" method="post" id="search_form">
模块：<input type="text" url="{'AutoComplete/langModule'|U}" jqac name="query[module]" value="{$smarty.post.query.module}"/>
下标：<input type="text" name="like[lang_key]" value="{$smarty.post.like.lang_key}">
中文：<input type="text" name="like[lang_value_cn]" value="{$smarty.post.like.lang_value_cn}">
<input type="hidden" value="1" name="search_form" autocomplete="off">
<input type="hidden" name="adminConfig" value="1" id="adminConfig">
<input id="nextPage" type="hidden" value="1" name="nextPage" autocomplete="off">
<input type="submit" name="ac_search" value="查询" id="ac_search">
</form>
<div align="right" style="margin-right:15px;"><a href="{'Other/langAdd'|U}" style="border-bottom:none"><div class="impBtn fRight btn14">新增</div></a></div>
<table id="index" class="list" border="0">
	<thead>
		<tr>
			<th width="10%">模块</th>
			<th width="20%">下标</th>
			<th width="30%">中文</th>
			<th>德文</th>
			<th>意大利文</th>
			<th width="100">操作</th>
		</tr>
	</thead>
	<tbody>
	{foreach item=item from=$list}
		<tr>
			<td>{$item.module}</td>
			<td>{$item.lang_key}</td>
			<td>{$item.lang_value_cn}</td>
			<td>{$item.lang_value_de}</td>
			<td>{$item.lang_value_it}</td>
			<td>
				<a href="{"/Other/langEdit/id/`$item.id`"|U}">修改</a>&nbsp;&nbsp;
				<a href="{"/Other/langDelete/id/`$item.id`"|U}" onclick="return check();">删除</a>
			</td>
		</tr>
	{/foreach}
	</tbody>
</table>
<script>
function check(){
	var chk	= confirm('您确认删除吗？');
	if(chk==false){
		return false;
	}
}
</script>