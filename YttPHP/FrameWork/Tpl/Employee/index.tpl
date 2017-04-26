{wz}
<form method="POST" action="{'Employee/index'|U}" id="search_form">
__SEARCH_START__
	<dl> 
		<dt>
			<label>{$lang.employee_no}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label> 
			<input type="text" name="like[employee_no]" url="{'AutoComplete/employeeNo'|U}" jqac />
		</dt>
		<dt>
			<label>{$lang.employee_name}：</label> 
			<input type="text" name="like[employee_name]" url="{'AutoComplete/employeeName'|U}" jqac />
		</dt>
		{company 
			type="dt" title=$lang.basic_name
			hidden=["id"=>"basic_id","name"=>"query[basic_id]","value"=>$smarty.post.query.basic_id]
			id="basic_name" name="temp[basic_name]" url='AutoComplete/companyName'
		} 				
		<dt>	
			<label>{$lang.sex}：</label>
            {select data=C('SEX') name="query[sex]" value="`$smarty.post.query.sex`" combobox=1}
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
{include file="Employee/list.tpl"}
</div> 