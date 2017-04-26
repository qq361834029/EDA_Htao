<form action="{'InstockImportAdjust/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.common_adjust_basic}<input type="hidden" id="flow" value="adjust"></div>
    				<div class="afr">{$lang.adjust_no}：{$rs.adjust_no}</div>
    			</div></th>
    		</tr>
    		<tr><td>
	    		<div class="basic_tb">  
	    		<ul> 
	    		<li>
					{$lang.adjust_date}：<input type="text" name="adjust_date" value="{$rs.fmd_adjust_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
				</li>
				<li>
					{$lang.delivery_no}：
					<input id="instock_id" value="{$rs.instock_id}" name="instock_id" onchange="setBoxWhere(this);showWCurrency(this,'');" class="valid-required" type="hidden">
                    <input id="instock_no" value="{$rs.instock_no}" name="instock_no" url="{'AutoComplete/instockImportInstockNo'|U}" jqac="" class="ac_input detail_input ui-autocomplete-input ui-corner-all" autocomplete="off"  type="text"><span class="font_red">*</span>
				</li>
    			{currency data=C('currency') view=true name='currency_id' id='currency_id' type='li' title=$lang.currency}
    			</td>
			</tr>
    		<tr>
    			<th >{$lang.stat_adjust_detail}</th>
    		</tr>
    		 
    	   <tr><td>{include file="InstockImportAdjust/detail.tpl"}</td></tr>
		    <tr>
				<td class="pad_top_10">
					<table cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td valign="top" width="15%">{$lang.comments}：</td>
							<td colspan="3" class="t_left" valign="top">
								<textarea name="comments" id="comments" class="textarea_height80">{$rs.edit_comments}</textarea><span class="font_red" style="position:relative;bottom:73px;">*</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

