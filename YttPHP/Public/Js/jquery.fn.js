/* 各个流程使用 */
(function($) {
    // 产品绑定厂家时选择厂家后更新产品autocomplete
    $.productEnabled = function(obj) {
        var factory_id = $.cParseInt(obj.value);
		var product_no = $(obj.form).find("input[name*='[product_no]']");
        product_no.val('').prev().val('');
        var where = "factory_id=" + factory_id;
        product_no.removeAttr("disabled").removeClass("disabled").attr({"where": where, "jqac": true})
                .each(function() {
            $(this).initAutocomplete();
        });
    }
    $.productEnabledForLc = function(obj) {
        var factory_id = $.cParseInt(obj.value);
        var where = "factory_id=" + factory_id;
        $(obj).parents("tr:first").find("input[name*='product_no]']").removeAttr("disabled").removeClass("disabled").attr({"where": where, "jqac": true}).initAutocomplete();
    }
    // 产品绑定颜色时选择产品后更新颜色autocomplete
    $.colorEnabled = function(obj) {
        var product_id = $.cParseInt(obj.value);
		var color_name = $(obj).parents("tr:first").find("input[name='color_name']");
        color_name.val('').prev().val('');
        if (product_id > 0) {
            $.ajax({
                type: "POST",
                url: APP + "/Ajax/getProductColorId",
                data: "id=" + product_id,
                dataType: "text",
                cache: false,
                success: function(result) {
                    var where = "id in(" + result + ")";
					//window.console.log(ids);
					color_name.removeAttr("disabled").removeClass("disabled").attr({"where": where, "jqac": true}).each(function() {
						$(this).initAutocomplete();
					})
                }
            });
        }
    }

    // 产品绑定尺码时选择产品后更新尺码autocomplete
    $.sizeEnabled = function(obj) {
        var product_id = $.cParseInt(obj.value);
		var size_name  = $(obj).parents("tr:first").find("input[name='size_name']");
        size_name.val('').prev().val('');
        if (product_id > 0) {
            $.ajax({
                type: "POST",
                url: APP + "/Ajax/getProductSizeId",
                data: "id=" + product_id,
                dataType: "text",
                cache: false,
                success: function(result) {
					var where = "id in(" + result + ")";
					size_name.removeAttr("disabled").removeClass("disabled").attr({"where": where, "jqac": true}).each(function() {
						$(this).initAutocomplete();
					})
                }
            });
        }
    }
    // 添加快捷菜单
    $.shortcutMenu = function(obj, m, a) {
        var url = $(obj).attr("url");
        $.post(url, {model: m, action: a}, function(state) {
            if (state > 0) {
                $.resetShortcutMenu();
            }
        });
    }
    // 重载快捷菜单
    $.resetShortcutMenu = function() {
        var w = $(window).width();
        if (w < 1280) {
            var i = 2;
        } else if (w < 1366) {
            var i = 4;
        } else {
            var i = 5;
        }
        $("#shortcutMenu").load(APP + '/Ajax/loadShortcutMenu/mt/' + i, function() {
            $("#sdfjasdlfasdf").mouseover(function() {
                $('#shortMenuHide').fadeIn(200)
            });
            $("#shortMenuHide").mouseout(function() {
                $('#shortMenuHide').hide()
            });
            $("#shortMenuHide ul li").mouseover(function() {
                $('#shortMenuHide').show()
            });
        })
    }
	$.btnClose = function(obj) {
		$("#s_loading").html('<a href="javascript:" onclick="$.removeLoading();" id="btnClose"><img src="'+PUBLIC+'/Images/Default/lightbox-btn-close.gif" alert="关闭"></a>');
		};
     // 显示进度条
    $.loading = function() {
		$dom.find(".button_place").hide();
		$("#s_loading").show();
		$("#s_loading").html('拼命提交中!');
		clearTimeout(removeLoadTime);
		var removeLoadTime = setTimeout($.btnClose,8000);
	};
    $.removeLoading = function() {
		$('#loader').css("display","none");
        $("#s_loading").hide();
		$dom.find(".button_place").show();
    }
    $.quicklyAdd = function(module, type) {
        var async   = $.ajaxSettings.async;
        $.ajaxSettings.async = true;//禁用异步
		var load_url = '/QuicklyOperate/' + module;
                if (type != '' && typeof(type) != 'undefined') {
                    load_url += +'/type/' + type;
                }
                switch(module) {
                    case 'District':
			var country_id = $dom.find("#country_id").val();
			if(country_id>0){
				load_url += +'/id/' + country_id;
			}
                        break;
                    case 'Client':
			var factory_id = $dom.find("#factory_id").val();
			if(factory_id>0){
				load_url += '/factory_id/' + factory_id;
			}
                        break;
                }
        $("#dialog-quickly_add").remove();
        $('<div id="dialog-quickly_add"></div>').load(APP + load_url, function() {
            var quick_dom = $(this);
            $(this).find("form").sendForm({"dataType": "json", "success": function(result, statusText, xhr, $form) {
                    if (result.status == 1) {
                        quicklyAddCallback(module, result);
                        $("#dialog-quickly_add").dialog("destroy");
                    } else if (result.status == 2) {
                        var oft = $("#dialog-quickly_add").offset();
                        validity(result.info, quick_dom, '.table_autoshow', 0, oft.left);
                    } else {
                        $("<div>" + result.info + "</div>").dialog({
                            modal: true,
                            resizable: false,
                            buttons: {
                                Ok: function() {
                                    $(this).remove();
                                }
                            }
                        });
                    }
					$.removeLoading();
                }});
            $(this).find("input[jqac]").each(function() {
                $(this).initAutocomplete();
            });
            $(this).find("select[combobox]").each(function() {
                $(this).combobox();
            });
        }).dialog({
            autoOpen: true,
            resizable: false,
            draggable: false,
            height: 450,
            width: 680,
            modal: true,
            buttons: [
                {
                    text: lang['common']['submit'],
                    click: function() {
                        $(this).find("form").submit();
//					$(this).dialog("close");
                    }
                },
                {
                    text: lang['common']['close'],
                    click: function() {
                        $("#dialog-quickly_add").remove();
                    }
                }
            ]
        });
        $.ajaxSettings.async = async;//禁用异步
    }

    //显示销售单状态信息
    $.quicklyShowSaleType = function(obj) {
        var sale_order_id = $(obj).parent().find("#sale_order_id").val();
        if (sale_order_id > 0) {
            $("<div id='dialog-sale_state'></div>").remove();
            $("<div id='dialog-sale_state'></div>").load(APP + '/SaleOrder/quicklyShowSaleType/id/' + sale_order_id).dialog({
                autoOpen: true,
                resizable: false,
                height: 600,
                width: 720,
                modal: true
            });
        }

    }

    $.quicklyMore = function(obj) {
        var table_obj = $(obj).parents("table:first").next();
        if (table_obj.css("display") == "none") {
            $(obj).html(lang['common']['close']);
            table_obj.show();
        } else {
            $(obj).html(lang['common']['add_open']);
            table_obj.hide();
        }
    }

    $.langTab = function(event, langSet) {
        if (event.shiftKey && event.which == 76) {
            if ($.browser.msie) {
                var txt = document.selection.createRange().text;
            } else {
                var txt = window.getSelection().toString();
            }
            if (txt == '') {
                return;
            }
            txt = encodeURI(txt);
            addTab(APP + '/Lang/index/search_form/1/lang_value_' + langSet + '/' + txt, lang['basic']['lang_index'], 1);
            return false;
        }
    }

})(jQuery);


/* 公共扩展 */
jQuery.fn.extend({
    initAutocomplete: function() {
        $(this).unbind("click").unbind("blur").autocomplete("destroy");
        var url = this.attr("url");
        var where = this.attr("where");
        this.addClass("ac_input detail_input");
        if (where == undefined)
            where = '';
        var _input = this;
        var search = this.attr('search');
        var _appendto = _input.attr("appendto") ? $dom.find("#" + _input.attr("appendto")) : _input.prev();
        var _itemto = _input.attr("itemto") ? _input.attr("itemto") : $tab_id;
        $(this).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: "term=" + request.term + "&where=" + encodeURIComponent(where),
                    success: function(data) {
                        _input.removeClass("ui-autocomplete-loading");
                        if ($.type(data) == "null") {
                            _input.autocomplete("close");
                            if (search == 1) {
                                _appendto.val(' ').trigger("change");
                            } else {
                                _appendto.val('').trigger("change");
                            }
                        }
                        else if (data.length == 1 && _input.val().toUpperCase() == data[0].value.toUpperCase()) {
                            _input.val(data[0].value);
                            _appendto.val(data[0].id).trigger("change");
                            response(data);
                        } else {
                            if (request.term == _input.val()) {
                                if (search == 1) {
                                    _appendto.val(' ').trigger("change");
                                } else {
                                    _appendto.val('').trigger("change");
                                }
                            }
                            response(data);
                        }
                    }
                });

            },
            select: function(event, ui) {
                _appendto.val(ui.item.id).trigger("change");
            },
            appendTo: "#" + _itemto,
			appendToParent: _input.attr("itemtoparent") ? true : false,
        })
                .click(function() {
            if ($(this).autocomplete("widget").is(":visible")) {
                $(this).autocomplete("close");
                return;
            }
            $(this).autocomplete("search", " ");
        })
                .blur(function() {
            if (this.value == "")
                _appendto.val('').trigger("change");
        })
    },
    tableClick: function() {
         $(this).find("tr").on('click', function(){
			if(!$(this).attr("expand"))
            $(this).toggleClass("selected_tr")
        });
    },
    bandCache:function(){
      $.sumDetailCache();
    },
    bandTotalMethod: function() {
        $dom.find('input[weight],input[row_total],input[row_total_money],input[row_total_disount],input[total_review_weight],input[total_review_long],input[total_review_wide],input[total_review_high],input[total_review_cube],span[class*=del],input[row_per],input[total_accepting_quantity]').die().live("keyup", function() {
            $.sumTotal(this);
        });
        $dom.find('input[row_tax]').die().live("keyup", function() {
            $.sumTax();
        });
    },
    bandProductMethod: function() {
        $dom.find('input[jqproc]').die().live("change", function() {
           $.getProductInfoById(this);
        });
        $dom.find('input[jqpinfo]').die().live("change", function() {
           $.getProductInfoByIdOrNo(this);
        });
		$dom.find('input[jqpad]').die().live("change", function() {
           $.getProductInfoByIdAd(this);
        });
        //选择仓库更新明细仓库
        $dom.find('input[jqware]').die().live("change", function() {
            $.getWareByMainWear(this);
        });
        //发票选择产品号
        $dom.find('input[jqip]').die().live("change", function() {
            $.getInvoiceProductInfoById(this);
        });
		//产品ID筛选出产品信息
        $dom.find('input[jqproductid]').die().live("change", function() {
			//防止箱号ID不对应，先清空在执行
			var obj_parent = $(this).parents('tr:first');
			$(obj_parent).find('#instock_detail_id').val('');
			$(obj_parent).find('#product_no').text('');	//SKU
			$(obj_parent).find('#autoshow_img').attr('pid','');	//SKU显示产品图
			$(obj_parent).find('#warehouse_id').val('');
			$(obj_parent).find('#location_id').val('');
			$(obj_parent).find('#barcode_no').val('');
			$(obj_parent).find('#barcode_no').removeAttr('where');
			$(obj_parent).find('#span_origin_quantity').text('');
			$(obj_parent).find('#origin_quantity').val('');
			$(obj_parent).find('#span_in_quantity').text('');
			$(obj_parent).find('#in_quantity').val('');
			$(obj_parent).find('#original_in_number').val('');
            $.getInstockProductInfo(this);
        });
    },
    UploadFile: function() {
        var _file = $(this);
		$msie = /msie/.test(navigator.userAgent.toLowerCase());
        if ($msie) {
            _file.addClass('other');
        } else {
            _file.css({border: "0px", margin: "0px", padding: "0px", width: "0", height: "0", display: 'none'});
            _file.after('<input type="button" id="button_other" value="' + lang['common']['upload_file'] + '" class="other" onmouseout="this.className=\'other\'" onmouseover="this.className=\'mover_other\'">');
            var obj = _file.next();
            obj.bind('click', function() {
                _file.trigger('click');
            });
        }
    }
});

