<div class="product_tb">
	<ul>
		<li class="t_right tbold">{$lang.product_no}：</li><li>{$basic_info.product_no}</li>
		<li class="t_right tbold">{$lang.product_name}：</li><li>{$basic_info.product_name}</li>
		{if C('PRODUCT_CLASS_LEVEL')>=1}
		<li class="t_right tbold">{$lang.class_name}：</li><li>{$basic_info.class_name}</li>
		{/if}
		<li class="t_right tbold">{$lang.factory_name}：</li><li>{$basic_info.factory_name}</li>
		<div style="float:left;width:660px;clear:both;">
			<div class="t_right tbold" style="float:left;width:170px;">{$lang.cube}：</div>
			<div style="float:left;width:480px;text-align:left;">{$basic_info.s_unit_cube}</div>
		</div>	
		{if C('product_color')==1}
		<li class="t_right tbold">{$lang.color_name}：</li><li>{$basic_info.color}</li>
		{/if}
		{if C('product_size')==1}
		<li class="t_right tbold">{$lang.size_name}：</li><li>{$basic_info.size}</li>
		{/if}
		{if C("storage_format")>1}
		<li class="t_right tbold">{$lang.p_s_1}：</li><li>{$basic_info.dml_capability}</li>
		{/if}
		{if C("storage_format")==3}
		<li class="t_right tbold">{$lang.p_s_2}：</li><li>{$basic_info.dml_dozen}</li>
		<li class="t_right tbold">{$lang.p_s_3}：</li><li>{$basic_info.capability/$basic_info.dozen}</li>
		{/if}
		<li class="t_right tbold">{$lang.weight}：</li><li>{$basic_info.s_unit_weight}</li>
    	{foreach key=key item=item from=$basic_info.detail}
   		<li class="t_right tbold">{$item.properties_name}：</li><li>{$item.properties_value}</li>
    	{/foreach}  	
	</ul>
	
</div>
{if $basic_info.pics}
<div class="basic_tb t_left">
{$lang.product_pics}：
<br>
{showFiles from=$basic_info.pics}
</div>
{/if}
<!--
<table  class="list" align="center">
	<tbody>	   						
		<tr>
			<td width="10%">{$lang.product_no}：</td>
			<td width="25%" class="t_left" {if !C('BARCODE')}  colspan="3"{/if}>{$basic_info.product_no}</td>
    		{if C('BARCODE')}
    		<td width="10%">{$lang.barcode}：</td>
    		<td  class="t_left"><div class="linefeed">{$basic_info.barcode}</div></td>
    		{/if}						
    	</tr>
    	<tr>
    		<td width="10%">{$lang.product_name}：</td>
    		<td width="25%" class="t_left"> {$basic_info.product_name}</td>  
    		<td rowspan="12" width="10%">{$lang.product_pics}：</td>
    		<td rowspan="12">{showFiles from=$basic_info.pics}</td>    							
    	</tr>
	{if C('PRODUCT_CLASS_LEVEL')>=1}
    	<tr>
    		<td>{$lang.class_name}：</td>
    		<td  class="t_left">{$basic_info.class_name}</td>    							
    	</tr>
	{else}
	<tr>
    		<td>&nbsp;</td>
    		<td  class="t_left">&nbsp;</td>    							
    	</tr>
	{/if}
    	<tr>
    		<td>{$lang.factory_name}：</td>
    		<td  class="t_left">{$basic_info.factory_name}</td>    							
    	</tr>
    	{if C('product_color')==1}
    	<tr>
     		<td>{$lang.color_name}：</td>
     		<td class="t_left">{$basic_info.color}</td>     							
   		</tr>
   		{/if}
    	{if C('product_size')==1}
    	<tr>
     		<td>{$lang.size_name}：</td>
      		<td class="t_left">{$basic_info.size}</td>      							
    	</tr>
    	{/if}
    	{if C("storage_format")>1} 
		<tr>
			<td>{$lang.p_s_1}：</td>
			<td class="t_left">{$basic_info.dml_capability}</td>
		</tr>
		{/if}
		{if C("storage_format")==3}
		<tr>
			<td>{$lang.p_s_2}：</td>
			<td class="t_left">{$basic_info.dml_dozen}</td>
		</tr>
		<tr>
			<td>{$lang.p_s_3}：</td>
			<td class="t_left">{$basic_info.capability/$basic_info.dozen}</td>
		</tr>
		{/if}
		<tr>
			<td>{$lang.cube}：</td>
			<td class="t_left">{$basic_info.s_unit_cube}</td>
		</tr>
		<tr>
			<td>{$lang.weight}：</td>
			<td class="t_left">{$basic_info.s_unit_weight}KG</td>
		</tr>
    	{foreach key=key item=item from=$basic_info.detail}
   		<tr>
      		<td>{$item.properties_name}：</td>
      		<td class="t_left">
     			{$item.properties_value}
     		</td>
   		</tr>
    	{/foreach}  						
    </tbody>
</table>
-->