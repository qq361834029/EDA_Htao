<div class="table_autoshow" style="border-style:none!important; width: 780px!important;">
	<div class="note_right" style="margin:10px 30px 0 0;float: none !important;">
		<dl>
			<a href="javascript:;" onclick="javascript:PrintMytable($('#print_barcode_{$smarty.get.id}'), 1000, 1040);"><dt><span class="icon icon-list-print"></span>{L('print')}</dt></a>
		</dl>
	</div>
	<div id="print_barcode_{$smarty.get.id}" class="width98">
		{assign var="row_num" value=0}
		{foreach from=$rs item=pc_name name=pc_name}
			{if $smarty.foreach.pc_name.iteration % 18 eq 1}
			<ul style="clear: both;page-break-after:always;">
			{/if}
				<li style="height: 172px !important;width:250px; float: left; vertical-align: top;">
                    <div style="line-height:90% ;font-size:9pt;font-weight:bolder;text-align:center;" >
                        <span><img style='padding:0 0 3px 0;' src="{$smarty.const.BARCODE_PATH}{$smarty.get.module}/{$smarty.get.id}/{$pc_name}.{"BARCODE_PC_TYPE"|C}" /></span>
                        <br />
                        {$box_info[$pc_name]['html']}
                    </div>
                </li>
			{if $smarty.foreach.pc_name.last || $smarty.foreach.pc_name.iteration % 18 eq 0}
				</ul>
			{/if}				
		{/foreach}
	</div>
</div>
