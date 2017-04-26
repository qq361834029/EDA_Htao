{if $rs}
	<form action="{'Instock/update'|U}" method="POST" beforeSubmit="">
	{wz action="list,reset"}
	<input type="hidden" name="step" value="2">
	<input type="hidden" name="id" value="{$rs.id}">
	<input type="hidden" name="instock_no" value="{$rs.instock_no}">
	<textarea class="none">{$detail}</textarea>
{else}
	<form action="{'Instock/insert'|U}" method="POST" beforeSubmit="">
	{wz action="hold,reset"}
	<input type="hidden" name="step" value="1">	
{/if}
<input type="hidden" name="flow" id="flow" value="instock">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
		<th>
			<div class="titleth">
			<div class="titlefl">{$lang.basic_info}</div>
			<div class="afr">{if $rs}{$lang.instock_no}：{$rs.instock_no}{/if}</div>
			</div>
		</th>
		</tr>
		<tr>
			<td colspan="4">
				{include file="Instock/main_info.tpl"}	
  			</td>
  		</tr> 
    	<tr>
    		<th colspan="4">
				{if $rs}
					{$lang.detail_info}
				{else}
					{$lang.box_detail_info}
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
				{/if}
			</th>
		</tr>
    	<tr>
			<td colspan="4" class="t_left">
				{if $rs}
					{include file="Instock/product_detail.tpl"}	
				{else}
					{include file="Instock/box_detail.tpl"}		
				{/if}
			</td>
		</tr>			
    	<tr>
    		<td colspan="4">
    			<table cellspacing="0" cellpadding="0" width="100%">
                    {if $login_user.role_type != C('SELLER_ROLE_TYPE')}	
    				<tr>
	   					<td valign="top" width="15%">{$lang.client_comments}：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="client_comments"  class="textarea_height80 disabled">{$rs.edit_client_comments}</textarea> </td>
					</tr>
                    <tr>
	   					<td valign="top" width="15%">{$lang.warehouse_comments}：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="comments"  class="textarea_height80">{$rs.edit_comments}</textarea> </td>
					</tr>
                    {else}
                     <tr>
	   					<td valign="top" width="15%">{$lang.client_comments}：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="client_comments"  class="textarea_height80">{$rs.edit_client_comments}</textarea> </td>
					</tr>  
                    <tr>
	   					<td valign="top" width="15%">{$lang.warehouse_comments}：</td>
	   					<td colspan="3" class="t_left" valign="top"><textarea name="comments"  class="textarea_height80 disabled">{$rs.edit_comments}</textarea> </td>
					</tr>
                    {/if}	    
	    		</table>
	    	</td>
	    </tr> 	 
		{if $rs}
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
		{/if}
    </tbody>
</table>
{if $rs}
	{staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
{else}
	{staff}
{/if}
</div>
</form>