/* 公共方法 */
(function($) {
    $.widget("ui.combobox", {
        _create: function() {
            var input,
                    self = this,
                    select = this.element.hide(),
                    selected = select.children(":selected"),
                    value = selected.val() ? selected.text() : "",
                    wrapper = this.wrapper = $("<span>")
                    .addClass("ui-combobox")
                    .insertAfter(select);
            input = $("<input>")
                    .appendTo(wrapper)
                    .val(value)
                    .addClass("ui-combobox-input ac_input")
                    .autocomplete({
                delay: 0,
                minLength: 0,
                source: function(request, response) {
                    var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                    response(select.children("option").map(function() {
                        var text = $(this).text();
                        if (this.value && (!request.term || matcher.test(text)))
                            return {
                                label: text.replace(
                                        new RegExp(
                                        "(?![^&;]+;)(?!<[^<>]*)(" +
                                        $.ui.autocomplete.escapeRegex(request.term) +
                                        ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                        ), "<strong>$1</strong>"),
                                value: text,
                                option: this
                            };
                    }));
                },
                select: function(event, ui) {
                    ui.item.option.selected = true;
                    self._trigger("selected", event, {
                        item: ui.item.option
                    });
                    select.trigger("change");
                },
                change: function(event, ui) {
                    if (!ui.item) {
                        var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex($(this).val()) + "$", "i"),
                                valid = false;
                        select.children("option").each(function() {
                            if ($(this).text().match(matcher)) {
                                this.selected = valid = true;
                                return false;
                            }
                        });
                        if (!valid) {
                            // remove invalid value, as it didn't match anything
                            $(this).val("");
                            select.val("");
                            input.data("autocomplete").term = "";
                            return false;
                        }
                    }
                },
                appendTo: select.attr("itemto") ? "#" + select.attr("itemto") : "#" + $tab_id,
				appendToParent: select.attr("itemtoparent") ? true : false,
            })
                    .addClass("ui-widget ui-widget-content ui-corner-all")
                    .click(function() {
                if (input.autocomplete("widget").is(":visible")) {
                    input.autocomplete("close");
                    return;
                }
                input.autocomplete("search", "");
                input.focus();
            });

            input.data("autocomplete")._renderItem = function(ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.label + "</a>")
                        .appendTo(ul);
            };


        },
        destroy: function() {
            this.wrapper.remove();
            this.element.show();
            $.Widget.prototype.destroy.call(this);
        }
    });

    // 查看链接
    $.view = function(obj) {
        var url = $(obj).attr("url");
        var title = $(obj).attr("title");
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: "accessCheck=1&referer=js",
            cache: false,
            success: function(result) {
                if (result.status == 1) {
                    $tabs.tabs("add", url, title);
                } else {
                    success(result);
                }
            }
        });
    }
    // 修改链接
    $.edit = function(obj) {
        var url = $(obj).attr("url");
        var title = $(obj).attr("title");
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
    // 删除链接
    $.cancel = function(obj,type) {
        var url = $(obj).attr("url");
        if (!url) {
            $("#dialog-error").dialog({height: 140, resizable: false, modal: true});
            return false;
        }
		if(type=='TrackOrderImport'){
			$.ajax({
				type: "POST",
				url: url,
				data: "referer=js",
				dataType: "json",
				cache: false,
				success: function(result) {
					success(result,'','','',type);
				}
			});
		}else{
			$("#dialog:ui-dialog").dialog("destroy");
			$("#dialog-confirm").dialog({
				resizable: false,
				height: 140,
				modal: true,
				buttons: {
					"是": function() {
						$(this).dialog("close");
						$.loading();
						$.ajax({
							type: "POST",
							url: url,
							data: "referer=js",
							dataType: "json",
							cache: false,
							async: false,
							success: function(result) {
								success(result);
							}
						});
					},
					"否": function() {
						$(this).dialog("close");
					}
				}
			});
		}
    }
    //展开弹窗
    $.showDialog = function(obj) {
        var url = $(obj).attr("url");
        if (!url) {
            $("#dialog-error").dialog({height: 140, resizable: false, modal: true});
            return false;
        }
        var id = $(obj).attr("dialogid");
        if (id) {
            var dialog_id = id;
            $("#" + dialog_id).remove();
        }
        $("<div id='" + dialog_id + "'></div>").load(url).dialog({
            resizable: false,
            height: 480,
            width: document.documentElement.clientWidth * 0.9,
            modal: true,
            buttons: {
                "关闭": function() {
                    $(this).dialog("close");
                }
            }
        });
    }
    // 还原链接
    $.restore = function(obj) {
        var url = $(obj).attr("url");
        var title = $(obj).attr("title");
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            cache: false,
            success: function(result) {
                success(result);
            }
        });
    }

    //复制行并清空 （流程中使用)
    $.copyRowWithFrom = function(obj, insertRowSort) {
		var table_first = $(obj).parents('table:first');
        var object_parent = table_first.find('tbody');
        var count = 0;
        var tr_index;
        //取最大索引值
        $(object_parent).find('tr').each(function() {
            tr_index = $.cParseInt($(this).attr('index'));
            if (count < tr_index) {
                count = tr_index;
            }
        });
        count = $.cParseInt(count);
        count += 1;
        var preFix = '<tr index="' + count + '">';
        var suFix = '</tr>';
        var newHtml = preFix + table_first.find('.none').html() + suFix;
        newHtml = newHtml.replace(/\[\d+\](?!\[\d+\])/g, "[" + count + "]");
        //插入行

        if ($(obj).parents('tr:first').attr('index') > 0) {
			if(insertRowSort=='before'){
				$(obj).parents('tr:first').before(newHtml);
				var new_obj = $(obj).parents('tr:first').prev();
			}else{
				$(obj).parents('tr:first').after(newHtml);
				var new_obj = $(obj).parents('tr:first').next();
			}
        } else {
            table_first.find('tbody tr:last').after(newHtml);
            var new_obj = object_parent.find('tr:last');
        }
        $(new_obj).find('td[id=span_state]').html(lang['common']['order_normal']);
        ///autocomplete初始化
        $(new_obj).find("input[jqac]").each(function() {
            $(this).initAutocomplete();
        });
        // select 初始化
        $(new_obj).find('select[combobox]').each(function() {
            $(this).parents('td:first').find('.ui-combobox').remove();
            $(this).combobox();
        });
        var last_html = $(new_obj).find('td:last').html().replace('delRowFlowBrf', "delRow");
        $(new_obj).find('td:last').html(last_html);
        return new_obj;
    };
    //复制行但不清空
    $.copyRowWithoutClear = function(obj) {
        var object_parent = $(obj).parents('tr:first');
        var count = $(object_parent).parent('tbody').find("tr").length + 1;
        $(object_parent).parent('tbody').find("tr").each(function() {
            if ($(this).attr("index") >= count) {
                count = $.cParseInt($(this).attr("index")) + 1
            }
            ;
        });
        var preFix = '<tr index="' + count + '">';
        var suFix = '</tr>';
        var newHtml = preFix + $(object_parent).html() + suFix;
        newHtml = newHtml.replace(/\[\d+\]/g, "[" + count + "]");
        $(object_parent).after(newHtml);
        var object_new = $(object_parent).next();
        object_new.find('#after_discount_money').html('');// 编辑时将id input删除
        object_new.find("input[name*='[id]']").replaceWith('');
        $(object_new).find('input[jqac]').each(function() {
            $(this).initAutocomplete();
        });
        $(object_new).find('select[combobox]').each(function() {
            $(this).parents('td:first').find('.ui-combobox').remove();
            $(this).combobox();
        });
        $.sumTotal(object_new.children());//edited by jp 20131204 (edit "obj" to "object_new.children()")
        return object_new;
    };
    $.copyRowWithoutClearNew = function(obj) {
        var object_parent   = $(obj).parents('tr:first');
        var count           = $(object_parent).parent('tbody').find("tr").length + 1;
        $(object_parent).parent('tbody').find("tr").each(function() {
            if ($(this).attr("index") >= count) {
                count = $.cParseInt($(this).attr("index")) + 1
            }
            ;
        });
        var arr             = new Array();
        var num             = 0;
        $(object_parent).children('td').children().each(function(){
            switch($(this).attr('type')){
                case 'radio':
                    if($(this).attr('checked')){
                        arr[num]   = $(this).val();
                        num++;
                    }
                    break;
                case 'text':
                case 'hidden':
                default:
                    arr[num]    = $(this).val();
                    num++;
                    break;
            }
        });
        var preFix = '<tr index="' + count + '">';
        var suFix = '</tr>';
        var newHtml = preFix + $(object_parent).html() + suFix;
        newHtml = newHtml.replace(/\[\d+\]/g, "[" + count + "]");
        $(object_parent).after(newHtml);
        var object_new = $(object_parent).next();
        var num             = 0;
        $(object_new).children('td').children().each(function(){
            switch($(this).attr('type')){
                case 'radio':
                    if($(this).val()==arr[num]){
                        $(this).attr('checked',true);
                        num++;
                    }
                    break;
                case 'text':
                case 'hidden':
                default:
                    $(this).val(arr[num]);
                    num++;
                    break;
            }
        });

        object_new.find('#after_discount_money').html('');// 编辑时将id input删除
//         add yyh 20150319  复制派送明细清空部分内容
        object_new.children('input').val('');
        var new_children    = object_new.children('td');
        object_new.find(".icon-del-plus").attr("url",APP+"/Shipping/deleteDetail/id");
        new_children.eq(0).children().val('');
//        new_children.eq(2).children('input').eq(2).val('');//add 20151103复制后保留派送方式
//        new_children.eq(2).children('input').eq(3).val('');
        new_children.find("input[name*='[id]']").replaceWith('');
        $(object_new).find('input[jqac]').each(function() {
            $(this).initAutocomplete();
        });
        $(object_new).find('select[combobox]').each(function() {
            $(this).parents('td:first').find('.ui-combobox').remove();
            $(this).combobox();
        });
        $.sumTotal(object_new.children());//edited by jp 20131204 (edit "obj" to "object_new.children()")
        return object_new;
    };
    //删除行
    $.delRow = function(obj) {
        var url   = $(obj).attr("url");
		var flow  = $dom.find('#flow').val();
		var args  = "accessCheck=1&referer=js";
        var object_parent = $(obj).parent('td').parent('tr');
        var count = $(object_parent).parent('tbody').find("tr[index]").not(".none").length;
        if (count == 1 && flow=='ReturnSaleOrder') {
//                $("<div>"+lang['common']['product_one']+"</div>").dialog({
//                    buttons: {
//                        Ok: function() {
//                            $( this ).dialog( "close" );
//                        }
//                    }
//                });
        }else{
        if(url != undefined){
            if(flow=='shipping'&&url.indexOf("/id/") != -1){
                var start = url.indexOf("/id/") + 4;
                var args  = args + '&id='+url.substr(start);
            }
        }
        var brf  = true;
        if (url) {
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: args,
                cache: false,
				async:false,//added by jp 20140314
                success: function(result) {
                    if (result.status != 1) {
                        $("<div>" + result.info + "</div>").dialog({
                            modal: true,
                            resizable: false,
                            buttons: {
                                Ok: function() {
                                    $(this).dialog("close");
                                }
                            }
                        });
                        brf = false;
                    }
                }
            });
        }
        if (brf == false)
            return false;
        if (count == 1) {
            //先复制一行
            $.copyRowWithFrom(obj);
        }
        $.sumTotal(obj, 'del');
        $.sumTax();
        object_parent.remove();
        return true;
    }
    };
    //删除行--流程验证
    $.delRowFlowBrf = function(obj, id) {
		var form	= $("form");
        var url		= form.attr("action");
        data = form.serialize();
        data += '&url=' + url + '&self_id=' + id + '&fn=Delete';
        //执行业务规则
        if ($.confirmBrf(data, 'validBrfDetail')) {
            $.delRow(obj);
        }

        return false;
    };

    $.expand = function(obj) {
        var expand	= $(obj).attr("expand");
        var url		= $(obj).attr("url");
        var data	= $(obj).attr("where");
        var this_tr = $(obj).parents("tr:first");
        var formData = $($dom).find("#search_form").serialize();
        if (expand == 1) {
            $(obj).attr("expand", 0);
            this_tr.find("a span").removeClass("icon-pattern-minus");
            this_tr.find("a span").addClass("icon-pattern-plus");
            this_tr.next().remove();
            this_tr.next().removeClass("b_top_style");
        } else {
            $(obj).attr("expand", 1);
            this_tr.find("a span").removeClass("icon-pattern-plus");
            this_tr.find("a span").addClass("icon-pattern-minus");
            $.ajax({
                type: "POST",
                url: url,
                data: "data=" + data + "&" + formData,
                dataType: "text",
                cache: false,
                success: function(html) {
                    var show_html = '<tr expandTr="true"><td><span class="icon icon-pattern-open"></span></td><td colspan="20" style="padding-top:8px;">' + html + '</td>';
                    this_tr.next().addClass("b_top_style");
                    this_tr.after(show_html);
                }
            });
        }
    };
    //列表中显示二级列表
    //列表中显示二级列表
    $.showExpand = function(action, show_id, id) {
        // 0隐藏 1展开
        if (action == '') {
            return false;
        }	//AJAX中方法的名字
        var expand			= $($dom).find("#" + show_id).attr("expand");
		var expand_span		= $($dom).find('#' + show_id + ' #expand span');
		var parent_table	= $($dom).find("#" + show_id).parents('.list:first');
		if ($(parent_table).data('isExpandAll') == 1) {//执行全部展开或全部收缩动作
			expand	= $(parent_table).data('expand');
		}
        if (expand == 1) {
            //把+这个样式替换成-样式
            expand_span.removeClass();
            expand_span.attr('class', 'icon icon-pattern-minus');
			if ($($dom).find("#" + show_id + '_expand_tr').length > 0) {
				$($dom).find("#" + show_id + '_expand_tr').show()
			} else {
            var colspan = $($dom).find('#' + show_id).find("td").size() - 1;
				//必传字段
				//show_id当前ID名称,colspan上级列的个数
				var data = "show_id=" + show_id + "&colspan=" + colspan + "&id=" + id;
				// 判断是否存在需要传递表单数据，表单ID为：search_form
				var formData = $($dom).find("#search_form").serialize();
				if (formData) {
					data = data + "&" + formData;
				}
				$.ajaxSettings.async = false;//禁用异步
				$.post(APP + "/AjaxExpand/" + action, data, function(data) {
					if (data != false) {
						data = '<tr id="' + show_id + '_expand_tr" expandTr="true"><td class="t_center"><span class="icon icon-pattern-open"></span></td><td colspan="' + colspan + '"><div class="tablediv" style="overflow: auto; max-height:900px;max-width:1400px;text-align: left;">' + data + '</div></td></tr>';
						$($dom).find("#" + show_id).after(data);
					}
				});
			}

        } else {
            $($dom).find("#" + show_id + '_expand_tr').hide(); //隐藏展开的内容
            //把-这个样式替换成+样式
            expand_span.removeClass();
            expand_span.attr('class', 'icon icon-pattern-plus');
        }
		$($dom).find("#" + show_id).attr("expand", expand == 1 ? 0 : 1);	//修改展开状态
    };

    //ajax上传图片
    $.uploadFile = function(obj) {
        $dom.find('#s_key').val('');
		var limit_number = $(obj).attr('limit_number');
		var upload_control_name_suffix	= $(obj).attr('upload_control_name_suffix') == undefined ? '' : $(obj).attr('upload_control_name_suffix');
		var upload_response	= $(obj).parent().find('#upload_response'+upload_control_name_suffix);
		$(upload_response).html('');
		var form	= $(obj).parents('form');
        var action = $(form).attr('action');
		var url			= APP + "/AjaxUploadify/uploads";
		if (upload_control_name_suffix) {
			url	= url + '/upload_control_name_suffix/' + upload_control_name_suffix;
		}
		//只允许上传一张
		if(limit_number == 1){
			var tocken = $dom.find('input[name="tocken"]').val();
			var relation_type = $dom.find('input[name="type"]').val();
			url	= url + '/limit_number/' + limit_number + '/tocken/' + tocken +  '/relation_type/' + relation_type;;
		}
        $(form).attr('action', url);
        $(form).ajaxSubmit({
            dataType: 'json',
            success: function(data) {
                if (data.id != -1) {
					switch(data.relation_type){
						case '10':
						case '11':
						case '12':
						case '13':
						case '14':
						case '16':
						case '17':
						case '18':
						case '35':
                        case '21':
                        case '26':	//移仓导入	add by lxt 2015.07.20
                        case '28':
                        case '33':    
							$.uploadExcel(data, obj);
							break;
                        case '24':
                        case '25':
                        case '19':
                        case '29':
						case '32':	//VAT上传证明	2016.07.27
                            $.uploadSuccess(data,obj,upload_control_name_suffix);
                            break
						case '34':
							data.limit_number = 1;
						default:
							$.uploadView(data, obj,upload_control_name_suffix);
							break;
					}
                } else {
                    $(upload_response).html(data.error);
                }
            }
        });
        $(form).attr('action', action);
    };
    $.uploadExcel = function(data, obj) {
		var parent_tr = $(obj).parents('tr');
		var response	= '';
		var file_name	= '';
		var flag	    = 0;
        if (data) {
			response	= data.cpation_name + '(' + data.size + ' KB)' + ' - 上传成功';
			file_name	= data.file_url;
            parent_tr.find('input[id*="submit"]').removeAttr('disabled');
			flag		= 1;
        } else {
			response	= data.error;
            parent_tr.find('#input[id*="submit"]').attr('disabled', 'disabled');
        }
		parent_tr.find('#file_name').val(file_name);
		//追踪订单上次成功跳转追踪单号列表页
		if(flag&&data.relation_type == 11){
			linkTab(data.url, data.title, 1);
		} else if (data.relation_type == 16 && !$(parent_tr).find('#file_list_no').val()) {
			$(parent_tr).find('#file_list_no').val(data.file_name)
		}

		$(obj).parent().find('#upload_response').html(response);
    }

    //上传后图片预览
    $.uploadView = function(data, obj,upload_control_name_suffix) {
		var upload_response	= $(obj).parent().find('#upload_response'+upload_control_name_suffix);
        if (data.id > 0) {
			var str = '<div id="file_upload_' + data.id + '" class="uploadifyQueueItem completed"><span class="fileName">' + data.cpation_name + '(' + data.size + ' KB)' + '</span><span class="percentage"> - 上传成功</span>';
			str += '<span class="cancel"><a href="javascript:;" onclick="$.deleteUpload(' + data.id + ')"><img border="0" src="' + PUBLIC + '/Images/Default/close_gray.png"></a></span>';
			if(data.extension != 'pdf'){	//pdf文件不显示内容
				str += '<br><img src="' + APP_FILES + data.file + '" border="0" width="100"></div>';
			}
            if(data.limit_number == 1){	//限制只能上传一张
				$("#file_uploadQueue"+upload_control_name_suffix).show().html(str);
			}else{
				$("#file_uploadQueue"+upload_control_name_suffix).show().append(str);
			}
        } else {
            $(upload_response).html(data.error);
        }
        $("input[name='file_upload']").val('');
    }
    //added by yyh 20140917上传成功后文字提示
    $.uploadSuccess = function(data, obj,upload_control_name_suffix) {
		var upload_response	= $(obj).parent().find('#upload_response'+upload_control_name_suffix);
        if (data.id > 0) {
            var str = '<div id="file_upload_' + data.id + '" class="uploadifyQueueItem completed"><span class="fileName">' + data.cpation_name + '(' + data.size + ' KB)' + '</span><span class="percentage"> - 上传成功</span>';
            str += '<span class="cancel"><a href="javascript:;" onclick="$.deleteUpload(' + data.id + ',this)"><img border="0" src="' + PUBLIC + '/Images/Default/close_gray.png"></a></span>';
            $("#file_uploadQueue"+upload_control_name_suffix).show().append(str);
        } else {
            $(upload_response).html(data.error);
        }
        $("input[name='file_upload']").val('');
    }
    //删除图片
    $.deleteUpload = function(id,obj) {
        $.get(APP + '/AjaxUploadify/deletes', {id: id}, function(data) {
            $dom.find("#file_upload_" + id).remove();
            if(obj){
                $(obj).parents().find("#file_upload_" + id + ":first").remove();
            }
        });
    }
    $.deleteFile    =function(id){
        $.get(APP + '/AjaxUploadify/deletes', {id: id}, function(data) {
            $dom.find("#file_view_" + id).remove();
        });
    }
    // 设置是否尾箱
    $.setQuantityState = function(obj) {
        if (obj.checked)
            $(obj).prev().val(2);
        else
            $(obj).prev().val(1);
        return;
    }
    //设置是否可用
    $.setIsUse = function(obj) {
        if (obj.checked)
            $(obj).prev().val(1);
        else
            $(obj).prev().val(2);
        return;
    }

    $.getLastQuantity = function(obj, type) {
        var obj_parent = $(obj).parents("tr:first");
        var p_id = obj_parent.find("input[name*='product_id]']").val();
        var state = obj_parent.find('#mantissa').val();
        if (type) {
            var flow = type;
        } else {
            var flow = $dom.find('#flow').val();
        }
        if (!obj.checked) {
            $.getJSON(APP + '/Ajax/getProductDefaultStorage', {id: p_id, flow: flow, mantissa: state}, function(info) {
                if (info.autocomplete == 1) {
                    if ($(obj_parent).find("input[name*='dozen']").length > 0) {
                        var c_obj = $(obj_parent).find("input[name*='capability']");
                        c_obj.attr({'where': 'product_id=' + p_id + ' and mantissa=' + state, 'jqac': true, 'url': APP + '/AutoComplete/lastStorageCapability'});
                        c_obj.initAutocomplete();
                        c_obj.val('').blur(function() {
                            $.sumTotal(c_obj)
                        });
                        var d_obj = $(obj_parent).find("input[name*='dozen']");
                        d_obj.attr({'where': 'product_id=' + p_id + ' and mantissa=' + state, 'jqac': true, 'url': APP + '/AutoComplete/lastStorageDozen'});
                        d_obj.initAutocomplete();
                        d_obj.val('').focus().trigger("click").blur(function() {
                            $.sumTotal(c_obj)
                        });
//						d_obj.val('').focus().trigger("click").bind("focus",function(){$.sumTotal(d_obj)});
                    } else if ($(obj_parent).find("input[name*='capability']").length > 0) {
                        var c_obj = $(obj_parent).find("input[name*='capability']");
                        c_obj.attr({'where': 'product_id=' + p_id + ' and mantissa=' + state, 'jqac': true, 'url': APP + '/AutoComplete/lastStorageCapability'});
                        c_obj.initAutocomplete();
//						c_obj.val('').blur(function(){$.sumTotal(c_obj)});
                        c_obj.val('').focus().trigger("click").blur(function() {
                            $.sumTotal(c_obj)
                        });
                    }
                } else {
                    if ($(obj_parent).find("input[name*='capability']").length > 0) {
                        var c_obj = $(obj_parent).find("input[name*='capability']");
                        c_obj.autocomplete("destroy").val(info.capability);
//						c_obj.bind("focus",function(){$.sumTotal(c_obj)});
                        c_obj.focus().trigger("click").blur(function() {
                            $.sumTotal(d_obj)
                        });
                    }
                    if ($(obj_parent).find("input[name*='dozen']").length > 0) {
                        var c_obj = $(obj_parent).find("input[name*='dozen']");
                        c_obj.autocomplete("destroy").val(info.dozen);
//						c_obj.bind("focus",function(){$.sumTotal(c_obj)});
                        c_obj.focus().trigger("click").blur(function() {
                            $.sumTotal(d_obj)
                        });
                    }
                }
            })
            return false;
        }
        if (!p_id) {
            return false;
        }
        $.getJSON(APP + '/Ajax/getLastStorage', {id: p_id, state: state}, function(info) {
            if (info) {
//				$(obj_parent).find("input[name*='quantity']").val(1);
                if (info.state == 1) {
                    if ($(obj_parent).find("input[name*='dozen']").length > 0) {
                        $(obj_parent).find("input[name*='capability']").val(info.data.capability);
                        $(obj_parent).find("input[name*='dozen']").val(info.data.dozen);
                        $(obj_parent).find("input[name*='capability']").autocomplete("destroy");
                        $(obj_parent).find("input[name*='dozen']").autocomplete("destroy");
                    } else if ($(obj_parent).find("input[name*='capability']").length > 0) {
                        $(obj_parent).find("input[name*='capability']").val(info.data.capability);
                        $(obj_parent).find("input[name*='capability']").autocomplete("destroy");
                    }
                    $.sumTotal($(obj_parent).find("input[name*='capability']"))
                } else if (info.state == 2) {
                    if ($(obj_parent).find("input[name*='dozen']").length > 0) {
                        var c_obj = $(obj_parent).find("input[name*='capability']");
                        c_obj.attr({'where': 'product_id=' + p_id + ' and mantissa=' + state, 'jqac': true, 'url': APP + '/AutoComplete/lastStorageCapability'});
                        c_obj.initAutocomplete();
//						c_obj.bind("focus",function(){$.sumTotal(c_obj)});
                        c_obj.val('').focus().trigger("click").blur(function() {
                            $.sumTotal(c_obj)
                        });

                        var d_obj = $(obj_parent).find("input[name*='dozen']");
                        d_obj.attr({'where': 'product_id=' + p_id + ' and mantissa=' + state, 'jqac': true, 'url': APP + '/AutoComplete/lastStorageDozen'});
                        d_obj.initAutocomplete();
//						d_obj.bind("focus",function(){$.sumTotal(c_obj)});
                        d_obj.val('').focus().trigger("click").blur(function() {
                            $.sumTotal(d_obj)
                        });
                    } else if ($(obj_parent).find("input[name*='capability']").length > 0) {
                        var c_obj = $(obj_parent).find("input[name*='capability']");
                        c_obj.attr({'where': 'product_id=' + p_id + ' and mantissa=' + state, 'jqac': true, 'url': APP + '/AutoComplete/lastStorageCapability'});
                        c_obj.initAutocomplete();
//						c_obj.bind("focus",function(){$.sumTotal(c_obj)});
                        c_obj.val('').focus().trigger("click").blur(function() {
                            $.sumTotal(c_obj)
                        });
                    }
                }
            } else {
                if ($(obj_parent).find("input[name*='dozen']").length > 0) {
                    $(obj_parent).find("input[name*='capability']").autocomplete("destroy").val('');
                    $(obj_parent).find("input[name*='dozen']").autocomplete("destroy").val('');
                } else if ($(obj_parent).find("input[name*='capability']").length > 0) {
                    $(obj_parent).find("input[name*='capability']").autocomplete("destroy").val('');
                }
            }
        });
    }

    //控制表单计算时的格式，将，转成.号
    $.turnToPointShow = function(input_val) {
        if (!input_val || input_val == undefined) {
            input_val = 0;
        }
        if (digital_format == 'eur') { //欧洲
            input_val = input_val.toString().replace(/\,/g, "");
//			input_val = input_val.toString().replace(/\./g,",");
            return 	$.cParseFloat(input_val);
        } else {//中国
            input_val = input_val.toString().replace(/\,/g, "");
            return 	$.cParseFloat(input_val);
        }

    };


    //设置对象HTML
    $.setObjHtml = function(obj_p, obj, str) {
        if (typeof obj_p == undefined || obj_p == '') {
            $dom.find("#" + obj).html(str);
        } else {
            $(obj_p).find("#" + obj).html(str);
        }
    };

    //浮点数字处理
    $.getFloatNum = function(num_val, str_len) {
        if (!str_len) {
            str_len = 2;
        }
        var pow_len = Math.pow(10, str_len);
        num_val = (num_val == '') ? 0 : isNaN(num_val) ? 0 : num_val;
        num_val = Math.round(num_val * pow_len) / pow_len;
        return   num_val;
    };

    //自定义整型转换
    $.cParseInt = function(value) {
        value = parseInt(value);
        value = isNaN(value) ? 0 : value;
        return value;
    };
    //自定义整型转换
    $.cParseIntToOne = function(value) {
        value = parseInt(value);
        value = isNaN(value) ? 1 : value;
        return value;
    };

    //自定义整型转换
    $.cParseFloat = function(value) {
        value = parseFloat(value);
        value = isNaN(value) ? 0 : value;
        return value;
    };

    //控制表单计算时的格式，将，转成.号
    $.turnToPoint = function(input_val) {
        if (!input_val || input_val == undefined) {
            input_val = 0;
            return input_val;
        }

        if (input_val.indexOf(',') > -1 && input_val.indexOf('.') > -1) {
            input_val = 0;
            return input_val;
        }
        input_val = input_val.toString().replace(/\,/g, ".");
        return 	$.cParseFloat(input_val);
    };

    //控制表单输入时的显示格式.转成,号
    $.turnToComma = function(input_val, len) {
        if (!input_val || input_val == undefined) {
            input_val = 0;
        }
        if (digital_format == 'eur') {
//			input_val = input_val.toString().replace(/\./g,",");
            input_val = $.formatCurrency(input_val, len);
            return input_val;
        } else {
            input_val = input_val.toString().replace(/\,/g, "");
            input_val = $.formatCurrency(input_val, len);
            return input_val;
        }
    };

    /**
     * 将数值四舍五入(保留2位小数)后格式化成金额形式
     *
     * @param num 数值(Number或者String)
     * @return 金额格式的字符串,如'1,234,567.45'
     * @type String
     */
    $.formatCurrency = function(num, len) {
        if (len == '' || len == undefined) {
            len = 0;
        }
        if (digital_format == 'eur') {
            var sign = ',';
            var dcimal_sign = '.'; //小数符号
        } else {
            var sign = ',';
            var dcimal_sign = '.';
        }
        temp_num = String(num).split(dcimal_sign);
        cents = temp_num[1];
        num = temp_num[0];
        var math_sign = '';
        if (num.substring(0, 1) == '-') {
            var math_sign = '-';
            num = num.substring(1);
        }
        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++) {
            num = num.substring(0, num.length - (4 * i + 3)) + sign + num.substring(num.length - (4 * i + 3));
        }
        if (cents == undefined) {
            return  math_sign + num;
        } else {
            if (len && cents.length < len) {
                for (var j = 0; j < (len - cents.length); j++) {
                    cents += 0;
                }
            } else if (len && cents.length > len) {
                cents = cents.substring(0, len);
            }
            return math_sign + num + dcimal_sign + cents;
        }
    }

    // 设置 money 显示格式
    $.showEurMoney = function(str, str_len) {
        str = this.getFloatNum(str, str_len + 2);	// 先保留 +1位的小数
        if (!str_len) {
            str_len = 2;
        }
        str = str.toFixed(str_len);
        str = str.replace(".", ",");
        return str;
    };

    // 总合计(改良后sumAll,只对当前修改的行进行比较差异，不遍历所有的行)
    /*
     $.sumTotal = function(obj,type) {
     obj				= $(obj).parents('tr:first');
     //	合计中的数量
     var obj_tfoot	= $(obj).parents('table:first').find('tfoot');
     var factory_id	= $(obj).find("#factory_id").val();
     var currency_id	= $(obj).find("#currency_id").val();
     var factory_name= $(obj).find("#span_fac_name").html();
     var sum_qn 		= $.turnToPointShow(obj_tfoot.find('#total_row_total').html()!=undefined ? obj_tfoot.find('#total_row_total').html() : obj_tfoot.find('#total_row_orders_total').html());
     var sum_money	= $.turnToPointShow(obj_tfoot.find('#total_total_money').html());// 	合计中的金额
     var old_data	= $(obj).find('span[id^=org_qn_data]').html(); // 修改前的数量及单价
     var qn			= $.turnToPoint($(obj).find('#quantity').val());	 // 修改后的数量
     var price		= $.turnToPoint($(obj).find('#price').val());	 // 修改后的单价
     var capability	= $(obj).find("#capability").val() == undefined ? 1 : $.turnToPoint($(obj).find("#capability").val());//获取包数
     var dozen 		= $(obj).find("#dozen").val() == undefined ? 1: $.turnToPoint($(obj).find("#dozen").val());//获取打数
     var pieces	 	= $(obj).find("#pieces").val()== undefined ? 1 : $.turnToPoint($(obj).find("#pieces").val());//获取支数
     var dif_money	= 0;
     var dif_qn		= 0;
     var dif_row_qn	= 0;
     var new_qn		= qn * capability * dozen * pieces; // 修改后数量
     var new_money	= new_qn * price ;				// 修改后金额
     var new_row_qn	= qn// 修改后数量
     if (type == 'del') { // 删除
     dif_money = 0;
     dif_qn	  = 0;
     new_money = - new_money;
     new_qn		  =  - new_qn;
     } else {
     if (old_data !='' && old_data != undefined && parseFloat(old_data)) { // 修改前数据
     old_data = old_data.split('_');
     dif_money = old_data[0] * old_data[4]; // 修改前该行的金额合计
     if (dif_money && old_data[1].toString() != '') { // 包
     dif_money = dif_money * old_data[1];
     }
     if (dif_money && old_data[2].toString() != '') { // 打
     dif_money = dif_money * old_data[2];
     }
     if (dif_money && old_data[3].toString() != '') { // 支
     dif_money = dif_money * old_data[3];
     }
     dif_qn	  = old_data[0] 	//  箱
     * (old_data[1].toString()  == '' ? 1 : old_data[1])	//  包
     * (old_data[2].toString()	== '' ? 1 : old_data[2])	//  打
     * (old_data[3].toString()  == '' ? 1:  old_data[3]);	//  支
     dif_row_qn	=	old_data[0];
     }
     }
     sum_money = sum_money + new_money - $.cParseFloat(dif_money.toFixed(money_length));	// 最后金额
     sum_qn	  = sum_qn + new_qn - $.cParseFloat(dif_qn.toFixed(money_length));
     $(obj).find('#row_total').html($.turnToComma(new_qn.toFixed(money_length), money_length));
     $(obj).find('#total_money').html($.turnToComma(new_money.toFixed(money_length), money_length));
     $(obj).find('span[id^=org_qn_data]').html(qn+'_'+capability+'_'+dozen+'_'+pieces+'_'+price);
     obj_tfoot.find('#total_row_total').html($.turnToComma(sum_qn.toFixed(int_length), int_length));
     obj_tfoot.find('#total_row_orders_total').html($.turnToComma(sum_qn.toFixed(int_length),int_length )); // 订货中明细特殊处理
     obj_tfoot.find('#total_total_money').html($.turnToComma(sum_money.toFixed(money_length), money_length));
     if ($dom.find('#sum_goods_cost').length) {
     $dom.find('#sum_goods_cost').html($.turnToComma(sum_money.toFixed(money_length), money_length));
     }
     var iva_sum_money = 0;
     if ($dom.find('#sum_iva_cost').length) {
     if($dom.find('#iva').val() > 0)	{
     var iva_sum_money = sum_money * ($(document).find('#iva').val()/100);
     $dom.find('#sum_iva_cost').html($.turnToComma(iva_sum_money.toFixed(money_length), money_length));
     }
     }
     if ($(document).find('#sum_total_cost').length) {
     var sum_total_cost = 	iva_sum_money + sum_money;
     $dom.find('#sum_total_cost').html($.turnToComma(sum_total_cost.toFixed(money_length), money_length));
     }
     // 折扣处理
     if ($(obj).find('#after_discount_money').length) {
     $.dealWithDiscount(obj, new_money, type, obj_tfoot);
     }

     sum_qn 		 	= 0;
     $(obj).parents('tbody').find("input[id='quantity']").each(function(){
     sum_qn += Number(this.value);
     });
     if (type == 'del'){
     sum_qn 			-= Number($(obj).find("input[id='quantity']").val());
     }
     obj_tfoot.find('#total_quantity').html(sum_qn, int_length);
     };
     */

    // 处理折扣金额
    $.dealWithDiscount = function(obj, new_money, type, obj_tfoot) {
        var discount = $.turnToPoint($(obj).find('#discount').val());// 	合计中的金额
        var org_new_money = $.turnToPointShow($(obj).find('#after_discount_money').html()); // 原折后金额
        var sum_after_dis_money = $.turnToPointShow(obj_tfoot.find('#total_after_discount_money').html());//折后金额合计
        var preferential_money = $.turnToPoint($dom.find('#pr_money').val());//优惠后金额
        var old_need_get_money = $.turnToPointShow($dom.find('#old_need_get_money').val());//预付款
        if (discount && type != 'del') { // 折扣大于0
            if (discount > 100 || discount < 0) {
                $(obj).find('#discount').val('');
                $(obj).find('#discount').focus();
                discount = 0;
            }
            new_money = new_money * (100 - discount) / 100;
        } else if (type == 'del') { //删除明细
            new_money = 0;
        }
        sum_after_dis_money = sum_after_dis_money + new_money - org_new_money;
        // 折后金额
        $(obj).find('#after_discount_money').html($.turnToComma(new_money.toFixed(money_length), money_length));
        // 折后金额合计
        obj_tfoot.find('#total_after_discount_money').html($.turnToComma(sum_after_dis_money.toFixed(money_length), money_length));
        // 计算优惠后金额
        $dom.find('#after_preferential_money').html($.turnToComma((sum_after_dis_money - preferential_money).toFixed(money_length), money_length));
        var pay_type = ['', 'pay_cash_money', 'pay_bill_money', 'pay_bank_money'];
        //应收款
        var inputmoney = $dom.find("#" + pay_type[$("#pay_paid_type").val()]).val();
        $dom.find('#need_get_money').html($.turnToComma((sum_after_dis_money + old_need_get_money - preferential_money - inputmoney).toFixed(money_length), money_length));
    }

    // 处理优惠后金额
    $.dealWithPM = function(objId, type) {
        var preferential_money = $.turnToPoint($dom.find('#pr_money').val());//优惠金额
        if ($.turnToPointShow($dom.find('td[total_col_dis_money]').html())) {
            var sum_after_dis_money = $.turnToPointShow($dom.find('td[total_col_dis_money]').html());//优惠后金额
        } else {
            var sum_after_dis_money = $.turnToPointShow($dom.find('td[total_col_money]').html());//优惠后金额
        }
        var old_need_get_money = $.turnToPointShow($dom.find('#old_need_get_money').val());//预付款
        if (typeof(objId) == 'undefined') {
            var inputmoney = 0
        } else {
            var inputmoney = objId && $.turnToPointShow($dom.find('#' + objId).val());//优惠后金额
        }
        $dom.find('#after_preferential_money').html($.turnToComma((sum_after_dis_money - preferential_money).toFixed(money_length), money_length));		//销售单金额
        if (type != 'undate') {
            $dom.find('#need_get_money').html($.turnToComma((sum_after_dis_money + old_need_get_money - preferential_money - inputmoney).toFixed(money_length), money_length));		//应收款
        }
        if (!objId) {
            $dom.find('.panes_sale').find('div:visible').find('input[name*="_money"]').trigger('keyup');
        }
    }

    //销售单实际金额
    $.realMoneyWithSale = function(sum_after_dis_money, preferential_money) {
        var old_need_get_money = $.turnToPointShow($dom.find('#old_need_get_money').val());//预付款
        var pay_type = ['', 'pay_cash_money', 'pay_bill_money', 'pay_transfer_money'];
        //应收款
        var inputmoney = $dom.find("#" + pay_type[$("#pay_paid_type").val()]).val();
        if (inputmoney == '' || typeof(inputmoney) == 'undefined') {
            inputmoney = 0;
        }
        $dom.find('#need_get_money').html($.turnToComma((sum_after_dis_money + old_need_get_money - preferential_money - inputmoney).toFixed(money_length), money_length));
    }

    //处理预付款
    $.advenceMoney = function(money, type) {
        var old_need_get_money = $.turnToPointShow($dom.find('#old_need_get_money').val());//历史金额
        money = $.turnToPoint(money);//历史金额
        if (type == 'add' || type == 'addsale') {
            $dom.find('#old_need_get_money').val((old_need_get_money - money).toFixed(money_length));		//销售单金额
        } else if (type == 'del') {
            $dom.find('#old_need_get_money').val((old_need_get_money + money).toFixed(money_length));		//销售单金额
        }
        if (type == 'addsale') {
            $.dealWithPM('', 'undate');
        } else {
            $.dealWithPM();
        }
    }

    // 处理优惠后金额
    $.dealWithIva = function() {
        var iva = $.turnToPoint($dom.find('#iva').val());//优惠金额
        var sum_goods_cost = $.turnToPointShow($dom.find('#sum_goods_cost').html());//优惠后金额
        var sum_iva_cost = sum_goods_cost * iva / 100;
        var sum_total_cost = sum_iva_cost + sum_goods_cost;
        $dom.find('#sum_iva_cost').html($.turnToComma(sum_iva_cost.toFixed(money_length), money_length));
        $dom.find('#sum_total_cost').html($.turnToComma(sum_total_cost.toFixed(money_length), money_length));
    }
    /**
     * 添加明细求和缓存
     * @param {type} obj
     * @author zmx 2013-04-22
     */
    $.sumDetailCache = function(obj){
        var _cache   = function(obj_row){			 
            //行箱数
            var quantity    = $.cParseFloat($(obj_row).find('input[name*=quantity]').val());
            $(obj_row).data('quantity',quantity);
			
            //复核重量 add by yyh 20151010
            var review_weight = $.cParseFloat($(obj_row).find('input[name*=review_weight]').val());
            $(obj_row).data('review_weight',review_weight);
            //复核长 add by yyh 20151130
            var review_long = $.cParseFloat($(obj_row).find('input[name*=review_long]').val());
            $(obj_row).data('review_long',review_long);
            //复核宽 add by yyh 20151130
            var review_wide = $.cParseFloat($(obj_row).find('input[name*=review_wide]').val());
            $(obj_row).data('review_wide',review_wide);
            //复核高 add by yyh 20151130
            var review_high = $.cParseFloat($(obj_row).find('input[name*=review_high]').val());
            $(obj_row).data('review_high',review_high);
            //复核体积 add by yyh 20151130
            var review_cube = $.cParseFloat($(obj_row).find('input[name*=review_cube]').val());
            $(obj_row).data('review_cube',review_cube);
			//行箱数
            var return_quantity    = $.cParseFloat($(obj_row).find('input[name*=return_quantity]').val());
            $(obj_row).data('return_quantity',return_quantity);
			//行总重量
			if ($(obj_row).find('input[name*=quantity]').length == 0) {
				var weight				= $.cParseFloat($(obj_row).find('#weight').val())!=0&&($.cParseFloat($(obj_row).find('#weight').val()));
				var check_weight		= $.cParseFloat($(obj_row).find('#check_weight').val())!=0&&($.cParseFloat($(obj_row).find('#check_weight').val()));
			} else {
				var weight				= $.cParseFloat($(obj_row).find('#weight').val())!=0&&(quantity*$.cParseFloat($(obj_row).find('#weight').val()));
				var check_weight		= $.cParseFloat($(obj_row).find('#check_weight').val())!=0&&(quantity*$.cParseFloat($(obj_row).find('#check_weight').val()));
			}
			$(obj_row).data('weight',weight);
			$(obj_row).data('check_weight',check_weight);
            //行折扣
            var discount    = $.cParseFloat($(obj_row).find('input[row_total_disount]').val()) == 0 ? 1 : (100 - $.cParseFloat($(obj_row).find('input[row_total_disount]').val())) / 100;
            $(obj_row).data('discount',discount);
            //行总数量
            var total_row_qn= new Array();
            $(obj_row).find('input[row_total]').each(function(){
                total_row_qn.push($.cParseFloat($(this).val()));
            });
            $(obj_row).data('total_row_qn',eval(total_row_qn.join("*")));		
            var total_return_quantity= new Array();
            $(obj_row).find('input[row_return_total]').each(function(){
                total_return_quantity.push($.cParseFloat($(this).val()));
            });
            $(obj_row).data('total_return_quantity',eval(total_return_quantity.join("*")));
            //行总金额
            var total_row_money = $.cParseFloat($(obj_row).find('input[row_total_money]').val()) != 0 && ($.cParseFloat(eval(total_row_qn.join("*"))) + '*' + $.cParseFloat($(obj_row).find('input[row_total_money]').val()));
            total_row_money     = eval(total_row_money)
            $(obj_row).data('total_row_money',total_row_money);
            //行合计折扣金额
            var total_row_dis_money = $.cParseFloat(discount) != 0 && (total_row_money + '*' + $.cParseFloat(discount));
            $(obj_row).data('total_row_dis_money',$.cParseFloat(eval(total_row_dis_money)));
            //行尺寸
            var per_size    = $.turnToPointShow($(obj_row).find('input[name*="per_size]"]').val()) * $.turnToPointShow(quantity);
            $(obj_row).data('per_size',per_size);
            //行总重量
            var per_capability  = $.turnToPointShow($(obj_row).find('input[name*="per_capability]"]').val()) * $.turnToPointShow(quantity);
            $(obj_row).data('per_capability',per_capability);
        };
        if(typeof(obj)==='undefined'){
            $('.detail_list tbody tr:visible').each(function(){
                _cache($(this));
            });
        }else{
            _cache($(obj));
        }
    }
    //计算列表合计和行合计
    /**
     * 明细合计
     * @param {type} obj
     * @param {type} type
     * @author  zmx
     * @version 2013-04-22
     */
    $.sumTotal = function(obj, type) {
        var parent				  = $(obj).parents('tr:first');
        var tbody_parent		  = $(obj).parents('tbody:first');
        var total_row_money		  = $.cParseFloat($(parent).data('total_row_money'));//行金额合计
        var total_quantity		  = $.cParseFloat($(parent).data('quantity'));
		var total_return_quantity = $.cParseFloat($(parent).data('total_return_quantity'));
		var total_weight	      = $.cParseFloat($(parent).data('weight'));//重量
		var total_check_weight	  = $.cParseFloat($(parent).data('check_weight'));//重量
        var total_row_qn		  = $.cParseFloat($(parent).data('total_row_qn'));//列数量合计	
        var total_row_dis_money   = $.cParseFloat($(parent).data('total_row_dis_money'));//行折扣合计
        var per_size			  = $.cParseFloat($(parent).data('per_size'));
        var per_capability		  = $.cParseFloat($(parent).data('per_capability'));
        var flow			      = $dom.find('#flow').val();
		var index			      = $(parent).attr('index');
        var total_row_review_weight = $.cParseFloat($(parent).data('review_weight'));//复核重量 add by yyh 20151010
        var total_row_review_long   = $.cParseFloat($(parent).data('review_long'));//复核长 add by yyh 20151130
        var total_row_review_wide   = $.cParseFloat($(parent).data('review_wide'));//复核宽 add by yyh 20151130
        var total_row_review_high   = $.cParseFloat($(parent).data('review_high'));//复核高 add by yyh 20151130
        var total_row_review_cube   = $.cParseFloat($(parent).data('review_cube'));//复核体积 add by yyh 20151130
	 		 
        $.sumDetailCache($(parent));
        ///行数量差异
        total_quantity  = type==='del'?-$(parent).data('quantity'):$(parent).data('quantity')-total_quantity;
		total_return_quantity  = type==='del'?-$(parent).data('total_return_quantity'):$(parent).data('total_return_quantity')-total_return_quantity;
		///行重量差异
        total_weight    = type==='del'?-$(parent).data('weight'):$(parent).data('weight')-total_weight;
        //复核重量 add by yyh 20151010
        total_row_review_weight = type==='del'?-$(parent).data('review_weight'):$(parent).data('review_weight')-total_row_review_weight;
	 
        //复核长 add by yyh 20151130
        total_row_review_long   = type==='del'?-$(parent).data('review_long'):$(parent).data('review_long')-total_row_review_long;
        //复核宽 add by yyh 20151130
        total_row_review_wide   = type==='del'?-$(parent).data('review_wide'):$(parent).data('review_wide')-total_row_review_wide;
        //复核高 add by yyh 20151130
        total_row_review_high = type==='del'?-$(parent).data('review_high'):$(parent).data('review_high')-total_row_review_high;
        //复核体积 add by yyh 20151130
        total_row_review_cube = type==='del'?-$(parent).data('review_cube'):$(parent).data('review_cube')-total_row_review_cube;
		///行查验重量差异
        total_check_weight    = type==='del'?-$(parent).data('check_weight'):$(parent).data('check_weight')-total_check_weight;
		//总数量差异
        total_row_qn    = type==='del'?-$(parent).data('total_row_qn'):$(parent).data('total_row_qn')-total_row_qn;
        //行合计金额差异
        total_row_money = type==='del'?-$(parent).data('total_row_money'):$(parent).data('total_row_money')-total_row_money;
        //计算行合计折扣金额差异
        total_row_dis_money = type==='del'?-$(parent).data('total_row_dis_money'):$(parent).data('total_row_dis_money')-total_row_dis_money;
        per_size        = type==='del'?-$(parent).data('per_size'):$(parent).data('per_size')-per_size;
        per_capability  = type==='del'?-$(parent).data('per_capability'):$(parent).data('per_capability')-per_capability;
        if (flow == 'orders')
            $(parent).find('input[name*="sumq]"]').val($(parent).data('total_row_qn'));
        $(parent).find('td[total_row_qn]').html($.turnToComma($.cParseFloat($(parent).data('total_row_qn')).toFixed(int_length), int_length));//总数量
        //如果装柜,去判断是否装柜数量大于订货数量,有则提示错误
        if (flow == 'loadcontainer') {
            var order_id = $(parent).find('#order_id').val();
            if ($.cParseFloat($(parent).data('total_row_qn')) > 0 && type != 'del' && order_id > 0) {
                $(parent).find('td[total_row_qn]').bind('change', checkLoadQuantity(obj, $(parent).data('total_row_qn'), 'loadcontainer'));
            }
        }
        //修改订货单,不允许小于装柜数量
        if (flow == 'orders') {
            var orders_id = $dom.find('input[name="id"]').val();
            if ($.cParseFloat($(parent).data('total_row_qn')) > 0 && type != 'del' && orders_id > 0) {
                $(parent).find('td[total_row_qn]').bind('change', checkLoadQuantity(obj, $(parent).data('total_row_qn'), 'orders'));
            }
        }
        $(parent).find('td[total_row_money]').html($.turnToComma($.cParseFloat($(parent).data('total_row_money')).toFixed(money_length), money_length));//总金额
        $(parent).find('td[total_row_dis_money]').html($.turnToComma($.cParseFloat($(parent).data('total_row_dis_money')).toFixed(money_length), money_length)); //折后金额

        var total_col_qn = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_col_qn]').html())+total_row_qn;
		var total_col_weight = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_col_weight]').html())+total_weight;
		var total_col_check_weight = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_col_check_weight]').html())+total_check_weight;
        var total_col_money = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_col_money]').html())+total_row_money;
        var total_col_dis_money = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_col_dis_money]').html())+total_row_dis_money;
        var col_quantity = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_quantity]').html())+total_quantity;
		var col_return_quantity = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_return_quantity]').html())+total_return_quantity;
        per_size    = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[col_per_size]').html())+per_size;
        per_capability  = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[col_per_capability]').html())+per_capability;


 
        //复核重量 add by yyh 20151010
        var total_col_review_weight = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_review_weight]').html())+total_row_review_weight;
        //复核长 add by yyh 20151130
        var total_col_review_long   = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_review_long]').html())+total_row_review_long;
        //复核宽 add by yyh 20151130
        var total_col_review_wide   = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_review_wide]').html())+total_row_review_wide;
        //复核高 add by yyh 20151130
        var total_col_review_high   = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_review_high]').html())+total_row_review_high;
        //复核体积 add by yyh 20151130
        var total_col_review_cube   = $.turnToPointShow($(parent).parents('table:first').find('tfoot td[total_review_cube]').html())+total_row_review_cube;
        //底部合计
        $(tbody_parent).parent('table').find('tfoot').find('td[total_col_qn]').html($.turnToComma(eval(total_col_qn).toFixed(int_length), int_length));//总数量
        $(tbody_parent).parent('table').find('tfoot').find('td[total_quantity]').html($.turnToComma(eval(col_quantity).toFixed(money_length), money_length));//总箱数
		$(tbody_parent).parent('table').find('tfoot').find('td[total_return_quantity]').html($.turnToComma(eval(col_return_quantity).toFixed(int_length), int_length));//总箱数
		$(tbody_parent).parent('table').find('tfoot').find('td[total_col_weight]').html($.turnToComma(eval(total_col_weight).toFixed(cube_length), cube_length));//总重量
		$(tbody_parent).parent('table').find('tfoot').find('td[total_col_check_weight]').html($.turnToComma(eval(total_col_check_weight).toFixed(cube_length), cube_length));//总查验重量
        $(tbody_parent).parent('table').find('tfoot').find('td[total_col_money]').html($.turnToComma(eval(total_col_money).toFixed(money_length), money_length));//总金额
        $(tbody_parent).parent('table').find('tfoot').find('td[total_col_dis_money]').html($.turnToComma(eval(total_col_dis_money).toFixed(money_length), money_length));//折后金额
        $(tbody_parent).parent('table').find('tfoot').find('td[col_per_size]').html($.turnToComma(eval(per_size).toFixed(money_length), money_length));//尺寸
        $(tbody_parent).parent('table').find('tfoot').find('td[col_per_capability]').html($.turnToComma(eval(per_capability).toFixed(money_length), money_length));//重量
		$(tbody_parent).parent('table').find('tfoot').find('td[total_review_weight]').html($.turnToComma(eval(total_col_review_weight).toFixed(cube_length), cube_length));//复核重量
		$(tbody_parent).parent('table').find('tfoot').find('td[total_review_long]').html($.turnToComma(eval(total_col_review_long).toFixed(cube_length), cube_length));//复核长 add yyh 20151130
		$(tbody_parent).parent('table').find('tfoot').find('td[total_review_wide]').html($.turnToComma(eval(total_col_review_wide).toFixed(cube_length), cube_length));//复核宽 add yyh 20151130
		$(tbody_parent).parent('table').find('tfoot').find('td[total_review_high]').html($.turnToComma(eval(total_col_review_high).toFixed(cube_length), cube_length));//复核高 add yyh 20151130
		$(tbody_parent).parent('table').find('tfoot').find('td[total_review_cube]').html($.turnToComma(eval(total_col_review_cube).toFixed(cube_length), cube_length));//复核体积 add yyh 20151130
		 
        if (flow == 'sale'){
			//规格处理
			var cube_long,cube_wide,cube_high,cube_quantity,shortest=0,a,b,c;
			var cube_size = [],tmp = [],_A = [],_B = [],_C = [];
			$('.detail_list tbody tr:visible').each(function() {
				if(type==='del'&&$(this).attr('index')==index){
					return true;
				}
				cube_quantity = $.cParseFloat($(this).find('#quantity').val());
				if(cube_quantity>0){
					cube_long = $(this).find('#cube_long').val();
					cube_wide = $(this).find('#cube_wide').val();
					cube_high = $(this).find('#cube_high').val();
					cube_long = $.cParseFloat(eval(cube_long).toFixed(cube_length));
					cube_wide = $.cParseFloat(eval(cube_wide).toFixed(cube_length));
					cube_high = $.cParseFloat(eval(cube_high).toFixed(cube_length));
					tmp		  = [];
					tmp.push(cube_long);
					tmp.push(cube_wide);
					tmp.push(cube_high);
					tmp = tmp.sort(function(a,b){return a>b?1:-1});
					_A.push(tmp.pop());//最大
					_B.push(tmp.pop());//中间大
					_C.push(tmp.pop()*cube_quantity);//最短*数量
				}
			});
			if(_A&&_B&&_C){
				var _a,_b,_c;
				_A = _A.sort(function(a,b){return a>b?1:-1});
				_B = _B.sort(function(a,b){return a>b?1:-1});
				cube_size.push(_A.pop());
				cube_size.push(_B.pop());
				cube_size.push(eval(_C.join('+')));
				cube_size = cube_size.sort(function(a,b){return a>b?1:-1});
				_a = cube_size.pop();
				_a = _a?_a:0;
				_b = cube_size.pop();
				_b = _b?_b:0;
				_c = cube_size.pop();
				_c = _c?_c:0;
				var spec  = $.turnToComma(eval(_a).toFixed(cube_length), cube_length)+' * '+$.turnToComma(eval(_b).toFixed(cube_length), cube_length)+' * '+$.turnToComma(eval(_c).toFixed(cube_length), cube_length);
				$(tbody_parent).parent('table').find('tfoot').find('td[total_col_cube]').html(spec);
			}
            $.dealWithPM();
		}
		if (flow == 'instock') {
			var total_col_cube	= 0;
			var total_col_check_cube	= 0;
			var has_check				= $(parent).find('input[name*="check_long]"]') ? true : false;
			$('.detail_list tbody tr:visible').each(function() {
				if(type==='del'&&$(this).attr('index')==index){
					return true;
				}
				var cube_long = $.cParseFloat($(this).find('input[name*="cube_long]"]').val());
				var cube_wide = $.cParseFloat($(this).find('input[name*="cube_wide]"]').val());
				var cube_high = $.cParseFloat($(this).find('input[name*="cube_high]"]').val());
				var cube	  = $.cParseFloat(cube_long*cube_wide*cube_high);
				total_col_cube	= eval(total_col_cube + " + " +  cube);
				if (has_check) {
					var check_long = $.cParseFloat($(this).find('input[name*="check_long]"]').val());
					var check_wide = $.cParseFloat($(this).find('input[name*="check_wide]"]').val());
					var check_high = $.cParseFloat($(this).find('input[name*="check_high]"]').val());
					var check_cube	  = $.cParseFloat(check_long*check_wide*check_high);
					total_col_check_cube	= eval(total_col_check_cube + " + " +  check_cube);
				}
			});
			$(tbody_parent).parent('table').find('tfoot').find('td[total_col_cube]').html(total_col_cube.toFixed(cube_length));
			if (has_check) {
				$(tbody_parent).parent('table').find('tfoot').find('td[total_col_check_cube]').html(total_col_check_cube.toFixed(cube_length));
			}
		}
        $.sumFactoryTotal($(parent),type);
    }
    //厂家合计
    $.sumFactoryTotal   = function(parent,type){
        //厂家装柜小计
        if ($dom.find('.load_list').html() != null) {
            if ($.cParseInt($(parent).find('#factory_id').val()) != 0) {
                var row_quantity = $(parent).data('quantity');
                var factory_id = $(parent).find('#factory_id').val();
                var currency_id = $(parent).find('#currency_id').val();
                var factory_name = $(parent).find('#span_fac_name').html();
                var ikey = factory_id + '_' + currency_id;
                var iquantity = 0;
                var isumquantity = 0;
                var imoney = 0;
                //当厂家小计已存在的话,累积
                if ($dom.find("#" + ikey + '_tr').size() > 0) {
                    var fac_quantity = 0;
                    var fac_subquantity = 0;
                    var fac_submoney = 0;
                    $dom.find('input[id=factory_id][value=' + factory_id + ']').parent('td').parent('tr').find('input[id=currency_id][value=' + currency_id + ']').each(function() {
                        if (type == 'del')
                            var parent_row = $(this).parent('td').parent('tr').not(parent);
                        else
                            var parent_row = $(this).parent('td').parent('tr');
                        fac_quantity += $(this).parents('tr:first').data('quantity');
                        fac_subquantity += $(this).parents('tr:first').data('total_row_qn');
                        fac_submoney += $.cParseFloat($.turnToPointShow($(parent_row).find('td[total_row_money]').html()));
                    });
                    //如果数量0了以后不显示该行
                    if (fac_quantity == 0 && fac_subquantity == 0) {
                        $dom.find("#" + ikey + '_tr').remove();
                    }
                    $dom.find("#" + ikey + '_quantity').html($.turnToComma(fac_quantity.toFixed(money_length), money_length));
                    if ($(parent).parents('table:first').find('tfoot').find('td[total_col_qn]').html() != null) {
                        $dom.find("#" + ikey + '_sumquantity').html($.turnToComma(fac_subquantity.toFixed(int_length), int_length));
                    } else {
                        $dom.find("#" + ikey + '_sumquantity').html($.turnToComma(fac_quantity.toFixed(int_length), int_length));
                    }
                    $dom.find("#" + ikey + '_money').html($.turnToComma(fac_submoney.toFixed(money_length), money_length));
                } else {
                    if (row_quantity > 0) {
                        //如果不存在新增一行厂家小计
                        var html_str = '';
                        var row_total_quantity = $(parent).data('total_row_qn');
                        var row_total_money = $.cParseFloat($.turnToPointShow($(parent).find('td[total_row_money]').html()));
                        html_str += '<tr id="' + ikey + '_tr">';
                        html_str += '<td  id="' + ikey + '_factory" class="t_left">' + factory_name + '</td>';
                        if ($(parent).parents('table:first').find('tfoot').find('td[total_col_qn]').html() != null) {
                            html_str += '<td  id="' + ikey + '_quantity" >' + $.turnToComma(row_quantity.toFixed(money_length), money_length) + '</td>';
                            html_str += '<td  id="' + ikey + '_sumquantity">' + $.turnToComma(row_total_quantity.toFixed(int_length), int_length) + '</td>';
                        } else {
                            html_str += '<td  id="' + ikey + '_sumquantity">' + $.turnToComma(row_quantity.toFixed(int_length), int_length) + '</td>';
                        }
                        html_str += '<td  id="' + ikey + '_money">' + $.turnToComma(row_total_money.toFixed(money_length), money_length) + '</td>';
                        html_str += '</tr>';
                        $dom.find("#total_factory").after(html_str);
                    }
                }
                $dom.find('#total_factory_quantity').html($(parent).parents('table:first').find('tfoot td[total_quantity]').html());
                if ($(parent).parents('table:first').find('tfoot').find('td[total_col_qn]').html() != null) {
                    $dom.find('#total_factory_sumquantity').html($(parent).parents('table:first').find('tfoot td[total_col_qn]').html());
                } else {
                    $dom.find('#total_factory_sumquantity').html($(parent).parents('table:first').find('tfoot td[total_quantity]').html());
                }
                $dom.find('#total_factory_money').html($(parent).parents('table:first').find('tfoot td[total_col_money]').html());
            }
        }
    }

    //流程获取产品的信息
    $.getProductInfoById = function(obj, type) {
//		var id		  	= $(obj).val();
        var obj_parent  = $(obj).parents('tr:first');
        var id		    = $(obj_parent).find('input[name*="product_id]"]').val();
        var flow	    = $dom.find('#flow').val();
        if (id > 0 ) {
			$(obj_parent).find('#autoshow_img').attr('pid', id);
            $.getJSON(APP + '/Ajax/getProductInfo', {id: id,flow:flow}, function(data) {				
				$(obj_parent).find('#span_product_no').html(data.output);
				$(obj_parent).find('#span_custom_barcode').html(data.custom_barcode);
                $(obj_parent).find('#span_product_name').html(data.product_name);
                $(obj_parent).find('#span_declared_value').val(data.declared_value);
				$(obj_parent).find('#span_product_weight').html(data.s_weight);
				$(obj_parent).find('#span_product_cube').html(data.s_cube);
				$(obj_parent).find('#weight').val(data.weight);
				$(obj_parent).find('#cube_long').val(data.cube_long);
				$(obj_parent).find('#cube_wide').val(data.cube_wide);
				$(obj_parent).find('#cube_high').val(data.cube_high);
                $(obj_parent).find('#span_check_weight').html(data.dml_check_weight);
                $(obj_parent).find('#span_check_cube').html(data.s_check_cube);

				$(obj_parent).find('input[weight]').trigger('keyup');
			});
        }
        ;
    }
        //流程获取产品的信息
    $.getProductInfoByIdOrNo = function(obj, type) {
		 
//		var id		  	= $(obj).val();
        var obj_parent  = $(obj).parents('tr:first');
        if(obj.id==='product_id'){
            var id  = $(obj_parent).find('#product_id').val();
        }else{
            var id  = $(obj_parent).find('#product_no').val();
        }
        var flow	    = $dom.find('#flow').val();
        if (id > 0) {
            $(obj_parent).find('#autoshow_img').attr('pid', id);
            $.getJSON(APP + '/Ajax/getProductInfo', {id: id,flow:flow}, function(data) {
                if(obj.id==='product_id'){
                    $(obj_parent).find('#product_id_show').val(data.product_id);
                    $(obj_parent).find('#product_no').val(data.product_id);
                }else{
                    $(obj_parent).find('#product_id').val(data.product_id);
                    $(obj_parent).find('#product_no_show').val(data.product_no);
                }
				$(obj_parent).find('#span_product_no').html(data.output);
                $(obj_parent).find('#span_product_name').html(data.product_name);
				$(obj_parent).find('#span_custom_barcode').html(data.custom_barcode);
                $(obj_parent).find('#span_declared_value').val(data.declared_value);
				$(obj_parent).find('#span_product_weight').html(data.s_weight);
				$(obj_parent).find('#span_product_cube').html(data.s_cube);
				$(obj_parent).find('#weight').val(data.weight);
				$(obj_parent).find('#cube_long').val(data.cube_long);
				$(obj_parent).find('#cube_wide').val(data.cube_wide);
				$(obj_parent).find('#cube_high').val(data.cube_high);
				$(obj_parent).find('input[weight]').trigger('keyup');
			});
        }
        ;
    }

	//流程获取产品的信息
    $.getProductInfoByIdAd = function(obj, type) {
	 
//		var id		  	= $(obj).val();
        var obj_parent  = $(obj).parents('tr:first');
        if(obj.id==='product_id'){
            var id  = $(obj_parent).find('#product_id').val();
        }else{
            var id  = $(obj_parent).find('#product_id_from_no').val();
        }
        var flow	    = $dom.find('#flow').val();
        if (id > 0) {
            $(obj_parent).find('#autoshow_img').attr('pid', id);
            $.getJSON(APP + '/Ajax/getProductInfo', {id: id,flow:flow}, function(data) {
                    $(obj_parent).find('#product_id_show').val(data.product_id);
                    $(obj_parent).find('#product_id').val(data.product_id);
					$(obj_parent).find('#product_no_show').val(data.product_no);
					$(obj_parent).find('#product_id_from_no').val(data.product_id);
					$(obj_parent).find('#span_custom_barcode').text(data.custom_barcode);
			});
        }
        ;
    }
	

    /*************配货******************/
    $.getWareByMainWear = function(obj) {
        var id = $(obj).val();
        if (id > 0) {
            $.post(APP + '/Ajax/getWareName', {id: id}, function(data) {
                $dom.find('input[name=warehouse_name]').each(function() {
                    $(this).val(data);
                    $(this).prev('input').val(id);
                });
            });
        }
    }
    /*******************************/
    $.invoiceProductEnabled = function(obj) {
        $(obj.form).find("input[name*='product_no]']").val('').prev().val('');
        $(obj.form).find("input[name*='product_no]']").removeAttr("disabled").removeClass("disabled").attr({"jqac": true})
                .each(function() {
            $(this).initAutocomplete();
        })
    }
    //获取发票产品信息
    $.getInvoiceProductInfoById = function(obj) {
        var id = $(obj).val();
        var obj_parent = $(obj).parents('tr:first');
        if (id > 0) {
            $.getJSON(APP + '/Ajax/getInvoiceProductInfo', {id: id}, function(data) {
                $(obj_parent).find('input[name*=product_id]').val(data.id);
                $(obj_parent).find('input[name*=product_name]').val(data.product_name);
                $(obj_parent).find('#span_product_name').html(data.product_name);
                $(obj_parent).find('#span_invoice_ingredient').html(data.ingredient);
            });
        }
    }
	//获取发货产品信息
    $.getInstockProductInfo = function(obj) {
		var obj_parent = $(obj).parents('tr:first');
		var instock_id = $.cParseInt($dom.find('#instock_id').val());
		var box_id = $.cParseInt($(obj_parent).find('#box_id').val());
		var product_id = $.cParseInt($(obj).val());
        if (instock_id > 0 && box_id > 0 && product_id > 0) {
            $.getJSON(APP + '/Ajax/getInstockProductInfo', {instock_id: instock_id,box_id: box_id,product_id: product_id}, function(data) {
				$(obj_parent).find('#instock_detail_id').val(data.instock_detail_id);
				$(obj_parent).find('#product_no').text(data.product_no);	//SKU
				$(obj_parent).find('#autoshow_img').attr('pid',product_id);	//SKU显示产品图
				$(obj_parent).find('#warehouse_id').val(data.warehouse_id);
				$(obj_parent).find('#barcode_no').val(data.location_no);
				$(obj_parent).find('#barcode_no').attr('where',encodeURIComponent('warehouse_id='+data.warehouse_id)).initAutocomplete();
				$(obj_parent).find('#location_id').val(data.location_id);
				$(obj_parent).find('#span_origin_quantity').text(data.quantity);
				$(obj_parent).find('#origin_quantity').val(data.quantity);
				$(obj_parent).find('#span_in_quantity').text(data.in_quantity);
                $(obj_parent).find('#in_quantity').val(data.in_quantity);
				$(obj_parent).find('#original_in_number').val(data.in_quantity);
            });
        }
    }
    //发票计算税额和发票总金额
    $.sumTax = function() {
        var iva = $.cParseFloat($dom.find('input[name=iva]').val());
        var total_money = $dom.find('.detail_list tr:last').find('td[total_col_dis_money]').html();
        if (total_money == null || total_money == undefined) {
            total_money = $dom.find('.detail_list tr:last').find('td[total_col_money]').html();
        }
        //货值
        $dom.find('td[tax_quantity]').html(total_money);
        //税额
        var tax_cost = (iva / 100 * $.turnToPointShow(total_money)).toFixed(money_length);
        $dom.find('td[tax_cost]').html($.turnToComma(tax_cost, money_length));
        //发票总金额
        var tax_total_cost = ($.turnToPointShow(total_money) + parseFloat(tax_cost)).toFixed(money_length);
        $dom.find('td[tax_total_cost]').html($.turnToComma(tax_total_cost, money_length));
    }

    $.autoShow = function(obj, module_name,type) {
		var width  = 680;
		var height = 500;
		if(module_name=='SaleOrderShipping'){
			var width  = 780;
			var height = 500;
		}
		if(type=='mobile'){
			var width  = 200;
			var height = 100;
		}
		//状态日志
		if(type == 'state_log'){
			var obj_parent  = $(obj).parent('td').parent('tr');
			var pid = $(obj_parent).find("#object_id").val();
            var position_left   = 20;
            var position_top    = -150;
        }else if(type == 'mobile'){
			var obj_parent  = $(obj).parent('td').parent('tr');
            var pid = $(obj_parent).find("#mobile").val();
            var position_left   = 40;
            var position_top    = -20;
            var title      = lang['common']['tel'];
        }else{
			var pid = $.cParseInt($(obj).attr("pid"));
            var position_left   = 20;
            var position_top    = -150;
		}
        if ((isNaN(pid) == true || pid <= 0) && type != 'mobile')
            return;
        $("#autoShowDiv").dialog("destroy").html('loading...');
        var oft = $(obj).offset();
        $("#autoShowDiv").load(APP + '/AutoShow', {"id": pid, "module": module_name,"type":type}).dialog({
            autoOpen: true,
            resizable: false,
            show: "Fold",
            width: width,
            height: height,
            position: [oft.left + position_left, oft.top + position_top],
            title:title
        }).mouseleave(function() {
            $('#autoShowDiv').dialog('destroy');
        });

//		$("#autoShowDiv").parents("div:first").attr('class','autoshow');
        return false;

    }

	$.exportCsv = function(obj,module_name) {
		var obj_parent    = $(obj).parent('td').parent('tr');
		var id			  = $(obj_parent).find("#object_id").val();
		var relation_type = $(obj_parent).find("#relation_type").val();
		var file_exists   = $(obj_parent).find("#file_exists").val();
        if (isNaN(id) == true||id=='')
            return;
		if (id > 0 && relation_type >0) {
			if(file_exists=='1'){
				window.location = APP + "/Ajax/exportCsv/id/"+id+'/relation_type/'+relation_type;
			}else{
				success('','','','',module_name);
			}
        }
    }
    // 通过条形码新增一行
    $.addRowByBarcode = function(obj) {
        var barcode = $.trim($(obj).val());
        var flow = $.trim($dom.find('#flow').val());
        var parent = $(obj).parent('td').parent('tr').parents('table').parent('td');
        if (barcode.length > 0) {
            $.getJSON(APP + '/Ajax/getProductByBarcode', {barcode: barcode}, function(data) {
                if (data) {
                    var first_obj = $(parent).find('.detail_list').find('tbody').find('tr:visible:first');
                    var list_row = $(parent).find('.detail_list').find('tbody').find('tr:visible').size();
                    for (i = 1; i <= list_row; i++)
                    {
                        if (first_obj.find("input[name*='product_id]']").val() < 1 || !first_obj.find("input[name*='product_no]']").val()) {
                            first_obj = first_obj;
                        } else {
                            if (i == list_row) {
                                first_obj = first_obj;
                            } else {
                                first_obj = first_obj.next();
                            }
                        }
                    }
                    if (first_obj.find("input[name*='product_id]']").val() < 1 || !first_obj.find("input[name*='product_no]']").val()) {
                        var obj = first_obj;
                    } else {
                        var obj = $.copyRowWithFrom($(first_obj).find('td:last').find('span[class*="icon-add-plus"]'));
                    }
                    $(obj).find('#barcode').html(barcode);
                    $(obj).find('input[name*="product_id]"]').val(data.p_id).trigger('change');
                    $(obj).find('input[name*="product_no]"]').val(data.product_no);
                    $(obj).find('#span_product_name').html(data.product_name);
                    // 设置产品颜色尺码(产品不绑定颜色及尺码)
                    if (data.color_id > 0) {
                        $(obj).find('input[name*="color_id]"]').val(data.color_id);
                        data.color_id != null && $(obj).find('input[name*="color_name"]').val(data.color_name);
                    }
                    if (data.size_id > 0) {
                        $(obj).find('input[name*="size_id]"]').val(data.size_id);
                        data.size_id != null && $(obj).find('input[name*="size_name"]').val(data.size_name);
                    }
                    // 设置产品颜色属性(产品绑定颜色及尺码)
//					if (($(obj).find('input[name*="color_id]"]').length>0 || $(obj).find('input[name*="span_id]"]').length>0) && (data.color_id < 1 || data.size_id <1)) {
//						var row_id = obj.attr('index');
//						if(!row_id) row_id = 1;
//						if(flow =='sale' ) {
//							var ajax_fn = 'getFlowPropertiesForSale';
//						} else{
//							var ajax_fn = 'getFlowProperties';
//						}
//						$.getJSON(APP+'/Ajax/'+ajax_fn,{id:data.p_id,row_id:row_id,color_id:data.color_id,size_id:data.size_id},function(data){
//						if(data.state==true){
//								if(data.color != undefined){
//									$(obj).find("#span_color").html(data.color);
//								}
//								if(data.size  != undefined){
//									$(obj).find("#span_size").html(data.size);
//								}
//							}
//						});
//					}
                }
            });
        }
    };
    $.addQuantityByBarcode = function(obj) {
        var product_barcode  = $.trim($(obj).val());
        var parent      = $(obj).parent('td').parent('tr').parents('table').parent('td').find('.detail_list').find('tbody');
        $.ajax({
            type: "GET",
            url: APP + '/Ajax/getProductIdByBarcode/product_barcode/'+product_barcode,
            dataType: "text",
            cache: false,
            async:false,
            success: function(product_id) {
                if (product_id.length > 0) {
					if($dom.find('input[name=verifyType]').val() == 1){	//符合订单验证发货 扫描条码，验证+1
						verifyQuantity(product_id);
					}else{
						$(parent).find('tr:visible').each(function() {
							if ($(this).find("input[name*='product_id]']").val() == product_id) {
								var real_quantity   = $(this).find("input[name*='real_quantity]']");
								var quantity    = real_quantity.val();
								real_quantity.val(Number(quantity)+1);
							}
						});
					}
                }
            }
        });
    };
    //基础信息列表排序
    $.sortBy = function(field, sort) {
        $dom.find('#search_form').find("input[name='_sort'],input[name='_order']").remove();
        var str = '<input type="hidden" name="_sort" value="' + sort + '"><input type="hidden" name="_order" value="' + field + '">';
        $dom.find('#search_form').append(str).submit();
    }
	//不做任何验证直接删除行
	$.newdelRow = function(obj) {
		var object_parent = $(obj).parent('td').parent('tr');
        var count = $(object_parent).parent('tbody').find("tr[index]").not(".none").length;
        if (count == 1) {
			//如只剩下一行，先复制一行，在删除
            $.copyRowWithFrom(obj);
        }
		$(object_parent).remove();
	}
        /**
         * @author yyh 20140827
         * @param {type} module
         * @param {type} id
         * 编辑发货状态弹窗
         */
	$.quicklyEditState = function(module,id,state){
           $("#dialog-edit_state").remove();
		var buttons = [{
							text: lang['common']['submit'],
							click: function() {
								$(this).find("form").submit();
							}
						},
						{
							text: lang['common']['close'],
							click: function() {
								$("#dialog-edit_state").remove();
							}
						}];
            var dialog  = $("<div id='dialog-edit_state'></div>");
            $(dialog).dialog({
				autoOpen: true,
				resizable: false,
				draggable: false,
				height: 340,
				width: 350,
				modal: true,
				buttons: buttons
			}).load(APP + '/QuicklyOperate/editState/module/' + module + '/id/' + id + '/state/' + state, function (){
                if ($(this).find("form").length != 0) {//有表单
                    var quick_dom = $(this);
                    $(this).find("form").sendForm({"dataType": "json", "success": function(result, statusText, xhr, $form) {
                        if (result.status == 1) {
                            $("#dialog-edit_state").dialog("destroy");
                            $("#tips").html(result.info).fadeIn().delay(100).fadeOut(200, function (){
                                $dom.find('#search_form').submit();
                            });
                        } else if (result.status == 2) {
                            var oft = $("#dialog-edit_state").offset();
                            validity(result.info, quick_dom, '.table_autoshow', 0, oft.left);
                        } else {
                            $("#dialog-edit_state").dialog("destroy");
                            $("<div>" + result.info + "</div>").dialog({
                                modal: true,
                                resizable: false,
                                buttons: {
                                    Ok: function() {
                                        $(this).remove();
                                    }
                                }
                            });
                        }
                        $.removeLoading();
                    }});
                }
				$(this).find("input[jqac]").each(function() {
					$(this).initAutocomplete();
				});
				$(this).find("select[combobox]").each(function() {
					$(this).combobox();
				});
            })
        }

	/**
	 * 查看条形码
	 * @author jph 20140227
	 * @param {string} module
	 * @param {int} id
	 */
	$.quicklyShowBarcode = function(module, id, quantity) {
		var height	= 'auto';
		var width	= 350;
		if (id > 0) {
            switch(module){
                case 'Instock':
                    height	= 500;
                    width	= 800;
                    $.loading();
                    do {
                        var i   = 0;
                        $.ajax({
                            type: "GET",
                            url: APP + '/InstockBarcode/regenerateInstockBoxBarcode/id/'+id,
                            dataType: "text",
                            cache: false,
                            async:false,
                            success: function(j) {
                                i = j;
                            }
                        });
                     } while (i > 0);
                     $.removeLoading();
                    break;
                case 'Product':
                    if (quantity > 0) {
                        height  =500;
                        width   =840;
                    }
                    break;
            }
			$("#dialog-show_barcode").remove();
			$("<div id='dialog-show_barcode'></div>").load(APP + '/QuicklyOperate/Barcode/module/' + module + '/id/' + id +'/quantity/'+quantity).dialog({
				autoOpen: true,
				resizable: false,
				height: height,
				width: width,
				modal: true
			});
		}
	}
	/**
	 * 导出条形码
	 * @author jph 20140903
	 * @param {string} module
	 * @param {int} id
	 * @param {boolean} batch 是否批量导出
	 */
	$.quicklyExportBarcode = function(module, id, type) {
		type = type === 'batch' ? type : 'single';
		if (type === 'batch' || id > 0) {
			var dialog_id	= 'dialog-export_barcode';
			$("#" + dialog_id).remove();
			var load_url = APP + '/QuicklyOperate/exportBarcode/module/' + module + '/type/' + type;
			if(type !== 'batch'){
				load_url	+= '/id/' + id;
			}
			$('<div id="' + dialog_id + '"></div>').load(load_url, function() {
				var quick_dom		= $(this);
				var form_dom		= $(quick_dom).find('form');
				var options		= {
					"dataType":"json",
					"success": function(result, statusText, xhr, $form) {
						if (result.status == 1) {
							//quicklyAddCallback(module, result);
							$("#" + dialog_id).dialog("destroy");
							window.open(APP + '/Ajax/exportBarcode/key/' + result.key);
						} else if (result.status == 2) {
							var oft = $("#" + dialog_id).offset();
							validity(result.info, quick_dom, '.table_autoshow', 0, oft.left);
						} else {
							$("<div>" + result.info + "</div>").dialog({
								modal: true,
								resizable: false,
								buttons: {
									Ok: function() {
										$(this).remove();
									}
								}
							});
						}
						$.removeLoading();
					}
				};
				$(form_dom).sendForm(options);
				$(quick_dom).find("input[jqac]").each(function() {
					$(this).initAutocomplete();
				});
			}).dialog({
				autoOpen: true,
				resizable: false,
				draggable: false,
				width: 400,
				height: type === 'batch' ? 300 : 180,
				modal: true,
				title:lang['common']['please_input_export_quantity'],
				buttons: [
					{
						text: lang['common']['submit'],
						click: function() {
							$(this).find("form").submit();
						}
					},
					{
						text: lang['common']['close'],
						click: function() {
							$("#" + dialog_id).remove();
						}
					}
				]
			});
		}
	}
    $.exportInstockBarcode = function(module,id) {
        if(module == 'Instock'){
            do {
                var i   = 0;
                $.ajax({
                    type: "GET",
                    url: APP + '/InstockBarcode/regenerateInstockBoxBarcode/id/'+id,
                    dataType: "text",
                    cache: false,
                    async:false,
                    success: function(j) {
                        i = j;
                    }
                });
             } while (i > 0);
        }
        window.open(APP + '/Ajax/exportInstockBarcode/module/' + module +'/id/' + id);
    }
    /**
	 * 打印条形码
	 * @author yyh 20141013
	 * @param {string} module
	 * @param {int} id
	 * @param {boolean} batch 是否批量导出
	 */
    $.quicklyPrintBarcode = function(module, id, type) {
		type = type === 'batch' ? type : 'single';
		if (type === 'batch' || id > 0) {
			var dialog_id	= 'dialog-print_barcode';
			$("#" + dialog_id).remove();
			var load_url = APP + '/QuicklyOperate/printBarcode/module/' + module + '/type/' + type;
			if(type !== 'batch'){
				load_url	+= '/id/' + id;
			}
			$('<div id="' + dialog_id + '"></div>').load(load_url, function() {
				var quick_dom		= $(this);
				var form_dom		= $(quick_dom).find('form');
				var options		= {
					"dataType":"json",
					"success": function(result, statusText, xhr, $form) {
                        if (result.status == 1) {
						$("#" + dialog_id).remove();
                        $.quicklyShowBarcode(result.module, result.id, result.quantity);
                        } else if (result.status == 2) {
							var oft = $("#" + dialog_id).offset();
							validity(result.info, quick_dom, '.table_autoshow', 0, oft.left);
						} else {
							$("<div>" + result.info + "</div>").dialog({
								modal: true,
								resizable: false,
								buttons: {
									Ok: function() {
										$(this).remove();
									}
								}
							});
						}
                        $.removeLoading();
                    }
				};
				$(form_dom).sendForm(options);
				$(quick_dom).find("input[jqac]").each(function() {
					$(this).initAutocomplete();
				});
			}).dialog({
				autoOpen: true,
				resizable: false,
				draggable: false,
				width: 400,
				height: type === 'batch' ? 300 : 180,
				modal: true,
				title:lang['common']['print_quantity'],
				buttons: [
					{
						text: lang['common']['submit'],
						click: function() {
							$(this).find("form").submit();
						}
					},
					{
						text: lang['common']['close'],
						click: function() {
							$("#" + dialog_id).remove();
						}
					}
				]
			});
		}
	}

    $.quicklyPrintSaleOrder = function(module, id, type) {
		type = type === 'batch' ? type : 'single';
		if (type === 'batch' || id > 0) {
			var dialog_id	= 'dialog-print_barcode';
			$("#" + dialog_id).remove();
			var load_url = APP + '/QuicklyOperate/printBarcode/module/' + module + '/type/' + type;
			if(type !== 'batch'){
				load_url	+= '/id/' + id;
			}
			$('<div id="' + dialog_id + '"></div>').load(load_url, function() {
				var quick_dom		= $(this);
				var form_dom		= $(quick_dom).find('form');
				var options		= {
					"dataType":"json",
					"success": function(result, statusText, xhr, $form) {
						$("#" + dialog_id).dialog("destroy");
                        $.quicklyShowBarcode(result.module, result.id, result.quantity);
                        $.removeLoading();
                    }
				};
				$(form_dom).sendForm(options);
				$(quick_dom).find("input[jqac]").each(function() {
					$(this).initAutocomplete();
				});
			}).dialog({
				autoOpen: true,
				resizable: false,
				draggable: false,
				width: 400,
				height: type === 'batch' ? 300 : 180,
				modal: true,
				title:lang['common']['please_input_export_quantity'],
				buttons: [
					{
						text: lang['common']['submit'],
						click: function() {
							$(this).find("form").submit();
						}
					},
					{
						text: lang['common']['close'],
						click: function() {
							$("#" + dialog_id).remove();
						}
					}
				]
			});
		}
	}

	$.quicklyShowReturnService = function(index, obj, action, is_factory,module,state_id) {//add module by lxt 2015.08.30
		if (index <= 0) {
			index	= $(obj).parents('tr:first').attr('index');
		}
		var module			   = module?module:'ReturnSaleOrder';//调用模块	add by lxt 2015.08.30
		var height		       = 350;
		var width	           = 750;
		var factory_id			=	$.cParseInt($dom.find("#factory_id2").val());//卖家id		add by lxt 2015.09.09
		var state_id			=	$.cParseInt($dom.find("#return_sale_order_state").val());
		var big_obj			   = $(obj).parents('tr:first');
		var return_service_obj = big_obj.find('#return_service');
		//add selector by lxt 2015.08.30
		if(action=='view'){
			var selector	=	module=='ReturnSaleOrder'?'#span_quantity':'#span_in_quantity';
			var quantity	   = $.cParseInt(big_obj.find(selector).attr('span_quantity'));
			var product_id	   = $.cParseInt(big_obj.find('#span_product').attr('span_product'));
		}else{
			var selector	=	module=='ReturnSaleOrder'?'#quantity':'#in_quantity';
			var quantity	   = $.cParseInt(big_obj.find(selector).val()) || $.cParseInt(big_obj.find('#span_quantity').attr('span_quantity'));
			var product_id	   = $.cParseInt(big_obj.find('#product_id').val());
		}
		var return_service_val = return_service_obj.val();
		var show_flag		   = (action=='add'||(action=='edit'&&is_factory=='1')) ? true : false;
		if(show_flag){
			var notice		   = '';
			if(product_id <= 0){
				notice += lang['common']['sku']+'<br>';
			}
			if(quantity <= 0 && state_id!=4){ //add by yyh 20151016处理完成修改金额
				notice += lang['common']['return_quantity']+'<br>';
			}
			if(notice){
				noticeInfo(notice);
				return false;
			}
		}
		if (product_id >0 && quantity > 0 && index > 0) {
			$("<div id='dialog-show_return_service'></div>").remove();
			var button_object  = [
                {
                    text: lang['common']['close'],
                    click: function() {
                        $("#dialog-show_return_service").remove();
						$( this ).dialog( "close" );
					}
                }
			];
			if(show_flag){
				button_object  = [{
						text: lang['common']['submit'],
						click: function() {
							var return_service_list	 = $('#return_service_list');
							var selected			 = $('#return_service_list input:checked');
							var oft					 = $("#dialog-show_return_service").offset();

							if (selected.length < 1) {
								var msg  = [{"name":"type_0[]","value":lang['common']['select_one']}];
								validity(msg, $(this), '.table_autoshow_return', 0, oft.left + 20);
								return false;
							}else{
								var returnArr = [],josnArr  = [];
								if (selected.length) {
									selected.each(function(){
										var select_split = $(this).attr('id').split("_");
										var select_index = parseInt(select_split[1]);
										var selected_value		  = $.cParseInt($(this).val());
										if(selected_value>0){
											var tmp_obj           = $(this).parent().parent();
											var r_quantity        = tmp_obj.find('#r_quantity_'+select_index).val();
											var r_price	          = tmp_obj.find('#r_price_'+select_index).val();
                                            var edit_flag         = tmp_obj.find('#r_price_'+select_index).attr('readonly');
											var flag			  = true;
										    if(r_quantity == "" || r_quantity == undefined) {
												var josnList      = {};
												josnList['name']  = 'r_quantity_'+select_index;
												josnList['value'] = lang['common']['require'];
												josnArr.push(josnList);
												flag			  = false;
										    }
											if(r_quantity&&!(/^[1-9]+\d*$/i.test(r_quantity))) {
												var josnList      = {};
												josnList['name']  = 'r_quantity_'+select_index;
												josnList['value'] = lang['common']['pst_integer'];
												josnArr.push(josnList);
												flag			  = false;
											}
                                            if( edit_flag == undefined){
                                                if(r_price == "" || r_price == undefined) {
                                                    var josnList      = {};
                                                    josnList['name']  = 'r_price_'+select_index;
                                                    josnList['value'] = lang['common']['require'];
                                                    josnArr.push(josnList);
                                                    flag			  = false;
                                                }
                                                if(r_price&&!(/^\d+(\.\d+)?$/i.test(r_price))) {
                                                    var josnList      = {};
                                                    josnList['name']  = 'r_price_'+select_index;
                                                    josnList['value'] = lang['common']['valid_money'];
                                                    josnArr.push(josnList);
                                                    flag			  = false;
                                                }
                                            }
											
											if(flag){
												var dataList      = {};
												dataList[0]		  = $(this).val();
												dataList[1]		  = r_quantity;
												dataList[2]		  = r_price;
												returnArr.push(dataList);
											}
										}
									});
								}
								if(josnArr.length>0){
									validity(josnArr, $(this), '.table_autoshow_return', 0, oft.left);
									return false;
								}else{
									return_service_obj.val('');
								        return_service_obj.val(JSON.stringify(returnArr));
									$.ajax({
										type: "POST",
										url: APP + "/Ajax/getReturnServiceNo",
										data:{service:returnArr},
										success: function(data){
										    big_obj.find('#ft').html(data);
										    big_obj.find('#icon').removeClass();
										}
										});
															       }
											   $dom.find("#is_edit_service").val('1');
							}
							$("#dialog-show_return_service").remove();
							$( this ).dialog( "close" );
							$.removeLoading();
						}
					},
					{
						text: lang['common']['reset'],
						click: function() {
							document.getElementById("form_id").reset();
						}
					},
					{
						text: lang['common']['close'],
						click: function() {
							$( this ).dialog( "close" );
							$("#dialog-show_return_service").remove();
						}
					}];
			}
			$("#dialog-show_return_service").remove();
			$("<div id='dialog-show_return_service'></div>").load(APP + '/QuicklyOperate/ReturnService',
				{index:          index,
				 action:         action,
				 return_service: return_service_val,
				 module:	module,
				 factory_id:factory_id,
				 state_id:state_id,
				 return_sale_order_id: action == 'view' ? 0 : (module=='ReturnSaleOrder' ? $dom.find('input[name=id]').val() : $dom.find('input[name=return_sale_order_id]').val())
				}
			).dialog({
				autoOpen:  true,
				resizable: false,
				height:    height,
				width:     width,
				modal:     true,
				buttons:   button_object
			});
		}
	}
    $.getApiToken= function(id) {
            $.ajax({
                type: "POST",
                url: APP + "/Ajax/getApiToken/id/"+id,
				cache: false,
				success: function(data){
						$dom.find("#auth_token").val(data);
                        alert(lang['common']['apply_api_prompt']);
				}
			});
    }
    $.checkRepeat = function(obj){
        var import_key          = $dom.find("input[name='import_key']").val();
        var file_name           = $dom.find("input[name='file_name']").val();
        var sheet               = $dom.find("input[name='sheet']").val();
        var warehouse_id        = $dom.find("input[name='warehouse_id']").val();
        if(file_name != '' && warehouse_id !=''){
            $.getJSON(APP+'/InstockImport/checkRepeat',{import_key:import_key,file_name:file_name,sheet:sheet,warehouse_id:warehouse_id}, function(data) {
                if(data.status== 1){
                    $("#dialog_reqeat").dialog("destroy");
                    $("<div id='dialog_reqeat'>"+data.info+"</div>").dialog({
                        resizable: false,
                        modal: true,
                        buttons: {
                            "是": function() {
                                $(this).dialog("close");
                                $dom.find('#s_key').val(data.key);
                                $(obj.form).submit();
                            },
                            "否": function() {
                                $(this).dialog("close");
                            }
                        }
                    });
                }else{
                    $dom.find('#s_key').val(data.key);
                    $(obj.form).submit();
                }
        });
        }else{
            $(obj.form).submit();
        }
    }
    /**
     * 快速编辑订单地址
     * @param {type} module
     * @param {type} id
     * @param {type} state
     * @returns {undefined}
     */
    $.quicklyEditAddress = function(module,id){
		var load_url = '/QuicklyOperate/editAddress/module/'+module+'/id/'+id;
        $("#dialog-edit_address").remove();
        $('<div id="dialog-edit_address"></div>').load(APP + load_url, function() {
            var quick_dom = $(this);
            $(this).find("form").sendForm({"dataType": "json", "success": function(result) {
                    if (result.status == 1) {
                        $("#dialog-edit_address").dialog("destroy");
                        $("#tips").html(result.info).fadeIn().delay(100).fadeOut(200, function (){
                                $dom.find('#search_form').submit();
                            });
                    } else if (result.status == 2) {
                        var oft = $("#dialog-edit_address").offset();
                        validity(result.info, quick_dom, '.table_autoshow', 0, oft.left);
                    } else {
                        $("<div>" + result.info + "</div>").dialog({
                            modal: true,
                            resizable: false,
                            buttons: {
                                Ok: function() {
                                    $(this).remove();
                                }
                            }
                        });
                    }
					$.removeLoading();
                }});
            $(this).find("input[jqac]").each(function() {
                $(this).initAutocomplete();
            });
            $(this).find("select[combobox]").each(function() {
                $(this).combobox();
            });
        }).dialog({
            autoOpen: true,
            resizable: false,
            draggable: false,
            height: 470,
            width: 500,
            modal: true,
            buttons: [
                {
                    text: lang['common']['submit'],
                    click: function() {
                        $(this).find("form").submit();
//					$(this).dialog("close");
                    }
                },
                {
                    text: lang['common']['close'],
                    click: function() {
                        $("#dialog-edit_address").remove();
                    }
                }
            ]
        });
    }
    $.printSaleOrderAddition = function(id) {
//		getSystemInfo('NetworkAdapter.1.PhysicalAddress',$(document).find('#mac_address'));
		var mac_address	= $(document).find('#mac_address').val();
		$.ajax({
			url: APP + "/Ajax/printSaleOrderAddition/id/"+id+'/mac_address/'+mac_address,
			cache: false,
			dataType:'json',
			success: function(result){
				if(result.error){
					if(result.error=='-1'){
						$("<div>"+lang['common']['gls_api_reprint_error']+"</div>").dialog({
							modal: true,
							resizable: false,
							buttons: {
								"是": function() {
									$(this).remove();
									$.printGlsWaybill(id,mac_address);
								},
								"否": function() {
									$(this).remove();
								}
							}
						});
					}else{
						if(result.error!='1'){
							$("<div>" + result.error + "</div>").dialog({
								modal: true,
								resizable: false,
								buttons: {
									Ok: function() {
										$(this).remove();
									}
								}
							});
						}
					}
				}else{
					if (result.pdf) {
						window.open(result.pdf);
					} else {
						printSaleOrder(result.info, result.size.width, result.size.height,true,result.size.is_it_nexive);
					}
				}
			}
		});
    }

    $.printPackBoxAddition = function(id) {
            $.ajax({
                url: APP + "/Ajax/printPackBoxAddition/id/"+id,
                cache: false,
                dataType:'json',
				success: function(result){
					printSaleOrder(result.info, result.size.width, result.size.height,true,result.size.is_it_nexive);
				}
			});
    }
    //打印退货物流单号		add by lxt 2015.09.11
    $.printReturnLogisticsNo = function(id) {
        $.ajax({
            url: APP + "/Ajax/printReturnLogisticsNo/id/"+id,
            cache: false,
            dataType:'json',
			success: function(result){
				printSaleOrder(result.info, result.size.width, result.size.height,true,result.size.is_it_nexive);
			}
		});
    }

    $.printOutBatchAddition = function(id) {
            $.ajax({
                url: APP + "/Ajax/printOutBatchAddition/id/"+id,
                cache: false,
                dataType:'json',
				success: function(result){
					printSaleOrder(result.info, result.size.width, result.size.height,true,result.size.is_it_nexive);
				}
			});
    }

	//打印gls运单 add wyl 20170302
    $.printGlsWaybill = function(id,mac_address) {
        $.ajax({
			url: APP + "/Ajax/printGlsWaybill/id/"+id+'/mac_address/'+mac_address,
			cache: false,
			dataType:'json',
			success: function(result){
				if(result.error!="1"){
					$("<div>" + result.error + "</div>").dialog({
						modal: true,
						resizable: false,
						buttons: {
							Ok: function() {
								$(this).remove();
							}
						}
					});
				}
			}
		});
    }
    //打印运单 add yyh 20160301
    $.printWaybill = function(id) {
		if (typeof(id) == 'undefined') {
			id  = $dom.find('#id').val();
		}
        $.ajax({
            url: APP + "/Ajax/printWaybill/id/"+id,
            cache: false,
            dataType:'json',
            success: function(result){
				printSaleOrder(result.info, result.size.width, result.size.height,true,result.size.is_it_nexive);
            }
        });
    }

    $.printProductBarcode = function(id) {
            $.ajax({
                url: APP + "/Ajax/printProductBarcode/id/"+id,
                cache: false,
                dataType:'json',
				success: function(result){
					printSaleOrder(result.info, result.size.width, result.size.height,true,result.size.is_it_nexive);
				}
			});
    }
    $.batchPrintProductBarcode = function(id,quantity) {
            $.ajax({
                url: APP + "/Ajax/batchPrintProductBarcode/id/"+id+'/quantity/'+quantity,
                cache: false,
                dataType:'json',
				success: function(result){
					printSaleOrder(result.info, result.size.width, result.size.height,true,result.size.is_it_nexive);
				}
			});
    }

    $.ButtenCheck   = function(obj){
        var class_name  = $(obj).attr('class');
        if(class_name   == 'icon icon-pattern-nocheck'){
            $(obj).removeClass().addClass('icon icon-pattern-check');
        }else{
            $(obj).removeClass().addClass('icon icon-pattern-nocheck');
        }
    }

     /**
	 * 重新上架库位
	 * @author yyh 20150715
	 * @param {int} id
	 */
    $.showBackShelvesLocation = function(id) {
		if (id > 0) {
			var dialog_id	= 'dialog-back_shelves';
			$("#" + dialog_id).remove();
			var load_url = APP + '/QuicklyOperate/backShelves/id/'+id;
			$('<div id="' + dialog_id + '"></div>').load(load_url, function() {
				var quick_dom		= $(this);
				var form_dom		= $(quick_dom).find('form');
				var options		= {
					"dataType":"json",
					"success": function(result, statusText, xhr, $form) {
                        if (result.status == 1) {
						$("#" + dialog_id).remove();
                        } else if (result.status == 2) {
							var oft = $("#" + dialog_id).offset();
							validity(result.info, quick_dom, '.table_autoshow', 0, oft.left);
						} else {
							$("<div>" + result.info + "</div>").dialog({
								modal: true,
								resizable: false,
								buttons: {
									Ok: function() {
										$(this).remove();
									}
								}
							});
						}
                        $.removeLoading();
                    }
				};
			}).dialog({
				autoOpen: true,
				resizable: false,
				draggable: false,
				width: 400,
				height:300,
				modal: true,
				title:lang['common']['back_shelves'],
				buttons: [
					{
						text: lang['common']['close'],
						click: function() {
							$("#" + dialog_id).remove();
						}
					}
				]
			});
		}
	}

    $.setReviewWeight    = function(obj,id){
		var state   = $(obj).parents('tr').find('#state').val();
        var old_review_weight = $(obj).parents('tr').find('#review_weight').html();
		if (id > 0) {
			var dialog_id	= 'dialog-set_pack_state';
			$("#" + dialog_id).remove();
			var load_url = APP + '/QuicklyOperate/setReviewWeight';
			$('<div id="' + dialog_id + '"></div>').load(load_url,{id:id,state:state}, function() {
				var quick_dom		= $(this);
				var form_dom		= $(quick_dom).find('form');
				var options		= {
					"dataType":"json",
					"success": function(result, statusText, xhr, $form) {
                        $("<div>" + result.info + "</div>").dialog({
                            modal: true,
                            resizable: false,
                            buttons: {
                                Ok: function() {
                                    $(this).remove();
                                }
                            }
                        });
						$.removeLoading();
					}
				};
				$(form_dom).sendForm(options);
				$(quick_dom).find("input[jqac]").each(function() {
					$(this).initAutocomplete();
				});
                $(this).find("select[combobox]").each(function() {
                    $(this).combobox();
                });
			}).dialog({
				autoOpen: true,
				resizable: false,
				draggable: false,
				width: 400,
				height: 300,
				modal: true,
				title:'',
				buttons: [
					{
						text: lang['common']['submit'],
						click: function() {
                                var returnArr   = [],return_id = 0,state_count=0,state = 0,is_first=0,last_state=0,state_name='';
                                $('#detail_review_weight_table').find('input[name*="review_weight]"]').each(function(){
                                    if(is_first >0){//过滤第一条空数据
                                        state   = $(this).val();
                                        if(state > 0){
                                            return_id   = $(this).parents('tr:first').find('#return_sale_order_id').val();
                                            var josnArr  = []
                                            josnArr[0]  = return_id;
                                            josnArr[1]  = state;
                                            last_state  += Number(state);
                                            returnArr.push(josnArr);
                                        }
                                    }
                                    is_first++;
                                });
                                $(obj).parents('tr:first').find('#review_weight').html(last_state);
                                var total   = $.cParseFloat($dom.find("tr:last").find("td:eq(4)").html());
                                $dom.find("tr:last").find("td:eq(4)").html(total+Number(last_state)-Number(old_review_weight));

                                $(obj).parents('tr:first').find('#review_weight').html();
                                $(obj).parents('tr').find('#state').val(JSON.stringify(returnArr));
                                $("#" + dialog_id).remove();
						}
					},
					{
						text: lang['common']['close'],
						click: function() {
							$("#" + dialog_id).remove();
						}
					}
				]
			});
		}
    }
    $.setCustomsClearanceState    = function(obj,id){
        var customs_clearance_state   = $(obj).parents('tr').find('input[name*="customs_clearance_state]"]').val();
		var state   = $(obj).parents('tr').find('#state').val();
		if (id > 0) {
			var dialog_id	= 'dialog-set_pack_state';
			$("#" + dialog_id).remove();
			var load_url = APP + '/QuicklyOperate/setCustomsClearanceState';
			$('<div id="' + dialog_id + '"></div>').load(load_url,{id:id,customs_clearance_state:customs_clearance_state,state:state}, function() {
				var quick_dom		= $(this);
				var form_dom		= $(quick_dom).find('form');
				var options		= {
					"dataType":"json",
					"success": function(result, statusText, xhr, $form) {
                        $("<div>" + result.info + "</div>").dialog({
                            modal: true,
                            resizable: false,
                            buttons: {
                                Ok: function() {
                                    $(this).remove();
                                }
                            }
                        });
						$.removeLoading();
					}
				};
				$(form_dom).sendForm(options);
				$(quick_dom).find("input[jqac]").each(function() {
					$(this).initAutocomplete();
				});
                $(this).find("select[combobox]").each(function() {
                    $(this).combobox();
                });
			}).dialog({
				autoOpen: true,
				resizable: false,
				draggable: false,
				width: 400,
				height: 300,
				modal: true,
				title:'',
				buttons: [
					{
						text: lang['common']['submit'],
						click: function() {
                                var returnArr   = [],return_id = 0,state_count=0,state = 0,is_first=0,last_state=-1,state_name='';
                                $('#detail_customs_clearance_table').find('select[name*="customs_clearance_state]"]').each(function(){
                                    if(is_first >0){//过滤第一条空数据
                                        state   = $(this).val();
                                        if(state > 0){
                                            return_id   = $(this).parents('tr:first').find('#return_sale_order_id').val();
                                            var josnArr  = []
                                            josnArr[0]  = return_id;
                                            josnArr[1]  = state;
                                            returnArr.push(josnArr);
                                        }
                                        if(last_state>=0){
                                            if(last_state != state){
                                                state_count++;
                                            }
                                        }else{
                                            last_state  = state;
                                        }
                                    }
                                    is_first++;
                                });
                                if(returnArr.length == 1){
                                    $(obj).parents('tr').find('#customs_clearance_state').val('');
                                }

                                if(state_count > 0){
                                    $(obj).parents('tr:first').find('input[name*="customs_clearance_state_name]"]').val('');
                                    $(obj).parents('tr:first').find('input[name*="customs_clearance_state]"]').val('');
                                }else{
                                    $(obj).parents('tr:first').find('input[name*="customs_clearance_state]"]').val(last_state);
                                    switch(last_state){
                                        case '1':
                                            state_name  = lang['batch']['reporting_discrepancies'];
                                            break;
                                        case '2':
                                            state_name  = lang['batch']['customs_seized'];
                                            break;
                                        default:
                                            state_name  = lang['common']['normal'];
                                            break;
                                    }
                                    $(obj).parents('tr:first').find('input[name*="customs_clearance_state_name]"]').val(state_name);
                                }

                                $(obj).parents('tr').find('#state').val(JSON.stringify(returnArr));
                                $("#" + dialog_id).remove();
						}
					},
					{
						text: lang['common']['close'],
						click: function() {
							$("#" + dialog_id).remove();
						}
					}
				]
			});
		}
    }


    $.setAssociateWithState    = function(obj,id){
        var associate_with_state    = $(obj).parents('tr').find('input[name*="associate_with_state]"]').val();
		var state   = $(obj).parents('tr').find('#state').val();
		if (id > 0) {
			var dialog_id	= 'dialog-set_pack_state';
			$("#" + dialog_id).remove();
			var load_url = APP + '/QuicklyOperate/setAssociateWithState';
			$('<div id="' + dialog_id + '"></div>').load(load_url,{id:id,associate_with_state:associate_with_state,state:state}, function() {
				var quick_dom		= $(this);
				var form_dom		= $(quick_dom).find('form');
				var options		= {
					"dataType":"json",
					"success": function(result, statusText, xhr, $form) {
                        $("<div>" + result.info + "</div>").dialog({
                            modal: true,
                            resizable: false,
                            buttons: {
                                Ok: function() {
                                    $(this).remove();
                                }
                            }
                        });
						$.removeLoading();
					}
				};
				$(form_dom).sendForm(options);
				$(quick_dom).find("input[jqac]").each(function() {
					$(this).initAutocomplete();
				});
                $(this).find("select[combobox]").each(function() {
                    $(this).combobox();
                });
			}).dialog({
				autoOpen: true,
				resizable: false,
				draggable: false,
				width: 400,
				height: 300,
				modal: true,
				title:'',
				buttons: [
					{
						text: lang['common']['submit'],
						click: function() {
                                var returnArr   = [],return_id = 0,state_count=0,state = 0,is_abnormity=false;
                                $('#detail_associate_with_table').find('select[name*="associate_with_state]"]').each(function(){
                                    state   = $(this).val();
                                    if(state > 0){
                                        var josnArr  = []
                                        return_id   = $(this).parents('tr:first').find('#return_sale_order_id').val();
                                        josnArr[0]  = return_id;
                                        josnArr[1]  = state;
                                        returnArr.push(josnArr);
                                        is_abnormity    = true;
                                    }
                                });

                                if(returnArr.length == 1){
                                    $(obj).parents('tr').find('#associate_with_state').val('');
                                }
                                var state_id = 0 , state_name = lang['common']['normal'];
                                if(is_abnormity){
                                    state_id    = 1;
                                    state_name  = lang['batch']['abnormal'];
                                }
                                $(obj).parents('tr:first').find('input[name*="associate_with_state_name]"]').val(state_name);
                                $(obj).parents('tr:first').find('input[name*="associate_with_state]"]').val(state_id);

                                $(obj).parents('tr').find('#state').val(JSON.stringify(returnArr));
                                $("#" + dialog_id).remove();
						}
					},
					{
						text: lang['common']['close'],
						click: function() {
							$("#" + dialog_id).remove();
						}
					}
				]
			});
		}
    }
    //批量上传
    $.batchUpload   = function () {
        $("#dialog-batch_upload").remove();
        $('<div id="dialog-batch_upload"></div>').load(APP + '/QuicklyOperate/batchUpload', function() {
            $(this).find("form").sendForm({
                "dataType": "json",
                "success": function() {
                    $.removeLoading();
                }
            });
            $(this).find("input[jqac]").each(function() {
                $(this).initAutocomplete();
            });
            $(this).find("select[combobox]").each(function() {
                $(this).combobox();
            });
        }).dialog({
            autoOpen: true,
            resizable: false,
            draggable: false,
            height: 300,
            width: 450,
            title:lang['common']['batch_upload'],
            modal: true,
            buttons: [
                {
                    text: "上传",
                    click: function() {
                       $(this).find("form").submit();
                       $(this).find('input[name="file_token"]').val(getRandomString());
                       $(this).find('input[name="sale_order_id"]').val('');
                       $(this).find('input[name="sale_order_no"]').val('');
                       $(this).find('#file_uploadQueue').html('');
                    }
                },
                {
                    text: lang['common']['close'],
                    click: function() {
                        $("#dialog-batch_upload").remove();
                    }
                }
            ]
        });
    }

    //退货入库列表拣货单导出		add by lxt 2015.09.22
    $.quicklyExportReturnStorage = function() {
    	var dialog_id	=	'dialog-export_piking';
    	$('#'+dialog_id).remove();
    	var load_url	=	APP+'/QuicklyOperate/pikingExport/';
    	$('<div id="'+dialog_id+'"></div>').load(load_url,function(result,status){
    		if(status=="success"){
    			$(this).find("select[combobox]").each(function() {
                    $(this).combobox();
                });
    			$(this).find("input[jqac]").each(function() {
					$(this).initAutocomplete();
				});
    			$(this).find("#service_detail_id").trigger("change");
    		}
    	}).dialog({
			autoOpen: true,
			resizable: false,
			draggable: false,
			width: 600,
			height: 385,
			modal: true,
			title:lang['common']['query_info_require'],
			buttons: [
				{
					text: lang['common']['submit'],
					click: function() {
						var is_aliexpress			=	$.cParseInt($(this).find("[name=is_aliexpress]:checked").val());
						var	service_detail_id		=	$.cParseInt($(this).find("#service_detail_id").val());
						var	return_sale_order_state	=	$.cParseInt($(this).find("#return_sale_order_state").val());
						var warehouse_id			=	$.cParseInt($(this).find("#warehouse_id").val());
						var data					=	{
								is_aliexpress			:	is_aliexpress,
								service_detail_id		:	service_detail_id,
								return_sale_order_state	:	return_sale_order_state,
								warehouse_id			:	warehouse_id
							};
						$.ajax({
							data		:	data,
							dataType	:	'json',
							type		:	'post',
							url			:	APP+'/Ajax/setPikingExport',
							success		:	function(result){
								if(result.state){
									var piking_rand	=	result.rand;
									var src			=	APP+"/Ajax/outPutExcel/state/pikingExport/piking_rand/"+piking_rand;
									var iframe		= $("<iframe style='display:none' name='iframe' src="+src+"></iframe>");
									$dom.find('iframe[name="iframe"]').remove();
									$dom.find('#search_form').append(iframe);
									$("#" + dialog_id).remove();
								}
							}
						});
					}
				},
				{
					text: lang['common']['close'],
					click: function() {
						$("#" + dialog_id).remove();
					}
				}
			]
		});

	}
    $.sentEmail = function(id,email_address) {
        var post_data					=	{
            object_id : id,
            email_address : email_address
        };
        $.ajax({
            type: "POST",
            url: APP + "/Ajax/sentEmail",
            data: post_data,
            dataType: "json",
            cache: false,           
            success: function(result) {     
                var buttons = {
                            Ok: function() {
                                $(this).remove();
                            }                          
                        };
                var dialog_value= lang['common']['sent_success'];
                if(result.state != true){
                    buttons.resend  = function() {                            
                            $(this).remove();
                            $.sentEmail(result.object_id,result.email_address);
                        };
                        dialog_value= lang['common']['sent_email_defaut']+result.abnormal_output;     
                }
                $("#dialog-sent_success").dialog("destroy");
                $("<div>"+ dialog_value+"</div>").dialog({
                    modal: true,
                    resizable: false,
                    buttons: buttons
                });
            }
        });
    }

	//发布信息
	$.messageAnnounced = function(id) {
        $.ajax({
            type: "POST",
            url: APP + "/Ajax/messageAnnounced",
            data: "id=" + id,
            dataType: "text",
            cache: false,
            success: function(result) {
                if(result==1){
			    $("#dialog-sent_success").dialog("destroy");
                    $("<div id='dialog-sent_success'> "+ lang['common']['message_announced_success']+"</div>").dialog({
                        modal: true,
                        resizable: false,
                        buttons: {
                            Ok: function() {
                                $(this).remove();
								$dom.find('#search_form').submit();
                            }
                        }
                    });				
                }else{
                    $("#dialog-sent_success").dialog("destroy");
                    $("<div  id='dialog-sent_success'>"+ lang['common']['sent_defaut']+"</div>").dialog({
                        modal: true,
                        resizable: false,
                        buttons: {
                            Ok: function() {
                                $(this).remove();

                            }
                        }
                    });
                }
            }
		});
	}


    //出库批次
    $.setPostSection    = function(obj,id){
		var post_section   = $(obj).parents('tr').find('#post_section').val();
        var dialog_id	= 'dialog-set_post_section';
        $("#" + dialog_id).remove();
        var load_url = APP + '/QuicklyOperate/setPostSection';
        $('<div id="' + dialog_id + '"></div>').load(load_url,{id:id,post_section:post_section}, function() {
            var quick_dom		= $(this);
            var form_dom		= $(quick_dom).find('form');
            var options		= {
                "dataType":"json",
                "success": function(result, statusText, xhr, $form) {
						if (result.status == 1) {
                            var returnArr   = [],post_english = 0,post_begin = 0,post_end = 0;
                            $('#detail_post_section_table').find('input[name*="english]"]').each(function(){
                                var josnArr  = [];
                                post_english    = $(this).val();
                                post_begin      = $(this).parents('tr:first').find('#post_begin').val();
                                post_end        = $(this).parents('tr:first').find('#post_end').val();
                                if(post_end != '' || post_begin != '' ||post_english != ''){
                                    josnArr[0]      = post_english;
                                    josnArr[1]      = post_begin;
                                    josnArr[2]      = post_end;
                                    returnArr.push(josnArr);
                                }
                            });
                            if(returnArr.length == 0){
                                var josnArr  = [];
                                josnArr[0]      = post_english;
                                josnArr[1]      = post_begin;
                                josnArr[2]      = post_end;
                                returnArr.push(josnArr);
                            }
                            $(obj).parents('tr').find('#post_section').val(JSON.stringify(returnArr));
							$("#" + dialog_id).dialog("destroy");
						} else if (result.status == 2) {
							var oft = $("#" + dialog_id).offset();
							validity(result.info, quick_dom, '.table_autoshow', 0, oft.left);
						} else {
							$("<div>" + result.info + "</div>").dialog({
								modal: true,
								resizable: false,
								buttons: {
									Ok: function() {
										$(this).remove();
									}
								}
							});
						}
						$.removeLoading();
					}
				};
				$(form_dom).sendForm(options);
				$(quick_dom).find("input[jqac]").each(function() {
					$(this).initAutocomplete();
				});
        }).dialog({
            autoOpen: true,
            resizable: false,
            draggable: false,
            width: 450,
            height: 300,
            modal: true,
            title:'',
            buttons: [
                {
                    text: lang['common']['submit'],
                    click: function() {
                        $(this).find("form").submit();
                    }
                },
                {
                    text: lang['common']['close'],
                    click: function() {
                        $("#" + dialog_id).remove();
                    }
                }
            ]
        });
    }
        
    $.setInsurePrice    = function(id){
        var dialog_id	= 'dialog-set_insure_price';
        $("#" + dialog_id).remove();
        var load_url = APP + '/QuicklyOperate/setInsurePrice';
        $('<div id="' + dialog_id + '"></div>').load(load_url,{id:id}, function() {
            $(this).find("form").sendForm({
                "dataType": "json", 
                "success": function() {
                    $.removeLoading();
                }
            });
        }).dialog({
            autoOpen: true,
            resizable: false,
            draggable: false,
            width: 300,
            height: 100,
            modal: true,
            title:lang['common']['edit_insure_price'],
            buttons: [
                {
                    text: lang['common']['submit'],
                    click: function() {
                        $(this).find("form").submit();
                        $("#" + dialog_id).remove();
                    }
                },
                {
                    text: lang['common']['close'],
                    click: function() {
                        $("#" + dialog_id).remove();
                    }
                }
            ]
        });
    }
    //复制
    $.addGlsConfig = function(obj) {
        var index   = $(obj).parents('tr:first').attr('index');
        $.ajax({
            type: "POST",
            url: APP + "/Ajax/addGlsConfig",
            data: "index=" + index,
            dataType: "text",
            cache: false,
            success: function(html) {
                $dom.find('.add_table tr:last').after(html);
                $dom.find("input[jqac]").each(function() {
                    $(this).initAutocomplete();
                });
            }
        });
    }
})(jQuery);