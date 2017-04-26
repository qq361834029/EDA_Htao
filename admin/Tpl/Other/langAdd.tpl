{include file="header.tpl"}
<div class="title"> 新增语言包。</div>
<form action="{'Other/langInsert'|U}" method="post">
	<table cellpadding=3 cellspacing=3 >
		<tr>
			<td class="rRight">模块：</td>
			<td class="rLeft"><input type="text" name="module"  ></td>
		</tr>
		<tr>
			<td class="rRight">下标：</td>
			<td class="rLeft"><input type="text" name="lang_key" ></td>
		</tr>
		{foreach from=C('SYSTEM_LANG') key=code item=label}
			<tr>
				<td class="rRight">{$label}：</td>
				<td class="rLeft"><input type="text" name="lang_value_{$code}" class="huge" ></td>
			</tr>
		{/foreach}
		 <tr>
			<td colspan="2">
			<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
			<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="重置" ></div>
			</td>
		</tr>
	</table>
</form>