<table cellspacing="0" cellpadding="0" border="0" class="table_fdc">
    <tr>
        <th>
            Code
        </th>
        <th>
            Base HT
        </th>
        <th>
            Taux TVA
        </th>
        <th>
            Montant TVA
        </th>
    </tr>
    <tr>
        <td>
            1
        </td>
        <td class="t_right">
        	<!-- 发票总金额 -->
            {$rs.detail_total.dml_discount_money}
        </td>
        <td class="t_right">
        	<!-- 税率 IVA -->
            {$rs.dml_iva}
        </td>
        <td class="t_right">
            {$rs.detail_total.dml_iva_cost}
        </td>
    </tr>
</table>