{wz}
<form method="POST" action="{'ProductClass/index'|U}" id="search_form">
__SEARCH_START__
			<dl>   
            	<dt>
					<label>{$lang.class_name_1}：<input type="hidden" id="rand" name="rand" value="{$rand}"></label>
					<input id="pv_no" name="like[a.class_name]" value="{$smarty.post.like.a_class_name}" url="{'/AutoComplete/ProductClass1Name'|U}" jqac>
				</dt>
				
				{if C('PRODUCT_CLASS_LEVEL')>=2}
				<dt>
					<label>{$lang.class_name_2}：</label>
					<input id="pv_no" name="like[b.class_name]" value="{$smarty.post.like.b_class_name}" url="{'/AutoComplete/ProductClass2Name'|U}" jqac>
				</dt>
				{/if}
				{if C('PRODUCT_CLASS_LEVEL')>=3}
				<dt>
					<label>{$lang.class_name_3}：</label>
					<input id="pv_no" name="like[c.class_name]" value="{$smarty.post.like.c_class_name}" url="{'/AutoComplete/ProductClass3Name'|U}" jqac>
				</dt>
				{/if}
				{if C('PRODUCT_CLASS_LEVEL')>=4}
				<dt>
					<label>{$lang.class_name_4}：</label>
					<input id="pv_no" name="like[d.class_name]" value="{$smarty.post.like.d_class_name}" url="{'/AutoComplete/ProductClass4Name'|U}" jqac>
				</dt>
				{/if}
            	<dt>	
					<label>{$lang.state}：</label>
            		{select data=C('BASICSTATE') name="stohide" value="`$smarty.post.stohide`" initvalue="1" combobox=1}
				</dt> 
			</dl> 
__SEARCH_END__
</form> 
{note export=true}
<div id="print" class="width98">
{include file="ProductClass/list.tpl"}
</div>  
