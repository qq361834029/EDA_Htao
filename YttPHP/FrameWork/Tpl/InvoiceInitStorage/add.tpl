<form action="{"InvoiceInitStorage/insert"|U}" method="POST" >
{wz action='save,list,reset'}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table">
	<tbody>  
		<tr>
			<th colspan="4">{$lang.basic_info}</th>
		</tr>    	
    	<tr>
    		<td>{$lang.init_date}：</td>
    		<td  class="t_left">    		
    			<input type="text" name="init_date"  id="init_date" value="" class="Wdate spc_input" onClick="WdatePicker()"/>__*__		
    		</td>    			
    	</tr>    		 		
    	<tr>
    		<th  colspan="4">{$lang.detail_info}</th>
    	</tr>
    	<tr>
    		<td colspan="4" class="t_center">
    		{include file="InvoiceInitStorage/detail.tpl"}
    		</td>
    	</tr>       		
</tbody>
</table>
<br>
{staff}
</div>
</form>