<script>
$(function() {
//	$("ul.tabs").tabs("div.panes > div");
	$dom.find("#tabs_1").trigger("click");
});
 

//function addPaidType(v){  
//	var old_paid_type	=	$dom.find("#pay_paid_type").val(); 
//	if(old_paid_type>0){ 
//		clearPaidType(old_paid_type)
//	}   
//	$dom.find("#pay_paid_type").val(v);  
//}
//
////清楚默认信息
function clearHtmlValueArray(clear_array){ 
	for(var i in clear_array){  
		$dom.find("#"+clear_array[i]).val('');  
	}	
}


function addPaidFund(obj,vo){ 
	var form_name	=	'Funds_'+vo;	
	if(vo=='cash'){
		var pay_cash_currency_id	= $dom.find('#pay_cash_currency_id').val();
		var pay_cash_money			= $dom.find('#pay_cash_money').val();
		var pay_bill_rate			= $dom.find('#pay_bill_rate').val();
		var pay_cash_account_money	= $dom.find('#pay_cash_account_money').val();
		var pay_cash_paid_date		= $dom.find('#pay_cash_paid_date').val();
		data						= { pay_cash_currency_id:pay_cash_currency_id,
										pay_cash_money:pay_cash_money,
										pay_cash_account_money:pay_cash_account_money,
										pay_cash_paid_date:pay_cash_paid_date,
										pay_bill_rate:pay_bill_rate,
										type:'Cash'};
	}else if(vo=='bill'){
		var pay_bill_currency_id	= $dom.find('#pay_bill_currency_id').val();
		var pay_bill_bill_date		= $dom.find('#pay_bill_bill_date').val();
		var pay_bill_paid_date		= $dom.find('#pay_bill_paid_date').val();
		var pay_bill_bill_no		= $dom.find('#pay_bill_bill_no').val();
		var pay_bill_money			= $dom.find('#pay_bill_money').val();
		var pay_bill_account_money	= $dom.find('#pay_bill_account_money').val();
		var pay_bill_rate			= $dom.find('#pay_bill_rate').val();
		data					= { pay_bill_currency_id:pay_bill_currency_id,
								   pay_bill_bill_date: pay_bill_bill_date,
								   pay_bill_paid_date:pay_bill_paid_date,
								   pay_bill_bill_no:pay_bill_bill_no,
								   pay_bill_money:pay_bill_money,
								   pay_bill_account_money:pay_bill_account_money,
								   pay_bill_rate:pay_bill_rate,
								   type:'Bill'};
	}else if(vo=='transfer'){
		var pay_transfer_bank_id		= $dom.find('#pay_transfer_bank_id').val();
		var pay_transfer_money			= $dom.find('#pay_transfer_money').val();
		var pay_transfer_account_money	= $dom.find('#pay_transfer_account_money').val();
		var pay_transfer_paid_date		= $dom.find('#pay_transfer_paid_date').val();
        var pay_transfer_contact_name	= $dom.find('#pay_transfer_contact_name').val();
		data							= { pay_transfer_bank_id: pay_transfer_bank_id,
										   pay_transfer_money: pay_transfer_money,
										   pay_transfer_account_money:pay_transfer_account_money,
										   pay_transfer_paid_date:pay_transfer_paid_date,
                                           pay_transfer_contact_name:pay_transfer_contact_name,
										   type:'Transfer'};
	} 
	$.ajax({
		type: "POST",
		url: APP+"/Ajax/checkVaildPaid",
		dataType: "json",
		data:data,
		cache: false,
		async: false,
		success: function(result){
			if(result.errorStatus==0){
					//验证通过复制黏贴到TR当
				$dom.find("#pay_"+vo+"_show").after(getPaidHtml(vo))
			}else if(result.errorStatus==2){
				validity(result.error,$dom);
			}
		}
	});
}

//插入列表
function getPaidHtml(vo){ 
	var myDate 	= new Date();  
	var tr_id	= myDate.getTime() 
	if(vo=='cash'){    
		$dom.find("#show_cash_list_tr").show();
		$dom.find("#show_cash_list_info").show(); 
		$dom.find("#pay_cash_show").after(getPaidHtmlCash(tr_id))
	}else if(vo=='bill'){  
		$dom.find("#show_bill_list_tr").show();
		$dom.find("#show_bill_list_info").show(); 
		$dom.find("#pay_bill_show").after(getPaidHtmlBill(tr_id))
	}else if(vo=='transfer'){
		$dom.find("#show_transfer_list_tr").show();
		$dom.find("#show_transfer_list_info").show(); 
		$dom.find("#pay_transfer_show").after(getPaidHtmlTransfer(tr_id)) 
	} 
} 

