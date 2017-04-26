{wz is_update=$rs.is_update}
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
                            {$rs.warehouse_fee_no}
                        </li>
                        <li>
                            {$lang.name}：
                            {$rs.warehouse_fee_name}
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <th >{$lang.warehouse_fee_detail}</th>
        </tr>
        <tr><td>{include file="WarehouseFee/detail.tpl"}</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>

