	<script>
	$().ready(function(){
		getFundsInfo('factory',{C('how_assign_info')});
	})
	function getFundsInfo(str,v){ 
		if(v==1){ 
//			$dom.find("[name^='check_info']").attr("checked",'true');//全选 
			$dom.find('#show_funs_ini_tr').show();  
			$dom.find('#show_funs_ini_info').show(); 
			$dom.find('#show_funs_sale_tr').show();  
			$dom.find('#show_funs_sale_info').show();  
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
			$dom.find('#show_funs_other_tr').hide();  
			$dom.find('#show_funs_other_info').hide(); 
			$dom.find('#show_funs_funds_tr').hide();  
			$dom.find('#show_funs_funds_info').hide();  
		}
	}  
	</script>  
		{if $fund.Ini neq ""}
		<tr id="show_funs_ini_tr" class="none" ><th colspan="4">{$lang.factory_ini_info}</th></tr>   
		<tr id="show_funs_ini_info" class="none" ><td colspan="4" class="t_center">
		<table border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th width="16%">{$lang.please_choose}</th>
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
			<td width="16%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
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
		<tr id="show_funs_sale_tr" class="none" ><th colspan="4">{$lang.factory_sale_info}</th></tr>   
		<tr id="show_funs_sale_info" class="none" ><td colspan="4" class="t_center">
		<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th width="16%">{$lang.please_choose}</th> 
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
			<td width="16%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
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
		<tr id="show_funs_other_tr" class="none"><th colspan="4">{$lang.factory_other_info}</th></tr>   
		<tr id="show_funs_other_info" class="none"><td colspan="4" class="t_center">
		<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th width="16%">{$lang.please_choose}</th>
				<th width="16%">&nbsp;</th>
				<th width="16%">{$lang.date}</th>
				<th width="16%">{$lang.money}</th>
				<th width="16%">{$lang.allot_money}</th>
				<th>{$lang.need_paid_money}</th>
			</tr>
		</thead>
		<tbody>
		{foreach key=key item=lst from=$fund.other}
		<tr >
			<td width="16%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
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
		  
		{if $fund.funds neq ""}
		<tr id="show_funs_funds_tr" class="none"><th colspan="4">{$lang.factory_funds_info}</th></tr>   
		<tr id="show_funs_funds_info" class="none"><td colspan="4" class="t_center">
		<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th width="16%">{$lang.please_choose}</th>
				<th width="16%">&nbsp;</th>
				<th width="16%">{$lang.date}</th>
				<th width="16%">{$lang.money}</th>
				<th width="16%">{$lang.allot_money}</th>
				<th>{$lang.need_paid_money}</th>
			</tr>
		</thead>
		<tbody>
		{foreach key=key item=lst from=$fund.funds}
		<tr >
			<td width="16%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
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