{searchForm} 
<div id="print">
{wz printid=".add_table"}
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li class="w320">
	    		{$lang.factory}：{$rs.detail.0.factory_name}
    		</li>
    		<li>{$lang.product_no}：{$rs.detail.0.product_no}</li>
    		</ul>
    		</div>
    		</td></tr> 		
    		<tr>
    			<th >{$lang.instock_detail}</th>
    		</tr>
    	   <tr><td>{include file="StatInstock/detail.tpl"}</td></tr>
    	</tbody> 
    </table>
</div>

