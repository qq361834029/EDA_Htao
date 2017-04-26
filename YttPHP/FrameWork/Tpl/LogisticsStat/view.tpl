{wz print=false}
<form method="POST" action="{'LogisticsStat/view'|U}"  beforeSubmit="checkSearchForm" validity="empty" id="search_form">
    <input type="hidden" id="rand" name="rand" value="{$rand}">
<div style="padding-top:12px;"></div>
__SEARCH_START__
			<dl> 
				<dt>
					<label>{$lang.logistics_name}：</label>
					<input type='hidden' name="comp_id" value="{$factory_id}" class="valid-required">
					<input type='text' url="{'/AutoComplete/logistics'|U}" value="{$factory_name}" jqac>__*__
				</dt>
                {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
                        <dt>
                        <label>{$lang.warehouse_name}：</label>
                        <input value="{$smarty.get.warehouse_id}" type="hidden" name="warehouse_id">
                        <input value="{$w_name}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
                        </dt>
                {/if}
				<dt>
					<label>{$lang.funds_class}：</label>
					<input type='hidden' name="pay_class_id" value="{$smarty.get.pay_class_id}"/>
					<input type="text" name="temp[pay_class_name]" value="{$pay_class_name}" url="{'/AutoComplete/fundsClassName'|U}" where="{" to_hide=1 and relation_object=4 and pay_type=1 "|urlencode}" jqac>
				</dt>					
				{company  type="dt" title=$lang.basic_name hidden=['name'=>'basic_id','id'=>'basic_id','value'=>$smarty.get.basic_id, class=>"valid-required"] name='basic_name' require=true}
				{currency data=C('CLIENT_CURRENCY') name="currency_id" id="currency_id" value=$smarty.get.currency_id type='dt' title=$lang.currency_name require="true" class="valid-required"}  
				<dt>
				<label>{$lang.from_date}：</label>
					<input type="text" name="from_paid_date" value="{$smarty.get.from_paid_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
						<label>{$lang.to_date}</label>
					<input type="text" name="to_paid_date" value="{$smarty.get.to_paid_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
				</dt> 
			</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="LogisticsStat/list_view.tpl"}
</div>
<script>
function expandAllDetail(){
    $dom.find('.list').find('tr[expand]').each(function(){
        $(this).find('td[expand]').find('a').trigger('click');
    });
}
</script>