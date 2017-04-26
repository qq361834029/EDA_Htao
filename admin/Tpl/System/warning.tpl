{include file="header.tpl"}
<div class="title"> 信息提醒配置，修改后系统可正确运行，无须处理任何数据记录。</div>
<form method="POST" action="{'System/save'|U}">
<table cellpadding=3 cellspacing=3 >
    <tr>
		<td class="tRight">今日统计：</td>
		<td class="tLeft"><input type="radio" name="remind_today_stat" id="" value="1" {if $rs.remind_today_stat==1}checked{/if}>是<input type="radio" name="remind_today_stat" id="" value="0" {if $rs.remind_today_stat==0}checked{/if}>否</td>
	</tr><tr>
		<td class="tRight">订货提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_order" id="" value="1" {if $rs.remind_order==1}checked{/if}>是<input type="radio" name="remind_order" id="" value="0" {if $rs.remind_order==0}checked{/if}>否</td> 
		</tr><tr>
		<td class="tRight">入库提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_instock" id="" value="1" {if $rs.remind_instock==1}checked{/if}>是<input type="radio" name="remind_instock" id="" value="0" {if $rs.remind_instock==0}checked{/if}>否</td> 
    </tr><tr>
		<td class="tRight">待发货提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_delivery" id="" value="1" {if $rs.remind_delivery==1}checked{/if}>是<input type="radio" name="remind_delivery" id="" value="0" {if $rs.remind_delivery==0}checked{/if}>否</td> 
		</tr><tr>
		<td class="tRight">客户待收款提醒：</td>
		<td class="tLeft"><input type="radio" name="remind_client" id="" value="1" {if $rs.remind_client==1}checked{/if}>是<input type="radio" name="remind_client" id="" value="0" {if $rs.remind_client==0}checked{/if}>否</td> 
    </tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="config_type" value="warning">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="footer.tpl"}
