{wz}
<form method="POST" action="{'Instock/index'|U}" id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.instock_no}：</label>
			<input type="hidden" name="main[query][id]" />
			<input type="text" name="temp[instock_no]" url="{'AutoComplete/instockNo'|U}" jqac />
		</dt>
		<dt>
			<label>{$lang.product_no}：</label>
			<input value="{$smarty.post.detail.like.product_no}" type='text' name="detail[like][product_no]" url="{'/AutoComplete/instockProductNo2'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.custom_barcode}：</label>
			<input type="hidden" name="detail[query][product_id]" />
			<input type='text'   url="{'/AutoComplete/productBarcode'|U}" jqac>
		</dt>
		{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
		<dt>
			<label>{$lang.destination}：</label>
			<input type="hidden" id="warehouse_id" name="main[query][warehouse_id]" >
			<input type="text" name="temp[w_name]" url="{'AutoComplete/saleWarehouse'|U}" jqac /> 
		</dt> 	
		{/if}
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		<dt>
			<label>{$lang.belongs_seller}：</label>
			<input type="hidden" id="factory_id" name="main[query][factory_id]" >
			<input type="text" name="temp[factory_name]" url="{'AutoComplete/factoryEmail'|U}" jqac /> 
		</dt> 	
		{/if}		
		<dt>
			<label>{$lang.delivery_date}{$lang.from}：</label>
			<input type="text" name="main[date][from_delivery_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][to_delivery_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		<dt>
			<label>{$lang.is_get}：</label>
			{select data=C('IS_GET') name="main[query][is_get]" combobox=""}
		</dt> 				
		<dt>
			<label>{$lang.head_way}：</label>
			{select data=C('TRANSPORT_TYPE') name="main[query][head_way]" combobox=""}
		</dt> 	
		<dt>
			<label>{$lang.logistics}：</label>
				<input type="hidden" name="main[query][logistics_id]" />
				<input name="temp[trans_comp]"  url="{'AutoComplete/logistics'|U}" jqac />
		</dt> 		
		<dt>
			<label>{$lang.logistics_no}：</label>
				<input type="text" name="main[like][container_no]" class="spc_input" >
		</dt>	
		<dt>
			<label>{$lang.go_date}{$lang.from}：</label>
			<input type="text" name="main[date2][from_go_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date2][to_go_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 
		<dt >
			<label>{$lang.arrive_date}{$lang.from}：</label>
			<input type="text" name="main[date3][from_arrive_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date3][to_arrive_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 
		<dt class="{if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}wfr_date{else}w320{/if}">
			<label>{$lang.real_arrive_date}{$lang.from}：</label>
			<input type="text" name="main[date4][from_real_arrive_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date4][to_real_arrive_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 		

			<input type="hidden" name="main[date_key]" value="4" />
		{else}
			<input type="hidden" name="main[date_key]" value="1" />
		{/if}		
        <dt>
			<label>{$lang.state}：</label>
			{select data=C('CFG_INSTOCK_TYPE') name="main[query][instock_type]" initvalue=$default_instock_type combobox=""}
		</dt>
	</dl> 
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="Instock/list.tpl"}
</div> 