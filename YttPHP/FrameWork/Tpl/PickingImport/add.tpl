<form action="{'PickingImport/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<input type="hidden" name="flow" id="flow" value="pickingImport">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th colspan="4">{$lang.basic_info}</th>
		</tr>
		<tr>
			<td colspan="4">
				<div class="basic_tb">  
					{assign var="import_key" value="PickingImport"}
					<ul> 
						<li>{$lang.picking_no}：
							<input type="text" id="file_list_no" name="picking_no" class="spc_input" url="{'/AutoComplete/unImportPickingNo'|U}" jqac>__*__	
						</li>	
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
							{$lang.pick_no}：
							<input value="" name="pick_no" value="{$smarty['post']['query']['pick_no']}" type='text' class="spc_input valid-required">__*__
						</li> 						
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
                            {$lang.download_import_template}：
							<a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>
						</li>	
						<li>{$lang.select_file}：
								{upload tocken=$file_tocken sid=$sid type=16 allowTypes="xls,xlsx"}
								<input type="hidden" id="file_name" name="file_name">
								<input type="hidden" name="sheet" value="0">
								<input type="hidden" name="import_key" value="{$import_key}">
						</li>		
					</ul>
				</div>
  			</td>
  		</tr> 
    	<tr>
    		<th colspan="4">{$lang.detail_info}</th>
		</tr>		
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%">{$lang.comments}：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="comments" id="comments" class="textarea_height80">{$rs.edit_comments}</textarea> </td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 	 		
    </tbody>
</table>
{staff}
</div>
</form>
