<form action="{"`$smarty.const.MODULE_NAME`/insert"|U}" method="POST" onsubmit="return false" >
{wz action="save,list,reset"}
<input type="hidden" name="from_type" value="packBox">
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
                    <div class="titleth">
                        <div class="titlefl">{$lang.pack_box_basic}<input type="hidden" id="flow" value="packBox"></div>
                    </div>
                </th>
    		</tr>
    		<tr>
                <td>
                    <div class="basic_tb">  
                        <li>
                            {$lang.pack_date}：<input type="text" name="pack_date" value="{$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
                        </li>
                        <li>
                            {$lang.warehouse}：
                            <input type="hidden" id="warehouse_id" onchange="setPackageWarehouse(this)" name="warehouse_id" >
                            <input type="text" name="temp[warehouse_name]" url="{'AutoComplete/saleWarehouse'|U}" jqac />__*__
                        </li>
                        <li>
                            {$lang.package}：
                            <input type="hidden" id="package_id" name="package_id" >
                            <input type="text" name="temp[package_name]" url="{'AutoComplete/packageNameUse'|U}" jqac />__*__
                        </li>
                        <li>
                            {$lang.is_aliexpress}：
                            {select id='is_aliexpress' data=C('IS_ALIEXPRESS') onchange='cleanPackBoxDetail()' name="is_aliexpress" empty=true value="1" combobox=""}__*__
                        </li>
                        <li>{$lang.belongs_seller}：
                            <input type="hidden" name="factory_id" id="factory_id" onchange="cleanPackBoxDetail()" value="">
                            <input id="factory_name" name="temp[factory_name]" value="" url="{'/AutoComplete/factoryEmail'|U}" jqac>__*__
                        </li>   
                    </div>
                </td>
            </tr>
		<tr>
			<th colspan="4">
				{$lang.pack_box_detail}
			</th>
		</tr>
        <tr>
            <td>
                <div class="basic_tb">  
                    <li>
                        {$lang.return_logistics_no}
                        <input value="" name="select_return_logistics_no" id="select_return_logistics_no" type='text' class="spc_input">
                    </li>
                    <li>
                        {$lang.return_waybill_no}
                        <input value="" name="select_return_track_no" id="select_return_track_no"  type='text' class="spc_input">
                    </li>
                    <li class="t_left">
                        <button type="button" onclick="addReturnToDetail()" class="other">{$lang.add}  </button>
                    </li>
                </div>
            </td>
		</tr>
        <tr><td>{include file="PackBox/detail.tpl"}</td></tr>
{*        <tr>
            <td class="pad_top_10">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
                        <td width="80%" valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80" name="comments"></textarea></td>
                    </tr>
                </table>
    		</td>
        </tr>*}
    	</tbody> 
    </table>
    {staff}
</div>
</form> 
<script type="text/javascript">
    //回车触发事件
$(document).ready(function(){ 
	$(document).on("keypress",'#select_return_logistics_no',function(event){
		if(event.which==13) {
			addReturnToDetail();
			return false;
		}
	});
    $(document).on("keypress",'#select_return_track_no',function(event){
		if(event.which==13) {
			addReturnToDetail();
			return false;
		}
	});
})
</script>

