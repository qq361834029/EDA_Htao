{wz}
<script type="text/javascript">
$dom.find("input[type=button]").attr("disabled","disabled");
function submitImport(key,obj){
//	$.loading('{$lang.submit_msg}');
	var in_type 	= $dom.find("input[type='radio'][name='"+key+"_type']:checked").val();
	var file_name	= $(obj).parent('td').find('#file_name').val();
	$.getJSON(APP+'/Ajax/imporExcel/key/'+key+'/file/'+file_name+'/in_type/'+in_type,function(result){  
		$.removeLoading();
		$("<div>"+result.msg+"</div>").dialog({
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
					loadTab();
				}
			}
		});
		//reload
//		location.reload();
	}) 
	return true;
}
</script>

<table width="98%" id="" class="detail_list" border="1" cellpadding=0 cellspacing=0 ><tr class="row" >
<th>{$lang.module_name}</th><th>{$lang.import_type}</th><th>{$lang.file_name}</th><th>{$lang.improt}</th><th>{$lang.excel_download}</th></tr>
{foreach key=key item=item from=$list}
<tr>
<input type="hidden" name="module" value="{$key}">
<td >{$lang[$key|strtolower]}</td>
<td >
{if $key=="District" || $key=="FactoryIni" || $key=="ClientIni" || $key=="InitStorage" ||  $key=="Stocktake"}
&nbsp;
{else}
<input type="radio" id="{$key}_radio" name="{$key}_type" value="1" checked>{$lang.replace} <input type="radio" name="{$key}_type" id="{$key}_radio" value="2">{$lang.pass}
{/if}
</td>
<td style="padding-top:3px;"><form>{upload tocken=$file_tocken sid=$sid type=10 allowTypes="xls,xlsx"}</form></td>
<td><input type="button" id="{$key}_submit" class="auditbutton" value="{$lang.improt}" onclick="submitImport('{$key}',this)"><input type="hidden" id="file_name"></td>
<td ><a href="{$smarty.const.EXCEL_PATH}/{$key}.xls">{$lang.download}</a></td>
</tr>
{/foreach}
</table>
