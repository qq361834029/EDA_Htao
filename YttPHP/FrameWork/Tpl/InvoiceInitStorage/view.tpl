<form action="{"InvoiceInitStorage/insert"|U}" method="POST" >
{wz}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
	<tbody>  
		<tr>
			<th colspan="4">
			<div class="titleth">
	    		<div class="titlefl">{$lang.basic_info}</div>
	    		<div class="afr">{$lang.doc_no}：{$rs.init_no}</div>
	    	</div>
			</th>
		</tr>    	
    	<tr>
    		<td width="10%">{$lang.init_date}：</td>
    		<td  class="t_left">    		
    			{$rs.fmd_init_date}
    		</td>
    		<td>&nbsp;</td> 
    		<td>&nbsp;</td>    			
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