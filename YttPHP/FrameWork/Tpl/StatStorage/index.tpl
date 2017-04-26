{wz}
<form method="POST" action="{"StatStorage/index"|U}" id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
            <label>{$lang.product_no}：</label>
            <input type="hidden" name="query[a.product_id]" >
            <input type="text" name="temp[product_name]" url="{'AutoComplete/product'|U}" jqac >
        </dt>
		<dt>
			<label>{$lang.from_date}：</label>
			<input type="text" name="from_date" class="Wdate spc_input_data" onclick="WdatePicker()" />
			<label>{$lang.to_date}</label>
			<input type="text" name="to_date" class="Wdate spc_input_data" onclick="WdatePicker()" />
        </dt>
		{if C('PRODUCT_CLASS_LEVEL')>=1}
		<dt>
			<label>{$lang.class_name_1}：</label>
			<input type="hidden" name="query[class_1]" >
			<input type="text" name="temp[class_1_name]" url="{'AutoComplete/productClass1'|U}" jqac >
		</dt>
		{if C('PRODUCT_CLASS_LEVEL')>=2}
		<dt>
			<label>{$lang.class_name_2}：</label>
			<input type="hidden" name="query[class_2]" >
			<input type="text" name="temp[class_2_name]" url="{'AutoComplete/productClass2'|U}" jqac>
		</dt>
		{if C('PRODUCT_CLASS_LEVEL')>=3}
		<dt>
			<label>{$lang.class_name_3}：</label>
			<input type="hidden" name="query[class_3]" >
			<input type="text" name="temp[class_3_name]" url="{'AutoComplete/productClass3'|U}" jqac>
		</dt>
		{if C('PRODUCT_CLASS_LEVEL')>=4}
		<dt>
			<label>{$lang.class_name_4}：</label>
			<input type="hidden" name="query[class_4]" >
			<input type="text" name="temp[class_4_name]" url="{'AutoComplete/productClass4'|U}" jqac>
		</dt>
		{/if}
		{/if}
		{/if}
		<dt>
			<label>{$lang.show_up}：</label>
			<select name="class_level" combobox="1">
				<option value="1" >{$lang.class_1}</option>
				{if C('PRODUCT_CLASS_LEVEL')>1}
					<option value="2" >{$lang.class_2}</option>
				{if C('PRODUCT_CLASS_LEVEL')>2}
					<option value="3" >{$lang.class_3}</option>
				{if C('PRODUCT_CLASS_LEVEL')>3}
					<option value="4" >{$lang.class_4}</option>
				{/if}
				{/if}
				{/if}
			</select>
		</dt>
		{/if}
	</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file='StatStorage/list.tpl'}
</div>