{wz}
<form method="POST" action="{"ProcessFee/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
                <dt>
                    <label>{$lang.belongs_warehouse}：</label>
                    <input type="hidden" name="query[warehouse_id]" value="{$smarty.post.query.warehouse_id}">
                    <input name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$smarty.post.query.w_name}" jqac />
                </dt>
				<dt>
					<label>{$lang.process_fee_no}：</label>
					<input type="hidden" name="query[id]" />
					<input type='text' name="temp[process_fee_no]" url="{'/AutoComplete/processFeeNo'|U}" jqac>
            	</dt>   			
				<dt>
					<label>{$lang.process_fee_name}：</label>
					<input type='text' name="like[process_fee_name]" url="{'/AutoComplete/processFee'|U}" jqac>
            	</dt>   
				<dt>
					<label>{$lang.shipping_type}：</label>
					{select data=C('SHIPPING_TYPE') name="query[shipping_type]" combobox=1}
				</dt>
				<dt>
				    <label>{$lang.type}：</label>
				    {select data=C('ACCORD_TYPE') name="query[accord_type]" combobox=1 empty=true value="`$smarty.post.query.accord_type`"}
				</dt>
		</dl>	
__SEARCH_END__
</form>
{note  insert=($admin===true)}
<div id="print" class="width98">
{include file="ProcessFee/list.tpl"}
</div> 

