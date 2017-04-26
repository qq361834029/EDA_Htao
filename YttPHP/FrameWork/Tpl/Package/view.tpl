{wz is_update=$rs.is_update}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
        <tr>   
            <td class="width10">{$lang.belongs_warehouse}：</td>
            <td class="t_left">{$rs.w_name}</td>
        </tr>
        <tr>   
            <td class="width10">{$lang.currency}：</td>
            <td class="t_left">{$rs.currency_no}</td>
        </tr>
		<tr>
      		<td class="width10">{$lang.package_name}：</td>
      		<td class="t_left">{$rs.package_name}</td>
    	</tr>
    	<tr>
      		<td>{$lang.package_spec}：</td>
      		<td class="t_left"> 
			{$lang.long}{$rs.dml_cube_long} {C('SIZE_UNIT')}*
			{$lang.wide}{$rs.dml_cube_wide} {C('SIZE_UNIT')}*
			{$lang.high}{$rs.dml_cube_high} {C('SIZE_UNIT')}
			={$rs.dml_cube}{C('VOLUME_SIZE_UNIT')}
		</td>
    	</tr>
    	<tr>
      		<td>{$lang.weight}：</td>
      		<td class="t_left">{$rs.dml_weight} {C('WEIGHT_UNIT')}</td>
    	</tr>
    	<tr>
      		<td>{$lang.price}：</td>
      		<td class="t_left">{$rs.dml_price}{$rs.currency_no}</td>
    	</tr>
    	<tr>
      		<td valign="top">{$lang.comment}：</td>
      		<td class="t_left" valign="top">
			<p class="line_24">
				{$rs.edit_comments|nl2br}
			</p>
		</td>
    	</tr>
	</tbody>
</table> 
</div>