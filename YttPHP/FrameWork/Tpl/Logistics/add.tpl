<form action="{'Logistics/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="comp_type" value="2">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
    	<tr>
    		<th colspan="2">{$lang.basic_info}</th>
    	</tr>		
		<tr>
			<td class="width15">{$lang.code}：</td>
      		<td class="t_left"><input type="text" name="comp_no" value="{$max_no}" {if $is_auto_no} readonly class="spc_input disabled" {else} class="spc_input" {/if} >__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.logistics_name}：</td>
      		<td class="t_left">
      			<input type="text" name="comp_name" class="spc_input" >__*__
      		</td>
    	</tr>
    	<tr>
      		<td>{$lang.tax_no}：</td>
      		<td class="t_left"><input type="text" name="tax_no" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.contact}：</td>
      		<td class="t_left"><input type="text" name="contact" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.phone}：</td>
      		<td class="t_left"><input type="text" name="mobile" class="spc_input" ></td>
    	</tr>
    	<tr>
    		<th colspan="2">{$lang.contact_info}</th>
    	</tr>		
    	<tr>
      		<td>{$lang.belongs_country}：</td>
      		<td class="t_left">
			<input type="text" id="country_name" name="country_name" class="spc_input">
			<input type="hidden" name="country_id" id="country_id" class="spc_input">
			<input type="text" name="temp[full_country_name]" url="{'AutoComplete/country'|U}" jqac >
      		</td>
    	</tr>
    	<tr>
      		<td>{$lang.belongs_city}：</td>
      		<td class="t_left">
			<input id="city_name" type="text" name="city_name" class="spc_input">
		</td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.street1}：</td>
      		<td class="t_left"><input type="text" name="address" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.street2}：</td>
      		<td class="t_left"><input type="text" name="address2" class="spc_input" ></td>
    	</tr>	
    	<tr>
      		<td valign="top">{$lang.post_code}：</td>
      		<td class="t_left"><input type="text" name="post_code" class="spc_input" ></td>
    	</tr>			
    	<tr>
      		<td>{$lang.email}：</td>
      		<td class="t_left"><input type="text" name="email" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.fax_no}：</td>
      		<td class="t_left"><input type="text" name="fax" class="spc_input" ></td>
    	</tr>		
   	 	<tr>
      		<td>{$lang.web_url}：</td>
      		<td class="t_left"><input type="text" name="web_url" class="spc_input" ></td>
	    </tr>
    	<tr>
      		<td valign="top">{$lang.comments}：</td>
      		<td class="t_left" valign="top"><textarea name="comments"></textarea></td>
    	</tr>
	</tbody>
</table>
</div>
</form>