//插入现金列表当中
function getPaidHtmlCash(tr_id){  
		var currency_id		=	$dom.find("#pay_cash_currency_id").val(); 
		var currency_name	=	$dom.find("#pay_cash_currency_id").find('option:selected').text();  
//		var currency_name	=	$dom.find("#pay_cash_currency_name").val(); 
		var money			=	$dom.find("#pay_cash_money").val();
		var rate			=	$dom.find("#pay_cash_rate").val();
		var account_money	=	$dom.find("#pay_cash_account_money").val();
		var paid_date		=	$dom.find("#pay_cash_paid_date").val(); 
		var comments		=	$dom.find("#pay_cash_comments").val(); 
		html_str  = "";
		html_str += '<tr id="cash'+tr_id+'">';
		{if $comp_currency_count!=1}
			html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='cash["+tr_id+"][currency_id]' value='"+currency_id+"'>"+currency_name+"</td>";
		{/if}
		html_str += "				<td style='border-bottom:1px solid #CCC;' class='t_right'><input type='hidden' name='cash["+tr_id+"][money]' value='"+money+"'>"+money+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'  class='t_right'><input type='hidden' name='cash["+tr_id+"][account_money]' value='"+account_money+"'>"+account_money+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='cash["+tr_id+"][rate]' value='"+rate+"'>"+rate+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='cash["+tr_id+"][paid_date]' value='"+paid_date+"'>"+paid_date+"</td>"; 
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='cash["+tr_id+"][comments]' value='"+comments+"'>"+comments+"</td>";  
		html_str += "		    	<td style='border-bottom:1px solid #CCC;'>";
		html_str += '				<a href="javascript:;" onclick=delFund(this,\'cash'+tr_id+'\');return false>'+lang['common']['delete']+'</a>';
		html_str += "				</td>	";	
		html_str += "</tr>";	  
		//清除页面提交后的值
		clearPaidType(1);
		
		return html_str;
}

function clearPaidType(paid_type){
	var clear_array	=	new Array();
	clear_array	=	''
	if(paid_type==1){
		var clear_html=['pay_cash_money',
						'pay_cash_account_money',
						'pay_cash_paid_date',
						'pay_cash_comments', 
//						'pay_cash_currency_name',
						'pay_cash_rate']; 
		clearHtmlValueArray(clear_html)//清空数据
		//给予默认
		$dom.find("#pay_cash_account_money").val(0);
		$dom.find("#pay_cash_rate").val(1);
	}else if(paid_type==2){
		var clear_html	=	'pay_bill_bill_no,pay_bill_money,pay_bill_account_money,pay_bill_bill_date,pay_bill_paid_date,pay_bill_comments,pay_bill_rate';//需要清除的值 
		//清除页面提交后的值 
		clearHtmlValue(clear_html);//清空数据
		//给予默认
		$dom.find("#pay_bill_account_money").val(0);
		$dom.find("#pay_bill_rate").val(1); 
	}else if(paid_type==3){
		var clear_html	=	'pay_transfer_bank_id,pay_transfer_bank_name,pay_transfer_money,pay_transfer_account_money,pay_transfer_paid_date,pay_transfer_comments,pay_transfer_currency_name,pay_transfer_rate';//需要清除的值
		//清除页面提交后的值
		clearHtmlValue(clear_html);//清空数据
		//给予默认
		$dom.find("#pay_transfer_account_money").val(0);
		$dom.find("#pay_transfer_rate").val(1);
	}
}

//删除支付信息
function delFund(obj,id){
	$("#"+id).remove();
} 





