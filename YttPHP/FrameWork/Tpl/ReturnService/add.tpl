<form action="{'ReturnService/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
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
							{$lang.return_service_no}：
							<input type="text" name="return_service_no" id='return_service_no' class="spc_input" />__*__
						</li>
						<li>
							{$lang.return_service_name}：
							<input type="text" name="return_service_name" id='return_service_name' class="spc_input" />__*__
						</li>			
						<li>
							{$lang.is_enable}：
							{radio data=C('IS_ENABLE') name="status" initvalue="1"}
						</li>
					</ul>
				</div>
			</td>
		</tr> 		
    		<tr>
    			<th >{$lang.service_project}</th>
    		</tr>
		<tr><td>{include file="ReturnService/detail.tpl"}</td></tr>

		<tr>
			<td class="pad_top_10">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comment}：</td>
					<td valign="top" class="t_left" width="80%">
					<textarea id="receive_addr" class="textarea_height80" name="comments"></textarea></td>
				</tr>
			</table>
			</td>
		</tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form>