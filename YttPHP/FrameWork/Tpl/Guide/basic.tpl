<div class="basic_explain">{$lang.guide_title_5}</div>
<div class="basic_content">

<!--公司信息开始-->	
{if $rights.basic.add || $rights.warehouse.add || $rights.district.add || $rights.department.add || $rights.position.add || $rights.employee.add || $admin_auth_key}
<div class="basic_title">{$lang.guide_company_info}</div>
<div class="imagebox">
    <div class="tb">
        <div class="r1" style="border-bottom:1px #CECECE solid;"></div>
        <div class="r2"></div>
        <div class="r3"></div>
    </div>
<div class="imagescontent" >
<div class="company_icon">
<ul>
{if $rights.basic.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Basic/add"|U}','{"guide_add_basic"|L}',1); "><img src="__PUBLIC__/Images/Guide/company.gif" width="32" height="32" /><br />{$lang.guide_add_basic}</a></li>
{/if}
{if $rights.warehouse.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Warehouse/add"|U}','{"guide_add_warehouse"|L}',1); "><img src="__PUBLIC__/Images/Guide/storage.gif" width="32" height="32" /><br />{$lang.guide_add_warehouse}</a></li>
{/if}
{if $rights.district.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"District/add"|U}','{"guide_add_city"|L}',1); "><img src="__PUBLIC__/Images/Guide/country.gif" width="32" height="32" /><br />{$lang.guide_add_city}</a></li>
{/if}
{if $rights.department.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Department/add"|U}','{"guide_add_department"|L}',1); "><img src="__PUBLIC__/Images/Guide/department.gif" width="32" height="32" /><br />{$lang.guide_add_department}</a></li>
{/if}
{if $rights.position.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Position/add"|U}','{"guide_add_position"|L}',1); "><img src="__PUBLIC__/Images/Guide/post.gif" width="32" height="32" /><br />{$lang.guide_add_position}</a></li>
{/if}
{if $rights.employee.add || $admin_auth_key}
<li><a href="javascript:;"} onclick="addTab('{"Employee/add"|U}','{"guide_add_employee"|L}',1); "><img src="__PUBLIC__/Images/Guide/staff.gif" width="32" height="32" /><br />{$lang.guide_add_employee}</a></li>
{/if} 
</ul>
</div>
</div>
<div class="tb">
        <div class="r3"></div>
        <div class="r2"></div>
        <div class="r1" style="border-top:1px #CECECE solid;"></div>
    </div>
</div>
{/if} 
<!--公司信息结束-->	
<div class="clear_both"></div>


<!--产品信息开始-->	
{if $rights.productclass.add || $rights.color.add || $rights.size.add || $rights.properties.add || $rights.propertiesvalue.add || $rights.product.add || $admin_auth_key}
<div class="basic_title">{$lang.product_info}</div>
<div class="imagebox">
    <div class="tb">
        <div class="r1" style="border-bottom:1px #CECECE solid;"></div>
        <div class="r2"></div>
        <div class="r3"></div>
    </div>
<div class="imagescontent">
<div class="product_icon">
<ul> 
{if $rights.productclass.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"ProductClass/add"|U}','{"guide_add_class"|L}',1); "><img src="__PUBLIC__/Images/Guide/category.gif" width="32" height="32" /><br>{$lang.guide_add_class}</a></li>
{/if}
{if $rights.color.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Color/add"|U}','{"guide_add_color"|L}',1); "><img src="__PUBLIC__/Images/Guide/color.gif" width="32" height="32" /><br>{$lang.guide_add_color}</a></li>
{/if}
{if $rights.size.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Size/add"|U}','{"guide_add_size"|L}',1); "><img src="__PUBLIC__/Images/Guide/size.gif" width="32" height="32" /><br>{$lang.guide_add_size}</a></li>
{/if}
{if $rights.properties.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Properties/add"|U}','{"guide_add_product_att"|L}',1); "><img src="__PUBLIC__/Images/Guide/productquality.gif" width="32" height="32" /><br>{$lang.guide_add_product_att}</a></li>
{/if}
{if $rights.propertiesvalue.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"PropertiesValue/add"|U}','{"guide_add_product_att_value"|L}',1); "><img src="__PUBLIC__/Images/Guide/productquality01.gif" width="32" height="32"/><br>{$lang.guide_add_product_att_value}</a></li>
{/if}
{if $rights.product.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Product/add"|U}','{"guide_add_product"|L}',1); "><img src="__PUBLIC__/Images/Guide/newproduct.gif" width="32" height="32" /><br>{$lang.guide_add_product}</a></li>
{/if}
</ul>
</div>
</div>
<div class="tb">
        <div class="r3"></div>
        <div class="r2"></div>
        <div class="r1" style="border-top:1px #CECECE solid;"></div>
    </div>
</div>
{/if}
<!--产品信息结束-->	
<div class="clear_both"></div>


<!--往来单位开始-->
{if $rights.factory.add || $rights.client.add || $rights.logistics.add || $rights.othercompany.add || $admin_auth_key}	
<div class="basic_title">{$lang.guide_exchanges_unit}</div>
<div class="imagebox">
    <div class="tb">
        <div class="r1" style="border-bottom:1px #CECECE solid;"></div>
        <div class="r2"></div>
        <div class="r3"></div>
    </div>
<div class="imagescontent">
<div class="btype_icon">
<ul> 
{if $rights.factory.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Factory/add"|U}','{"guide_add_factory"|L}',1); "><img src="__PUBLIC__/Images/Guide/vender.gif" width="32" height="32" /><br>{$lang.guide_add_factory}</a></li>
{/if}
{if $rights.client.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Client/add"|U}','{"guide_add_client"|L}',1); "><img src="__PUBLIC__/Images/Guide/client.gif" width="32" height="32" /><br>{$lang.guide_add_client}</a></li>
{/if}
{if $rights.logistics.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"Logistics/add"|U}','{"guide_add_logs"|L}',1); "><img src="__PUBLIC__/Images/Guide/apllogistics.gif" width="32" height="32" /><br>{$lang.guide_add_logs}</a></li>
{/if}
{if $rights.othercompany.add || $admin_auth_key}
<li><a href="javascript:;" onclick="addTab('{"OtherCompany/add"|U}','{"guide_add_exchanges_unit"|L}',1); "><img src="__PUBLIC__/Images/Guide/btype.gif" width="32" height="32" /><br>{$lang.guide_add_exchanges_unit}</a></li>
{/if} 
</ul>
</div>
</div>
<div class="tb">
        <div class="r3"></div>
        <div class="r2"></div>
        <div class="r1" style="border-top:1px #CECECE solid;"></div>
    </div>
</div>
{/if} 
<!--往来单位结束-->	
<div class="clear_both"></div>
{if $rights.bank.add || $rights.payclass.add}	
<!--财务信息开始-->	
<div class="basic_title">{$lang.guide_funds_info}</div>
<div class="imagebox">
    <div class="tb">
        <div class="r1" style="border-bottom:1px #CECECE solid;"></div>
        <div class="r2"></div>
        <div class="r3"></div>
    </div>
<div class="imagescontent">
<div class="product_icon">
<ul> 
{if $rights.bank.add}
<li><a href="javascript:;" onclick="addTab('{"Bank/add"|U}','{"guide_add_bank_no"|L}',1); "><img src="__PUBLIC__/Images/Guide/bankcard.gif" width="32" height="32" /><br>{$lang.guide_add_bank_no}</a></li>
{/if}
{if $rights.payclass.add} 
<li><a href="javascript:;" onclick="addTab('{"PayClass/add"|U}','{"guide_add_other"|L}',1); "><img src="__PUBLIC__/Images/Guide/incomepay.gif" width="32" height="32"/><br>{$lang.guide_add_other}</a></li>
{/if} 
</ul>
</div>
</div>
<div class="tb">
        <div class="r3"></div>
        <div class="r2"></div>
        <div class="r1" style="border-top:1px #CECECE solid;"></div>
    </div>
</div>
{/if} 

