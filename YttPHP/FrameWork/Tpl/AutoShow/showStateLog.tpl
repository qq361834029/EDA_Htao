<table  class="list" border="1"> 
	<tr>
		<th rowspan="1">{$lang.state}</th> 
		<th rowspan="1">{$lang.comment}</th> 
		<th rowspan="1">{$lang.edit_time}</th>
		<th rowspan="1">{$lang.operate_person}</th>  
	</tr> 
	{tr from=$list.list }
		{td }
			{$item.$dd_update_field_name}
		{/td} 
		{td }
			{$item.edit_log_comments}
		{/td}
		{td }
			{$item.fmd_paid_date}
		{/td} 
		{td }
			{$item.add_real_name}
		{/td} 
	{/tr} 
</table>
<br><br> 
