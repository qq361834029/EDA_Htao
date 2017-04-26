{wz}
<form method="POST" action="{'OtherRevenue/index'|U}" id="search_form">
__SEARCH_START__
			<dl>  
	            	<dt>
						<label>{$lang.outlay_class}：</label>
						<input type='hidden' name="query[pay_class_id]">
						<input type='text' url="{'/AutoComplete/IncomeLay'|U}" jqac>
	            	</dt>
	            	{company  type="dt" title=$lang.basic_name
					hidden=['name'=>'query[basic_id]','id'=>'basic_id']
					name='basic_name'   
					} 
					<dt>
					<label>{$lang.is_cost}：</label>
            		{select data=C('IS_COST') name="query[is_cost]" value="`$smarty.post.query.is_cost`"}
					</dt>
					
					<dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="date[from_paid_date]" value="{$smarty.post.date.from_paid_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
							<label>{$lang.to_date}</label>
						<input type="text" name="date[to_paid_date]" value="{$smarty.post.date.to_paid_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            		</dt> 
			</dl> 
__SEARCH_END__
</form> 
{note}
<div id="print" class="width98">
{include file="OtherRevenue/list.tpl"}
</div> 
