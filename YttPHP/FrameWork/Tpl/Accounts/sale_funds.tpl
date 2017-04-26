<script type="text/javascript"> 
		function addFund(obj,vo){  
			var type	= $dom.find('#user_type').val();
			var data	= '';
			if(vo=='cash'){
				var pay_cash_money	= $dom.find('#pay_cash_money').val();
				data				= { pay_cash_money:pay_cash_money,type:'Cash'};
			}else if(vo=='bill'){
				var pay_bill_bill_date	= $dom.find('#pay_bill_bill_date').val();
				var pay_bill_bill_no	= $dom.find('#pay_bill_bill_no').val();
				var pay_bill_money		= $dom.find('#pay_bill_money').val();
				data					= { pay_bill_bill_date: pay_bill_bill_date,pay_bill_bill_no:pay_bill_bill_no,pay_bill_money:pay_bill_money,type:'Bill'};
			}else if(vo=='transfer'){
				var pay_transfer_bank_id= $dom.find('#pay_transfer_bank_id').val();
				var pay_transfer_money= $dom.find('#pay_transfer_money').val();
				data					= { pay_transfer_bank_id: pay_transfer_bank_id,pay_transfer_money: pay_transfer_money,type:'Transfer'};
			} 
			$.ajax({
				type: "POST",
				url: APP+"/Ajax/checkVaildSale",
				dataType: "json",
				data:data,
				cache: false,
				async: false,
				success: function(result){
					if(result.errorStatus==0){
							//验证通过复制黏贴到TR当
						$dom.find("#sale_funds_after").after(getHtml(vo));
						$(obj).parents('td').prev('td').find('input').trigger('keyup');
					}else if(result.errorStatus==2){
						validity(result.error,$dom);
					}
				}
			});
		}
		
		function clearPaidType(paid_type){
			var clear_array	=	new Array();
			clear_array	=	''
			if(paid_type==1){
				var clear_html=['pay_cash_money',
								'pay_cash_currency_id',
								'pay_cash_currency_name',
								'pay_cash_account_money',
								'pay_cash_paid_date',
								'pay_cash_comments']; 
				clearHtmlValueArray(clear_html)//清空数据 
				$dom.find("#pay_cash_account_money").val(0);
			}else if(paid_type==2){
				var clear_html	=[	'pay_bill_bill_no',
									'pay_bill_money', 
									'pay_bill_bill_date',
									'pay_bill_paid_date',
									'pay_bill_comments',
									'pay_bill_account_money',
									'pay_bill_currency_id',
									'pay_bill_currency_name'];//需要清除的值 
				//清除页面提交后的值 
				clearHtmlValueArray(clear_html);//清空数据 
				$dom.find("#pay_bill_account_money").val(0);
			}else if(paid_type==3){
				var clear_html	=	['pay_transfer_bank_id',
									'pay_transfer_bank_name',
									'pay_transfer_money', 
									'pay_transfer_paid_date',
									'pay_transfer_account_money',
									'pay_transfer_comments'];//需要清除的值
				//清除页面提交后的值
				clearHtmlValueArray(clear_html);//清空数据 
				$dom.find("#pay_transfer_account_money").val(0);
			}else{  
			} 
		}
		
	
		function delFund(obj,id,type){
			var money	=	$dom.find("#"+id).find("#money").val();
			$dom.find("#"+id).remove();
			if(type=='transfer'){
				//特殊处理把销售单中的币种设置为不可选择的 
				if($dom.find("#transfer_bank_id").size()==0){ 
					//$("#currency_select").removeAttr("disabled"); 
					$dom.find("#currency_select").attr('disabled','');
				} 
			}   
			$.advenceMoney(money,'del');//减去应收款
		}
		
		//插入列表
		function getHtml(vo){
			var myDate  = new Date();  
			var tr_id	= myDate.getTime();
			if(vo=='cash'){ 
				$dom.find("#sale_funds_after").after(getHtmlCash(tr_id));
			}else if(vo=='bill'){  
				$dom.find("#sale_funds_after").after(getHtmlBill(tr_id))
			}else if(vo=='transfer'){ 
				$dom.find("#sale_funds_after").after(getHtmlTransfer(tr_id))
				//特殊处理把销售单中的币种设置为不可选择的
				if($dom.find("#currency_id").val()>0){
					$dom.find("#currency_select").attr("disabled",true); 
				} 
			}  
		}
		
		//插入现金列表当中
		function getHtmlCash(tr_id){ 
				var clear_html		=	'pay_cash_money,pay_cash_account_money,pay_cash_paid_date,pay_cash_comments';//需要清除的值 
				var money			=	$dom.find("#pay_cash_money").val();
				html_str  = "";
				html_str += '<tr id="cash'+tr_id+'">';
				html_str += "				<td class='t_right'><span class='pad_right_2'>现金：</span></td>";
				html_str += "				<td  class='t_right_red'><input type='hidden' id=money name='cash["+tr_id+"][money]' value='"+money+"'><span class='pad_right_3'>"+money+"</span></td>";
		//		html_str += "				<td  ><input type='hidden' name='cash["+tr_id+"][account_money]' value='"+account_money+"'>"+account_money+"</td>";
		//		html_str += "				<td  ><input type='hidden' name='cash["+tr_id+"][paid_date]' value='"+paid_date+"'>"+paid_date+"</td>"; 
		//		html_str += "				<td  ><input type='hidden' name='cash["+tr_id+"][comments]' value='"+comments+"'>"+comments+"</td>";  
				html_str += "		    	<td class='t_center'>";
				html_str += '				<span class="icon icon-del-plus" onclick=delFund(this,\'cash'+tr_id+'\',"cash");return false></span>';
				html_str += "				</td>	";	
				html_str += "</tr>";	 
				$.advenceMoney(money,'addsale');//增加预付款总金额 
				//清除页面提交后的值
				clearHtmlValue(clear_html);//清空数据 
				return html_str;
		}
		
		//插入支票列表当中
		function getHtmlBill(tr_id){ 
				var clear_html	=	'pay_bill_bill_no,pay_bill_money,pay_bill_account_money,pay_bill_bill_date,pay_bill_paid_date,pay_bill_comments';//需要清除的值 
				var bill_no			=	$dom.find("#pay_bill_bill_no").val();
				var money			=	$dom.find("#pay_bill_money").val();
				var bill_date		=	$dom.find("#pay_bill_bill_date").val(); 
				html_str  = "";
				html_str += '<tr id="bill'+tr_id+'">';
				html_str += "				<td class='t_right'>支票日期：<input type='hidden' name='bill["+tr_id+"][bill_date]' value='"+bill_date+"'>"+bill_date+"&nbsp;&nbsp;&nbsp;支票号码：<input type='hidden' name='bill["+tr_id+"][bill_no]' value='"+bill_no+"'><span class='pad_right_3'>"+bill_no+"</span></td>"; 
				html_str += "				<td class='t_right_red'><input type='hidden' id=money name='bill["+tr_id+"][money]' value='"+money+"'><span class='pad_right_3'>"+money+"</span></td>";
		//		html_str += "				<td  ><input type='hidden' name='bill["+tr_id+"][account_money]' value='"+account_money+"'>"+account_money+"</td>";
		//		html_str += "				<td  ><input type='hidden' name='bill["+tr_id+"][paid_date]' value='"+paid_date+"'>"+paid_date+"</td>"; 
		//		html_str += "				<td  ><input type='hidden' name='bill["+tr_id+"][comments]' value='"+comments+"'>"+comments+"</td>";  
				html_str += "		    	<td  >";
				html_str += '				<span class="icon icon-del-plus" onclick=delFund(this,\'bill'+tr_id+'\',"cash");return false></span>';
				html_str += "				</td>	";	
				html_str += "</tr>";	 
				//清除页面提交后的值 
				$.advenceMoney(money,'addsale');//增加预付款总金额
				clearHtmlValue(clear_html);//清空数据 
				return html_str;
		}
		
		//插入转账列表当中
		function getHtmlTransfer(tr_id){ 
				var clear_html	=	'pay_transfer_bank_id,pay_transfer_bank_name,pay_transfer_money,pay_transfer_account_money,pay_transfer_paid_date,pay_transfer_comments';//需要清除的值 
				var bank_id			=	$dom.find("#pay_transfer_bank_id").val();
				var bank_name		=	$dom.find("#span_bank_name").val(); 
				var money			=	$dom.find("#pay_transfer_money").val();
				html_str  = "";
				html_str += '<tr id="transfer'+tr_id+'">';
				html_str += "				<td  class='t_right'>银行简称：<input type='hidden' id=transfer_bank_id name='transfer["+tr_id+"][bank_id]' value='"+bank_id+"'>"+bank_name+"&nbsp;&nbsp;&nbsp;<span class='pad_right_3'>金额：</span></td>";
				html_str += "				<td  class='t_right_red'><input type='hidden' id=money name='transfer["+tr_id+"][money]' value='"+money+"'><span class='pad_right_3'>"+money+"</span></td>";
				html_str += "		    	<td>";
				html_str += '				<span class="icon icon-del-plus" onclick=delFund(this,\'transfer'+tr_id+'\',"transfer");return false></span>';
				html_str += "				</td>	";	
				html_str += "</tr>";	 
				//清除页面提交后的值
				$.advenceMoney(money,'addsale');//增加预付款总金额
				clearHtmlValue(clear_html);//清空数据 
				return html_str;
		}
		
		//清空对应的ID
		function clearHtmlValue(clear_html){
			if(clear_html==''){
				return ;
			}
			var clear_array	=	clear_html.split(',');  						
			for(var i in clear_array){ 
				$dom.find("#"+clear_array[i]).val('');  
			}	
		}
