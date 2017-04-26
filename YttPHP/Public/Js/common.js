function success(result,statusText, xhr, $form, module_name){
	if(result.status==1){
//        if(result.data.module_action=='Instock_insert' || result.data.module_action=='Instock_update'){
//            $.ajax({
//                type: "POST",
//                url: APP+"/Ajax/generateBarcode",
//                data:"id="+result.id,
//                async:true,
//                success: function(){}
//            });
//        }
		if(result.data.status==1){
			if(result.out_stock_type){
				//loadTab();
				linkTab(result.data.href,result.data.title,1);
				$("#tips").html(result.info).fadeIn().delay(100).fadeOut(100); 
				if (result.submit_type == 4) {
					switch(result.data.module_name) {
						case 'SaleOrder'://订单出库保存并打印
						case 'ReturnSaleOrder'://退货保存并打印
							if (result.data.printInfo.pdf) {
								window.open(result.data.printInfo.pdf);
							} else {
								if(result.data.$post.is_gls){
									$.printGlsWaybill(result.data.$post.id,result.data.$post.mac_address);
								}else{
									printSaleOrder(result.data.printInfo.info, result.data.printInfo.size.width, result.data.printInfo.size.height, true, result.data.printInfo.size.is_it_nexive);
								}
							}
							break;
						default:
							printBarcode(result.barcode_src, '100mm', '65mm');
							break;
					}
				}
			}else{
				result.data.href += '/s_r/1';
				linkTab(result.data.href,result.data.title,1);	// 保存至列表
			}			
		}else if(result.data.status == 2){
			linkTab(result.data.href,result.data.title,1);
		}else{
			loadTab();
			$("#tips").html(result.info).fadeIn().delay(100).fadeOut(100);            
		}
	}else if(result.status==2){
		validity(result.info,$dom);
    }else if(result.status == 3){
        $.removeLoading();
        $("#dialog_reqeat").dialog("destroy");
        $("<div id='dialog_reqeat'>"+result.info+"</div>").dialog({
            resizable: false,
            modal: true,
            buttons: {
               yes : function() {
                        $(this).dialog("close");
                        $dom.find('#check_repeat').val('1');
                        $dom.find("form").submit();
                },
                no : function() {
                    $(this).dialog("close");
                }
            }
        });
    }else{
		var show_str	= result.info;
		if(show_str==undefined || show_str==''){
			if(result==true){
				show_str = lang['common']['success'];
			}else if(module_name=='TrackOrder'){
				show_str = lang['common']['no_filename'];
			}else{
				show_str = lang['common']['error'];
			}
		}
		var mydate		= new Date();
		var time		= mydate.getTime();
		var dialog_id	= 'dialog_' + time;
		var real_str	= removeHTMLTag(show_str);
		var length		= real_str.length;
		var width		= length <= 120 ? 300 : 600;
		var height		= length <= 120 ? 200 : 400;
		var buttons		= [];
		var copy_button	= result.copy || (result.data && result.data.copy);
		if (copy_button) {
			var copy_id		= 'copy_' + time;
			buttons.push({
				text: "Copy",
				id: copy_id,
				'data-clipboard-target': dialog_id,
			});
		}
		buttons.push({
			text: "Ok",
			click: function() {
			  $( this ).dialog( "close" );
			}
		});
		$('#' + dialog_id).remove();
		var title	= result && result.title ? result.title : (result.data && result.data.title ? result.data.title : '');
		$('<div id="' + dialog_id + '">'+show_str+'</div>').dialog({
			modal: true,
			resizable: false,
			show: "Clip",
			width: width,
			height: height,
			buttons: buttons,
			title: title,
			beforeClose: function(){
				if($dom.find("#flow").length>0){
					switch($dom.find("#flow").val()) {
						case 'saleOrderImport':
						case 'productImport':
						case 'trackOrderImport':
						case 'importTrackNo':
							loadTab();
							break;
						case 'instockImport':
						case 'pickingImport':
							$dom.find('#file_upload').val('');
							$dom.find('#upload_response').html('');							
							break;
					}
				}	
			}
		});
		if (copy_button) {
			//复制
			var moviePath	= PUBLIC + "/Js/ZeroClipboard/ZeroClipboard.swf";
			var clip_object = new ZeroClipboard($('#' + copy_id), {
				moviePath: moviePath
			} );
			clip_object.on( 'complete', function(client, args) {
				var zIndex	= $.cParseInt($("#tips").css('z-index'));
				if (zIndex < 99999) {
					zIndex	= 99999;
				}
				$("#tips").css('z-index', zIndex).html(lang['common']['copied_successfully']).fadeIn().delay(500).fadeOut(500);
			});
		}
		$.removeLoading();
	}
}

function removeHTMLTag(html) {
	html	= html.replace(/<\/?[^>]*>/g,''); //去除HTML tag
	html	= html.replace(/[ | ]*\n/g,'\n'); //去除行尾空白
	html	= html.replace(/ /ig,'');//去掉
	return html;
}

