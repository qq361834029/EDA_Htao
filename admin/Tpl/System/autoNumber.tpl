{include file="header.tpl"}
<div class="title"> 自动编号配置，修改后系统可正确运行，无须处理任何数据记录。</div>
<form method="POST" action="{'System/save'|U}">
<table cellpadding=3 cellspacing=3 >
  <tr>
	<td class="tRight">自动仓库编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_warehouse_no" value="1" {if $rs.setauto_warehouse_no==1}checked{/if}>是<input type="radio" name="setauto_warehouse_no" value="2" {if $rs.setauto_warehouse_no==2}checked{/if}>否</td>
	</tr>
	<tr>
	<td class="tRight">
	自动员工编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_employee_no" value="1" {if $rs.setauto_employee_no==1}checked{/if}>是<input type="radio" name="setauto_employee_no" value="2" {if $rs.setauto_employee_no==2}checked{/if} >否</td>
	</tr>
	<tr>
	<td class="tRight">自动买家编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_client_no" value="1" {if $rs.setauto_client_no==1}checked{/if}>是<input type="radio" name="setauto_client_no"  value="2" {if $rs.setauto_client_no==2}checked{/if}>否</td>
	</tr>
	<tr>
	<td class="tRight">自动卖家编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_factory_no" value="1" {if $rs.setauto_factory_no==1}checked{/if}>是<input type="radio" name="setauto_factory_no"  value="2" {if $rs.setauto_factory_no==2}checked{/if}>否</td>
	</tr>
	<tr>
	<tr>
	<td class="tRight">自动物流公司编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_logistics_no" value="1" {if $rs.setauto_logistics_no==1}checked{/if}>是<input type="radio" name="setauto_logistics_no"  value="2" {if $rs.setauto_logistics_no==2}checked{/if}>否</td>
	</tr>
	<td class="tRight">自动快递公司编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_express_no" value="1" {if $rs.setauto_express_no==1}checked{/if}>是<input type="radio" name="setauto_express_no"  value="2" {if $rs.setauto_express_no==2}checked{/if}>否</td>
	</tr>
	<tr>
	<td class="tRight">自动产品属性编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_properties_no" value="1" {if $rs.setauto_properties_no==1}checked{/if}>是<input type="radio" name="setauto_properties_no"  value="2" {if $rs.setauto_properties_no==2}checked{/if}>否</td> 
	</tr>
	<tr>
	<td class="tRight">自动属性值编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_propertiesvalue_no" value="1" {if $rs.setauto_propertiesvalue_no==1}checked{/if}>是<input type="radio" name="setauto_propertiesvalue_no"  value="2" {if $rs.setauto_propertiesvalue_no==2}checked{/if}>否</td>
	</tr>
	<tr>
	<td class="tRight">自动产品编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_product_no" value="1" {if $rs.setauto_product_no==1}checked{/if}>是<input type="radio" name="setauto_product_no"  value="2" {if $rs.setauto_product_no==2}checked{/if}>否</td> 
    </tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="config_type" value="autoNumber">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="footer.tpl"}