</script>
<input type="hidden" id="pay_paid_type" name="pay_paid_type" 	value="1" >
<input type="hidden" id="pay_include" 	name="pay_include" 		value="pay_sale"> 
<div class="panes_sale">
	<div id="cash"> 
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="pay_table">
    <tr>
	<td class="b_bottom b_left t_right b_top">
<ul class="tabs_sale">
	<li>
	<select name="user_type" class="" id="user_type" onchange="addPaidType($(this).val())" style="width:60px;"><option value="1" selected>{$lang.cash}</option><option value="2" >{$lang.pay_bill}</option><option value="3" >{$lang.pay_transfer}</option></select></li>
</ul>
</td>	
	<td class="b_bottom b_top t_right" width="121"><input type="text" id="pay_cash_money" name="pay_cash_money" onkeyup="$.dealWithPM('pay_cash_money');"></td>	
	<td class="b_bottom b_right b_top" width="57"><span class="icon icon-add-plus"onclick="addFund(this,'cash');"></span></td></tr>
   </table>
	</div>
	
	<div id="bill" style="display:none;"> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="pay_table">
    <tr>
    <td  class="b_bottom b_top">{$lang.bill_date}：</td>	
	<td  class="b_bottom b_top" width="104"><input type="text" id="pay_bill_bill_date" name="pay_bill_bill_date" class="Wdate date_input" onClick="WdatePicker()" style="width:90px;"/></td>
    <td  class="b_bottom b_left b_top">{$lang.bill_no}：</td>	
	<td  class="b_bottom b_top"><input type="text" id="pay_bill_bill_no" name="pay_bill_bill_no" class="date_input"></td>	
	<td  class="b_bottom t_right b_top"><ul class="tabs_sale">
	<li><select name="user_type" class="" id="user_type" onchange="addPaidType($(this).val())" style="width:60px;"><option value="1">{$lang.cash}</option><option value="2" selected>{$lang.pay_bill}</option><option value="3" >{$lang.pay_transfer}</option></select></li>
