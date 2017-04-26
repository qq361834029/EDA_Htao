{wz}
<form method="POST" action="{'ProductPrice/index'|U}" id="search_form">
__SEARCH_START__
			<dl>  
				<dt>
					<label>{$lang.factory_name}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label>
					<input type="hidden" name="main[query][factory_id]" value="{$smarty.post.query.factory_id}"><input id="factory_name" name="temp[factory_name]" value="{$smarty.post.temp.factory_name}" url="{'/AutoComplete/factoryName'|U}" jqac>
            	</dt> 
				<dt><label>{$lang.product_no}：</label>
					<input id="product_no" name="main[like][product_no]" value="{$smarty.post.like.product_no}" url="{'/AutoComplete/productNo'|U}" jqac>
            		</dt>
				<dt><label>{$lang.product_name}：</label>
					<input id="product_no" name="main[like][product_name]" value="{$smarty.post.like.product_name}" url="{'/AutoComplete/productName'|U}" jqac>
            	</dt>
            	<dt>
					<label>{$lang.class_name_1}：</label>
					<input type="hidden" name="class[query][class_1]" value="{$smarty.post.query.class_1}"><input id="class_name1" name="temp[class_name1]" value="{$smarty.post.temp.class_name1}" url="{'/AutoComplete/productClass1'|U}" jqac>
				</dt>
				{if C('PRODUCT_CLASS_LEVEL')>=2}
				<dt>
					<label>{$lang.class_name_2}：</label>
					<input type="hidden" name="class[query][class_2]" value="{$smarty.post.query.class_2}"><input id="class_name2" name="temp[class_name2]" value="{$smarty.post.temp.class_name2}" url="{'/AutoComplete/productClass2'|U}" jqac> 
				</dt>
				{/if}
				{if C('PRODUCT_CLASS_LEVEL')>=3}
				<dt>
					<label>{$lang.class_name_3}：</label>
					<input type="hidden" name="class[query][class_3]" value="{$smarty.post.query.class_3}"><input id="class_name3" name="temp[class_name3]" value="{$smarty.post.temp.class_name3}" url="{'/AutoComplete/productClass3'|U}" jqac> 
				</dt>
				{/if}
				{if C('PRODUCT_CLASS_LEVEL')>=4}
				<dt>
					<label>{$lang.class_name_4}：</label>
					<input type="hidden" name="class[query][class_4]" value="{$smarty.post.query.class_4}"><input id="class_name4" name="temp[class_name4]" value="{$smarty.post.temp.class_name4}" url="{'/AutoComplete/productClass4'|U}" jqac> 
				</dt>
				{/if}
            			<dt><label>{$lang.price_range}：</label>
            				{select data=C('PRICE_RANGE') name="price_range" value="`$smarty.post.price_range`" initvalue="0" combobox=1}
				</dt>
			</dl> 
__SEARCH_END__
</form> 
{note export=true}
<div id="print" class="width98">
{include file="ProductPrice/list.tpl"}
</div>  