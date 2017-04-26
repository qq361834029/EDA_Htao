<form action="{'Factory/insert'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="comp_type" value="2">
<div class="table_autoshow" style="border-style:none!important;">
<table cellspacing="0" cellpadding="0"  align="center" width="100%">
    <tbody>
    	<tr>
    		<th colspan="2">{$lang.factory_basic}</th>
    	</tr>
     	<tr>
      		<td class="width20">{$lang.factory_no}：</td>
      		<td class="t_left"><input type="text" name="comp_no" value="{$max_no}"  {$is_auto_no}>__*__</td>
    	</tr>
    	<tr>
      		<td>{$lang.factory_name}：</td>
      		<td class="t_left">
      			<input type="text" name="comp_name" class="spc_input" >__*__
      		</td>
    	</tr>
    	{currency type='tr' title=$lang.currency data=C('FACTORY_CURRENCY') name="currency_id" empty=true require='' itemto="dialog-quickly_add"}
    	<tr>
    		<th colspan="2">{$lang.add_moe}[<a href="javascript:;" onclick="$.quicklyMore(this)">{$lang.add_open}</a>]</th>
    	</tr>
    	</tbody></table>
    	
    	<table cellspacing="0" cellpadding="0" class="table_autoshow_hidden" align="center">
    	<tr>
      		<td class="width20">{$lang.factory_country}：</td>
      		<td class="t_left">
      			<input type="hidden" name="country_id" class="spc_input" onchange="getCity(this,'dialog-quickly_add')">
      			<input type="text" name="temp[country_name]" url="{'AutoComplete/country'|U}" jqac itemto="dialog-quickly_add"/>
      		</td>
    	</tr>
    	<tr>
      		<td>{$lang.factory_city}：</td>
      		<td class="t_left"><span id="city">{$lang.select_country}</span></td>
    	</tr>
    	<tr>
      		<td>{$lang.repayment_day}：</td>
      		<td class="t_left"><input type="text" name="remind_day" value="" class="spc_input" >
    	</tr>
     	<tr>
      		<td>{$lang.iva}：</td>
      		<td class="t_left"><input type="text" name="iva" class="spc_input" ></td>
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
      		<td valign="top">{$lang.address}：</td>
      		<td class="t_left"><textarea name="address"></textarea></td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.comments}：</td>
      		<td class="t_left"><textarea name="comments"></textarea></td>
    	</tr>
	</tbody>
</table>
</div>
</form>