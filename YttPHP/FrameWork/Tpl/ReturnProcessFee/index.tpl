{wz}
<form method="POST" action="{"ReturnProcessFee/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
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
					<input type='text' name="temp[return_process_fee_no]" url="{'/AutoComplete/returnProcessFeeNo'|U}" jqac>
            	</dt>   			
				<dt>
					<label>{$lang.process_fee_name}：</label>
					<input type='text' name="like[return_process_fee_name]" url="{'/AutoComplete/returnProcessFee'|U}" jqac>
            	</dt>   
				<dt>
					<label>{$lang.shipping_type}：</label>
					{select data=C('SHIPPING_TYPE') name="query[shipping_type]" combobox=1}
				</dt>
		</dl>	
__SEARCH_END__
</form>
{note  insert=($admin===true)}
<div id="print" class="width98">
{include file="ReturnProcessFee/list.tpl"}
</div> 

