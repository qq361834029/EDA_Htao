{if $list.list}
<div class="add_box">
	<table cellspacing="0" cellpadding="0" class="add_table">
		{foreach from=$list.list item='item'}
		<tr>
			<th colspan="2">
				{$lang.request_id}：{$item.id}
			</th>
		</tr>
		<tr>
			<td class="width15">
				{$lang.request_time}：
			</td>
			<td class="t_left">
				{$item.fmd_request_time}
			</td>
		</tr>
		<tr>
			<td class="width15">
				{$lang.return_time}：
			</td>
			<td class="t_left">
				{$item.fmd_return_time}
			</td>
		</tr>
		<tr>
			<td class="width15">
				{$lang.request_status}：
			</td>
			<td class="t_left">
				{$item.log_request_status}
			</td>
		</tr>
		<tr>
			<td class="width15">
				{$lang.status_code}：
			</td>
			<td class="t_left">
				{$item.log_status_code}
			</td>
		</tr>
		<tr>
			<td class="width15">
				{$lang.status_message}：
			</td>
			<td class="t_left">
				{$item.log_status_message}
			</td>
		</tr>
		<tr>
			<td class="width15">
				{$lang.track_no}：
			</td>
			<td class="t_left">
				{if $item.request_type != 'deleteShipmentDD'}
					<a href="{$item.Labelurl}" target="_blank">{$item.shipmentNumber}</a>
				{else}
				  {$item.shipmentNumber}
				{/if}
			</td>
		</tr>
		<tr>
			<td class="width15">
				{$lang.process_status}：
			</td>
			<td class="t_left">
				{$item.request_status}
			</td>
		</tr>
		<tr>
			<td class="width15">
				{$lang.process_status_code}：
			</td>
			<td class="t_left">
				{$item.status_code}
			</td>
		</tr>
		<tr>
			<td class="width15" style="vertical-align: top;">
				{$lang.process_status_message}：
			</td>
			<td class="t_left">
				{$item.edit_status_message|html_entity_decode}
			</td>
		</tr>
		{/foreach}
	</table>
</div>
{/if}
