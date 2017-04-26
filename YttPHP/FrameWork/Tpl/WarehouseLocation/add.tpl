<form action="{'WarehouseLocation/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>		
		<tr>
		  <td>{$lang.belongs_warehouse}：</td>
		  <td class="t_left">
		  <input type="hidden" name="warehouse_id" id="warehouse_id" >
		  <input id="w_name" name="temp[w_name]" url="{'/AutoComplete/warehouseName'|U}" jqac>__*__<span class="font_red">({$lang.cannot_modify_after_saved})</span>
		  </td>
		</tr>  		
		<tr>
			<td>{$lang.zone_type}：</td>
			<td class="t_left">
				{radio data=C('CFG_ZONE_TYPE') value=1 name="zone_type"}
			</td>
		</tr> 		
		<tr>
			<td class="width10">{$lang.reservoir_no}：</td>
			<td class="t_left"><input type="text" name="location_no" class="spc_input" />__*__</td>
		</tr>
		<tr>
			<td>{$lang.shelves_cols}：</td>
			<td class="t_left">
				<input type="text" name="col_number" class="spc_input" >__*__</td>
		</tr>
		<tr>
			<td>{$lang.starting_layers}：</td>
			<td class="t_left">
				<input type="text" name="layer_start" class="spc_input" value="1" ><span class="font_red">({$lang.starting_layers_over_the_limit})</span></td>
		</tr>
		<tr>
			<td>{$lang.shelves_layers}：</td>
			<td class="t_left">
				<input type="text" name="layer_number" class="spc_input" >__*__</td>
		</tr>
		<tr>
			<td>{$lang.layer_boxs}：</td>
			<td class="t_left">
				<input type="text" name="box_number" class="spc_input" >__*__</td>
		</tr> 
		<tr>
			<td>{$lang.path_sort}：</td>
			<td class="t_left"><input type="text" name="path_sort" class="spc_input"/></td>
		</tr>
		<tr>
			<td valign="top">{$lang.comments}：</td>
			<td class="t_left"><textarea name="comments" rows="5" cols="60"></textarea></td>
		</tr>
	</tbody>
</table>
</div>  
</form> 

