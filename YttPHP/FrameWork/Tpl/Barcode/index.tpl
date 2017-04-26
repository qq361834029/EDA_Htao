{wz}
<form method="POST" action="{'Barcode/index'|U}" id="search_form">
__SEARCH_START__
<dl> 
				<dt>
					<label>{$lang.barcode}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label>
            		<input name="like[barcode_no]" type="text" url="{'/AutoComplete/barcode'|U}" jqac>
            		</dt>
				<dt><label>{$lang.product_no}：</label>
					<input name="query[p_id]" type="hidden" value="">
					<input name="" type="text" url="{'/AutoComplete/product'|U}" jqac>
            		</dt> 
			</dl> 
__SEARCH_END__
</form>
{note export=true}
<div id="print" class="width98">
{include file="Barcode/list.tpl"}
</div> 
