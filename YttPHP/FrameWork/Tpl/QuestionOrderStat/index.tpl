{wz}
<form method="POST" action="{"QuestionOrderStat/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.express_way}：</label>
			<input type="hidden" name="query[express_id]">
			<input name="temp[ship_name]" type='text' url="{'/AutoComplete/shipping'|U}" jqac>
		</dt>
		<dt>
			<label>最近：</label>
			<select name="period" id="period" combobox>
				<option value="1" >一个月内</option>
				<option value="2" >三个月内</option>
				<option value="3" >半年内</option>
            </select>
		</dt>
	</dl>
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="QuestionOrderStat/list.tpl"}
</div> 