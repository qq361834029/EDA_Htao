<div class="main" >
<div class="content">
<TABLE id="checkList" class="list" cellpadding=0 cellspacing=0 >
<tr><td height="5" colspan="5" class="topTd" ></td></tr>
<TR class="row" ><th colspan="3" class="space">系统信息</th></tr>
{foreach item="v" key=key from=$info}
<TR class="row" ><TD width="15%">{$key}</TD><TD>{$v}</TD></TR>
{/foreach}
<tr><td height="5" colspan="5" class="bottomTd"></td></tr>
</TABLE>
</div>
</div>
