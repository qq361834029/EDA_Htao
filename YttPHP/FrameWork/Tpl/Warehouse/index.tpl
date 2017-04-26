{wz}
<form method="POST" action="{'Warehouse/index'|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
	<dl> 
		<dt>
			<label>{$lang.warehouse_no}：</label>
			<input type="hidden" name="query[id]" value="{$smarty.post.query.id}" />
			<input type="text" name="temp[w_no]" url="{'AutoComplete/warehouseNo'|U}" value="{$smarty.post.like.w_no}" jqac /> 
		</dt> 		
		<dt>
			<label>{$lang.warehouse_name}：</label>
			<input type="text" name="like[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$smarty.post.like.w_name}" jqac /> 
		</dt> 
		{if !$is_factory}
		{company
			type="dt" id="basic_name" name="temp[basic_name]" url='AutoComplete/companyName' title=$lang.basic_name
			hidden=["id"=>"basic_id","name"=>"query[basic_id]","value"=>$smarty.post.query.basic_id]
		} 
		<dt>
			<label>{$lang.is_use}：</label> 
			{select data=C('IS_USE') name="query[is_use]" value="`$smarty.post.query.is_use`" combobox=1}
		</dt>		 
		<dt>	
			<label>{$lang.state}：</label>
            {select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
		</dt>
        <dt>	
			<label>{$lang.is_sold}：</label>
            {select data=C('IS_RETURN_SOLD') name="query[is_return_sold]" value="`$smarty.post.query.is_return_sold`" initvalue=-2 combobox=1}
		</dt>
		{/if}
	</dl>
__SEARCH_END__ 
</form> 
{note content="<ul><li>`$lang.comments`:</li><li class='line_bzgreen'></li><li>`$lang.default_warehouse`</li></ul>" export=!$is_factory insert=!$is_factory}
<div id="print" class="width98">
{include file="Warehouse/list.tpl"}
</div> 