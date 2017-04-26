<form action="{'Orders/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.order_basic}</div>
    				<div class="afr">{$lang.order_no}：{$rs.order_no}</div>
    			</div></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li class="w320">
	    		{$lang.factory_name}：{$rs.factory_name}
    		</li>
    		
    		{currency type='li' title=$lang.currency name="currency_id" id='currency_id'  data=C('FACTORY_CURRENCY') view=true value="{$rs.currency_id}" }
    		
    		
    		<li>{$lang.order_date}：{$rs.fmd_order_date}</li>
    		<li>{$lang.expect_date}：{$rs.fmd_expect_date}</li>
    		</ul>
    		</div>
    		</td></tr> 		
    		<tr>
    			<th >{$lang.order_details}</th>
    		</tr>
    	   <tr><td>{include file="Orders/detail.tpl"}</td></tr>
	
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

