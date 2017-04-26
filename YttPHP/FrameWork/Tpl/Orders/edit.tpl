<form action="{'Orders/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.order_basic}</div>
    				<div class="afr">{$lang.order_no}：{$rs.order_no}</div>
    			</div><input type="hidden" id="flow" value="orders"></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li>{$lang.order_no}：{$rs.order_no}</li>
    		<li class="w320">
    		{$lang.factory_name}：
    		
    		
    		<input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}" {if C('PRODUCT_FACTORY')==1}onchange="$.productEnabled(this)"{/if}>
    		{if $rs.order_state>0}
    			{$rs.factory_name}
    		{else}
    			<input type="text" name="factory_name" value="{$rs.factory_name}" id='factory_name' url="{'AutoComplete/factory'|U}" jqac>__*__
    		{/if}
    			{quicklyAdd module="Product"}</li>
    		</li>
    		
    		{if $rs.order_state>0}
    			{currency type='li' title=$lang.currency name="currency_id" id='currency_id' data=C('FACTORY_CURRENCY') value="{$rs.currency_id}" view="true"}
    		{else}
				{currency type='li' title=$lang.currency name="currency_id" id='currency_id' data=C('FACTORY_CURRENCY') value="{$rs.currency_id}"}
			{/if}
    		
    		<li>{$lang.order_date}：<input type="text" name="order_date"  id="order_date" value="{$rs.fmd_order_date}" class="Wdate spc_input" onClick="WdatePicker()"/> __*__</li>
    		<li>{$lang.expect_date}：<input type="text" name="expect_date" id="expect_date" value="{$rs.fmd_expect_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	</li>
    		<li></li>
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
					<td valign="top" class="t_left" width="80%"><textarea id="receive_addr" class="textarea_height80" name="comments">{$rs.edit_comments}</textarea></td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

