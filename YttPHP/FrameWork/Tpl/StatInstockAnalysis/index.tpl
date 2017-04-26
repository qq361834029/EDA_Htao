{wz}
<form method="POST" action='{"/StatInstockAnalysis/index/search_form/1"|U}' validity="statCheck" formtarget="print" id="form">
<div style="padding-top:12px;"></div>
<div class="add_box" style="padding:0px!important;margin-bottom:0px!important;margin-top:0px!important;height:62px;">
    <div class="search_left" style="width:92%!important;">
		<dl>
		   		<dt>
					<label >{$lang.product_no}：</label>
					<input type='hidden' name="detail[query][b.product_id]">
             		<input type='text' url="{'/AutoComplete/product'|U}" jqac>
            	</dt>
				<dt class="w320">
					<label>{$lang.from_date}：</label><input class="Wdate spc_input_data" type="text" onclick="WdatePicker()" value="" name="main[date][from_real_arrive_date]"> <label>{$lang.to_date}：</label><input class="Wdate spc_input_data" type="text" onclick="WdatePicker()" value="" name="main[date][to_real_arrive_date]">
            	</dt>            			  
            	<dt>
					<label>{$lang.compare_type}：</label>
					{radio data=C('COMPARE_TYPE') name="compare_type" initvalue=2}
            	</dt>
		{if C('PRODUCT_CLASS_LEVEL')>=1}
            	<dt>
			<label>{$lang.class_name_1}：</label>
			<input type="hidden" name="detail2[query][class_1]">
			<input id="pv_no" name="class_1"  url="{'/AutoComplete/ProductClass1'|U}" jqac>
		</dt>
		
		{if C('PRODUCT_CLASS_LEVEL')>=2}
		<dt>
			<label>{$lang.class_name_2}：</label>
			<input type="hidden" name="detail2[query][class_2]">
			<input id="pv_no" name="class_2"  url="{'/AutoComplete/ProductClass2'|U}" jqac>
		</dt>
		{if C('PRODUCT_CLASS_LEVEL')>=3}
		<dt>
			<label>{$lang.class_name_3}：</label>
			<input type="hidden" name="detail2[query][class_3]">
			<input id="pv_no" name="class_3" url="{'/AutoComplete/ProductClass3'|U}" jqac>
		</dt>
		{if C('PRODUCT_CLASS_LEVEL')>=4}
		<dt>
			<label>{$lang.class_name_4}：</label>
			<input type="hidden" name="detail2[query][class_4]">
			<input id="pv_no" name="class_4" url="{'/AutoComplete/ProductClass4'|U}" jqac>
		</dt>
		{/if}
		{/if}
		{/if}
		{/if}   
		</dl>	
		<input type="hidden" name="date_key" value="2">
   </div>

   <div style="background:url('__PUBLIC__/Images/Default/search_button_bg.gif');width:68px;height:62px;float:right;text-align:center;">
    <input type="hidden" value="1" name="search_form" autocomplete="off">
    <input type="hidden" value="1" id="nextPage" name="nextPage" autocomplete="off">
    <button type="submit" id="ac_search" name="ac_search" onmouseover="this.className='mover_search'" onmouseout="this.className='mout_search'" value="1" class="mout_search">{$lang.search}</button>
    </div>
    
</div>
</form>
{note}
<div id="print" class="width98">
{include file="StatInstockAnalysis/list.tpl"}
</div> 

