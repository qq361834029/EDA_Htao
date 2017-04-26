<form action="{'Instock/update'|U}" method="POST" >
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
<input type="hidden" name="instock_no" value="{$rs.instock_no}">	
<input type="hidden" name="step" value="2">
<input type="hidden" name="flow" id="flow" value="instock">
<input type="hidden" name="instock_type" value="{$rs.instock_type}">
	 
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th>
				<div class="titleth">
    				<div class="titlefl">{$lang.basic_info}</div>
    				<div class="afr">{$lang.instock_no}：{$rs.instock_no}</div>
    			</div>
			</th>
		</tr>
		<tr>
			<td>
				{include file="Instock/restricted_main_info.tpl"}				
  			</td>
  		</tr> 
    	<tr>
    		<th>{$lang.box_detail_info}</th></tr>
    	<tr>
    		<td  class="t_center" id="box">
    			{include file="Instock/box_detail.tpl"}
    		</td>
    	</tr>
		{if $rs.product}
    	<tr>
    		<th>{$lang.detail_info}</th></tr>
    	<tr>
    		<td  class="t_center" id="product">
				{include file="Instock/product_detail.tpl"}
    		</td>
    	</tr>		
		{/if}
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%">{$lang.client_comments}：</td>
						<td colspan="3" class="t_left" valign="top"><textarea class="disabled" disabled="disabled">{$rs.edit_client_comments}</textarea></td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 	 
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%">{$lang.warehouse_comments}：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="comments" id="comments" class="textarea_height80">{$rs.edit_comments}</textarea> </td>
					</tr>
	    		</table>
	    	</td>
	    </tr>	
			<tr>
				<td style="padding-top:10px;">
					<table cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td valign="top" width="15%" class="t_right">{$lang.pics}：</td>
							<td colspan="3" class="t_left" valign="top">{showFiles from=$rs.pics}</td>
						</tr>
					</table>
				</td>
			</tr> 		
    </tbody>
</table>
   {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form>