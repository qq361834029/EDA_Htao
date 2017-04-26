{wz}
<form method="POST" action="{'GlsPrinterName/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<dl>  
	<dt><label>{$lang.mac_address}：</label>
		<input id="mac_address" name="query[mac_address]" value="{$smarty.post.query.mac_address}" url="{'/AutoComplete/glsPrinterMacAddress'|U}" jqac>
	</dt>
	<dt><label>{$lang.printer_name}：</label>
		<input id="printer_name" name="like[printer_name]" value="{$smarty.post.query.printer_name}" url="{'/AutoComplete/glsPrinterName'|U}" jqac>
	</dt>
</dl>
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="GlsPrinterName/list.tpl"}
</div>  