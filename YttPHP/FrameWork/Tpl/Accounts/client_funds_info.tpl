	<script> 
	$().ready(function(){
		getFundsInfo('client',{C('how_assign_info')});
	})
	function getFundsInfo(str,v){ 
		if(v==1){ 
//			$("[name^='check_info']").attr("checked",'true');//全选 
			$dom.find('#show_funs_ini_tr').show();  
			$dom.find('#show_funs_ini_info').show(); 
			$dom.find('#show_funs_sale_tr').show();  
			$dom.find('#show_funs_sale_info').show(); 
			$dom.find('#show_funs_return_tr').show();  
			$dom.find('#show_funs_return_info').show(); 
			$dom.find('#show_funs_other_tr').show();  
			$dom.find('#show_funs_other_info').show(); 
			$dom.find('#show_funs_funds_tr').show();  
			$dom.find('#show_funs_funds_info').show();
		}else{ 
			$dom.find("[name^='check_info']").removeAttr("checked");//取消全选
			$dom.find('#show_funs_ini_tr').hide();  
			$dom.find('#show_funs_ini_info').hide(); 
			$dom.find('#show_funs_sale_tr').hide();  
			$dom.find('#show_funs_sale_info').hide(); 
			$dom.find('#show_funs_return_tr').hide();  
			$dom.find('#show_funs_return_info').hide(); 
			$dom.find('#show_funs_other_tr').hide();  
			$dom.find('#show_funs_other_info').hide(); 
			$dom.find('#show_funs_funds_tr').hide();  
			$dom.find('#show_funs_funds_info').hide();  
		}
	}  
	</script>  
{if $fund.Ini neq ""}
		<tr id="show_funs_ini_tr" class="none"><th colspan="4">{$lang.client_ini_info}</th></tr>   
		<tr id="show_funs_ini_info" class="none"><td colspan="4" class="t_center">
		<table border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th>
				<th width="16%">&nbsp;</th>
				<th width="16%">&nbsp;</th>
				<th width="16%">{$lang.date}</th>
				<th width="16%">{$lang.money}</th>
				<th width="16%">{$lang.allot_money}</th>
				<th>{$lang.need_paid_money}</th>
			</tr>
		</thead>
		<tbody>
		{foreach key=key item=lst from=$fund.Ini}
		<tr >
			<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
			<td width="16%">&nbsp;</td>
			<td width="16%">&nbsp;</td>
			<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
			<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
 		</tr>
 		{/foreach}
 		</tbody>
		</table></td>
		</tr>
		{/if}
		{if $fund.sale neq ""}
		<tr id="show_funs_sale_tr" class="none" ><th colspan="4">{$lang.client_sale_info}</th></tr>   
		<tr id="show_funs_sale_info" class="none" ><td colspan="4" class="t_center">
		<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th> 
				<th width="16%">{$lang.funds_class}</th>
				<th width="16%">{$lang.doc_no}</th>
				<th width="16%">{$lang.date}</th>
				<th width="16%">{$lang.money}</th>
				<th width="16%">{$lang.allot_money}</th>
				<th>{$lang.need_paid_money}</th>
			</tr>
		</thead>
		<tbody>
		{foreach key=key item=lst from=$fund.sale}
		<tr >
			<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
			<td width="16%">{$lst.pay_class_name}</td>
			<td width="16%">
			{if $lst.comments_url}
			<a href="javascript:;" onclick="addTab('{$lst.comments_url}','{$lang.view_detail}',1); ">
			{$lst.account_no}&nbsp;
			</a>
			{else}
			{$lst.account_no}&nbsp;
			{/if}
			</td>
			<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
			<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
 		</tr>
 		{/foreach}
 		</tbody>
		</table></td>
		</tr>
		{/if}
		
		{if $fund.other neq ""}
		<tr id="show_funs_other_tr" class="none"><th colspan="4">{$lang.client_other_info}</th></tr>   
		<tr id="show_funs_other_info" class="none"><td colspan="4" class="t_center">
		<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th>
				<th width="16%">{$lang.funds_class}</th>
				<th width="16%">{$lang.doc_no}</th>
				<th width="16%">{$lang.date}</th>
				<th width="16%">{$lang.money}</th>
				<th width="16%">{$lang.allot_money}</th>
				<th>{$lang.need_paid_money}</th>
			</tr>
		</thead>
		<tbody>
		{foreach key=key item=lst from=$fund.other}
		<tr >
			<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
			<td width="16%">{$lst.pay_class_name}</td>
			<td width="16%">
			{if $lst.comments_url}
			<a href="javascript:;" onclick="addTab('{$lst.comments_url}','{$lst.comments_url_title}',1); ">
			{$lst.account_no}&nbsp;
			</a>
			{else}
			{$lst.account_no}&nbsp;
			{/if}				
			</td>
			<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
			<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
 		</tr>
 		{/foreach}
 		</tbody>
		</table></td>
		</tr>
		{/if}
		
		{if $fund.return neq ""}
		<tr id="show_funs_return_tr" class="none"><th colspan="4">{$lang.client_return_info}</th></tr>   
		<tr id="show_funs_return_info" class="none"><td colspan="4" class="t_center">
		<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th>
				<th width="16%">{$lang.funds_class}</th>
				<th width="16%">{$lang.doc_no}</th>
				<th width="16%">{$lang.date}</th>
				<th width="16%">{$lang.money}</th>
				<th width="16%">{$lang.allot_money}</th>
				<th>{$lang.need_paid_money}</th>
			</tr>
		</thead>
		<tbody>
		{foreach key=key item=lst from=$fund.return}
		<tr >
			<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
			<td width="16%">{$lst.pay_class_name}</td>
			<td width="16%">
			{if $lst.comments_url}
			<a href="javascript:;" onclick="addTab('{$lst.comments_url}','{$lang.view_detail}',1); ">
			{$lst.account_no}&nbsp;
			</a>
			{else}
			{$lst.account_no}&nbsp;
			{/if}
			</td>
			<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
			<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
 		</tr>
 		{/foreach}
 		</tbody>
		</table></td>
		</tr>
		{/if} 
		
		{if $fund.funds neq ""}
		<tr id="show_funs_funds_tr" class="none"><th colspan="4">{$lang.client_funds_info}</th></tr>   
		<tr id="show_funs_funds_info" class="none"><td colspan="4" class="t_center">
		<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th>
				<th width="16%">{if $lst.object_type=='123'}{$lang.funds_class}{/if} </th>
				<th width="16%">{if $lst.object_type=='123'}{$lang.doc_no}{/if}</th>
				<th width="16%">{$lang.date}</th>
				<th width="16%">{$lang.money}</th>
				<th width="16%">{$lang.allot_money}</th>
				<th>{$lang.need_paid_money}</th>
			</tr>
		</thead>
		<tbody>
		{foreach key=key item=lst from=$fund.funds}
		<tr >
			<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
			<td width="16%">{if $lst.object_type=='123'}{$lst.pay_class_name}{/if}</td>
			<td width="16%">
			{if $lst.object_type=='123'}
			<a href="javascript:;" onclick="addTab('{$lst.comments_url}','{$lang.view_detail}',1); ">
			{$lst.account_no}
			</a>
			{/if} 
			&nbsp;</td> 
			<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
			<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
			<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
 		</tr>
 		{/foreach}
 		</tbody>
		</table></td>
		</tr>
		{/if}