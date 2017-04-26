
/*!
 * jQuery JavaScript Library v 1.0 beta1
 * http://llhdf.javaeye.com
 *
 * Copyright (c) 2009 
 × author: jason he, chang hong wei
 * blog: http://llhdf.javaeye.com
 * Dual licensed under the MIT and GPL licenses.
 *
 * Date: 2009-09-9 17:34:21 -0500 (Thu, 19 Feb 2009)
 */
(function($) {
	
	$.fn.mulitselector = function(options) { 
		
		if ($dom.find("#mulitSelector").length != 0) return;

		var $input    = $(this);
		var $input_id = $input.prev();

		var ms_html;

		var settings  = 
		{
			title:      "请选择类别",
			data:       null,			
			autosearch: null,
			splitchar:  ',',
			callback:   ''
		};

		if (options){
			jQuery.extend(settings, options);
		}

		function initialise(){
			initContent();
			initEvent();	
		}
		//弹出窗按钮事件 1:确定，2:情况，3:添加，4:取消
		function initEvent() {
			//确定
			$dom.find("#ms_bt_ok").click(function() {
				autoButton('ok');
			});
			//清空
			$dom.find("#ms_bt_clear").click(function() {
				ms_html.remove();
				$input.val("");
				$input_id.val("");
			});
			if(settings.autosearch){
				//添加
				$dom.find("#ms_bt_add").click(function() {
					autoButton('add',true);
				});
				//取消
				$dom.find("#ms_bt_cancel").click(function() {
					autoButton('cancel',false);
				});
			}
			//关闭
			$dom.find("#ms_img_close").click(function() {
				ms_html.remove();
			});
		}

		function initContent() {
			//弹出定位
			var box_oft    = $dom.find(".add_box").offset();
			var oft		   = $input.offset();
            var top_delta  = parseInt(oft.top - box_oft.top);   
			var divleft    = parseInt(oft.left);
			var divtop     = top_delta + 40;  
			var divleft    = divleft + 'px';
			var divtop     = divtop + 'px';
 
			var popmask    = document.createElement('div');
			var autosearch = settings.autosearch;
			var html	   = [];	
			html.push('<div id="mulitSelector" style="display:block; top:'+divtop+';left:'+divleft+'; position: absolute;z-index:0;">');
			html.push('<!--[if IE 6]><iframe id="zindexDiv" frameborder="0" src=""></iframe><![endif]-->');
			html.push('    <div id="pslayer"  class="alert_div sech_div ms_width">');
			html.push('        <div class="box">');
			html.push('        <h1><span>'+settings.title+'</span><a href="javascript:void(0);" class="butn3" id="ms_img_close"></a></h1>');
			html.push('		   <div class="blk">');
			html.push('				<div class="sech_layt">');
			html.push('					<h3>');
			html.push('						<span id="selectingHeader">'); 
			html.push('						</span>'); 
			html.push('						<b><input class="button_new" id="ms_bt_ok" name="" type="button" value="'+lang['basic']['btn_confirm']+'" />');
			html.push('						<input class="button_new" id="ms_bt_clear" name="" type="button" value="'+lang['basic']['btn_clear']+'" /></b>');
			html.push('					</h3>');
			html.push('				</div>');
			html.push('				<div class="sech_layb"> ');  
			html.push('					<ol id="allItems1" style="margin-top:10px;line-height:20px;font-size:14px;height:200px;overflow-x:hidden;overflow-y:auto;">');
			if(autosearch != null){
				html.push("<li style='line-height:30px'>");
				html.push(autosearch);
				html.push('					<b><input class="button_new" id="ms_bt_add" name="" type="button" value="'+lang['basic']['btn_add']+'" /><input class="button_new" id="ms_bt_cancel" name="" type="button" value="'+lang['basic']['btn_cancel']+'" /></b>');
				html.push("</li>");
			}
			var dataArray      = settings.data;
			if (dataArray != null){
				var len        = dataArray.length;
				for(var i=0; i<len; i++){
					var d      = dataArray[i];
					var status = findStatus(d.id);
					html.push('						<li id=$'+d.id+' class="nonelay">');
					html.push('							<a href="javascript:void(0);">');
					html.push('							<label for="'+d.id+'">');
					html.push('							<input id="'+d.id+'" type="checkbox" '+status+' value="'+(d.id+ '@'+ d.name)+'"/>&nbsp;'+d.name+'</label>'); 
					html.push('							</a>');
					html.push('						</li>');
				}
			}
			html.push('					</ol>');
			html.push('				</div>');
			html.push('			</div>');
			html.push('		</div>');
			html.push('   </div>');
			html.push('</div>');
		 
			ms_html = $(html.join("")).appendTo($dom.find('.add_box'));

			$(document).ready(function(){
				$dom.find("input[jqac]").each(function(){ $(this).initAutocomplete();});
			})
		}
		//已经选中国家
		function findStatus(d){
			var content = $input_id.val();
			if (jQuery.trim(content) == ""){
				return "";
			}

			var obj		= content.split(",");
			for(var i=0; i<obj.length; i++){
				if(obj[i] == d){
					return "checked";
				}
			}
		}
		
		function autoButton(type,v){
			if(type!='ok'){
				var auto_id = $dom.find('#auto_country_id').val().trim();
				if(auto_id !=''){
					$dom.find('#'+auto_id).attr("checked",v);
				}
			}
			var result      = result_id = "";
			var obj		    = $dom.find("#allItems1 input:checked");
			var splitchar   = settings.splitchar;
			for(var i=0; i<obj.length; i++)
			{
				result      += (i==0?"":splitchar)+obj[i].value.split("@")[1];
				result_id   += (i==0?"":",")+obj[i].value.split("@")[0];
			} 
			$input.val(result);
			$input_id.val(result_id);
			if(type=='ok'){
				ms_html.remove();
				if(settings.callback) settings.callback($input.parents("tr"));
			}else{
				$dom.find('#auto_country').val('');
			}
		}

		initialise();
	}
})(jQuery);