//插入支票列表当中
function getPaidHtmlBill(tr_id){ 
		
		var currency_id		=	$dom.find("#pay_bill_currency_id").val();
		var currency_name	=	$dom.find("#pay_bill_currency_id").find('option:selected').text();  
//		var currency_name	=	$dom.find("#pay_bill_currency_name").val(); 
		var bill_no			=	$dom.find("#pay_bill_bill_no").val();
		var money			=	$dom.find("#pay_bill_money").val();
		var account_money	=	$dom.find("#pay_bill_account_money").val();
		var rate			=	$dom.find("#pay_bill_rate").val();
		var bill_date		=	$dom.find("#pay_bill_bill_date").val(); 
		var paid_date		=	$dom.find("#pay_bill_paid_date").val(); 
		var comments		=	$dom.find("#pay_bill_comments").val(); 
		html_str  = "";
		html_str += '<tr id="bill'+tr_id+'">';
		{if $comp_currency_count!=1}
			html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='bill["+tr_id+"][currency_id]' value='"+currency_id+"'>"+currency_name+"</td>";
		{/if}
		html_str += "				<td style='border-bottom:1px solid #CCC;'  class='t_right'><input type='hidden' name='bill["+tr_id+"][money]' value='"+money+"'>"+money+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'  class='t_right'><input type='hidden' name='bill["+tr_id+"][account_money]' value='"+account_money+"'>"+account_money+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='bill["+tr_id+"][rate]' value='"+rate+"'>"+rate+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='bill["+tr_id+"][bill_no]' value='"+bill_no+"'>"+bill_no+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='bill["+tr_id+"][bill_date]' value='"+bill_date+"'>"+bill_date+"</td>"; 
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='bill["+tr_id+"][paid_date]' value='"+paid_date+"'>"+paid_date+"</td>"; 
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='bill["+tr_id+"][comments]' value='"+comments+"'>"+comments+"</td>";  
		html_str += "		    	<td style='border-bottom:1px solid #CCC;'>";
		html_str += '				<a href="javascript:;" onclick=delFund(this,\'bill'+tr_id+'\');return false>'+lang['common']['delete']+'</a>';
		html_str += "				</td>	";	
		html_str += "</tr>";	 
		clearPaidType(2)
		return html_str;
}

//插入转账列表当中
function getPaidHtmlTransfer(tr_id){  
		var rate			=	$dom.find("#pay_transfer_rate").val();
		var bank_id			=	$dom.find("#pay_transfer_bank_id").val();
		var bank_name		=	$dom.find("#pay_transfer_bank_name").val();
		var money			=	$dom.find("#pay_transfer_bank_id").val();
		var money			=	$dom.find("#pay_transfer_money").val();
		var account_money	=	$dom.find("#pay_transfer_account_money").val();
		var paid_date		=	$dom.find("#pay_transfer_paid_date").val(); 
		var comments		=	$dom.find("#pay_transfer_comments").val(); 
		html_str  = "";
		html_str += '<tr id="transfer'+tr_id+'">'; 
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='transfer["+tr_id+"][bank_id]' value='"+bank_id+"'>"+bank_name+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'  class='t_right'><input type='hidden' name='transfer["+tr_id+"][money]' value='"+money+"'>"+money+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'  class='t_right'><input type='hidden' name='transfer["+tr_id+"][account_money]' value='"+account_money+"'>"+account_money+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='transfer["+tr_id+"][rate]' value='"+rate+"'>"+rate+"</td>";
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='transfer["+tr_id+"][paid_date]' value='"+paid_date+"'>"+paid_date+"</td>"; 
		html_str += "				<td style='border-bottom:1px solid #CCC;'><input type='hidden' name='transfer["+tr_id+"][comments]' value='"+comments+"'>"+comments+"</td>";  
		html_str += "		    	<td style='border-bottom:1px solid #CCC;'>";
		html_str += '				<a href="javascript:;" onclick=delFund(this,\'transfer'+tr_id+'\');return false>'+lang['common']['delete']+'</a>';
		html_str += "				</td>	";	
		html_str += "</tr>";	 
		//清除当前支付信息
		clearPaidType(3);
		return html_str;
}

//清空对应的ID
function clearHtmlValue(clear_html){
	if(clear_html==''){
		return ;
	}
	var clear_array	=	clear_html.split(',');  						
	clearHtmlValueArray(clear_array)
}
function clearHtmlValueArray(clear_array){
	for(var i in clear_array){ 
		$dom.find("#"+clear_array[i]).val('');  
	}	
}

