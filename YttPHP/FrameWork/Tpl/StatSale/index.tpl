{wz}
<form method="POST" action="{'StatSale/index'|U}" id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.client_name}：</label> 
			<input type="hidden" name="query[client_id]">
			<input  name="client_name"  url="{'/AutoComplete/client'|U}" jqac> 
		</dt>
		{company 
			type="dt" title=$lang.basic_name empty=true
			hidden=["id"=>"basic_id","name"=>"query[basic_id]"]
			id="basic_name" name="temp[basic_name]" url='AutoComplete/company'
		} 					
		<dt>
			<label>{$lang.product_no}：</label>  
			<input type="hidden" name="query[b.product_id]">
			<input type="text" name="temp[product_no]" url="{'AutoComplete/product'|U}" jqac />
        </dt>
        <dt class="w320">
        	<label>{$lang.from_date}：</label>
        	<input type="text" name="date[from_order_date]" class="Wdate spc_input_data" onClick="WdatePicker()">
        	<label>{$lang.to_date}</label>
        	<input type="text" name="date[to_order_date]" class="Wdate spc_input_data" onClick="WdatePicker()" >
        </dt>
	{if 'product_class_level'|C>=1}
        <dt>
        	<label>{$lang.class_name_1}：</label>
        	<input type="hidden" name="query[class_1]" >
        	<input type='text' name="temp[class_1]" url="{'AutoComplete/productClass1'|U}" jqac />
        </dt>
        {if 'product_class_level'|C>=2}
        <dt>
        	<label>{$lang.class_name_2}：</label>
        	<input type="hidden" name="query[class_2]">
        	<input type="text" name="temp[class_2]" url="{'AutoComplete/productClass2'|U}" jqac />
        </dt>
        {if 'product_class_level'|C>=3}
        <dt>
        	<label>{$lang.class_name_3}：</label>
        	<input type="hidden" name="query[class_3]">
        	<input type="text" name="temp[class_3]" url="{'AutoComplete/productClass3'|U}" jqac />
        </dt>
        {if 'product_class_level'|C>=4}
        <dt>
        	<label>{$lang.class_name_4}：</label>
        	<input type="hidden" name="query[class_4]">
        	<input type="text" name="temp[class_4]" url="{'AutoComplete/productClass4'|U}" jqac />
        </dt>
	{/if}
	{/if}
	{/if}
        {/if}
        <dt>
        	<label>{$lang.show_up}：</label>
        	<select  name="class_level">
			{if 'product_class_level'|C>=1}
        		<option value="1">{$lang.class_1}</option>
        		{if 'product_class_level'|C>=2}
        			<option value="2">{$lang.class_2}</option>
        		{if 'product_class_level'|C>=3}
        			<option value="3">{$lang.class_3}</option>
        		{if 'product_class_level'|C>=4}
        			<option value="4">{$lang.class_4}</option>
        		{/if}
			{/if}
			{/if}
			{/if}
        		<option value="5">{$lang.by_client}</option>
        	</select>
        </dt>
	</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="StatSale/list.tpl"}
</div>