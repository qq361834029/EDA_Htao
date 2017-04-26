<form action="{'WarehouseFee/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="from_type" value="warehouse_fee">
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    <tbody>
        <tr><th>{$lang.warehouse_fee_basic}</th></tr>

        <tr>
            <td>
                <div class="basic_tb">
                    <ul>
                        <li>
                            {$lang.code}：
                            <input type="text" name="warehouse_fee_no" value="" class="spc_input">__*__
                        </li>
                        <li>
                            {$lang.name}：
                            <input type="text" name="warehouse_fee_name" value="" class="spc_input">__*__
                        </li>
                    </ul>
                </div>
            </td>
        </tr>

        <tr>
            <th colspan="4">
                {$lang.warehouse_fee_detail}
            </th>
        </tr>
        <tr><td>{include file="WarehouseFee/detail.tpl"}</td></tr>
    </tbody>
</table>
    {staff}
</div>
</form>

