<form action="{'Shipping/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz is_update=$rs.is_update}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.basic_info}</div>
    			</div></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li>
	    		{$lang.shipping_no}：{$rs.express_no}
    		</li>				
    		<li>
	    		{$lang.shipping_name}：{$rs.express_name}
    		</li>
            <li>
			{$lang.shipping_type}：
			{$rs.dd_shipping_type}
			</li>	
			<li>{$lang.is_enable}：{$rs.dd_status}</li>           
    		<li>{$lang.express_date}：{$rs.express_date}</li>
			<li>{$lang.express}：{$rs.comp_name}</li>
			<li>{$lang.warehouse_name}：{$rs.w_name}</li>
            <li>{$lang.currency}:{$rs.currency_no}</li>
            <li>{$lang.is_enable_volume}：{$rs.dd_calculation}</li>
            <li>{$lang.whether_api_enabled}：{$rs.dd_enable_api}</li>
            <li>{$lang.is_enable_print}：
                {if $rs.enable_print==1}
                {$lang.yes}
                {/if}
                {if $rs.enable_print==2}
                {$lang.no}
                {/if}
            </li>
    		</ul>
    		</div>
    		</td></tr> 		
    		<tr>
				<th >{$lang.detail_info}<span class="red">({$lang.post_interval_remarks})</span></th>
    		</tr>
    	   <tr><td>{include file="Shipping/detail.tpl"}</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
					<td valign="top" class="t_left" width="80%">{$rs.edit_comments}</td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

