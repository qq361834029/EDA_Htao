<form action="{'ReturnService/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz is_update=$rs.is_update}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
		<tr>
			<th>
				<div class="titleth">
				<div class="titlefl">{$lang.basic_info}</div>
				</div>
			</th>
		</tr>
    		<tr>
			<td>
				<div class="basic_tb">  
				<ul> 
					<li>
						{$lang.return_service_no}：{$rs.return_service_no}
					</li>				
					<li>
						{$lang.return_service_name}：{$rs.return_service_name}
					</li> 
					<li>
						{$lang.is_enable}：{$rs.dd_status}
					</li>
				</ul>
				</div>
			</td>
		</tr> 		
    		<tr>
		<th >{$lang.service_project}</th>
    		</tr>
		<tr><td>{include file="ReturnService/detail.tpl"}</td></tr>

		<tr><td class="pad_top_10">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comment}：</td>
					<td valign="top" class="t_left" width="80%">{$rs.comments}</td>
				</tr>
			</table>
		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form>