/*

//汇率修改
function setRateDisPlayWithBankId(bank_id,object_id){
	var currency_id	=	$("#currency_id").val();
	if(currency_id>0){
		$.getJSON("_Ajax_/getBankCurrencyId",{ 'bank_id':bank_id},function(data) {		  	 
			if(data.currency_id>0 && data.currency_id!=currency_id){
				$("#tr_"+object_id).removeClass("none");  
			}else{
				$("#"+object_id).val(1);
				$("#tr_"+object_id).addClass("none"); 
			} 					
		});	
	} 
} 


function addPaidType(v){
	var old_paid_type	=	$("#pay_paid_type").val();
	if(old_paid_type>0){
		clearPaidType(old_paid_type)
	} 
	$("#pay_paid_type").val(v);
}

*/


//汇率修改
function setRateDisPlay(id,object_id){
	var currency_id	=	$dom.find("#currency_id").val(); 
	if(currency_id>0 && currency_id==id){
		$dom.find("#"+object_id).val(1);
		$dom.find("#tr_"+object_id).addClass("none"); 
	}else{
		$dom.find("#tr_"+object_id).removeClass("none");  
	}
}
function setCurrentClass(obj){
	$('.tabs').find(".current").removeClass('current');
	$(obj).addClass("current");
}
//汇率修改
function setRateDisPlayWithBankId(bank_id,object_id){
	var currency_id	=	$dom.find("#currency_id").val();
	if(currency_id>0){
		$.getJSON(APP+"/Ajax/getBankCurrencyId",{ 'bank_id':bank_id},function(data) {		  	 
			if(data.currency_id>0 && data.currency_id!=currency_id){
				$dom.find("#tr_"+object_id).removeClass();  
			}else{
				$dom.find("#"+object_id).val(1);
				$dom.find("#tr_"+object_id).addClass('none'); 
			} 					
		});	
	}
}

</script>
  <table border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
 	<td height="10">
	 	<input type="hidden" id="old_paid_type" name="old_paid_type" 	value="0" >
	 	<input type="hidden" id="pay_paid_type" name="pay_paid_type" 	value="1" >
	 	<input type="hidden" id="pay_include" 	name="pay_include" 		value="pay_currency" >
 	</td>
 </tr>
 <tr><td>
<ul class="tabs">
	<li><a href="#" onclick="addPaidType(1);setCurrentClass(this);" id="tabs_1" class="current">{$lang.cash}</a></li>
	<li><a href="#" onclick="addPaidType(2);setCurrentClass(this);">{$lang.pay_bill}</a></li>
	<li><a href="#" onclick="addPaidType(3);setCurrentClass(this);">{$lang.pay_transfer}</a></li>
</ul>
<div class="panes">

	<div id="cash"> 
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
    <tr {if $comp_currency_count==1} style="display:none" {/if} >
    <td class="width150">{$lang.currency}：</td>	 
	<td class="t_left">{currency data={$comp_currency} name="pay_cash_currency_id" id="pay_cash_currency_id" value="{$rs.currency_id}" onchange="setRateDisPlay(this.value,'pay_cash_rate')" empty=true}__*__</td></tr>  
    <tr>
	<td>{$lang.cash_money}：</td>	
	<td class="t_left"><input type="text" id="pay_cash_money" name="pay_cash_money" class="spc_input">__*__</td>
	</tr>
	 <tr>
	<td>{if $rs.currency_id>0}{$rs.currency_name}{/if}{$lang.account_money}：</td>	
	<td class="t_left"><input type="text" id="pay_cash_account_money" name="pay_cash_account_money" value="0" class="spc_input">__*__</td></tr>
	<tr id="tr_pay_cash_rate" class="none">
	<td >{$lang.rate}：</td>	
	<td class="t_left"><input type="text" id="pay_cash_rate"  name="pay_cash_rate" value="1" class="spc_input">__*__</td></tr>
    <tr>
	<td>{$lang.paid_date}：</td>	
	<td class="t_left">{paidDate id="pay_cash_paid_date" minDate="`$min_paid_date`" value="$this_day" }__*__</td></tr>
	  <tr>
	<td>{$lang.pay_comments}：</td>	
	<td class="t_left"><input type="text" id="pay_cash_comments" name="pay_cash_comments" class="spc_input"></td></tr>			
	<tr>
	 <td>&nbsp;</td>	
	 <td class="t_left"><a href="javascript:void(0)" onclick="addPaidFund(this,'cash');" class="button_new"><span >{$lang.add}</span></a></td></tr>
