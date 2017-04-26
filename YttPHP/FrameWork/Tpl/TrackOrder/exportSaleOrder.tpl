<script type="text/javascript">	
$dom.find('#ac_search').html('{L('export')}');
</script>
{wz}
<form method="POST" action="{"TrackOrder/{$smarty.const.ACTION_NAME}"|U}" beforeSubmit="checkSearchForm" id="search_form">
<div style="padding-top:12px;"></div>
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
<input type="hidden" id="type" name="type" value="0">
<dl>
	{if $login_user.role_type==C('WAREHOUSE_ROLE_TYPE')}
	<input type="hidden" id="warehouse_id" name="query[a.warehouse_id]" value="{$warehouse_id}">    
	{else}
	<dt>
		<label>{$lang.warehouse_name}：</label>
        <input id="warehouse_id" value="{$smarty.post.query.a_warehouse_id}" type="hidden" name="query[a.warehouse_id]" onchange="getExpressCompany(this)" class="valid-required">
        <input id="warehouse_name" value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/saleWarehouse'|U}" jqac>__*__
        </dt>
	{/if}
	<dt>
		<label>{$lang.express}：</label>
        <span id="company">
            <input type="hidden" name="query[d.company_id]" id="company_id">
            <input type="text" name="temp[express_name]" id="company_name" url="{'/AutoComplete/companyUse'|U}" where="1" jqac/>
        </span>__*__
	</dt>    
	<dt>
		<label>{$lang.order_date}：</label>
		<input type="text" name="date[needdate_from_order_date]" value="{$smarty.post.date.needdate_from_order_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
		<label>{$lang.to_date}</label>
		<input type="text" name="date[needdate_to_order_date]" value="{$smarty.post.date.needdate_to_order_date}" class="Wdate spc_input_data" onClick="WdatePicker()"/>
	</dt>  
	<dt>
		<label>{$lang.express_way}：</label>
		<input value="{$smarty.post.query.a_express_id}" type="hidden" name="query[a.express_id]" id="express_id">
		<input value="{$smarty.post.temp.express_name}" name="temp[express_name]" type='text' url="{'/AutoComplete/shipping'|U}" jqac>
	</dt>
	<dt>
		<label>{$lang.factory_name}：</label>
		<input value="{$smarty.post.query.a_factory_id}" type='hidden' name="query[a.factory_id]">
		<input value="{$smarty.post.temp.factory}" name="temp[factory]" type='text' url="{'/AutoComplete/factory'|U}" jqac>
	</dt> 
	<dt>
	
	</dt>
	<dt>
		<label>{$lang.comments}：</label>
		<input class="spc_input" value="" name="comments" id="comments" type="text" maxlength="140">
	</dt>
</dl>	    
</div>
<input type="hidden" name="date_key" value="2">
{if $admin || $login_user.role_type==C('WAREHOUSE_ROLE_TYPE')}
<td id="search_button_bg" width="68" height="40" bgcolor="#DBEAFF" background="__PUBLIC__/Images/Default/search_button_bg.gif" align="center">
<input id="print_butten" class="mout_search" type="button" name="ac_search" onmouseover="this.className='mover_search'" onmouseout="this.className='mout_search'" onclick="javascript:$dom.find('#type').val(1);$(this.form).submit();" value="{$lang.print}">
</td>
{/if}
    </td>
    <td id="search_button_bg" width="68" height="40" background="__PUBLIC__/Images/Default/search_button_bg.gif" bgcolor="#DBEAFF" align="center">
    <input type="hidden" name="search_form" value="1">
    <input type="hidden" name="{C('VAR_PAGE')}" id="{C('VAR_PAGE')}" value="{$var_page}">
    <input class="mout_search" value="{$lang.export}" onmouseout="this.className='mout_search'" onmouseover="this.className='mover_search'" name="ac_search" id="ac_search" type="button" onclick="javascript:$dom.find('#type').val(0);$(this.form).submit();">
    </td>
  </tr>
