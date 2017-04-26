{wz}
<form method="POST" action="{"Stocktake/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
		   		<dt>
					<label >{$lang.stocktake_no}：</label>
					<input type="text" name="main[like][stocktake_no]" url="{'/AutoComplete/stockTakeNo'|U}" jqac>
            	</dt>
				<dt>
					<label>{$lang.product_no}：</label>
					<input type='hidden' name="detail[query][b.product_id]">
             		<input type='text' url="{'/AutoComplete/product'|U}" jqac>
            	</dt>            			  
            	<dt>
					<label>{$lang.start_stocktake_date}：</label>
						<input type="text" name="main[date][from_stocktake_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
						<label>{$lang.end_stocktake_date}</label>
						<input type="text" name="main[date][to_stocktake_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>    
            	{warehouse type="dt" title=$lang.warehouse hidden=["name"=>"main[query][warehouse_id]"]  name="temp[w_name]" empty=true}  
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
<br>
{note}
<div id="print" class="width98">
{include file="Stocktake/list.tpl"}
</div> 

