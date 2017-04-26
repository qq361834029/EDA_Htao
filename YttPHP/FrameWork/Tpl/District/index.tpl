{wz}
<form method="POST" action="{'District/index'|U}" id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.country_name}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label> 
			<input type="text" name="like[a.district_name]" url="{'AutoComplete/countryName'|U}" value="{$smarty.post.list.a_district_name}" jqac />
		</dt>
		<dt>
			<label>{$lang.country_no}：</label>
			<input type="hidden" name="query[a.id]" >
			<input type='text' name="abbr_district_name" url="{'AutoComplete/abbrDistrictName'|U}" jqac >
		</dt>
		<dt>
			<label>{$lang.city}：</label>
			<input type="text" name="like[b.district_name]" url="{'AutoComplete/cityName'|U}" value="{$smarty.post.like.b_district_name}" jqac /> 
		</dt>
		<dt>
			<label>{$lang.country}{$lang.state}：</label>
			{select data=C('BASICSTATE') name="query[a.to_hide]"  combobox=1}
		</dt>
		<dt>	
			<label>{$lang.city}{$lang.state}：</label>
            {select data=C('BASICSTATE') name="query[b.to_hide]"  combobox=1}
		</dt> 
	</dl> 
__SEARCH_END__
</form>
{note export=true}
<div id="print" class="width98">
{include file="District/list.tpl"}
</div>  