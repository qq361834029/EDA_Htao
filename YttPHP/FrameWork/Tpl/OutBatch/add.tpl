<form action="{'OutBatch/insert'|U}" method="POST" onsubmit="return false">
{wz action="list,reset"}
<input type="hidden" name="from_type" value="out_batch">
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.out_batch_basic}<input type="hidden" id="flow" value="out_batch"></div>
    			</div>
                </th>
    		</tr>
    		<tr>
			<td>
	    		<div class="basic_tb">  
	    		<ul> 
                    <li>
                        {$lang.transport_start_date}：<input type="text" name="transport_start_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
                    </li>
                    
                    <li>
                        {$lang.transport_type}：{select data=C('TRANSPORT_TYPE') name="transport_type" empty=true value="2" combobox=""}__*__
                    </li>
                    
                    <li>
                        {$lang.arrive_date}：<input type="text" name="expected_arrival_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>
                    </li>
                    
{*                    <li>
                        {$lang.delivery_fee}：<input type="text" name="freight" value="" class="spc_input"/>
                    </li>*}
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
    {staff}
</div>
</form> 

