{wz}
<form method="POST" action="{"InstockStorage/index"|U}" id="search_form">
__SEARCH_START__
	<dl>
        <dt>
			<label>{$lang.delivery_no}：</label>
			<input type="hidden" name="main[query][instock_id]" />
			<input type="text" name="temp[instock_no]" url="{'AutoComplete/instockNo'|U}" jqac />
		</dt>
		<dt>
			<label>{$lang.instock_no}：</label>            
			<input value="{$smarty.post.main.like.storage_no}" type="text" name="main[like][storage_no]" url="{'/AutoComplete/instockStorageNo'|U}" jqac>
		</dt>        
		<dt>
			<label>{$lang.product_no}：</label>
			<input value="{$smarty.post.detail.like.product_no}" type='text' name="detail[like][product_no]" url="{'/AutoComplete/productNo'|U}" jqac>
		</dt>
		{if $login_user.role_type == C('WAREHOUSE_ROLE_TYPE') || $login_user.role_type == 1}
		<dt>
			<label>{$lang.product_id}：</label>
			<input type="text" name="detail[query][product_id]" class="spc_input" value="{$smarty.post.detail.query.product_id}"/>
		</dt>
		{/if}
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
		<dt>
			<label>{$lang.destination}：</label>
			<input type="hidden" id="warehouse_id" name="main[query][warehouse_id]" >
			<input type="text" name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" jqac /> 
		</dt> 	
		{/if}
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		<dt>
			<label>{$lang.belongs_seller}：</label>
			<input type="hidden" id="warehouse_id" name="main[query][factory_id]" >
			<input type="text" name="temp[factory_name]" url="{'AutoComplete/factoryEmail'|U}" jqac /> 
		</dt> 	
		{/if}
        <dt class="w320">
			<label>{$lang.go_date}{$lang.from}：</label>
			<input type="text" name="main[date][from_go_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][to_go_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt>
        <dt>
			<label>{$lang.head_way}：</label>
			{select data=C('TRANSPORT_TYPE') name="main[query][head_way]" combobox=""}
		</dt> 	
        <dt class="w320">
			<label>{$lang.storage_date}{$lang.from}：</label>
			<input type="text" name="main[date4][from_storage_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date4][to_storage_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt>  	
        <dt>
			<label>{$lang.logistics}：</label>
				<input type="hidden" name="main[query][logistics_id]" />
				<input name="temp[trans_comp]"  url="{'AutoComplete/logistics'|U}" jqac />
		</dt> 	
        <dt class="w320">
			<label>{$lang.arrive_date}{$lang.from}：</label>
			<input type="text" name="main[date2][from_arrive_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date2][to_arrive_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 
        <dt class="{if $smarty.const.LANG_SET=='de'}wfr_date{else}w320{/if}">
			<label>{$lang.real_arrive_date}{$lang.from}：</label>
			<input type="text" name="main[date3][from_real_arrive_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date3][to_real_arrive_date]"  class="Wdate spc_input_data" onclick="WdatePicker()"/>
		</dt> 	
    </dl>	
	<input type="hidden" name="main[date_key]" value="4">
__SEARCH_END__
</form>
{note}
<div id="print" class="width98">
{include file="InstockStorage/list.tpl"}
</div> 

