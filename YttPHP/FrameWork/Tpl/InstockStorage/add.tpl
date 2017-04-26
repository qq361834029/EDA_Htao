<form action="{'InstockStorage/insert'|U}" method="POST" beforeSubmit="">
	{wz action='save,list,reset'}
<input type="hidden" name="flow" id="flow" value="instock_storage">
<div style="position: fixed; background: #FEFEFE repeat-x scroll 0 0;height: 34px;width: 98.75%; z-index: 100; ">
    <div style=" width: 700px;float: right;">
        <label>{$lang.custom_barcode}：</label>
	    <input id="custom_barcode" value="" name="query[custom_barcode]" type='text' onkeyup="checkForm(event)" class="spc_input valid-required">
    </div>
</div>
<div class="add_box" style="margin: 40px auto 60px;">
<input type="hidden" id="instock_id" name="instock_id" value="{$rs.id}">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>
		<tr>
			<th>
				<div class="titleth">
    				<div class="titlefl">{$lang.basic_info}</div>
    				<div class="afr">{$lang.delivery_no}：{$rs.instock_no}</div>
    			</div>
			</th>
		</tr>
		<tr>
			<td>
				{include file="InstockStorage/restricted_main_info.tpl"}				
  			</td>
  		</tr> 
		{if $rs.product}
    	<tr>
    		<th>{$lang.detail_info}
            <table class="fr">
            <tr>
                {assign var="import_key" value="InstockStorage"}
                <td><a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>&nbsp;&nbsp;</td>
                <td>
                    {upload tocken=$file_tocken sid=$sid type=21 allowTypes="xls,xlsx" multi=true}
                </td>
                <td>
                    <input type="radio" class="none" checked="check" value="3" name="{$import_key}_type" />
                    <input type="button" sheet="0" id="{$import_key}_submit" onclick="submitImport('{$import_key}',this)" class="other" disabled="disabled" value="{$lang.import}" />
                    <input type="hidden" id="file_name">
                </td>
            </tr>
        </table>
            </th></tr>
    	<tr>
        
    		<td  class="t_center">
    			{include file="InstockStorage/product_detail.tpl"}
    		</td>
    	</tr>		
		{/if}
			<tr>
				<td style="padding-top:10px;">
					<table cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td valign="top" width="15%" class="t_right">{$lang.comments}：</td>
							<td colspan="3" class="t_left" valign="top"><textarea >{$rs.edit_comments}</textarea></td>
						</tr>
					</table>
				</td>
			</tr> 			
    </tbody>
</table>
   {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form>
{literal}
<script>
    $(document).ready(function(){ 
        $dom.find('#custom_barcode').focus();  
    });
</script>
{/literal}