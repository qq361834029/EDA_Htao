<form action="{'DomesticWaybill/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
                    <div class="titleth">
                        <div class="titlefl">{$lang.waybill_basic}<input type="hidden" id="flow" value="domesticWaybill"></div>
                    </div>
                </th>
    		</tr>
    		<tr>
                <td>
                    <div class="basic_tb">  
                        <li>
                            {$lang.waybill_date}：<input type="text" name="waybill_date" value="{$rs.waybill_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
                        </li>
                    </div>
                </td>
            </tr>
        <tr>
			<th colspan="4">
				{$lang.search_product}
			</th>
		</tr>
        <tr>
            <td>
                <div class="basic_tb">  
                    <li>
                        {$lang.location_no}
                        <input type="hidden" onchange="getresultInfo(this);" name="detail[{$index}][location_id]" id="location_id" value="" class="w200">
                        <input type="text" name="temp[{$index}][barcode_no]" value="" url="{'AutoComplete/noSoldLocation'|U}" jqac class="w200" {$readonly}>
                    </li>
                    <li>
                        <button type="button" onclick="allCheck()">{$lang.select_all}</button>
                        <button type="button" onclick="reverseCheck()">{$lang.select_none}</button>
                        <button type="button" onclick="addProductToDetail()">{$lang.add}</button>
                    </li>
                    <li>
                        {$lang.product_id}                             
                        <input type="hidden" onchange="getresultInfo(this);" name="detail[{$index}][product_id]" id="product_id" value="{$item.product_id}" class="w200">
                        <input type='text' name="query[a.product_id]" url="{'/AutoComplete/noSoldProductId'|U}" jqac>
                    </li>
                    <li>
                        <button type="button" onclick="allCheck()">{$lang.select_all}</button>
                        <button type="button" onclick="reverseCheck()">{$lang.select_none}</button>
                        <button type="button" onclick="addProductToDetail()">{$lang.add}</button>
                    </li>
                </div>
            </td>
		</tr>
        <tr>
            <td>
                <div id="select_product_show">

                </div>
            </td>
        </tr>
		<tr>
			<th colspan="4">
				{$lang.waybill_detail}
			</th>
		</tr>
        <tr><td>{include file="DomesticWaybill/detail.tpl"}</td></tr>
        <tr>
            <td class="pad_top_10">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
                        <td width="80%" valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80" name="comments">{$rs.comments}</textarea></td>
                    </tr>
                </table>
    		</td>
        </tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

