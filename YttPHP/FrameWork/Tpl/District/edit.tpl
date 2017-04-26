{if $rs.parent_id==0}
<form action="{'District/update'|U}" method="POST"  onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" >
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
 		<tr>
 			<th colspan="2" class="t_left">{$lang.add_country}</th>
 		</tr> 
    	<tr>
      		<td class="width15">{$lang.country_name}：</td>
      		<td class="t_left"><input type="text" name="district_name" value="{$rs.district_name}" class="spc_input disabled" readonly/>__*__</td>
    	</tr> 
    	<tr>
    		<td>{$lang.country_no}：</td>
    		<td class="t_left">
				<input type="text" name="abbr_district_name" value="{$rs.abbr_district_name}" class="spc_input disabled" readonly>
    		</td>
    	</tr>
		<tr>
      		<td>{$lang.no_vat_quota}：</td>
      		<td  class="t_left"><input type="text" name="no_vat_quota" value="{$rs.no_vat_quota}" class="spc_input" >
      		</td>
    	</tr>
		<tr>
      		<td>{$lang.no_vat_warning}：</td>
      		<td  class="t_left"><input type="text" name="no_vat_warning" value="{$rs.no_vat_warning}" class="spc_input" >
      		</td>
    	</tr>
		<tr>
      		<td>{$lang.has_other_vat_quota}：</td>
      		<td  class="t_left"><input type="text" name="has_other_vat_quota" value="{$rs.has_other_vat_quota}" class="spc_input" >
      		</td>
    	</tr>
		<tr>
      		<td>{$lang.has_other_vat_warning}：</td>
      		<td  class="t_left"><input type="text" name="has_other_vat_warning" value="{$rs.has_other_vat_warning}" class="spc_input" >
      		</td>
    	</tr>
    </tbody>
</table>
</div>
</form> 
{else}
<form action="{'District/update'|U}" method="POST"  onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" > 
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
    	<tr>
    		<th colspan="2" class="t_left">{$lang.add_city}</th>
    	</tr>
    	<tr>
      		<td class="width5">{$lang.country_name}：</td>
      		<td class="t_left">
      			<input type="hidden" name="parent_id" value="{$rs.parent_id}" class="spc_input" >
      			<input type="text" name="country_name" url="{'AutoComplete/country'|U}" value="{$rs.country_name}" jqac />
      			__*__
     		</td>
    	</tr>
    	<tr>
      		<td class="width5">{$lang.city}：</td>
      		<td  class="t_left"><input type="text" name="district_name" value="{$rs.district_name}" class="spc_input" >__*__
      		</td>
    	</tr>
	</tbody>
</table> 
</div>
</form>
{/if}
