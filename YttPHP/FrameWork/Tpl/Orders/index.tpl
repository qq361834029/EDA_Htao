{wz}
<form method="POST" action="{"Orders/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
		   <dt>
					<label >{$lang.order_no}：</label>
					<input type="text" name="main[like][order_no]" url="{'/AutoComplete/orderNo'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.factory_name}：</label>
					<input type='hidden' name="main[query][factory_id]">
					<input type='text' url="{'/AutoComplete/factory'|U}" jqac>
            	</dt>    
				<dt>
					<label>{$lang.product_no}：</label>
					<input type='hidden' name="detail[query][product_id]">
             		<input type='text' url="{'/AutoComplete/product'|U}" jqac>
            	</dt>            			  
            	<dt>
					<label>{$lang.order_date_from}：</label>
						<input type="text" name="main[date][from_order_date]" class="Wdate spc_input_data" onClick="WdatePicker({ onpicked:function(){ dsklfjdas();}})"/>
						<label>{$lang.to_date}</label>
						<input type="text" id="dsfkjdlasfjdsfs" name="main[date][to_order_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>    
            	<dt>
					<label>{$lang.expect_date_from}：</label>
						<input type="text" name="main[date][from_expect_date]" value="{$smarty.post.date.from_expect_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
					<label>{$lang.to_date}</label>
						<input type="text" name="main[date][to_expect_date]" value="{$smarty.post.date.to_expect_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>         
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note tabs="orders" content="<ul><li>{$lang.comments}：</li><li class='bzyellow'></li><li>{$lang.mf_tip}</li></ul>"}
<div id="print" class="width98">
{include file="Orders/list.tpl"}
</div> 

