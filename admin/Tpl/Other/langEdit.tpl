{include file="header.tpl"}
<div class="title"> 修改语言包。</div>
<form action="{'Other/langUpdate'|U}" method="post">
	<input type="hidden" name="id" value="{$rs.id}">
	<table cellpadding=3 cellspacing=3 >
		<tr>
			<td class="tRight">模块：</td>
			<td class="rLeft"><input type="text" name="module" value="{$rs.module}" readonly class="readonly"></td>
		</tr>
		<tr>
			<td class="rRight">下标：</td>
			<td class="rLeft"><input type="text" name="lang_key" value="{$rs.lang_key}" readonly class="readonly"></td>
		</tr>
		{foreach from=C('SYSTEM_LANG') key=code item=label}
			<tr>
				<td class="rRight">{$label}：</td>
				{assign var='lang_value' value="lang_value_$code"}
				<td class="rLeft"><input type="text" name="{$lang_value}"  value="{$rs.$lang_value}" class="huge" ></td>
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