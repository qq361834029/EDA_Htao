<form action="{'InstockAbnormal/update'|U}" method="POST"  onsubmit="return false">
{wz action="list,reset"}
  <input type="hidden" name="id" value="{$rs.id}">
  <div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <tr>
		<th colspan="4">
			<div class="titleth">
				<div class="titlefl">{$lang.basic_info}</div>
				<div class="afr">{$lang.instock_no}：{$rs.file_list_no}</div>
			</div>			
		</th>
	</tr>
	<tr>
		<td colspan="4">
			<div class="basic_tb">  
				<ul> 
					<li>
						{$lang.warehouse_name}：
							<input type="hidden" name="warehouse_id" value="{$rs.warehouse_id}">{$rs.w_name}
					</li>
					<li>
						{$lang.location_no}：
							<input type="hidden" name="location_id" value="{$rs.location_id}">
							<input type="text" name="barcode_no" value="{$rs.barcode_no}" url="{'AutoComplete/locationNo'|U}" where="{" warehouse_id='{$rs.warehouse_id}' "|urlencode}" jqac/>__*__
					</li>	
					<li>
						{$lang.box_id}：
							<input type="hidden" name="box_no" value="{$rs.box_no}" onchange="$(this).parents('ul').find('#span_box_no').html(this.value)" />
							<input type="text" name="box_id" value="{$rs.box_id}" url="{'AutoComplete/instockDetailBoxId'|U}" where="{" warehouse_id='{$rs.warehouse_id}' "|urlencode}" jqac>__*__						
					</li>
					<li>
						{$lang.box_no}：
							<span id="span_box_no">{$rs.box_no}</span>
					</li> 					
					<li>
						{$lang.product_id}：
							<input type="hidden" name="product_no" value="{$rs.product_no}" onchange="$(this).parents('ul').find('#span_product_no').html(this.value)" />
							<input type="text" name="product_id" value="{$rs.product_id}" url="{'AutoComplete/instockProductId'|U}" jqac>__*__							
					</li>
					<li>
						{$lang.product_no}：
							<span id="span_product_no">{$rs.product_no}</span>
					</li> 		
					<li>
						{$lang.quantity}：
							<input type="text" name="quantity" value="{$rs.quantity}" class="spc_input" />__*__
					</li>    
					<li>
						{$lang.process_state}：
							{select data=C('CFG_FILE_IMPORT_STATE') name="state" initvalue=$rs.state combobox="1" empty=true filter=C('CFG_IMPORT_SUCCESS_STATE')}__*__
					</li>   					
				</ul>
			</div>  				
		</td>
	</tr> 	
    	<tr>
    		<th colspan="4">{$lang.detail_info}</th>
		</tr>		
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%">{$lang.error_cause}：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="comments" id="comments" class="textarea_height80">{$rs.edit_comments}</textarea> </td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 	
    </tbody>
  </table> 
{staff}
  </div>
</form>