</table>
	</div>
	<div id="bill"> 
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
    <tr {if $comp_currency_count==1} style="display:none" {/if} >
    <td class="width150">{$lang.currency}：</td>
	<td class="t_left">{currency data={$comp_currency} name="pay_bill_currency_id" id="pay_bill_currency_id" value="{$rs.currency_id}" onchange="setRateDisPlay(this.value,'pay_bill_rate')" empty=true}__*__</td></tr>  
    <tr>
	<td>{$lang.bill_no}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_bill_no" name="pay_bill_bill_no" class="spc_input">__*__</td>
	</tr>
	 <tr>
	<td>{$lang.bill_money}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_money" name="pay_bill_money" class="spc_input">__*__</td></tr>
	<tr>
	<td>{if $rs.currency_id>0}{$rs.currency_name}{/if}{$lang.account_money}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_account_money" name="pay_bill_account_money" value="0" class="spc_input">__*__</td></tr>
    <tr id="tr_pay_bill_rate" class="none">
	<td >{$lang.rate}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_rate" name="pay_bill_rate" value="1" class="spc_input">__*__</td></tr>
	<tr>
	<td>{$lang.bill_date}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_bill_date" name="pay_bill_bill_date" class="Wdate spc_input" onClick="WdatePicker()"/>__*__</td></tr>	
	 <tr>
	<td>{$lang.paid_date}：</td>	
	<td class="t_left">{paidDate id="pay_bill_paid_date" minDate="`$min_paid_date`" }__*__</td></tr>
	 <tr>
	<td>{$lang.pay_comments}：</td>	
	<td class="t_left"><input type="text" id="pay_bill_comments" name="pay_bill_comments" class="spc_input"></td></tr>		
	<tr>
	 <td>&nbsp;</td>	
	 <td class="t_left"><a href="javascript:void(0)" onclick="addPaidFund(this,'bill');" class="button_new"><span>{$lang.add}</span></a></td></tr>
</table>
	</div> 
	<div id="transfer"> 
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="width150">{$lang.account_holder}：</td>
        <td class="t_left">          
            <input id="pay_transfer_contact_name" type="hidden" onchange="getPayBankSelect(this,'({$currency_id})')" name="pay_transfer_contact_name" value="">
            <input type="text" name="contact" id='contact' url="{'AutoComplete/contact'|U}" value="" jqac>__*__
        </td>
    </tr>
    <tr><td class="width150">{$lang.pay_bank}：</td>	
	<td class="t_left">
	<input type="hidden" id="pay_transfer_bank_id" name="pay_transfer_bank_id" onchange="setRateDisPlayWithBankId(this.value,'pay_transfer_rate')">
	<input type="text" name="pay_transfer_bank_name" id='pay_transfer_bank_name' where="" url="{'AutoComplete/bank'|U}" jqac>__*__
	
	{* autoComplete name="pay_transfer_bank_name" action="account" extend="currency_id in ($comp_currency)" *}</td></tr>  
    <tr>
	<td>{$lang.transfer_money}：</td>	
	<td class="t_left"><input type="text" id="pay_transfer_money" name="pay_transfer_money" class="spc_input">__*__</td>
	</tr>
	 <tr>
	<td>{if $rs.currency_id>0}{$rs.currency_name}{/if}{$lang.account_money}：</td>	
	<td class="t_left"><input type="text" id="pay_transfer_account_money" name="pay_transfer_account_money" value="0" class="spc_input">__*__</td></tr>
	<tr id="tr_pay_transfer_rate" class="none" >
	<td>{$lang.rate}：</td>	
	<td class="t_left"><input type="text" id="pay_transfer_rate" name="pay_transfer_rate" value="1" class="spc_input">__*__</td></tr>
    <tr>
	<td>{$lang.paid_date}：</td>	
	<td class="t_left">{paidDate id="pay_transfer_paid_date" minDate="`$min_paid_date`"}__*__</td></tr>
	  <tr>
	<td>{$lang.pay_comments}：</td>	
	<td class="t_left"><input type="text" id="pay_transfer_comments" name="pay_transfer_comments" class="spc_input"></td></tr>			
	<tr>
	 <td>&nbsp;</td>	
	 <td class="t_left"><a href="javascript:void(0)" onclick="addPaidFund(this,'transfer');" class="button_new"><span>{$lang.add}</span></a></td></tr>
</table>	
	</div>
</div>
</td></tr></table>
 