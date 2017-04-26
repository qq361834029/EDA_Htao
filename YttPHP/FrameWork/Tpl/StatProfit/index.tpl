{wz}
<form method="POST" action='{"/StatProfit/index/search_form/1"|U}' id="search_form">
__SEARCH_START__
		<dl>
		   		<dt>
					<label >{$lang.year}：</label>
					<input type="text" name="profit_year" class="Wdate spc_input" onClick="WdatePicker({ dateFmt:'yyyy'})" />
            	</dt>
				<dt>
					<label>{$lang.search}：</label>
					{radio data=C('PROFIT_USER') name="profit_user" initvalue=2}
            	</dt>
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="StatProfit/list.tpl"}
</div> 

