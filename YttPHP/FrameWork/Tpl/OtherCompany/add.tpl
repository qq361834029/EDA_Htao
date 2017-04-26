<form action="{'OtherCompany/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="comp_type" value="4">
<table cellspacing="0" cellpadding="0" class="add_table" align="center">
    <tbody>
    	<tr>
    		<th colspan="2">{$lang.o_company_basic}</th>
    	</tr>
     	<tr>
      		<td class="width15">{$lang.factory_no}：</td>
      		<td class="t_left"><input type="text" name="comp_no" value="{$max_no}" {if $is_auto_no} readonly class="spc_input disabled" {else} class="spc_input" {/if} >__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.factory_name}：</td>
      		<td class="t_left"><input type="text" name="comp_name" class="spc_input" >__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.factory_country}：</td>
		    <td class="t_left">
		    	<input type="hidden" name="country_id" class="spc_input" onchange="getCity()">
		    	<input type="text" name="temp[country_name]" url="{'AutoComplete/country'|U}" jqac />
      		</td>
    	</tr>
    	<tr>
      		<td>{$lang.factory_city}：</td>
      		<td class="t_left"><span id="city">{$lang.select_country}</span></td>
    	</tr>
    	<tr>
    		<th colspan="2">{$lang.factory_contact}</th>
    	</tr>
    	<tr>
      		<td>{$lang.contact}：</td>
      		<td class="t_left"><input type="text" name="contact" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.mobile}：</td>
      		<td class="t_left"><input type="text" name="mobile" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.phone}：</td>
      		<td class="t_left"><input type="text" name="phone" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.address}：</td>
      		<td class="t_left"><input type="text" name="address" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.zip_code}：</td>
      		<td class="t_left"><input type="text" name="post_code" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.fax_no}：</td>
      		<td class="t_left"><input type="text" name="fax" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td>{$lang.email}：</td>
      		<td class="t_left"><input type="text" name="email" class="spc_input" ></td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.comments}：</td>
      		<td class="t_left"><textarea name="comments"></textarea></td>
    	</tr>
	</tbody>
</table>
</div>
</form>

