{note}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
	<tbody>  
		<tr>
			<td colspan="6">
			<div class="product_basic">  
    			<ul> 
    				<li class="t_right tbold">{$lang.product_no}：</li>
    				<li class="t_left">{$basic_info.product_no}</li>
					<li class="t_right tbold">{$lang.custom_barcode}：</li>
    				<li class="t_left">{$basic_info.custom_barcode}</li>
    				<li class="t_right tbold">{$lang.product_name}：</li>
    				<li class="t_left">{$basic_info.product_name}</li>
    			</ul>
			</td>
    	</tr>
    	<tr>
    		<th  colspan="6">{$lang.product_storage_info}</th>
    	</tr> 
		
    	<tr>
    		<td colspan="6" class="t_center">
    		<!-- 产品库存异动信息 -->
    			{include file='StatProduct/productSourceInstock.tpl'}
    		<!-- 产品库存异动信息 -->
    		</td>
    	</tr>
    		
    		 <tr>
    			<th  colspan="6">{$lang.product_basic_info}</th>
    		</tr>  
    		<tr>
    			<td colspan="6" class="t_center">
    				<!--产品基本信息-->
    				{include file='StatProduct/productBasicInfo.tpl'} 
    			</td>
    		</tr>     
    </tbody>
</table> 
</div>