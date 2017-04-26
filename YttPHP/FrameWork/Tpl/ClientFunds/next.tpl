 <form action="{'ClientFunds/insert'|U}" method="POST" onsubmit="return false">
{wz action="list,reset"}
<div class="add_box">
		<table cellspacing="0" cellpadding="0" class="add_table">
		<tbody>
			<input type="hidden" id="module_name" value="{$smarty.const.MODULE_NAME}" /> 
			<input type="hidden" name="id" id="id" value="{$rs.id}" class="spc_input" > 
			<input type="hidden" name="comp_type" id="comp_type" value="{$comp_type}" class="spc_input" > 
		<tr>
    			<th colspan="4">{$lang.factory_info}</th>
    	</tr>
    	<tr>
    			<td class="width15">{$lang.factory_name}：</td>
				<td class="t_left width30">
					<input type="hidden" name="comp_id" id="comp_id" value="{$rs.comp_id}">{$rs.client_name} 
				</td>
	            	{company  type="td" title=$lang.basic_name
					hidden=['name'=>'basic_id','id'=>'basic_id']
					name='basic_name'}
                    <input type="hidden" name="warehouse_id" value="{$rs.warehouse_id}">
		<tr>
		<tr>
    			<td>{$lang.currency_name}：</td>
				<td  class="t_left">
					<input type="hidden" name="currency_id" id="currency_id" value="{$rs.currency_id}">{$rs.currency_name} 
				</td>
				<td>{$lang.total_money}:&nbsp;</td>
				<td class="t_left">&nbsp;{$account.dml_money}{if $account.is_account_money==1}({$account.dml_account_money}){/if}</td> 
		</tr>
		<!--
		<tr>
    			<td>{$lang.show_need_get_info}：</td>
				<td  class="t_left">
					<input type="radio" name="is_appoint" id="is_appoint" {if C('how_assign_info')==2}checked{/if} value="2" onclick="getFundsInfo(this.value)">{$lang.no} 
					<input type="radio" name="is_appoint" id="is_appoint" {if C('how_assign_info')==1}checked{/if} value="1" onclick="getFundsInfo(this.value)">{$lang.yes}  
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td> 
		</tr>  
		<tr>
			<td colspan="4">
				{include file="Accounts/funds_info.tpl"}
				<script> 
					$(document).ready(function(){
						getFundsInfo({C('how_assign_info')});
					});
				</script>				
			</td>
		</tr>
		-->
		<tr>
    		<td colspan="4">
				{include file="Accounts/funds.tpl"}   	
				{include file="Accounts/funds_list.tpl"}
    		</td>
		</tr>
		 		
		</tbody>
		</table>
	</div>	
	<br><br><br>
 	</form> 	