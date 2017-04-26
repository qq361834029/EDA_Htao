<div class="table_autoshow" style="border-style:none!important; width: 840px!important;">
    <div class="note_right" style="margin:10px 30px 0 0;float: none !important;">
        <dl>
            <a href="javascript:;" onclick="javascript:printSaleOrder($('#print_barcode_{$smarty.get.id}'), '210.1mm', '297.1mm',false);"><dt><span class="icon icon-list-print"></span>{L('print')}</dt></a>
        </dl>
    </div>
    <div id="print_barcode_{$smarty.get.id}">
            {foreach from=$rs item=pc_name name=pc_name} 
                {if $smarty.foreach.pc_name.iteration % 8 eq 1}
                    <div style="page-break-after:always">
                {/if}
                    <div style="width: 266pt;height: 170pt;padding: 0pt 0pt 0pt 40pt;float: left;color: #000;font-size:9pt; font-weight:bolder;line-height: 10pt;">{*border: 1px solid;*}
                        <div>
                            <br />
                            FROM:EDA ITALY SRL<br />
                            (LOGISTICA PER CONTO TERZI)<br />
                            VIA SANTA CORNELIA 5/S1<br />
                            00060 FORMELLO RM ITALY（peso:{$pc_name.edml_weight}g)<br />
                        </div>
                        <br />
                        <br />
                        <br />
                        <div style="width: 150pt;padding: 0pt 0pt 0pt 32pt;display:block;word-break: break-all;word-wrap: break-word;">
                            TO:{$pc_name.consignee}<br />{*收货人*}
                            <br />
                            <br />
                            {$pc_name.address} {$pc_name.address2}<br />{*地址一地址二*}
                            {$pc_name.post_code}&nbsp;&nbsp;{$pc_name.city_name}&nbsp;&nbsp;{$pc_name.company_name}<br />{*邮编 城市 省份*}
                            {if $pc_name.country_id != C('IT_COUNTRY_ID')}{*所属国家（除意大利国家以外的才显示）*}
                            {$pc_name.country_name} {$pc_name.abbr_district_name}<br />
                            {/if}
                            <br />
                        </div>
                    </div>
                    {if $smarty.foreach.pc_name.iteration % 8 eq 0}
                        </div>
                    {/if}
            {/foreach}
                <div style="clear:both"></div> 
    </div>
</div>

