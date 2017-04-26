{wz is_update=$is_update}
<div class="add_box">
{if $rs.parent_id==0} 
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" > 
    <tr>
      <td class="width15">{$lang.country}：</td>
      <td class="t_left">{$rs.district_name}</td>
    </tr> 
    <tr>
    	<td>{$lang.country_no}：</td>
    	<td class="t_left">{$rs.abbr_district_name}</td>
    </tr>
	<tr>
    	<td>{$lang.no_vat_quota}：</td>
    	<td class="t_left">{$rs.no_vat_quota}</td>
    </tr>
	<tr>
    	<td>{$lang.no_vat_warning}：</td>
    	<td class="t_left">{$rs.no_vat_warning}</td>
    </tr>
	<tr>
    	<td>{$lang.has_other_vat_quota}：</td>
    	<td class="t_left">{$rs.has_other_vat_quota}</td>
    </tr>
	<tr>
    	<td>{$lang.has_other_vat_warning}：</td>
    	<td class="t_left">{$rs.has_other_vat_warning}</td>
    </tr>
    </tbody>
  </table> 
{else} 
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody> 
    <input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" > 
    <tr>
      <td class="width5">{$lang.country}：</td>
      <td class="t_left">{$rs.country_name}</td>
    </tr>
    <tr>
      <td>{$lang.city}：</td>
      <td class="t_left">{$rs.district_name}</td>
    </tr> 
    </tbody>
  </table>
{/if}
</div>