<form action="{'Instock/update'|U}" method="POST" beforeSubmit="">
{if $step eq 2}
	{wz action="list,reset"}
	<input type="hidden" name="step" value="2">
{else}
	{wz action="hold,reset"}
	<input type="hidden" name="step" value="1">		
{/if}
<input type="hidden" name="flow" id="flow" value="instock">
<div class="add_box">
<input type="hidden" name="id"  id="instock_id"  value="{$rs.id}">
<input type="hidden" name="instock_no" value="{$rs.instock_no}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th colspan="4">{$lang.basic_info}</th>
		</tr>
		<tr>
			<td colspan="4">
				{include file="Instock/main_info.tpl"}
  			</td>
  		</tr> 
    	<tr>
    		<th colspan="4">
				{if $step eq 2}
					{$lang.detail_info}
					<table class="fr">
						<tr>
							{assign var="import_key" value="InstockDetail"}
							<td><a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>&nbsp;&nbsp;</td>
							<td>
								{upload tocken=$file_tocken sid=$sid type=12 allowTypes="xls,xlsx" multi=true}
							</td>
							<td>
								<input type="radio" class="none" checked="check" value="3" name="{$import_key}_type" />
								<input type="button" sheet="0" id="{$import_key}_submit" onclick="submitImport('{$import_key}',this)" class="other" disabled="disabled" value="{$lang.import}" />
								<input type="hidden" id="file_name">
							</td>
						</tr>
					</table>					
				{else}
					{$lang.box_detail_info}
				{/if}			
			</th>
		</tr>
    	<tr>
    		<td colspan="4" class="t_center">
    		{if $step eq 2}
				{include file="Instock/product_detail.tpl"}
    		{else}
    			{include file="Instock/box_detail.tpl"}
    		{/if}
    		</td>
    	</tr>
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%">
						{$lang.client_comments}	：
						</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="client_comments" id="comments" class="textarea_height80">{$rs.edit_client_comments}</textarea> </td>
					</tr>
                    <tr>
	   					<td valign="top" width="15%">
						{$lang.warehouse_comments}	：
						</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea class="disabled" disabled="disabled">{$rs.edit_comments}</textarea> </td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 	    
		<tr>
			<td style="padding-top:10px;">
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td valign="top" width="15%" class="t_right">{$lang.pics}：</td>
						<td colspan="3" class="t_left" valign="top">{showFiles from=$rs.pics}</td>
					</tr>
				</table>
			</td>
		</tr>
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
    				<tr>
	   					<td valign="top" width="15%">{$lang.upload_pics}：</td>
	   					<td colspan="3" class="t_left" valign="top">{upload tocken=$file_tocken sid=$sid type=2}</td>
					</tr>
	    		</table>
	    	</td>
	    </tr> 			
    </tbody>
</table>
   {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form>