{wz is_update=$admin==true}
<div class="add_box">
	<table cellspacing="0" cellpadding="0" class="add_table">
		<tbody>
            <tr>   
                <td class="width10">{$lang.belongs_warehouse}：</td>
                <td class="t_left">{$rs.w_name}</td>
            </tr>
			<tr>
				<td class="width15">{$lang.process_fee_no}：</td>
				<td class="t_left">{$rs.return_process_fee_no}</td>
			</tr>
			<tr>
				<td>{$lang.process_fee_name}：</td>
				<td class="t_left">{$rs.return_process_fee_name}</td>
			</tr>
			<tr>
				<td>{$lang.shipping_type}：</td>
				<td class="t_left">{$rs.dd_shipping_type}</td>
			</tr>
			<tr>
				<td colspan=2 style="padding:0 600px 0 120px">{include file="ReturnProcessFee/view_detail.tpl"}</td>
			</tr>
			<tr>
				<td valign="top">{$lang.comments}：</td>
				<td class="t_left">{$rs.edit_comments}</td>
			</tr>
		</tbody>
	</table>
</div>