{wz}
<form action="{'StatClientAnalysis/index'|U}" method="post" validity="statCheck"  beforeSubmit="checkSearchForm" id="search_form" onsubmit="return false;">
<input type="hidden" name="date_key" value="2">
<div style="padding-top:12px;"></div>
<div class="add_box" style="padding:0px!important;margin-bottom:0px!important;margin-top:0px!important;height:62px;">
    <div class="search_left" style="width:92%!important;">
<dl>
	<dt>
		<label>{$lang.client_name}：</label>
		<input type="hidden" name="query[client_id]">
		<input type='text' name="client_name" url="{'AutoComplete/client'|U}" jqac />
	</dt>
	{company type='dt' hidden=['name'=>'query[basic_id]'] name='basic_name' title=$lang.basic_name}
	<dt class="w320">
		<label>{$lang.from_date}：</label>
		<input type="text" id="date_from" name="date[from_order_date]" class="valid-required Wdate spc_input_data" onclick="WdatePicker()">
		<label>{$lang.to_date}</label>
		<input type="text" id="date_to" name="date[to_order_date]" class="valid-required Wdate spc_input_data" onclick="WdatePicker()">
	</dt>
	<dt>
		<label>{$lang.compare_type}：</label>
		<input type="radio"  name="compare_type" id="compare_type" value="1"   checked >{$lang.compare_type_year}
		<input type="radio"  name="compare_type" id="compare_type" value="2" >{$lang.compare_type_month}
		<input type="radio"  name="compare_type" id="compare_type" value="3"  >{$lang.compare_type_day}
	</dt>
{if 'product_class_level'|C>=1}
	<dt>
        <label>{$lang.class_name_1}：</label>
        <input type="hidden" name="query[class_1]" >
        <input type='text' name="temp[class_1]" url="{'AutoComplete/productClass1'|U}" jqac />
   </dt>
   {if 'product_class_level'|C>=2}
	<dt>
		<label>{$lang.class_name_2}：</label>
        <input type="hidden" name="query[class_2]">
        <input type="text" name="temp[class_2]" url="{'AutoComplete/productClass2'|U}" jqac />
   </dt>
   {if 'product_class_level'|C>=3}
   <dt>
       	<label>{$lang.class_name_3}：</label>
		<input type="hidden" name="query[class_3]">
        <input type="text" name="temp[class_3]" url="{'AutoComplete/productClass3'|U}" jqac />
   </dt>
   {if 'product_class_level'|C>=4}
   <dt>
        <label>{$lang.class_name_4}：</label>
        <input type="hidden" name="query[class_4]">
        <input type="text" name="temp[class_4]" url="{'AutoComplete/productClass4'|U}" jqac />
   </dt>
   {/if}
   {/if}
   {/if}
   {/if}
</dl>
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
{if $smarty.post.search_form}
{include file='StatClientAnalysis/list.tpl'}
{/if}
</div>