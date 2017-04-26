{wz}
<form method="POST" action="{'PayClass/index'|U}" id="search_form">
__SEARCH_START__
<dl>   
				<dt>
					<label>{$lang.pay_class_name}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label>  
					<input name="like[pay_class_name]" type="text" url="{'/AutoComplete/payClassName'|U}" jqac>
				</dt>				
				<dt>	
					<label>{$lang.pay_type}：</label>
            		{select data=C('PAY_TYPE') name="query[pay_type]" combobox=1}
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
{include file="PayClass/list.tpl"}
</div> 
