<form action="{"InvoiceInitStorage/update"|U}" method="POST" >
{wz action='save,list,reset'}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
	<tbody>  
		<tr>
			<th colspan="4">{$lang.basic_info}</th>
		</tr>    	
    	<tr>
    		<td>{$lang.doc_no}：</td>
    		<td class="t_left">
    		{$rs.init_no}
    		</td>
    		<td>{$lang.init_date}：</td>
    		<td  class="t_left">    		
    			<input type="text" name="init_date"  id="init_date" value="{$rs.fmd_init_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__		
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
{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form>