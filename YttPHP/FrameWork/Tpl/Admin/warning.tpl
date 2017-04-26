{include file="Admin/header.tpl"}
<div class="title"> 信息提醒配置，修改后系统可正确运行，无须处理任何数据记录。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
    <tr>
		<td class="tRight">今日统计：</td>
		<td class="tLeft"><input type="radio" name="remind_today_stat" id="" value="1" {if 'remind_today_stat'|C==1}checked{/if}>是<input type="radio" name="remind_today_stat" id="" value="0" {if 'remind_today_stat'|C==0}checked{/if}>否</td>
	</tr><tr>
		<td class="tRight">订货提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_order" id="" value="1" {if 'remind_order'|C==1}checked{/if}>是<input type="radio" name="remind_order" id="" value="0" {if 'remind_order'|C==0}checked{/if}>否</td> 
		</tr><tr>
		<td class="tRight">入库提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_instock" id="" value="1" {if 'remind_instock'|C==1}checked{/if}>是<input type="radio" name="remind_instock" id="" value="0" {if 'remind_instock'|C==0}checked{/if}>否</td> 
    </tr><tr>
		<td class="tRight">待配货提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_predelivery" id="" value="1" {if 'remind_predelivery'|C==1}checked{/if}>是<input type="radio" name="remind_predelivery" id="" value="0" {if 'remind_predelivery'|C==0}checked{/if}>否</td>
		</tr><tr>
		<td class="tRight">待发货提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_delivery" id="" value="1" {if 'remind_delivery'|C==1}checked{/if}>是<input type="radio" name="remind_delivery" id="" value="0" {if 'remind_delivery'|C==0}checked{/if}>否</td> 
		</tr><tr>
		<td class="tRight">客户待收款提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_client" id="" value="1" {if 'remind_client'|C==1}checked{/if}>是<input type="radio" name="remind_client" id="" value="0" {if 'remind_client'|C==0}checked{/if}>否</td> 
    </tr><tr>
		<td class="tRight">厂家待付款提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_factory" id="" value="1" {if 'remind_factory'|C==1}checked{/if}>是<input type="radio" name="remind_factory" id="" value="0" {if 'remind_factory'|C==0}checked{/if}>否</td> 
		</tr>
		<!--<tr>
		<td class="tRight">票据到期提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_invoice" id="" value="1" {if 'remind_invoice'|C==1}checked{/if}>是<input type="radio" name="remind_invoice" id="" value="0" {if 'remind_invoice'|C==0}checked{/if}>否</td> 
		</tr><tr>
		<td class="tRight">待审核提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_audit" id="" value="1" {if 'remind_audit'|C==1}checked{/if}>是<input type="radio" name="remind_audit" id="" value="0" {if 'remind_audit'|C==0}checked{/if}>否</td> 
    </tr>-->
    <tr>
		<td class="tRight">物流待付款提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_logistics" id="" value="1" {if 'remind_logistics'|C==1}checked{/if} >是<input type="radio" name="remind_logistics" id="" value="0" {if 'remind_logistics'|C==0}checked{/if}>否</td> 
    </tr> 
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="warning">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
