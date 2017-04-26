{include file="Admin/header.tpl"}
<div class="title"> 该页面配置提交后不可修改，请确认无误后再提交。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >产品类别级别：</td>
	<td class="tLeft" ><select name="product_class_level" combobox>
            <option value="1" {if product_class_level|C==1}selected{/if}>一级类别</option>
            <option value="2" {if product_class_level|C==2}selected{/if}>二级类别</option>
            <option value="3" {if product_class_level|C==3}selected{/if}>三级类别</option>
            <option value="4" {if product_class_level|C==4}selected{/if}>四级类别</option>
          </select></td>
</tr>
<tr>
	<td class="tRight" >产品绑定颜色：</td>
	<td class="tLeft" ><input type="radio" name="product_color" value="1" {if product_color|C==1}checked{/if}>是<input type="radio" name="product_color" value="2" {if product_color|C==2}checked{/if}>否</td>
</tr>
<tr>
	<td class="tRight" >产品绑定尺码：</td>
	<td class="tLeft" ><input type="radio" name="product_size" value="1" {if product_size|C==1}checked{/if}>是<input type="radio" name="product_size" value="2" {if product_size|C==2}checked{/if}>否</td>
</tr>
<tr>
	<td class="tRight" >产品绑定厂家：</td>
	<td class="tLeft" ><input type="radio" name="product_factory" id="" value="1" {if product_factory|C==1}checked{/if}>是<input type="radio" name="product_factory" id="" value="2"  {if product_factory|C==2}checked{/if}>否</td>
</tr>

<tr>
	<td class="tRight" >是否多仓库：</td>
	<td class="tLeft" ><input type="radio" name="multi_storage" value="1" {if multi_storage|C==1}checked{/if}>是<input type="radio" name="multi_storage" value="2" {if multi_storage|C==2}checked{/if}>否</td>
</tr>

<tr>
	<td class="tRight" >库存规格：</td>
	<td class="tLeft" ><select name="storage_format" id="storage_format" combobox>
              <option value="1" {if storage_format|C==1}selected{/if}>按数量</option>
              <option value="2" {if storage_format|C==2}selected{/if}>按箱*每箱数量</option>
              <option value="3" {if storage_format|C==3}selected{/if}>按箱*每箱包数*每箱数量</option>
            </select><input type="checkbox" name="storage_color" id="" value="1" {if storage_color|C==1}checked{/if}>颜色  <input type="checkbox" name="storage_size" id="" value="1" {if storage_size|C==1}checked{/if}> 尺码  <input type="checkbox" name="storage_mantissa" id="" value="1" {if storage_mantissa|C==1}checked{/if}> 尾箱</td>
</tr>
<tr>
	<td class="tRight">箱数规格：</td>
	<td class="tLeft">
		<select name="quantity_format" combobox>
			<option value="1" {if quantity_format|C==1}selected{/if}>整数</option>
			<option value="2" {if quantity_format|C==2}selected{/if}>小数</option>
		</select>
	</td>
</tr>


<tr>
	<td class="tRight" >汇率设置：</td>
	<td class="tLeft" ><select name="set_rate_type" combobox ><option value="2" {if set_rate_type|C==2}selected{/if}>按月</option><option value="3" {if set_rate_type|C==3}selected{/if}>按单据日期</option></select>（无法获取设置汇率时取固定汇率同时记录汇率异常）</td>
</tr>
<tr>
	<td class="tRight" >本位币：</td>
	<td class="tLeft" >
	{currency data='1,2,3,4,5' name="currency" value="{C('currency')}" empty=true combobox=1}</td>
</tr>
<tr>
	<td class="tRight" >银行存款关联现金：</td>
	<td class="tLeft" ><input type="radio" name="bank_cash" value="1" {if bank_cash|C==1}checked{/if}>是<input type="radio" name="bank_cash" value="2" {if bank_cash|C==2}checked{/if}>否</td>
</tr>
<tr>
	<td class="tRight" >可销售库存显示方式：</td>
	<td class="tLeft" ><input type="radio" name="sale_storage_show_type" value="1" {if $rs.sale_storage_show_type==1}checked{/if}>按类别<input type="radio" name="sale_storage_show_type" value="2" {if $rs.sale_storage_show_type==2}checked{/if}>按产品</td>
</tr>
<tr>
	<td class="tRight" >实际库存显示方式：</td>
	<td class="tLeft" ><input type="radio" name="real_storage_show_type" value="1" {if $rs.real_storage_show_type==1}checked{/if}>按类别<input type="radio" name="real_storage_show_type" value="2" {if $rs.real_storage_show_type==2}checked{/if}>按产品</td>
</tr>
<tr>
	<td class="tRight" >发送客户应付款：</td>
	<td class="tLeft" ><input type="radio" name="client_stat_sent_email" value="1" {if $rs.client_stat_sent_email==1}checked{/if}>是<input type="radio" name="client_stat_sent_email" value="2" {if $rs.client_stat_sent_email==2}checked{/if}>否</td>
</tr>
<tr>
	<td class="tRight" >订货时区配置：</td>
    <td class="tLeft"><select name="orders_timezone" combobox >
    <option value="Asia/Shanghai" {if orders_timezone|C=='Asia/Shanghai'}selected{/if}>中国/上海</option>
    <option value="America/New_York" {if orders_timezone|C=='America/New_York'}selected{/if}>美国/纽约</option>
    <option value="Europe/Berlin" {if orders_timezone|C=='Europe/Berlin'}selected{/if}>欧洲/柏林</option>
    <option value="Europe/Rome" {if orders_timezone|C=='Europe/Rome'}selected{/if}>欧洲/罗马</option>
    </select></td>
</tr>
<tr>
	<td class="tRight" >销售时区配置：</td>
    <td class="tLeft"><select name="sale_timezone" combobox >
    <option value="Asia/Shanghai" {if sale_timezone|C=='Asia/Shanghai'}selected{/if}>中国/上海</option>
    <option value="America/New_York" {if sale_timezone|C=='America/New_York'}selected{/if}>美国/纽约</option>
    <option value="Europe/Berlin" {if sale_timezone|C=='Europe/Berlin'}selected{/if}>欧洲/柏林</option>
    <option value="Europe/Rome" {if sale_timezone|C=='Europe/Rome'}selected{/if}>欧洲/罗马</option>
    </select></td>
</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="once">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>



 <tr>
	<td colspan="2">
	<br><br>
	<a href="__URL__/updateFlowStorage">更新所有流程明细字段与库存一致</a>（同步颜色，尺码，尾箱，库存规格）
	<br><br>
	特别说明：<br>
一、库存规格用于更新库存的唯一标准，<br>
二、选择规格后不对流程的规格输入框做限制，<br>
三、各个流程还可以自由配置，未出现在规则中的数据则做为流程信息记录。
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
