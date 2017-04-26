<span class="red">{$lang.post_interval_remarks}</span>
<table  class="list" border="1"> 
	<tr>
		<th rowspan="1">{$lang.area}</th> 
		<th rowspan="1">{$lang.country_name}</th> 
		<th rowspan="1">{$lang.postcode_interval_with_note}</th> 
		<th rowspan="1">{$lang.weight_range}</th> 
		<th rowspan="1">{$lang.long_with_unit}</th> 
		<th rowspan="1">{$lang.wide_with_unit}</th>
		<th rowspan="1">{$lang.high_with_unit}</th>  
		<th rowspan="1">{$lang.bulk_with_unit}</th>  
		<th rowspan="1">{$lang.basic_price}</th>   
		<th rowspan="1">{$lang.registration_fee}</th>  
	</tr> 
	{foreach from=$shipping item=item}
	<tr>
		<td>{$item.area}</td>
		<td>{$item.abbr_district}</td>
		<td {if $item.post_is_express neq 1}class="disabled"{/if}>
{*			{if $item.post_begin&&$item.post_end}
			{$item.post_begin}<br>
			-<br>
			{$item.post_end}
			{elseif $item.post_begin}
			{$item.post_begin}
			{elseif $item.post_end}
			{$item.post_end}
			{/if}*}
            {$item.view_post_section}
		</td>
		<td>{$item.weight_begin}<br>
		-<br>{$item.weight_end}</td>
		<td>{$item.edml_cube_long}</td>
		<td>{$item.edml_cube_wide}</td>
		<td>{$item.edml_cube_high}</td>
		<td>{$item.edml_cube}</td>
		<td>{$item.edml_price}</td> 
		<td>{$item.edml_registration_fee}</td> 
	</tr>
	{/foreach}
</table>
<br><br> 