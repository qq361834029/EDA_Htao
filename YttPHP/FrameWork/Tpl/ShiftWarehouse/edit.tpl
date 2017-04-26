<form action="{'ShiftWarehouse/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
            <tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.shift_warehouse_basic}<input type="hidden" id="flow" value="ShiftWarehouse"></div>
    				<div class="afr">{$lang.shift_warehouse_no}：{$rs.shift_warehouse_no}</div>
    			</div></th>
    		</tr>
    		<tr>
			<td>
	    		<div class="basic_tb">  
                    <ul> 
                        <li>
                            {$lang.shift_warehouse_date}：<input type="text" name="shift_warehouse_date" value="{$rs.shift_warehouse_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
                        </li>
                    </ul>
                </div>
			</td>
            </tr>
    		<tr>
    			<th >
                    {$lang.shift_warehouse_detail}
                </th>
    		</tr>
            <tr><td>{include file="ShiftWarehouse/detail.tpl"}</td></tr>
    		<tr>
                <td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
					<td width="80%" valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80" name="comments">{$rs.edit_comments}</textarea></td>
					</tr>
                </table>
               </td>
            </tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

