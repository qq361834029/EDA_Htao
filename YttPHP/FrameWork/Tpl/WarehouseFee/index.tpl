{wz}
<form method="POST" action="{"WarehouseFee/index"|U}" id="search_form">
__SEARCH_START__
	<dl>
		<dt>
			<label>{$lang.code}：</label>
			<input value="" type="text" name="main[like][warehouse_fee_no]" url="{'/AutoComplete/warehouseFeeCode'|U}" jqac>
		</dt>
	</dl>
__SEARCH_END__
</form>
{note insert=!$is_factory}
<div id="print" class="width98">
{include file="WarehouseFee/list.tpl"}
</div> 

