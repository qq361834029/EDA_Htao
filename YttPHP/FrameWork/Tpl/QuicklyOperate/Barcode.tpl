<div class="table_autoshow" style="border-style:none!important; width: 320px!important;">
	<div class="note_right" style="margin:0;float: none !important;">
		<dl>
			<a href="javascript:;" onclick="printBarcode($('#print_barcode_{$smarty.get.id}'),'75mm','25mm');"><dt><span class="icon icon-list-print"></span>{L('print')}</dt></a>
		</dl>
	</div>
	<div id="print_barcode_{$smarty.get.id}" class="width98">
		<table cellspacing="0" cellpadding="0" width="100%">
			<tbody>			
				<tr>
					<th colspan="2" class="t_center">
						<img id="barcode" width="300" src="{$smarty.const.BARCODE_PATH}{$smarty.get.module}/{$smarty.get.id}.{"BARCODE_PC_TYPE"|C}?{$smarty.now}" />
					</th>
				</tr>
			</tbody>
		</table> 
	</div>
</div>
