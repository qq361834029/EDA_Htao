{wz}
<form method="POST" action="{"LoadContainer/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
				<dt>
					<label>{$lang.load_container_no}：</label>
					<input type="hidden" name="main[query][id]">
					<input type="text" url="{'/AutoComplete/loadContainerNo'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.container_no}：</label>
					<input type="text" name="main[like][container_no]"  url="{'/AutoComplete/containerNo'|U}" jqac class="spc_input">
			 	</dt>
            	<dt>
					<label>{$lang.order_no}：</label>
					<input type="hidden" name="order[query][id]">
					<input type="text" url="{'/AutoComplete/orderno'|U}" jqac>
            	</dt>                  	   
				<dt>
					<label>{$lang.product_no}：</label>
					<input type='hidden' name="detail[query][product_id]">
					<input type="text" url="{'/AutoComplete/product'|U}" jqac>
            	</dt>             
            	<dt>
					<label>{$lang.load_date_from}：</label>
					<input type="text" name="main[date][from_load_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
					<label>{$lang.load_date_to}</label>
					<input type="text" name="main[date][to_load_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
			 	</dt>   
		</dl>	
__SEARCH_END__
</form>
{note tabs="loadContainer"}
<div id="print" class="width98">
{include file="LoadContainer/list.tpl"}
</div> 

