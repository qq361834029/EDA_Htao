{wz}
<form method="POST" action="{'LoadContainer/waitLoadContainer'|U}" id="search_form">
__SEARCH_START__
		<dl>
		<dt>
					<label>{$lang.order_no}：</label>
					<input type="hidden" name="main[query][id]">
					<input type="text" url="{'/AutoComplete/orderNo'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.factory_name}：</label>
					<input type='hidden' name="main[query][factory_id]">
					<input type="text" url="{'/AutoComplete/factory'|U}" jqac>
            	</dt>    
				<dt>
					<label>{$lang.product_no}：</label>
					<input type='hidden' name="detail[query][product_id]">
					<input type="text" url="{'/AutoComplete/product'|U}" jqac>
            	</dt> 
		</dl>	
__SEARCH_END__
</form>
{note tabs="loadContainer"}
<div id="print" class="width98">
{include file="LoadContainer/waitlist.tpl"}
</div> 

