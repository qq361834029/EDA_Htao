{wz}
<form method="POST" action="{'Log/index'|U}" id="search_form">
__SEARCH_START__
<dl> 
				<dt>
					<label>{$lang.user_name}：</label>
					<input type="hidden" name="query[user_id]">
					<input type="text" class="spc_input ac_input" url="{'/AutoComplete/user'|U}" jqac>
				</dt>
				<dt>
					<label>{$lang.ip}：</label>
					<input type="text" name="like[ip]" class="spc_input">
				</dt>
				<dt>
					<label>{$lang.time_start}：</label>
						<input type="text" name="date[from_insert_time]" class="Wdate spc_input" onClick="WdatePicker()"/>
            	</dt>   
            	<dt>
					<label>{$lang.time_end}：</label>
						<input type="text" name="date[to_insert_time]" class="Wdate spc_input" onClick="WdatePicker()"/>
            	</dt>
				<dt>
					<label>{$lang.comment}：</label>
            		<input name="like[content]" class="spc_input">
            	</dt>				
			</dl>  
__SEARCH_END__
</form>
{note content="`$lang.system_time_set_info`"}
<div id="print" class="width98">
{include file="Log/list.tpl"}
</div> 