{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
                    <div class="titleth">
                        <div class="titlefl">{$lang.waybill_basic}<input type="hidden" id="flow" value="domesticWaybill"></div>
                    </div>
                </th>
    		</tr>
    		<tr>
                <td>
                    <div class="basic_tb">  
                        <li>
                            {$lang.waybill_date}：{$rs.waybill_date}
                        </li>
                    </div>
                </td>
            </tr>
        <tr>
            <td>
                <div id="select_product_show">

                </div>
            </td>
        </tr>
		<tr>
			<th colspan="4">
				{$lang.waybill_detail}
			</th>
		</tr>
        <tr><td>{include file="DomesticWaybill/detail.tpl"}</td></tr>
        <tr>
            <td class="pad_top_10">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
                        <td width="80%" valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80 disabled" name="comments" readonly>{$rs.comments}</textarea></td>
                    </tr>
                </table>
    		</td>
        </tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>

