<form action="{"SaleOrder/batchUpload"|U}" method="POST" onsubmit="return false">
    <div class="add_box" style="color: #000000;margin: 0;height: 200px;">
        <table cellspacing="0" cellpadding="0" width="100%">
            <tbody>
                <input type="hidden" name="file_tocken" value="{$file_tocken}">
                <tr>
                    <td>{$lang.deal_no}：</td>
                    <td>
                        <input type="hidden" name="sale_order_id">
                        <input type="text" name="sale_order_no" url="{'/AutoComplete/saleDealNo'|U}" jqac>
                    </td>
                </tr>
                <tr>
                    <td>{$lang.upload_file}：</td>
                    <td class="t_left">{upload tocken=$file_tocken sid=$sid type=19 allowTypes="all"}</td>
                    <input type="hidden" id="file_name" name="file_name">
                    <input type="hidden" name="sheet" value="0">
                    <input type="hidden" name="import_key" value="{$import_key}">
                </tr>
            </tbody>
        </table>
    </div>
</form>