{wz}
<form method="POST" action="{'OtherCompany/index'|U}" id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.factory_no}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label>
			<input type="text" name="query[comp_no]" url="{'AutoComplete/otherCompanyNo'|U}" value="{$smarty.post.query.comp_no}" jqac />
		</dt>
		<dt>
			<label>{$lang.factory_name}：</label>
			<input type="text" name="query[comp_name]" url="{'AutoComplete/otherCompanyName'|U}" value="{$smarty.post.query.comp_name}" jqac />
		</dt>
		<dt>
			<label>{$lang.factory_country}：</label>
            <input type="hidden" name="query[country_id]" value="{$smarty.post.query.country_id}">
            <input type="text" name="temp[country_name]" value="{$smarty.post.temp.country_name}" url="{'AutoComplete/countryName'|U}" jqac />
		</dt>
		<dt>
			<label>{$lang.factory_city}：</label>
            <input type="hidden" name="query[city_id]" value="{$smarty.post.query.city_id}">
            <input type="text" name="temp[city_id]" value="{$smarty.post.temp.city_name}" url="{'AutoComplete/cityName'|U}" jqac />
		</dt>
		<dt>
			<label>{$lang.state}：</label>
			{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
		</dt>
	</dl> 
__SEARCH_END__
</form>
{note export=true}
<div id="print" class="width98">
{include file="OtherCompany/list.tpl"}
</div>  