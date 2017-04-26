{wz}
<form method="POST" action="{'Department/index'|U}" id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.department_no}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label> 
			<input type="text" name="like[department_no]" url="{'AutoComplete/departmentNo'|U}"  jqac />
		</dt>
		<dt>
			<label>{$lang.department_name}：</label> 
			<input type="text" name="like[department_name]" url="{'AutoComplete/departmentName'|U}" jqac />
		</dt>
		<dt>
			<label>{$lang.address}：</label>
			<input type="text" name="like[address]"  class="spc_input" > 
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
{include file="Department/list.tpl"}
</div> 