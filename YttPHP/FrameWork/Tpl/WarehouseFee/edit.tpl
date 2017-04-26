<form action="{'WarehouseFee/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
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
                            <input type="text" name="warehouse_fee_no" value="{$rs.warehouse_fee_no}" class="spc_input">__*__
                        </li>
                        <li>
                            {$lang.name}：
                            <input type="text" name="warehouse_fee_name" value="{$rs.warehouse_fee_name}" class="spc_input">__*__
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
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

