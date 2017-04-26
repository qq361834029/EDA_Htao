{wz}
<form method="POST" action="{'LogisticsCheckAccount/index'|U}" id="search_form">
__SEARCH_START__
			<dl> 
					<dt>
						<label>{$lang.logistics_name}：</label>
						<input type='hidden' name="query[comp_id]">
						<input type='text' url="{'/AutoComplete/logistics'|U}" jqac>
	            	</dt>
	            	{company  type="dt" title=$lang.basic_name
					hidden=['name'=>'query[basic_id]','id'=>'basic_id']
					name='basic_name'   
					} 
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
{include file="LogisticsCheckAccount/list.tpl"}
</div> 
