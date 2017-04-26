{wz}
<form method="POST" action="{"SaleStorage/lcStorage"|U}" id="search_form">
__SEARCH_START__
		<dl>
		
		<dt>
					<label>{$lang.product_no}：</label>
					<input type="hidden" name="detail[query][product_id]">
					<input type='text' url="{'/AutoComplete/product'|U}" jqac>
				</dt>
				
				<dt>
					<label>{$lang.stop_date}：</label>
					<input type="text" name="main[date][lt_delivery_date]" class="Wdate spc_input" onClick="WdatePicker()"/>
            	</dt>
            	<dt>
					<label>{$lang.container_no}：</label>
					<input type='text' name="main[like][container_no]" url="{'/AutoComplete/containerNo'|U}" jqac>
            	</dt>
		</dl>	
__SEARCH_END__
</form>
{note tabs="saleStorage"}
<div id="print" class="width98">
{include file="SaleStorage/lclist.tpl"}
</div> 

