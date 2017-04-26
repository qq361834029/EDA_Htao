{wz}
<form method="POST" action="{'FundsClass/index'|U}" id="search_form">
<input type="hidden" id="rand" name="rand" value="{$rand}">	
__SEARCH_START__
<dl>   	
				<dt>
					<label>{$lang.funds_class_name}：</label>  
					<input name="like[pay_class_name]" type="text" url="{'/AutoComplete/fundsClassName'|U}" jqac>
				</dt>		
				<dt>	
					<label>{$lang.relation_object}：</label>
            		{select data=C('CFG_PAY_RALATION_OBJECT') name="query[relation_object]" combobox=1}
				</dt>  				
				<dt>	
					<label>{$lang.funds_class_type}：</label>
            		{select data=C('FUNDS_TYPE') name="query[pay_type]" combobox=1}
				</dt>  
				<dt>	
					<label>{$lang.state}：</label>
            		{select data=C('BASICSTATE') name="query[to_hide]" value="`$smarty.post.query.to_hide`" initvalue="1" combobox=1}
				</dt>
</dl> 
__SEARCH_END__
</form>
{note export=true}
<div id="print" class="width98">
{include file="FundsClass/list.tpl"}
</div> 
