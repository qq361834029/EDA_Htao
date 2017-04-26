<form action="{'Adjust/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="from_type" value="adjust">
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.adjust_basic}<input type="hidden" id="flow" value="adjust"></div>
    			</div></th>
    		</tr>
    		<tr>
			<td>
	    		<div class="basic_tb">  
	    		<ul> 
	    		<li>
					{$lang.adjust_date}：<input type="text" name="adjust_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
				</li>
    			
			<!--li>
			{$lang.warehouse_name}：
				{if $w_id > 0}
					<input type="hidden" name="warehouse_id" value="{$w_id}">
					<input name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$w_name}" disabled="disabled" class="spc_input disabled" />__*__	
				{else}
					<input type="hidden" name="warehouse_id" value="{$rs.warehouse_id|default:$w_id}">
					<input name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$rs.w_name|default:$w_name}" class="spc_input" jqac />__*__							
				{/if}
			</li-->	
			{currency data=C('currency') view=true name='currency_id' id='currency_id' type='li' title=$lang.currency}
			</div>
			</td>
		</tr>
		<tr>
			<th colspan="4">
				{$lang.adjust_detail}
				{if $rs}
					{$lang.detail_info}
				{else}
					{$lang.box_detail_info}
					<table class="fr">
						<tr>
							{assign var="import_key" value="AdjustDetail"}
							<td><a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>&nbsp;&nbsp;</td>
							<td>
								{upload tocken=$file_tocken sid=$sid type=18 allowTypes="xls,xlsx" multi=true}
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
    		   
    	   <tr><td>{include file="Adjust/detail.tpl"}</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
					<td width="80%" valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80" name="comments"></textarea></td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form> 

