<form action="{'InstockImport/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<input type="hidden" name="flow" id="flow" value="instockImport">
<input type="hidden" name="s_key" id="s_key" value="">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th colspan="4">{$lang.basic_info}</th>
		</tr>
		<tr>
			<td colspan="4">
				<div class="basic_tb">  
					{assign var="import_key" value="InstockImport"}
					<ul> 
						<li>
						{$lang.warehouse_name}：
							{if $w_id > 0}
								<input type="hidden" name="warehouse_id" value="{$w_id}">
								<input name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$w_name}" disabled="disabled" class="spc_input disabled" />__*__	
							{else}
								<input type="hidden" name="warehouse_id" value="{$rs.warehouse_id|default:$w_id}">
								<input name="temp[w_name]" url="{'AutoComplete/warehouseName'|U}" value="{$rs.w_name|default:$w_name}" class="spc_input" jqac />__*__							
							{/if}
						</li>							
						<li>{$lang.download_import_template}：
							<a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>
						</li>		
						<li>{$lang.select_file}：
								{upload tocken=$file_tocken sid=$sid type=13 allowTypes="xls,xlsx"}
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