</table>
</div>
</form>
<script type="text/javascript">
	function exportSaleOrder(){
		var w_id									= $.cParseInt($dom.find('#warehouse_id').val());
		var company_id								= $.cParseInt($dom.find('#company_id').val());
		if (w_id <= 0 || company_id <= 0) {
			var tips	= w_id <= 0 ? '{L('w_id_require')}' : '{L('express_id_require')}';
			$dom.find('#print').html('<div class="add_box" style="text-align:center"><span class="tred">' + tips + '</span></div>')
			return;
		}
		var type									= $.cParseInt($dom.find('#type').val());
		var rand									= $dom.find('#rand').val();
		if(type==1){
			$("#dialog-show_barcode").remove();
			$("<div id='dialog-show_barcode'></div>").load(APP + '/QuicklyOperate/printSaleOrder/module/TrackOrder/rand/' + rand).dialog({
				autoOpen: true,
				resizable: false,
				height: 500,
				width: 840,
				modal: true
			});
			return;
		}
		
		var src										= APP+"/Ajax/outPutExcel/rand/"+rand+"/w_id/"+w_id+'/company_id/'+company_id;
		var express_id								= $.cParseInt($dom.find('#express_id').val());
		if (express_id > 0) {
			src += '/express_id/'+express_id;
		}
		var comments	= escape(encodeURIComponent($dom.find('#comments').val()));
		if(comments){
			src += '/comments/'+comments;
		}
		$dom.find('#comments').val('')
		var stateArr								= [];
		{if C("EXPRESS_DHL_ID")}
		stateArr[{C("EXPRESS_DHL_ID")}]				= 'exportDhlSaleOrder';
		{/if}
		{if C("EXPRESS_FR_POST_EXPRESS_ID")}
		stateArr[{C("EXPRESS_FR_POST_EXPRESS_ID")}]	= 'expressFrPostSaleOrder';
		{/if}
		{if C("EXPRESS_FR_POST_ID")}
		stateArr[{C("EXPRESS_FR_POST_ID")}]			= 'exportDeutscheSaleOrder';
		{/if}
		{if C("EXPRESS_DEUTSCHE_POST_ID")}
		stateArr[{C("EXPRESS_DEUTSCHE_POST_ID")}]	= 'exportDeutscheSaleOrder';
		{/if}
		{if C("EXPRESS_IT-NEXIVE_ID")}
		stateArr[{C("EXPRESS_IT-NEXIVE_ID")}]		= 'exportItBrtSaleOrder';
		{/if}
		{if C("EXPRESS_BRT_ID")}
		stateArr[{C("EXPRESS_BRT_ID")}]				= 'exportItBrtSaleOrder';
		{/if}
		{if C("EXPRESS_FR-GLS_ID")}
//		stateArr[{C("EXPRESS_FR-GLS_ID")}]			= 'exportFrGlsSaleOrder';
		{/if}
		{if C("EXPRESS_UK-DPD_ID")}
		stateArr[{C("EXPRESS_UK-DPD_ID")}]			= 'exportUKDPDSaleOrder';
		{/if}
		{if C("EXPRESS_ROYAL_MAIL_ID")}
		stateArr[{C("EXPRESS_ROYAL_MAIL_ID")}]		= 'exportROYALMAILSaleOrder';
		{/if}
		{if C("EXPRESS_PARCEL_FORCE_ID")}
		stateArr[{C("EXPRESS_PARCEL_FORCE_ID")}]	= 'exportParcelForceSaleorder';
		{/if}
		{if C("EXPRESS_FEDEX_ID")}
		stateArr[{C("EXPRESS_FEDEX_ID")}]			= 'exportFedexSaleorder';
		{/if}
		{if C("EXPRESS_YODEL_ID")}
		stateArr[{C("EXPRESS_YODEL_ID")}]			= 'exportYodelSaleOrder';
		{/if}
		{if C("EXPRESS_FR-DPD_ID")}
		stateArr[{C("EXPRESS_FR-DPD_ID")}]			= 'exportFRDPDSaleOrder';
		{/if}
		{if C("EXPRESS_IT-UPS_ID")}
		stateArr[{C("EXPRESS_IT-UPS_ID")}]			= 'exportITUpsSaleOrder';
		{/if}
		{if C("EXPRESS_ITFEDEX_ID")}
		stateArr[{C("EXPRESS_ITFEDEX_ID")}]			= 'exportInternationalFedexSaleOrder';
		{/if}
        {if C("EXPRESS_MYHEMERS_ID")}
		stateArr[{C("EXPRESS_MYHEMERS_ID")}]		= 'exportMyHemersSaleOrder';
		{/if}
        {if C("EXPRESS_MONDIAL_RELAY_ID")}
		stateArr[{C("EXPRESS_MONDIAL_RELAY_ID")}]	= 'exportMondialRelaySaleOrder';
		{/if}
		{if C("EXPRESS_GEODIS_ID")}
		stateArr[{C("EXPRESS_GEODIS_ID")}]			= 'exportGeodisSaleOrder';
		{/if}
		//虚拟托盘派送，针对IT虚拟托盘派送配置IT-BRT的模板 || 如果是意大利仓且快递公司为虚拟托盘派送，派送方式为空的话，默认导出IT-BRT的模板
		if((company_id == {C("EXPRESS_VIRTUAL_TRAY_ID")} && express_id == {C("EXPRESS_IT_VIRTUAL_TRAY_ID")}) || (w_id == {C("EXPRESS_IT_WAREHOUSE_ID")} && company_id == {C("EXPRESS_VIRTUAL_TRAY_ID")} && express_id == '')){	
			stateArr[{C("EXPRESS_VIRTUAL_TRAY_ID")}]				= 'exportItBrtSaleOrder';
		}
		var state									= stateArr[company_id] ? stateArr[company_id] : 'exportSaleOrder';
		src											+= "/state/"+state;
		var iframe = $("<iframe style='display:none' name='iframe' src=" + src + "></iframe>");
		$dom.find('iframe[name="iframe"]').remove();
		$dom.find('#search_form').append(iframe);
	}
</script>
<div id="print" class="width98">

</div>  
