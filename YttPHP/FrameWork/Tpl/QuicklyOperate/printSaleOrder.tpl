<div class="table_autoshow" style="border-style:none!important; width: 840px!important;">
    <div class="note_right" style="margin:10px 30px 0 0;float: none !important;">
        <dl>
            <a href="javascript:;" onclick="javascript:printSaleOrder($('#print_barcode_{$smarty.get.id}'), '210.1mm', '297.1mm',false);"><dt><span class="icon icon-list-print"></span>{L('print')}</dt></a>
        </dl>
    </div>
    <div id="print_barcode_{$smarty.get.id}">
        <table>
            {foreach from=$rs item=pc_name name=pc_name}
                {if $smarty.foreach.pc_name.iteration % 4 eq 1}
                    <tr>			
                {/if}
                <div style="width: 191px;height: 190px;float: left;color: #000; ">
                    {if in_array($pc_name.company_id,array(C('EXPRESS_FR_POST_ID'),C('EXPRESS_FR_POST_EXPRESS_ID')))}
                        {assign var='company_name' value='Eda Warehousing FR.  34av charles de gaulle(lot45/46) </br> 93240 stains'}
                    {elseif $pc_name.company_id == C('EXPRESS_IT-POST_ID')}
                        {assign var='company_name' value='EDA ITALY srl   VIA SANTA CORNELIA  5/A S 1   00060 FORMELLO (RM)'}
                    {elseif $pc_name.company_id == C('MAIL_ES_CORREOS_ID')}
                        {assign var='company_name' value='Eda Warehousing034 S.L，C/Barrio  Estación.53-Pol.Yeles(Toledo) ，45220'}
                    {elseif $pc_name.shipping_type == C('SHIPPING_TYPE_SURFACE')&&$pc_name.warehouse_id==C('EXPRESS_PL_WAREHOUSE_ID')}
                        {assign var='company_name' value='ABZ Logistics GmbH·Schubertstraße 67·15234 Frankfurt (Oder)'}
					{else}
						{assign var='company_name' value='Eda Warehousing DE. UG Industrie str. 11421107 Hamburg'}
                    {/if}
                    <div style="text-align:center;margin: 15px 5px 3px 5px;font-size:4px;"><u>{$company_name}</u>
                    </div>               
                    <div style="font-weight: bolder;line-height: normal;margin: 0 20px;text-align: left;font-size:8.5px;">
						{if $pc_name.DPW}
                        <span style="font-family:Calibri,sans-serif;text-decoration:underline;">{$pc_name.DPW}</span></br>
						 {/if}
                            {$pc_name.consignee}</br>
                            <span style="font-size: 11px;">{$pc_name.address}</span></br>
                            {$pc_name.post_code} {$pc_name.city_name}</br>
                    </div>
                </div>
                {if $smarty.foreach.pc_name.last || $smarty.foreach.pc_name.iteration % 4 eq 0}
                    <div style=”clear:both”></div> 
                    </tr>
                {/if}				
            {/foreach}
        </table>
    </div>
</div>

