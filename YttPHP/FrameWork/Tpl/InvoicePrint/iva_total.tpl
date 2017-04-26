<table cellspacing="0" cellpadding="0" border="0" class="table_fdc">
    <tr>
        <th width="50%" class="t_left b_bottom b_right">
            Total HT
        </th>
        <td class="t_right b_bottom b_left">
            {$rs.detail_total.dml_discount_money}
        </td>
    </tr>
    <tr>
        <th class="t_left b_top b_right">
            Net HT
        </th>
        <td class="t_right b_top b_left tbold">
            {$rs.detail_total.dml_discount_money}
        </td>
    </tr>
    <tr>
        <th class="t_left b_bottom b_right">
            Total TVA
        </th>
        <td class="t_right b_bottom b_left">
            {$rs.detail_total.dml_iva_cost}
        </td>
    </tr>
    <tr>
        <th class="t_left b_top b_right">
            Total TVA
        </th>
        <td class="t_right b_top b_left ">
            {$rs.detail_total.dml_total_cost}
        </td>
    </tr>
    <tr>
        <th class="t_left b_right">
            NET A PAYER
        </th>
        <td class="t_right b_top b_left tbold">
            {$rs.detail_total.dml_total_cost}
        </td>
    </tr>
</table>