var tptimeout;
;(function($) {
	$.initToolBar = function(){
		//Adjust panel height
		$.fn.adjustPanel = function(){ 
			$(this).find("ul, .subpanel").css({ 'height' : 'auto'});
			var windowHeight = $(window).height(); 
			var panelsub = $(this).find(".subpanel").height(); 
			var panelAdjust = windowHeight - 100; 
			var ulAdjust =  panelAdjust - 25; 
			if ( panelsub >= panelAdjust ) {	
				$(this).find(".subpanel").css({ 'height' : panelAdjust }); 
				$(this).find("ul").css({ 'height' : ulAdjust}); 
			}
			else if ( panelsub < panelAdjust ) { 
				$(this).find("ul").css({ 'height' : 'auto'}); 
			}
		};
		
		$("#toolbar_lang,#toolbar_help,#toolbar_remind").adjustPanel(); 
		$(window).resize(function () { 
			$("#toolbar_lang,#toolbar_help,#toolbar_remind").adjustPanel();
		});
		
		$("#toolbar_lang a:first,#toolbar_help a:first,#toolbar_remind a:first").click(function() {
			if($(this).next(".subpanel").is(':visible')){ 
				$(this).next(".subpanel").hide();
				$("#footpanel li a").removeClass('active'); 
			}
			else { 
				$(".subpanel").hide(); 
				$(this).next(".subpanel").toggle();
				$("#footpanel li a").removeClass('active'); 
				$(this).toggleClass('active'); 
			}
			$(".statisticsWindow").hide();
			return false; 
		});
		
		$(document).click(function() { 
			$(".subpanel").hide();
			$(".statisticsWindow").hide();
			$("#footpanel li a").removeClass('active'); 
		});
		$('.subpanel ul,.statisticsWindow,.toolbar_product').click(function(e) { 
			e.stopPropagation();
		});
		$('.subpanel ul li').bind('click', function() {
		  $.closeAllToolbar();
		});
		$("#toolbar_stat").click(function(){
			$(".statisticsWindow").toggle();
			var url = $(this).attr("url");
			$("#toolbarTodayRemind").load(url,function(){
				$(".popHead").click(function(){
					$('.statisticsWindow').hide();
				})
			})
			$(".subpanel").hide();
			return false;
		});
		$("#shToolbar").click(function(){
			$(".user,.today,.menu_nav").toggle();
			if($(".user").css("display")=="none"){
				$(this).removeClass("fl arrow_icon arrow_right");
				$(this).addClass("fl arrow_icon arrow_left");
				if($('#footpanel').attr('invoice')==1){
					$("#footpanel").css("width",'40px');
				}else{
					$("#footpanel").css("width",'192px');
				}
			}else{
				$(this).removeClass("fl arrow_icon arrow_left");
				$(this).addClass("fl arrow_icon arrow_right");
				if($('#footpanel').attr('invoice')==1){
					$("#footpanel").css("width",'450px');
				}else if($("#toolbar_remind").length>0){
					$("#footpanel").css("width",'703px');
				}else{
					$("#footpanel").css("width",'640px');
				}
				
			}
		});
	},
	$.closeAllToolbar = function(){
		$(".subpanel").hide();
		$(".statisticsWindow").hide();
	},
	$.showToolsBarProduct = function(obj){
		if(obj.value == ""){
			$("#toolbarProduct").hide();
			return;
		}
		clearTimeout(tptimeout);
		tptimeout = setTimeout(function(){
			$("#toolbarProduct").load(APP + "/Ajax/toolBarProduct",{'no': obj.value, 'is_id': $(obj).attr('is_id')},function(){
				$(obj).attr('is_id', 0);
				var product_id	= $("#toolbar_pid").val();
				var url			= product_id > 0 ? "/StatProduct/view/product_id/"+product_id : "/StatProduct/index";
				$("#toolbar_product_search").attr("url", APP + url);
			}).show();
		}, 100);
	},
	$.setToolsBarProduct = function(no, is_id){
		$("#toolbar_product_input").attr('is_id', is_id).val(no).keyup();
	},
	$.getRemindMenu = function(url){
		$.ajax({ url: url, ifModified:true,success: function(cssname){
			if(cssname==0){
				$("#toolbar_remind").remove();
				$("#footpanel").css("width","640px");
				$(".menu_nav").css("width","302px");
			}else{
				$("#toolbar_remind").find("a:first").removeAttr('class').addClass(cssname);
			}
		}});
	},
	$.getProductInfo = function(title,obj){
		var url = $(obj).attr("url");
		if(!url) return;
		addTab(url,lang['basic']['stat_product_info']);
	}
})(jQuery);

$.fn.remind = function(){
	var obj = $(this);
	var first_obj	= obj.find("a:first");
	$.getRemindMenu(first_obj.attr("stateurl"));
	if($("#toolbar_remind").length<=0){return false;}
	first_obj.click(function(){
		if (first_obj.hasClass('active') !== true) {
			obj.find("ul").load($(this).attr("url"));
		}
	})
	setInterval(function(){
		$.getRemindMenu(first_obj.attr("stateurl"));
	},60000*10);
    var url = APP + "/Message/index/is_read/2";
    var title = lang['common']['message_list'];
    $.getJSON(APP+'/Ajax/remindMessage',{},function(data){
        if(data>0){
            var buttons = [{
                text: lang['common']['show'],
                click: function() {
                        $(this).remove();
                        $.ajax({
                            type: "POST",
                            url: url,
                            dataType: "json",
                            data: "accessCheck=1&referer=js",
                            cache: false,
                            success: function(result) {
                                if (result.status == 1) {
                                    linkTab(url, title, 1);
                                } else {
                                    success(result);
                                }
                            }
                        });
                    }
            }];
            buttons.unshift({
                text: lang['common']['ignore'],
                click: function() {
                    $(this).remove();
                }
            });
            
            $("<div>"+lang['common']['new_message'] +"</div>").dialog({
                modal: true,
                resizable: false,
                show: "Clip",
                buttons: buttons
            });
        }
    });
    $(this).find("input[jqac]").each(function() {
        $(this).initAutocomplete();
    });
};