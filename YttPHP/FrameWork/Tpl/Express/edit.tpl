<form action="{'Express/update'|U}" method="POST"  onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>			
		<tr>
      		<td class="width15">{$lang.code}：</td>
      		<td class="t_left"><input type="text" name="comp_no" value="{$rs.comp_no}" {$is_auto_no}>__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.express_name}：</td>
      		<td class="t_left">
      			<input type="text" name="comp_name" value="{$rs.comp_name}" class="spc_input" >__*__
      		</td>
    	</tr>
	<tr>
      		<td>{$lang.priority}：</td>
      		<td class="t_left">
      			<input type="text" name="priority" class="spc_input" value="{$rs.priority}">
      		</td>
    	</tr>
    	<tr>
      		<td>{$lang.tax_no}：</td>
      		<td class="t_left"><input type="text" name="tax_no" value="{$rs.tax_no}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.contact}：</td>
      		<td class="t_left"><input type="text" name="contact" value="{$rs.contact}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.phone}：</td>
      		<td class="t_left"><input type="text" name="mobile" value="{$rs.mobile}" class="spc_input" ></td>
    	</tr>
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>			
    	<tr>
      		<td >{$lang.belongs_country}：</td>
      		<td class="t_left">
      			<input type="text" name="country_name" class="spc_input" value="{$rs.country_name}">
			<input type="hidden" name="country_id" id="country_id" class="spc_input" value="{$rs.country_id}">
			<input id="country_name" name="temp[full_country_name]" value="{$rs.full_country_name}" url="{'AutoComplete/country'|U}" jqac >
      		</td>
    	</tr>
    	<tr>
      		<td >{$lang.belongs_city}：</td>
      		<td class="t_left">
      			<input type="text" name="city_name" value="{$rs.city_name}" class="spc_input">
      		</td>
    	</tr>		
     	<tr>
      		<td >{$lang.street1}：</td>
      		<td class="t_left"><input type="text" name="address" value="{$rs.edit_address}" class="spc_input" ></td>
    	</tr>		
     	<tr>
      		<td >{$lang.street2}：</td>
      		<td class="t_left"><input type="text" name="address2" value="{$rs.edit_address2}" class="spc_input" ></td>
    	</tr>			
    	<tr>
      		<td >{$lang.post_code}：</td>
      		<td class="t_left"><input type="text" name="post_code" value="{$rs.post_code}" class="spc_input" ></td>
    	</tr>		
    	<tr>
      		<td>{$lang.email}：</td>
      		<td class="t_left"><input type="text" name="email" value="{$rs.email}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.fax_no}：</td>
      		<td class="t_left"><input type="text" name="fax" value="{$rs.fax}" class="spc_input" ></td>
    	</tr>				
    	<tr>
      		<td>{$lang.web_url}：</td>
      		<td class="t_left"><input type="text" name="web_url" value="{$rs.web_url}" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.comments}：</td>
      		<td class="t_left" valign="top"><textarea name="comments">{$rs.edit_comments}</textarea></td>
    	</tr>
	</tbody>
</table>
</div>
</form>

