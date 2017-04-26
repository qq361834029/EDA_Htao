{wz}
<form method="POST" action="{"QuestionOrder/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
	<dl>
        <input id="rand" type="hidden" name="rand" value="{$rand}">
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
		<dt>
			<label>{$lang.shipping_warehouse}：</label>
			<input value="{$smarty.post.sale_order.query.question_order_warehouse_id}"   type="hidden" name="main[query][warehouse_id]" id="question_order_warehouse_id">
			<input value="{$smarty.post.temp.warehouse_name_use}" name="temp[warehouse_name_use]" type='text' url="{'/AutoComplete/saleWarehouse'|U}" jqac>
		</dt>
		{/if}
		<dt>
			<label>{$lang.question_order_no}：</label>
			<input type="hidden" name="main[query][id]" id="id" value=""  >
			<input type="text"  value="{$smarty.post.temp.question_order_no}" name="main[query][question_order_no]" url="{'AutoComplete/questionOrder'|U}" jqac >
		</dt>  
		<dt>
			<label>{$lang.deal_no}：</label>
			<input type="hidden" name="main[query][sale_order_id]" id="sale_order_id"  value="" >
			<input value="{$smarty.post.main.query.sale_order_no}" type="text" name="main[query][sale_order_no]" url="{'/AutoComplete/questionSaleOrderNo'|U}"   jqac>
		</dt>
		<dt>
			<label>{$lang.orderno}：</label>
			<input type="hidden" name="main[query][order_no]" id="order_no"  value="" >
			<input value="{$smarty.post.main.query.order_no}"  type="text" name="main[query][order_no]" url="{'/AutoComplete/questionOrderNo'|U}"  jqac>
		</dt> 
		<dt>
			<label>{$lang.add_order_date}：</label>
			<input type="text" name="main[date][needdate_from_add_order_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_from_add_order_date}" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_add_order_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_to_add_order_date}"  onClick="WdatePicker()"/>
		</dt>
		<dt>
			<label>{$lang.finish_date}：</label>
			<input type="text" name="main[date][needdate_from_finish_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_from_finish_date}" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_finish_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_to_finish_date}"  onClick="WdatePicker()"/>
		</dt>
		<dt>
			<label>{$lang.state}：</label>
			{select value=$smarty.post.main.query.question_order_state data=C('QUESTION_ORDER_STATE') name='main[query][question_order_state]' id='question_order_state' initvalue="1" combobox="1"}
		</dt>   
		<dt>
			<label>{$lang.treatment}：</label>
			{select value=$smarty.post.main.query.process_mode data=C('PROCESS_MODE') name='main[query][process_mode]' id='process_mode' initvalue="1" combobox="1"}
		</dt>   
		<dt>
			<label>{$lang.question_reason}：</label>
			{select data=C('QUESTION_REASON')  id="question_reason" value="{$smarty.post.main.query.question_reason}" name='main[query][question_reason]' combobox=1}
		</dt>
		<dt>
			<label>{$lang.id}：</label>
			<input value="{$smarty.post.sale_order_detail.query.product_id}" name="sale_order_detail[query][product_id]" type='text' class="spc_input">
		</dt>  
		<dt>
			<label>{$lang.product_no}：</label> 
			<input value="{$smarty.post.product.like.product_no}" type='text' name="product[like][product_no]" url="{'/AutoComplete/productNo'|U}" jqac>
		</dt>
		<dt>
			<label>{$lang.express_way}：</label>
			<input value="{$smarty.post.sale_order.query.express_id}" type="hidden" name="sale_order[query][express_id]">
			<input value="{$smarty.post.temp.express_name}" name="temp[express_name]" type='text' id="express_name" where=""   url="{'/AutoComplete/shippingName'|U}" jqac>
		</dt>
        <dt>
			<label>{$lang.track_no}：</label> 
			<input value="{$smarty.post.sale_order.like.track_no}" type='text' name="sale_order[like][track_no]" url="{'/AutoComplete/questionTrackNo'|U}" jqac>
		</dt>
        <dt>
			<label>{$lang.compensation_date}：</label>
			<input type="text" name="main[date][needdate_from_compensation_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_from_compensation_date}" onClick="WdatePicker()"/>
			<label>{$lang.to_date}</label>
			<input type="text" name="main[date][needdate_to_compensation_date]" class="Wdate spc_input_data" value="{$smarty.post.date.needdate_to_compensation_date}"  onClick="WdatePicker()"/>
		</dt>
        {if $login_user.role_type!=C('SELLER_ROLE_TYPE')}  
		<dt>
			<label>{$lang.belongs_seller}：</label>
			<input value="{$smarty.post.main.query.sale_order_factory_id}" type='hidden' name="main[query][factory_id]">
			<input value="{$smarty.post.temp.factory}" name="temp[factory]" type='text' url="{'/AutoComplete/factory'|U}" jqac>
		</dt> 
		{/if}
        <dt>
			<label>{$lang.doc_staff}：</label>
			<input value="{$smarty.post.temp.add_user}" type='hidden' name="temp[add_user]">
			<input value="{$smarty.post.user.like.real_name}" name="user[like][real_name]" type='text' url="{'/AutoComplete/questionAddUserName'|U}" jqac>
		</dt> 
	</dl>
__SEARCH_END__
</form>
{note export=true}
__SCROLL_BAR_START__
<div id="print" class="width98">
{include file="QuestionOrder/list.tpl"}
</div> 
__SCROLL_BAR_END__