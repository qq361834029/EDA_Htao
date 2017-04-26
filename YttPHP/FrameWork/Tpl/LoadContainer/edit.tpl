<script type="text/javascript">
	{if $rs.id}
		$(document).ready(function(){
			var parent	= $dom.find('.detail_list').find('tr:hidden');
			$(parent).find('input[name=order_no]').attr({ 'where':'order_state<3','jqac':true,'url':APP+'/AutoComplete/orderNo' });
			$(parent).find('input[name=order_no]').initAutocomplete();
			$(parent).find('input[name*="product_no]"]').attr({ 'where':'','jqac':true,'url':APP+'/AutoComplete/orderProduct' });
			$(parent).find('input[name*="product_no]"]').initAutocomplete();
		});
	{/if}
</script>
<form action="{'LoadContainer/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
<input type="hidden" name="fund_logistics_norms" value="{'instock.instock_logistics_funds'|C}">
{wz action="save,hold,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.load_container_basic}<input type="hidden" id="flow" value="loadcontainer"></div>
    				<div class="afr">{$lang.load_container_no}：{$rs.load_container_no}</div>
    			</div></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li>{$lang.container_no}：<input type='text' name='container_no' value="{$rs.container_no}" class="spc_input"/>__*__</li>
    <li>{$lang.trans_comp}：
    <input type="hidden" name="logistics_id" value="{$rs.logistics_id}">
    <input type="text" value="{$rs.logistics_name}" url="{'AutoComplete/logistics'|U}" jqac>{if C("instock.instock_logistics_funds")==1}__*__{/if}
   </li>
   <li>{$lang.load_date}：<input type="text" name="load_date" id="load_date" value="{$rs.fmd_load_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</li>
    <li>{$lang.delivery_date}：<input type='text' name='delivery_date' id="delivery_date" value="{$rs.fmd_delivery_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	</li>
     <li>{$lang.expect_arrive_date}：<input type='text' name='expect_arrive_date' id="expect_arrive_date" value="{$rs.fmd_expect_arrive_date}"  class="Wdate spc_input" onClick="WdatePicker()"/>__*__	</li>
    		</ul>
    		</div>
    		</td></tr> 		
    		<tr>
    			<th >{$lang.query_orders}</th>
    		</tr>
    		<tr>
	    		<td colspan="4" class="t_left">
	    			&nbsp;&nbsp;&nbsp;
	    			<label>{$lang.order_no}：</label>
						<input type="hidden" name="logistics_norms" id="logistics_norms" value="{C("instock.instock_logistics_funds")}">
						<input type="hidden"  id="order_id" value="">
						<input type="text" url="{'AutoComplete/orderNo'|U}" jqac>
	            	&nbsp;
	            	<label>{$lang.factory_name}：</label>
						<input type='hidden' id='factory_id'>
						<input type="text" url="{'AutoComplete/factory'|U}" jqac>
	             	&nbsp;
	             	<label>{$lang.product_no}：</label>
						<input type='hidden' name="product_id" id='product_id'>
						<input type="text" url="{'AutoComplete/product'|U}" jqac>
	             	&nbsp;
	             	<button type="button" class=other onmouseover="this.className='mover_other'" onmouseout="this.className='other'" onclick="getUnLoadOrders();" value="{$lang.search}">{$lang.search}</button>
					 &nbsp;<button type="button" class=other onmouseover="this.className='mover_other'" onmouseout="this.className='other'" onclick="$.clearData();" value="{$lang.clear}" id="clear_load">{$lang.clear}</button>
					 <div id="loadContrain"></div>
	    		</td>
    		</tr>
    		<tr>
    			<th >{$lang.load_container_detail}</th>
    		</tr>
    	   <tr><td>
			{include file="LoadContainer/detail.tpl"}
			</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="15%" class="t_right" valign="top">{$lang.comments}：</td>
					<td width="35%" valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80" name="comments">{$rs.edit_comments}</textarea></td>
					<td>
					{include file="LoadContainer/factoryTotal.tpl"}
				</td>
				</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

