<table  class="list" border="1"> 
	<tr>
		<th rowspan="1">{$lang.flow_no}</th> 
		<th rowspan="1">{$lang.sale_order_state}</th> 
		<th rowspan="1">{$lang.comment}</th> 
		<th rowspan="1">{$lang.edit_time}</th>
		<th rowspan="1">{$lang.operate_person}</th>  
	</tr> 
	{tr from=$list.list }
		{td }
			<a href="javascript:;" onclick="addTab('{$item.comments_url}','{$lang.view_detail}',1); ">
			{$item.flow_no}
			</a>
		{/td}
		{td }
			{$item.dd_state_id}
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
