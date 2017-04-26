{wz}
<form method="POST" action="{'WarehouseLocation/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
	<dl> 
		<dt>
			<label>{$lang.belongs_warehouse}：</label>
			<input type="hidden" id="warehouse_id" name="query[warehouse_id]" value="{$smarty.post.query.warehouse_id}">
			<input type="text" name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$smarty.post.temp.w_name}" jqac /> 
		</dt> 
		<dt>
			<label>{$lang.zone_type}：</label> 		
			{select data=C('CFG_ZONE_TYPE') name="query[zone_type]" value="`$smarty.post.query.zone_type`" combobox=1}
		</dt>	
	</dl>
__SEARCH_END__ 
</form> 
{note export=true}
<div id="print" class="width98">
{include file="WarehouseLocation/list.tpl"}
</div> 