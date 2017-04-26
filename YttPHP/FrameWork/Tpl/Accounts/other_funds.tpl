<!--<link rel="stylesheet" href="__PUBLIC__css/jquery.tabs.css" type="text/css"/>-->
{literal}
<script>
$(function() {
//	$("ul.tabs").tabs("div.panes > div");
//	alert($("ul.tabs").tabs("div.panes > div").size())
	$dom.find("#tabs_1").trigger("click");
});  

function setCurrentClass(obj){
	$('.tabs').find(".current").removeClass('current');
	$(obj).addClass("current");
}

function clearPaidType(paid_type){
	var clear_array	=	new Array();
	clear_array	=	''
	if(paid_type==1){
		var clear_html=['pay_cash_money',
						'pay_cash_currency_id',
						'pay_cash_currency_name',
						'pay_cash_paid_date',
						'pay_cash_comments']; 
		clearHtmlValueArray(clear_html)//清空数据 
	}else if(paid_type==2){
		var clear_html	=[	'pay_bill_bill_no',
							'pay_bill_money', 
							'pay_bill_bill_date',
							'pay_bill_paid_date',
							'pay_bill_comments',
							'pay_bill_currency_id',
							'pay_bill_currency_name'];//需要清除的值 
		//清除页面提交后的值 
		clearHtmlValueArray(clear_html);//清空数据 
	}else if(paid_type==3){
		var clear_html	=	['pay_transfer_bank_id',
							'pay_transfer_bank_name',
							'pay_transfer_money', 
							'pay_transfer_paid_date',
							'pay_transfer_comments'];//需要清除的值
		//清除页面提交后的值
		clearHtmlValueArray(clear_html);//清空数据 
	}else{  
	} 
} 
</script>
{/literal}


 <table border="0" cellspacing="0" cellpadding="0" align="center">
 <tr><td> 
	 	<input type="hidden" id="pay_paid_type" name="pay_paid_type" 	value="1" >
	 	<input type="hidden" id="pay_include" 	name="pay_include" 		value="pay_only" > 
<ul class="tabs">
	<li><a href="#" onclick="addPaidType(1);setCurrentClass(this);" id="tabs_1" class="current">{$lang.cash}</a></li>
	<li><a href="#" onclick="addPaidType(2);setCurrentClass(this);">{$lang.pay_bill}</a></li>
	<li><a href="#" onclick="addPaidType(3);setCurrentClass(this);">{$lang.pay_transfer}</a></li>
</ul>
<div class="panes">
<div id="cash"> 
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
    {currency data=C('COMPANY_CURRENCY') name="pay_cash_currency_id" id="pay_cash_currency_id" value=$rs.currency_id type='tr' title=$lang.currency_name require="" }
	<td>{$lang.cash_money}：</td>	
	<td class="t_left"><input type="text" id="pay_cash_money" name="pay_cash_money" class="spc_input" value="{if $rs.paid_type==1}{$rs.dml_money}{/if}">__*__</td>
	</tr>
	 <tr>
	<td>{$lang.paid_date}：</td>	
	<td class="t_left"><input type="text" id="pay_cash_paid_date" name="pay_cash_paid_date" class="Wdate spc_input" value="{if $rs.paid_type==1}{$rs.fmd_paid_date}{/if}" onClick="WdatePicker()"/>__*__</td></tr>
	<tr>
	<td valign="top">{$lang.comments}：</td>	
	<td class="t_left"><input type="text" id="pay_cash_comments" name="pay_cash_comments" class="spc_input" value="{if $rs.paid_type==1}{$rs.edit_comments}{/if}"></td></tr>	
</table>
	</div>
	<div id="bill">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 	{currency data=C('COMPANY_CURRENCY') name="pay_bill_currency_id" id="pay_bill_currency_id" value=$rs.currency_id type='tr' title=$lang.currency_name require="" }
    <tr>
	<td>{$lang.bill_no}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_bill_no" name="pay_bill_bill_no" class="spc_input">__*__</td>
	</tr>
	 <tr>
	<td>{$lang.bill_money}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_money" name="pay_bill_money" class="spc_input" value="{if $rs.paid_type==2}{$rs.dml_money}{/if}">__*__</td></tr>
	<tr>
	<td>{$lang.bill_date}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_bill_date" name="pay_bill_bill_date" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</td></tr>
		<tr>
	<td>{$lang.paid_date}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_paid_date" name="pay_bill_paid_date" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</td></tr>	
		<tr>
	<td valign="top">{$lang.comments}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_comments" name="pay_bill_comments" class="spc_input" ></td></tr>		
</table>
	</div>
	
	<div id="transfer"> 
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center"> 
    <tr><td class="width150">{$lang.pay_bank}：</td>	
    
	<td class="t_left">
				<input type="hidden" 	name="pay_transfer_bank_id" id="pay_transfer_bank_id" value="" >
            	<input type="text" 		name="pay_transfer_bank_name" id='pay_transfer_bank_name' url="{'AutoComplete/bank'|U}" jqac>__*__
	</td></tr>  
    <tr>
	<td>{$lang.transfer_money}：</td>	
	<td class="t_left"><input type="text" id="pay_transfer_money" name="pay_transfer_money" class="spc_input" value="{if $rs.paid_type==3}{$rs.dml_money}{/if}">__*__</td>
	</tr>
	 <tr>
	<td>{$lang.paid_date}：</td>	
	<td class="t_left"><input type="text" id="pay_transfer_paid_date" name="pay_transfer_paid_date" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</td></tr>
	<tr>
	<td valign="top">{$lang.comments}：</td>	
	<td class="t_left"><input type="text" id="pay_transfer_comments" name="pay_transfer_comments" class="spc_input"></td></tr>	
</table>		
	</div>	
</div>
</td></tr></table>

