{wz}
<form method="POST" action="{"Profitandloss/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
		   		<dt>
					<label >{$lang.profitandloss_no}：</label>
					<input type="text" name="main[like][profitandloss_no]" url="{'/AutoComplete/profitandlossNo'|U}" jqac>
            	</dt>   			  
            	<dt>
					<label>{$lang.profitandloss_date}：</label>
						<input type="text" name="main[date][from_profitandloss_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
						<label>{$lang.to_date}</label>
						<input type="text" name="main[date][to_profitandloss_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>    
            	{warehouse type="dt" title=$lang.warehouse hidden=["name"=>"main[query][warehouse_id]"]  name="temp[w_name]" empty=true}  
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
<br>
<div id="print" class="width98">
{include file="Profitandloss/list.tpl"}
</div> 

