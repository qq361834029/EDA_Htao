{include file="Admin/header.tpl"}
<div class="title"> 自动编号配置，修改后系统可正确运行，无须处理任何数据记录。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
  <tr>
	<td class="tRight">自动仓库编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_warehouse_no" value="1" {if 'setauto_warehouse_no'|C==1}checked{/if}>是<input type="radio" name="setauto_warehouse_no" value="2" {if 'setauto_warehouse_no'|C==2}checked{/if}>否</td>
	</tr><tr>
	<td class="tRight">自动部门编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_department_no" value="1" {if 'setauto_department_no'|C==1}checked{/if}>是<input type="radio" name="setauto_department_no" value="2" {if 'setauto_department_no'|C==2}checked{/if} >否</td> 
	</tr><tr>
	<td class="tRight">自动职务编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_position_no" value="1" {if 'setauto_position_no'|C==1}checked{/if}>是<input type="radio" name="setauto_position_no" value="2" {if 'setauto_position_no'|C==2}checked{/if} >否</td> 
    </tr><tr>
	<td class="tRight">
	自动员工编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_employee_no" value="1" {if 'setauto_employee_no'|C==1}checked{/if}>是<input type="radio" name="setauto_employee_no" value="2" {if 'setauto_employee_no'|C==2}checked{/if} >否</td>
	</tr><tr>
	<td class="tRight">自动物流公司编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_logistics_no" value="1" {if 'setauto_logistics_no'|C==1}checked{/if}>是<input type="radio" name="setauto_logistics_no" value="2" {if 'setauto_logistics_no'|C==2}checked{/if}>否</td> 
	</tr><tr>
	<td class="tRight">自动其他往来单位编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_othercompany_no" value="1" {if 'setauto_othercompany_no'|C==1}checked{/if}>是<input type="radio" name="setauto_othercompany_no" value="2" {if 'setauto_othercompany_no'|C==2}checked{/if}>否</td> 
    </tr>
    </tr><tr>
	<td class="tRight">自动客户编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_client_no" value="1" {if 'setauto_client_no'|C==1}checked{/if}>是<input type="radio" name="setauto_client_no"  value="2" {if 'setauto_client_no'|C==2}checked{/if}>否</td>
	</tr><tr>
	<td class="tRight">自动厂家编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_factory_no" value="1" {if 'setauto_factory_no'|C==1}checked{/if}>是<input type="radio" name="setauto_factory_no"  value="2" {if 'setauto_factory_no'|C==2}checked{/if}>否</td> 
	</tr><tr>
	<td class="tRight">自动类别编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_productclass_no" value="1" {if 'setauto_productclass_no'|C==1}checked{/if}>是<input type="radio" name="setauto_productclass_no"  value="2" {if 'setauto_productclass_no'|C==2}checked{/if}>否</td> 
    </tr><tr>
	<td class="tRight">自动颜色编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_color_no" value="1" {if 'setauto_color_no'|C==1}checked{/if}>是<input type="radio" name="setauto_color_no"  value="2" {if 'setauto_color_no'|C==2}checked{/if}>否</td>
	</tr><tr>
	<td class="tRight">自动尺码编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_size_no" value="1" {if 'setauto_size_no'|C==1}checked{/if}>是<input type="radio" name="setauto_size_no"  value="2" {if 'setauto_size_no'|C==2}checked{/if}>否</td> 
	</tr><tr>
	<td class="tRight">自动产品属性编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_properties_no" value="1" {if 'setauto_properties_no'|C==1}checked{/if}>是<input type="radio" name="setauto_properties_no"  value="2" {if 'setauto_properties_no'|C==2}checked{/if}>否</td> 
    </tr><tr>
	<td class="tRight">自动属性值编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_propertiesvalue_no" value="1" {if 'setauto_propertiesvalue_no'|C==1}checked{/if}>是<input type="radio" name="setauto_propertiesvalue_no"  value="2" {if 'setauto_propertiesvalue_no'|C==2}checked{/if}>否</td>
	</tr><tr>
	<td class="tRight">自动产品编号：</td>
	<td class="tLeft"><input type="radio" name="setauto_product_no" value="1" {if 'setauto_product_no'|C==1}checked{/if}>是<input type="radio" name="setauto_product_no"  value="2" {if 'setauto_product_no'|C==2}checked{/if}>否</td> 
    </tr>
    
     
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="autoNumber">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
