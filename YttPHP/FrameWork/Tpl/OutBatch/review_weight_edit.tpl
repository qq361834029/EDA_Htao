<form action="{'OutBatch/update'|U}" method="POST" beforeSubmitDialogType="confirm" beforeSubmitDialogContent="重量一经复核将不可修改，请确认！">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="list,reset" title="review_weight"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.out_batch_basic}
                        <input type="hidden" id="flow" value="out_batch">
                        <input type="hidden" name="review_weight" value=true>
                        <input type="hidden" name="is_review_weight" value="1">
                    </div>
					<div class="afr">{$lang.out_batch_no}：{$rs.out_batch_no}</div>
    			</div>
                </th>
    		</tr>
    		<tr>
			<td>
	    		<div class="basic_tb">  
	    		<ul> 
                    <li>
                        {$lang.transport_start_date}：{$rs.transport_start_date}	
                    </li>
                    
                    <li>
                        {$lang.transport_type}：{$rs.dd_transport_type}
                    </li>
                    
                    <li>
                        {$lang.arrive_date}：{$rs.expected_arrival_date}
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
        <tr><td>{include file="OutBatch/review_weight_detail.tpl"}</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

