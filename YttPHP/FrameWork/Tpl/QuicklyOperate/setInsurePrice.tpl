<form action="{'Ajax/setInsurePrice'|U}" method="POST" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important; width: 290px!important;color:#222222;">
    <input type="hidden" name="id" id='id' value='{$rs.id}' class="spc_input">
    {$lang.insure_price}：
    <input type="text" name="insure_price" id='insure_price' value='{$rs.edml_insure_price}' class="spc_input">{$rs.w_currency_no}
</div>
</form> 