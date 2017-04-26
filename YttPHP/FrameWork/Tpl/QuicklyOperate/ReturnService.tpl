<form id="form_id" action="" method="POST">
<div class="table_autoshow_return" style="border-style:none!important;">
<table class="list" cellspacing="0" cellpadding="0" width="100%" id="return_service_list"> 
<tbody>
	<tr>
		<th rowspan="1">{$lang.return_service_no}</th> 
		<th rowspan="1">{$lang.return_service_name}</th> 
		<th rowspan="1">{$lang.item_number}</th> 
		<th rowspan="1">{$lang.item_name}</th> 
		<th rowspan="1">{$lang.price_explanation}</th>
		<th rowspan="1">{$lang.is_select}</th>  
		<th rowspan="1">{$lang.quantity}</th>  
		<th rowspan="1">{$lang.money}</th>  
		<th rowspan="1">{$lang.comment}</th> 
	</tr> 
	{foreach from=$return_service key=key item=item}
	<tr>
		<td>{$item.return_service_no}</td>
		<td>{$item.return_service_name}<br>
		<td>{$item.item_number}</td>
		<td>{$item.item_name}</td>
		<td>{$item.price_explanation}</td>
		<td>{$item.checkbox}</td>
		<td>{$item.quantity}</td>
		<td>{$item.price}</td>
		<td>{$item.comments}</td> 
	</tr>
	{/foreach}
</tbody>
</table>
</div>
</form>