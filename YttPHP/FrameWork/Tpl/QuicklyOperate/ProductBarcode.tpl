<div class="table_autoshow" style="border-style:none!important; width: 840px!important;">
	<div class="note_right" style="margin:10px 30px 0 0;float: none !important;">
		<dl>
			<a href="javascript:;" onclick="$.batchPrintProductBarcode({$smarty.get.id},{$smarty.get.quantity});"><dt><span class="icon icon-list-print"></span>{L('print')}</dt></a>
		</dl>
	</div>
	<div id="print_barcode_{$smarty.get.id}">        
            {section name=quantity loop=$smarty.get.quantity}
        	{if $smarty.section.quantity.iteration % 40 eq 1}
			<ul style="clear: both;page-break-after:always;">
			{/if}
				<li style=" float: left; height:110;vertical-align: top;margin-top: 41px ;text-align:center;">
					<img width="190" src="{$smarty.const.BARCODE_PATH}{$smarty.get.module}/{$smarty.get.id}.{"BARCODE_PC_TYPE"|C}" />
                    <br />{$rs.html}
				</li>
            {if $smarty.section.quantity.iteration eq $smarty.get.quantity || $smarty.section.quantity.iteration % 40 eq 0}
			</ul>
			{/if}            
            {/section} 
	</div>
</div>
