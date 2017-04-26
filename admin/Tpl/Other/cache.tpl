{include file="header.tpl"}
<div class="title"> 缓存管理</div>
<table id="index" class="list" border=1>
	<thead>
		<tr>
			<th width="15%">缓存名称</th>
			<th width="15%">缓存类型</th>
			<th width="50%">缓存说明</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>配置缓存</td>
			<td>文件缓存</td>
			<td>后台超级管理员配置、前台系统配置缓存</td>
			<td><a href="__URL__/updateCache/type/config">更新</a></td>
		</tr>
		<tr>
			<td>字典缓存</td>
			<td>内存缓存</td>
			<td>如产品，买家，卖家等数据表缓存</td>
			<td><a href="__URL__/updateCache/type/dd">更新</a></td>
		</tr>
		<tr>
			<td>部署模式缓存</td>
			<td>文件缓存</td>
			<td>核心函数、数据库字段缓存文件</td>
			<td><a href="__URL__/updateCache/type/runtime">更新</a></td>
		</tr>
		<tr>
			<td>语言包缓存</td>
			<td>文件缓存</td>
			<td>中文，德文语言包缓存</td>
			<td><a href="__URL__/updateCache/type/lang">更新</a></td>
		</tr>
		<tr>
			<td>导入模板</td>
			<td>文件缓存</td>
			<td>更新导入模板文件缓存</td>
			<td><a href="__URL__/updateCache/type/excel">更新</a></td>
		</tr>
		<tr>
			<td>菜单缓存</td>
			<td>文件缓存</td>
			<td>更新菜单缓存</td>
			<td><a href="__URL__/updateCache/type/menu">更新</a></td>
		</tr>
		<tr>
			<td>EBAY缓存</td>
			<td>内存缓存</td>
			<td>EBAY基本信息缓存</td>
			<td><a href="__URL__/updateCache/type/ebay">更新</a></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><a href="__URL__/updateCache/">更新全部</a></td>
		</tr>
	</tbody>
</table>
{include file="footer.tpl"}