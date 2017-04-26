<form action="{'Ajax/setPostSection'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="module" value="Shipping" />
<div class="table_autoshow" style="border-style:none!important; width: 380px!important;">
<table cellspacing="0" cellpadding="0"  class="add_table" width="100%">
    <tbody>
        <tr>
			<th colspan="4" style="background-image:none;">
                <table  width="100%">
                    <tr>
                        {assign var="import_key" value="ExpressPost"}
                        <td style="border:0px;"><a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>&nbsp;&nbsp;</td>
                        <td style="border:0px;">
                            {upload tocken=$file_tocken sid=$sid type=28 allowTypes="xls,xlsx" multi=true}
                        </td>
                        <td style="border:0px;">
                            <input type="radio" class="none" checked="check" value="3" name="{$import_key}_type" />
                            <input type="button" sheet="0" id="{$import_key}_submit" onclick="submitImport('{$import_key}',this)" class="other" disabled="disabled" value="{$lang.import}" />
                            <input type="hidden" id="file_name">
                        </td>
                    </tr>
                </table>
			</th>
		</tr>
        <tr style="border:0px;">
            <td style="border:0px;">
                {include file="QuicklyOperate/PostDetail.tpl"}
            </td>
        </tr>
    <tbody>
</table>
</div>
</form> 