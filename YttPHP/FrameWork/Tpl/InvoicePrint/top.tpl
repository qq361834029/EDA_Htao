<table width="466px" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td width="28%" align="left">
            <table cellspacing="0" cellpadding="0" border="0" class="table_fdc">
                <tr>
                    <th align="center">
                        Facture N°
                    </th>
                </tr>
                <tr>
                    <td class="tbold">
                        {$rs.invoice_no}
                    </td>
                </tr>
            </table>
        </td>
        <td width="2%">
            &nbsp;
        </td>
        <td width="28%">
            <table cellspacing="0" cellpadding="0" border="0" class="table_fdc">
                <tr>
                    <th>
                        Date
                    </th>
                </tr>
                <tr>
                    <td class="tbold">
                        {$rs.fmd_invoice_date}
                    </td>
                </tr>
            </table>
        </td>
        <td width="2%">
            &nbsp;
        </td>
        <td width="40%">
            <table cellspacing="0" cellpadding="0" border="0" class="table_fdc">
                <tr>
                    <th>
                        Client
                    </th>
                </tr>
                <tr>
                    <td class="tbold">
                    {if $smarty.const.MODULE_NAME=='InvoiceIn'}
                    	{$rs.factory_name}
                    {else}
                        {$rs.client_name}
                    {/if}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>