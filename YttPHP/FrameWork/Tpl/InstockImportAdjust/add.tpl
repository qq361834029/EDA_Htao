<form action="{'InstockImportAdjust/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="from_type" value="instock_adjust">
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.common_adjust_basic}<input type="hidden" id="flow" value="adjust"></div>
    			</div></th>
    		</tr>
    		<tr>
			<td>
	    		<div class="basic_tb">  
	    		<ul> 
	    		<li>
					{$lang.adjust_date}：<input type="text" name="adjust_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
				</li>
				<li>
					{$lang.delivery_no}：
					<input id="instock_id"  name="instock_id" onchange="setBoxWhere(this);" class="valid-required" type="hidden">
                    <input id="instock_no"  name="instock_no" url="{'AutoComplete/instockImportInstockNo'|U}" jqac="" class="ac_input detail_input ui-autocomplete-input ui-corner-all" autocomplete="off" type="text"><span class="font_red">*</span>
				</li>
			{currency data=C('currency') view=true name='currency_id' id='currency_id' type='li' title=$lang.currency}
			</div>
			</td>
		</tr>
		<tr>
			<th colspan="4">
				{$lang.stat_adjust_detail}
				{if $rs}
					{$lang.detail_info}
				{else}
					{$lang.box_detail_info}
					<table class="fr">
						<tr>
							{assign var="import_key" value="AdjustInstockDetail"}
							<td><a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>&nbsp;&nbsp;</td>
							<td>
								{upload tocken=$file_tocken sid=$sid type=35 allowTypes="xls,xlsx" multi=true}
							</td>
							<td>
								<input type="radio" class="none" checked="check" value="3" name="{$import_key}_type" />
								<input type="button" sheet="0" id="{$import_key}_submit" onclick="submitImport('{$import_key}',this)" class="other" disabled="disabled" value="{$lang.import}" />
								<input type="hidden" id="file_name">
							</td>
						</tr>
					</table>					
				{/if}
			</th>
		</tr>
    		   
    	   <tr><td>{include file="InstockImportAdjust/detail.tpl"}</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%">{$lang.comments}：</td>
	   					<td colspan="3" class="t_left" valign="top">
							<textarea name="comments" id="comments" class="textarea_height80"></textarea><span class="font_red" style="position:relative;bottom:73px;">*</span>
						</td>
					</tr>
	    		</table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form> 