</ul></td>	
	<td class="b_bottom b_top t_right"  width="121"><input type="text" id="pay_bill_money" name="pay_bill_money"  onkeyup="$.dealWithPM('pay_bill_money');"></td>
	<td  class="b_bottom b_right b_top" width="57"><span class="icon icon-add-plus"onclick="addFund(this,'bill');"></span></td></tr>
</table>
	</div>
	 
	<div id="transfer" style="display:none;"> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="pay_table">
    <tr><td class="b_bottom b_left b_top t_right">{$lang.pay_bank}：</td>	 
	<td class="b_bottom b_top" id="show_transfer_bank_info" width="140"><input type="hidden" id="pay_transfer_bank_id" name="pay_transfer_bank_id" onchange="getBankName(this);" class="w120">
	{if C(CLIENT_CURRENCY_COUNT)==1}
		<input type="text" id="pay_transfer_bank_name" name="pay_transfer_bank_name" value="{$item.color_name}" url="{'AutoComplete/bank'|U}"  {if $rs}where="{"currency_id={$rs.currency_id}"|urlencode}"{else}where="{"currency_id={C('client_currency')}"|urlencode}"{/if} jqac class="w120">	
	{else}
	<input type="text" id="pay_transfer_bank_name" name="pay_transfer_bank_name" value="{$item.color_name}" url="{'AutoComplete/bank'|U}"  {if $rs}where="{"currency_id={$rs.currency_id}"|urlencode}"{/if} jqac class="w120">
	{/if}
	<input type="hidden" id="span_bank_name" class="w120"></td>
	 <td class="b_bottom t_right b_top" valign="middle" width="100">
	 <ul class="tabs_sale"><li><select name="user_type" class="" id="user_type" onchange="addPaidType($(this).val())" style="width:60px;"><option value="1">{$lang.cash}</option><option value="2" >{$lang.pay_bill}</option><option value="3" selected>{$lang.pay_transfer}</option></li>
</ul></td>	
	 <td class="b_bottom b_top t_right" width="121"><input type="text" id="pay_transfer_money" name="pay_transfer_money" onkeyup="$.dealWithPM('pay_transfer_money');"></td> 
	 
	 <td class="b_bottom b_right b_top"  width="57"><span class="icon icon-add-plus"onclick="addFund(this,'transfer');"></span></td></tr>
</table>
	</div>
	
</div>


