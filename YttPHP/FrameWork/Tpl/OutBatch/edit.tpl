<form action="{'OutBatch/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.out_batch_basic}<input type="hidden" id="flow" value="out_batch"></div>
					<div class="afr">{$lang.out_batch_no}：{$rs.out_batch_no}</div>
    			</div>
                </th>
    		</tr>
    		<tr>
			<td>
	    		<div class="basic_tb">  
	    		<ul> 
                    <li>
                        {$lang.transport_start_date}：<input type="text" name="transport_start_date" value="{$rs.transport_start_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
                    </li>
                    
                    <li>
                        {$lang.transport_type}：{select data=C('TRANSPORT_TYPE') name="transport_type" empty=true value="{$rs.transport_type}" combobox=""}__*__	
                    </li>
                    
                    <li>
                        {$lang.arrive_date}：<input type="text" name="expected_arrival_date" value="{$rs.expected_arrival_date}" class="Wdate spc_input" onClick="WdatePicker()"/>
                    </li>
                    
                </ul>
			</div>
			</td>
		</tr>
        <tr>
            <th colspan="4">
                {$lang.out_batch_detail}
            </th>
        </tr>
        <tr><td>{include file="OutBatch/detail.tpl"}</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

