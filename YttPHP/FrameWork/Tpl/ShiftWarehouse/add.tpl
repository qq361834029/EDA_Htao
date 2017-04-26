<form action="{'ShiftWarehouse/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="from_type" value="shift_warehouse">
<input type="hidden" name="flow" id="flow" value="ShiftWarehouse">
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
            <tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.shift_warehouse_basic}</div>
    			</div></th>
    		</tr>
    		<tr>
			<td>
	    		<div class="basic_tb">  
                    <ul> 
                        <li>
                            {$lang.shift_warehouse_date}：<input type="text" name="shift_warehouse_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
                        </li>
                    </ul>
                </div>
			</td>
		</tr>
		<tr>
			<th colspan="4">
				{$lang.shift_warehouse_detail}
				<table class="fr">
					<tr>
						{assign var="import_key" value="ShiftWarehouseDetail"}
						<td><a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>&nbsp;&nbsp;</td>
						<td>
							{upload tocken=$file_tocken sid=$sid type=26 allowTypes="xls,xlsx" multi=true}
						</td>
						<td>
							<input type="radio" class="none" checked="check" value="3" name="{$import_key}_type" />
							<input type="button" sheet="0" id="{$import_key}_submit" onclick="submitImport('{$import_key}',this)" class="other" disabled="disabled" value="{$lang.import}" />
							<input type="hidden" id="file_name">
						</td>
					</tr>
				</table>
			</th>
		</tr>
        <tr><td>{include file="ShiftWarehouse/detail.tpl"}</td></tr>

        <tr>
            <td class="pad_top_10">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                    <td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
                    <td width="80%" valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80" name="comments"></textarea></td>
                    </tr>
                </table>
            </td>
        </tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form> 

