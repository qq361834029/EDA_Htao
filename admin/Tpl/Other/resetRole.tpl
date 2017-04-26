{include file="header.tpl"}
<div class="title"> 初始化系统数据。</div>
<form method="POST" action="{'/Admin/resetRole/update/1'|U}">
<br>
<div class="fLeft bold red">初始化后影响的点：</div><br>
<dl>
<dt>删除所有已存在用户</dt>
	<dd>添加xiamen超级管理员帐号，密码xm10086；</dd>
<dt>删除所有已存在角色</dt>
	<dd>创建管理员角色；</dd>
	<dd>创建厂家角色；</dd>
	<dd>创建客户角色；</dd>
	<dd>创建发票角色；</dd>
<dt>删除所有国家信息</dt>
	<dd>添加默认国家信息；</dd>	
<dt>删除所有币种</dt>
	<dd>导入初始币种；</dd>
<dt>删除所有固定汇率</dt>
	<dd>导入初始固定汇率（汇率抓取日期2012-09-19收盘价）；</dd>	
<dt>删除所有收入，支出类别</dt>
	<dd>添加支出类别“转回国内”；</dd>
<dt>删除所有仓库</dt>
	<dd>添加仓库“默认仓库”；</dd>
</ul>
<input type="submit" value="初始化" class="button"><br><br>
</form>
{include file="footer.tpl"}
