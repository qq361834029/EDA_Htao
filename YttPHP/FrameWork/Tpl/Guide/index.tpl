<link type="text/css" rel="stylesheet" href="__PUBLIC__/Css/guidestyle_cn.css">
<style type="text/css">
.hide{ display:none; }
.show{ display:block; }
</style>
<script type="text/javascript">
function show(v){
	document.getElementById('content_1').className = 'hide';
	document.getElementById('content_2').className = 'hide';
	document.getElementById('content_3').className = 'hide';
	document.getElementById('content_4').className = 'hide';
	document.getElementById('content_'+v).className = 'show';
}
function setGuide(obj){
	if(obj.checked==true){
		var guide = 2;
	}else{
		var guide = 1;
	}
	$.post('{"Ajax/setGuide"|U}',{ guide:guide },function(){
		alert('操作成功，下次登陆生效')
	})
}
</script>
<div class="guide">
	<div class="guideWindow">
	<div class="Head">
		<div class="hTitle">{$lang.guide_initial_wizard}</div>
		<div class="hClose"></div>
	</div>
	<div class="popBody">
	<div class="buttonbox">
		<ul>
  			<li>
  				<a href="javascript:;" class="button_out" onmouseover="this.className='button_over'" onmouseout="this.className='button_out'" onclick="show(1)" onfocus=this.blur()><font class="figure">1</font>{$lang.guide_system_set}</a>
  			</li>
  			<li class="buttonbox_arrow"></li>
    		<li>
    			<a href="javascript:;" class="button_out" onmouseover="this.className='button_over'" onmouseout="this.className='button_out'" onclick="show(2)" onfocus=this.blur()><font class="figure">2</font>{$lang.guide_permissions_configuration}</a>
    		</li>
  			<li class="buttonbox_arrow"></li>
     		<li>
     			<a href="javascript:;" class="button_out" onmouseover="this.className='button_over'" onmouseout="this.className='button_out'" onclick="show(3)" onfocus=this.blur()><font class="figure">3</font>{$lang.basic_info}</a>
     		</li>
  			<li class="buttonbox_arrow"></li>
     		<li>
     			<a href="javascript:;" class="button_out" onmouseover="this.className='button_over'" onmouseout="this.className='button_out'" onclick="show(4)" onfocus=this.blur()><font class="figure">4</font>{$lang.guide_ini_date}</a>
     		</li>
		</ul>
	</div>
	<div class="clear_both"></div>
	<div id="content_1" class="show">{include file="Guide/system.tpl"}</div>
	<div id="content_2" class="none">{include file="Guide/collocate.tpl"}</div>
	<div id="content_4" class="none">{include file="Guide/initialdata.tpl"}</div>
	<div id="content_3" class="none">{include file="Guide/basic.tpl"}</div>
	</div>
	<div class="Foot">
	<span>
		<input  type="checkbox" onclick="setGuide(this)" {if $guide==2}checked{/if}></span><span class="pad_left_3">{$lang.guide_title_2}
	</span>
</div>
</div>