//错误提示弹窗
function noticeInfo(info){
	$("<div>"+info+"</div>").dialog({
		modal: true,
		resizable: false,
		show: "Clip",
		buttons: {
			Ok: function() {
				$(this).remove();
			}
		}
	});
	$.removeLoading();
}

function searchSuccess(){
    $dom.children('#think_page_trace').remove();//移除多余page_trace added by jp 20131203
	$.removeLoading();
	$("#s_success").html(lang['common']['search_success']).fadeIn(400).delay(100).slideUp(400);
}

function log(msg){
    window.console.log(msg);
}

function validity(result,obj,appendto,topoft,leftoft){
	if(appendto){
		var show_obj = obj.find(appendto);
	}else{
		var show_obj = obj.find(".add_box").length>0 ? obj.find(".add_box") : obj.find(".search_box");
	}
	if(obj.find("#form_error_msg").length<=0) $("<div id='form_error_msg'></div>").appendTo(show_obj);
	obj.find("#form_error_msg").html('').show();
	execValidity(result,obj,show_obj,topoft,leftoft);
	obj.find("#form_error_msg").delay(3000).fadeOut();
	$.removeLoading();
}

function createFormErrorMsg(element,appendto){
	element.find("#form_error_msg").html('');
	if(appendto){
		var show_obj = element.find(appendto);
	}else{
		var show_obj = element.find(".add_box");
	}
	if(element.find("#form_error_msg").length<=0) $("<div id='form_error_msg'></div>").appendTo(show_obj);
	element.find("#form_error_msg").show();
}

function execValidity(result,obj,show_obj,topoft,leftoft){
	if(!topoft) topoft = 20;
	if(!leftoft) leftoft = 0;
    var offset  = 9999999;
    var el_position = 0;
	$(result).each(function(){
		var info = this;
		var comma_position = info.name.indexOf(',');
		if (comma_position > 0) {//同时验证多个字段时，只在第一个弹出提醒
			info.name	= info.name.substr(0,comma_position);
		}
		if ($.trim(info.name) == "") {
			return true;
		}
		var attr_filter	= '[name="' + info.name + '"]';
		obj.find("input" + attr_filter + ",select" + attr_filter + ",textarea" + attr_filter).each(function(){
			if($(this).attr("type")=="hidden" || $(this).css("display")=="none"){
				var element = $(this).next();
			}else{
				var element = $(this);
			}
			if(element.length==0) return true;
            var box_oft = show_obj.offset();
			var oft = element.offset();
            var top_delta = parseInt(oft.top - box_oft.top);   
			var left = parseInt(oft.left)-leftoft;
			var top = top_delta - topoft; 
            //added yyh 20150930
            offset  = $(this).position().top > offset ? offset : $(this).position().top;
            $("<div></div>").addClass("validity-tooltip")
			.html(info.value).css({ "top":top+"px","left":left+"px"})
			.bind("click",function(){$(this).remove()})
			.append($('<div class="validity-tooltip-outer"></div>'))
			.appendTo(obj.find("#form_error_msg"));
		})
	})
    $dom.scrollTop(offset-100);
}

function showMessage(msg,id){
	$("#"+id).html(msg).fadeIn().delay(3000).fadeOut(400);
}

function checkEpass(url){
	var bool = true;
	try{
		var ePass_rights;
		ePass_rights = new ActiveXObject("FT_ND_SC.ePsM8SC.1");
		ePass_rights.OpenDevice(1,"");
		ePass_rights.OpenFile(0,3);
		var fileLen 	= ePass_rights.GetFileInfo(0,3,3,0);
		var epass_data = ePass_rights.Read(0,0,0,fileLen);
		var epass_sn = ePass_rights.GetStrProperty(7,0,0);
		if(url){
			$.ajax({
				type: "POST",
				url: url,
				dataType: "json",
				data:"epass_no="+epass_sn+"&epass_data="+epass_data,
				cache: false,
				success: function(result){
					if(result.status==0){
						$("<div>"+result.info+"</div>").dialog({
							modal: true,
							resizable: false,
							buttons: {
								Ok: function() {
									$( this ).remove();
								}
							}
						});
						bool = false;
					}
				}
			});
		}
	}catch(error){
		$("<div>未检查到UsbKey信息，请确认UsbKey已正确连接！</div>").dialog({
			modal: true,
			resizable: false,
			buttons: {
				Ok: function() {
					$( this ).remove();
				}
			}
		});
		bool = false;
	}
	return bool;
}
//跳转到某一个页码
function goPage(){ 
	var v	=	$dom.find("#page_no").val(); 
	if(v>0){ 
		$dom.find("#nextPage").val(v);
		$dom.find("#ac_search").trigger("click")//就是执行#a的click事件
 
	}
	
}
//上下页面
function nextPage(v){ 
	if(v>0){
		$dom.find("#nextPage").val(v);
		$dom.find("#ac_search").trigger("click")//就是执行#a的click事件 
	}
}
// 定义一个空函数，统计的表单验证时使用。
function empty(){
	$.removeLoading();
}

