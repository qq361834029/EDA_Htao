<form action="{'InstockStorage/view'|U}" method="POST" beforeSubmit="">
    {wz}
<input type="hidden" name="flow" id="flow" value="instock_storage">
<div class="add_box">
<input type="hidden" id="id" name="id" value="{$rs.id}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th>
				<div class="titleth">
    				<div class="titlefl">{$lang.basic_info}</div>
    				<div class="afr">{$lang.delivery_no}：{$rs.instock_no}</div>
    			</div>
			</th>
		</tr>
		<tr>
			<td>
				{include file="InstockStorage/restricted_main_info.tpl"}				
  			</td>
  		</tr> 
		{if $rs.product}
    	<tr>
    		<td  class="t_center">
    			{include file="InstockStorage/product_detail.tpl"}
    		</td>
    	</tr>		
		{/if}
			<tr>
				<td style="padding-top:10px;">
					<table cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td valign="top" width="15%" class="t_right">{$lang.comments}：</td>
							<td colspan="3" class="t_left" valign="top"><textarea >{$rs.edit_comments}</textarea></td>
						</tr>
					</table>
				</td>
			</tr> 			
    </tbody>
</table>
   {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form>