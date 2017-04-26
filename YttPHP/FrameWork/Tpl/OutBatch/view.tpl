{wz is_update=0}
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
                        {$lang.transport_start_date}：{$rs.transport_start_date}
                    </li>
                    
                    <li>
                        {$lang.transport_type}：{$rs.dd_transport_type}
                    </li>
                    
                    <li>
                        {$lang.arrive_date}：{$rs.expected_arrival_date}
                    </li>
                    
                    <li>
                        {$lang.delivery_fee}：{$rs.detail_total.dml_freight}
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

