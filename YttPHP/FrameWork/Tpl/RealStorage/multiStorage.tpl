{wz}
<div class="search_box">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <div class="search_left">
		<dl>
		
		<dt>
					<label>{$lang.product_no}：</label>
					<input type="hidden" id="product_id" name="query[product_id]">
					<input type='text' url="{'/AutoComplete/productReal'|U}" jqac>
				</dt>
			
		</dl>	
</div>
    </td>
    <td width="68" height="34" background="__PUBLIC__/Images/Default/search_button_bg.gif" bgcolor="#DBEAFF" align="center">
    <button class="mout_search" value="1" onclick="javascript:multiStorage($dom.find('#product_id').val(),this)" onmouseout="this.className='mout_search'" onmouseover="this.className='mover_search'" name="ac_search" id="ac_search" type="submit" url="{'/Ajax/multiStorage'|U}">查询</button>
    </td>
  </tr>
</table>
</div>
{note tabs="realStorage"}
<div id="print" class="width98">

</div> 

