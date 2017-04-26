<form action="{'Orders/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.order_basic}</div>
    			</div><input type="hidden" id="flow" value="orders"></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li class="w320">
    		{$lang.factory_name}：
    		<input type="hidden" name="factory_id" id="factory_id" {if C('PRODUCT_FACTORY')==1}onchange="$.productEnabled(this);getFacCurrencyId(this);"{else}onchange="getFacCurrencyId(this);"{/if}>
    		<input type="text" name="factory_name" id='factory_name' url="{'AutoComplete/factory'|U}" jqac>__*__
    			{quicklyAdd module="Product"}</li>
    		</li>
    		
				{currency type='li' title=$lang.currency name="currency_id" id='currency_id' data=C('FACTORY_CURRENCY')}
    		
    		<li>{$lang.order_date}：<input type="text" name="order_date" value="{$this_day}" id="order_date" class="Wdate spc_input" onClick="WdatePicker()"/> __*__</li>
    		<li>{$lang.expect_date}：<input type="text" name="expect_date" id="expect_date" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	</li>
    		<input type="hidden" name="order_state" id="order_state" value="0">
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
					<td valign="top" class="t_left" width="80%">
					<textarea id="receive_addr" class="textarea_height80" name="comments"></textarea></td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form> 

