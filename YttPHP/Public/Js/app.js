/**
产品
**/
function getParentProductClass(v,i){
	$.get(APP+'/Ajax/getParentProductClass/id/'+i,function(data){
		data && $dom.find("#parent_info").html(lang['basic']['class_parent']+data)
	})
}

function sumBag(obj){
	if(obj){
		var dom = $(obj).parents("form:first");
	}else{
		var dom = $dom;
	}
	if(dom.find("#dozen").length<=0) return;
	var c = parseInt(dom.find("#capability").val());
	var d = parseInt(dom.find("#dozen").val());
	if(isNaN(c)) c = 0;
	if(isNaN(d)) d = 0;
	if(c/d=='Infinity'){
		dom.find("#p_s_3").val('');
		return;
	}
	var bag = c/d;
	if(isNaN(bag) || bag==0) bag = '';
	dom.find("#p_s_3").val(bag);
}

function sumQuantity(obj){
	var row = $(obj).attr('row');
	var cols = $(obj).attr('cols');
	var row_quantity = 0;
	var cols_quantity = 0;
	var fit = $dom.find("#fit");
	fit.find("input[row='"+row+"']").each(function(){
		row_quantity += isNaN(parseInt(this.value)) ? 0 : parseInt(this.value);
	})
	fit.find("#total_row"+row).html(row_quantity);

	fit.find("input[cols='"+cols+"']").each(function(){
		cols_quantity += isNaN(parseInt(this.value)) ? 0 : parseInt(this.value);
	})
	fit.find("#total_cols"+cols).html(cols_quantity);
	var all_quantity = 0;
	fit.find("td[id^='total_row']").each(function(){
		all_quantity += isNaN(parseInt(this.innerHTML)) ? 0 : parseInt(this.innerHTML);
	});
	fit.find("#all_total").html(all_quantity);
}

function setBgColor(obj){
	var row = $(obj).attr('rowindex');
	var cols = $(obj).attr('colsindex');
	var fit = $dom.find("#fit");
	fit.find("td").removeClass("selected_color");
	fit.find("td[rowindex=1][colsindex="+cols+"]").addClass("selected_color");
	fit.find("td[rowindex="+row+"][colsindex=1]").addClass("selected_color");
	$dom.find(obj).addClass("selected_color");
}

function clearBgColor(){
	$("#fit").find("td").removeClass("selected_color");
}
/*角色使用 开始*/
function selectCheckbox(obj,id) {
	if(id){
		if($(obj).attr('checked')=='checked'){
			$dom.find("#"+id+" input:checkbox").attr('checked', true);
		}else{
			$dom.find("#"+id+" input:checkbox").attr('checked', false);
		}
	}
	//setParentCheckbox(obj);
};
function setParentCheckbox(obj){
	var parent_id = $dom.find(obj).attr('parent');
	if(parent_id){
		var i = 0;
		$dom.find("#"+parent_id+" input[type='checkbox']").each(function(){
			if($(this).attr("checked")){
				i++;
			}
		});
		var parent_obj = $dom.find("#"+parent_id+" input[type='checkbox']:first");
		if(i>0){
			if(i==1 && parent_obj.attr("checked")){
				parent_obj.attr("checked",false);
				if(parent_obj.attr('parent')){
					$.setParentCheckbox(parent_obj);
				}
				return;
			}
			parent_obj.attr("checked",true);
		}else{
			parent_obj.attr("checked",false);
		}
		if(parent_obj.attr('parent')){
			setParentCheckbox(parent_obj);
		}
	}
};
function setSelectValue(obj,id) {
	$dom.find("#"+id+" select").val(obj.value);
};
/*角色使用 结束*/

/* 用户 开始 */
function setCompanyUrl(v){
	$dom.find("#company_id").val('');
	$dom.find("#company").val('');
	$dom.find("#role_id").val('');
	$dom.find("#role").val('');
	$dom.find("#belong_name").html(lang['basic']['belong_seller']);
	if(v>1){
		$dom.find("#company_tr").show();
		switch(v){
			case '4':
				$dom.find("#company").attr("url",$dom.find("#url_4").val()).initAutocomplete();
				$dom.find("#role").attr("url",$dom.find("#role_url_4").val()).initAutocomplete();
				break;
			case '5':
				$dom.find("#belong_name").html(lang['basic']['belong_warehouse']);
				$dom.find("#company").attr("url",$dom.find("#url_5").val()).initAutocomplete();
				$dom.find("#role").attr("url",$dom.find("#role_url_5").val()).initAutocomplete();
				break;
			default:
				$dom.find("#company").attr("url",$dom.find("#url_2").val()).initAutocomplete();
				$dom.find("#role").attr("url",$dom.find("#role_url_2").val()).initAutocomplete();
				break;
		}
	}else{
		$dom.find("#company_tr").hide();
		$dom.find("#role").attr("url",$dom.find("#role_url_1").val()).initAutocomplete();
	}
}
/* 用户 结束 */

/* 国家 开始 */
function getCity(obj,dom,city_id){
	if(dom){
		var self_dom = $("#"+dom);
	}else{
		var self_dom = $dom;
	}
	var     city_name_flag = self_dom.find('#city_name_flag').val();
	if(typeof city_name_flag != "undefined" && city_name_flag == 1){
		city_name_flag = 1;
	}else{
		city_name_flag = 0;
	}
	var country_id = $(obj).val();
	$.get(APP+'/Ajax/getCity',{id:country_id,city_id:city_id,city_name_flag:city_name_flag},function(data){
		self_dom.find("#city").html(data);
		self_dom.find("input[name='city_name']").initAutocomplete();
	});
};

/* 国家 结束 */


/* 订单 开始 */
function getOrderFacCur(obj){
	var tr_first = $(obj).parents("tr:first");
	if(!obj.value) {
		tr_first.find("#currency_id").val('');
		tr_first.find("#span_fac_name").html('');
		return;
	}
	var url = APP+'/Ajax/getOrderFacCur/id/'+obj.value;
	$.getJSON(url,function(data){
		tr_first.find("#currency_id").val(data.currency_id);
		tr_first.find("#span_fac_name").html(data.factory_name);
		tr_first.find("#factory_id").val(data.factory_id);
	});
	getDataByOrderId(obj);

};
/* 订单 结束 */
/* 退换货*/
function getReturnSaleType(obj){
if(obj.value==2){
		$dom.find("#show_sale_order_tr").show();
		$dom.find("#show_sale_order").show();
		$dom.find("#tr_barcode").show();
	}else{
		$dom.find("#show_sale_order_tr").hide();
		$dom.find("#show_sale_order").hide();
		$dom.find("#tr_barcode").hide();
	}
}

// 产品绑定厂家时获取产品输入框
function getProductNo(){
	var client_id	=	$dom.find("#client_id").val();
	var basic_id	=	$dom.find("#basic_id").val();
//	var currency_id	=	$("#currency_id").val();
	if(client_id>0 && basic_id>0){
		$.post(APP+"/Ajax/getReturnSaleProductNoInput",{client_id:client_id,basic_id:basic_id},function(data){
	        if (data != false) {
	        	$dom.find("#return_order_detail input[name*='product_no]']").each(function(){
	        		$(this).attr({'where':encodeURIComponent(data),'jqac':true});
	        		$(this).initAutocomplete();
	        	});
	        };
		});
	}
}

/* 退换货结束*/
/* 通过厂家获取改厂家的默认币种 */
function getFacCurrencyId(obj,type){
	var fac_id	= $(obj).val();
	var type	= type ? type : 1;
	if(fac_id>0){
		$.getJSON(APP+'/Ajax/getFacCurrencyId',{id:fac_id},function(data){
			if(type==1){
				$dom.find('#currency_id').val(data.id);
				$dom.find('#currency_id').next('span').find('input').val(data.no);
			}else{
				var parent	= $(obj).parent('td').parent('tr');
				$(parent).find('#currency_id').val(data.id);
				$(parent).find('#currency_id').next('span').find('input').val(data.no);
				$(parent).find('input[name*=product_id]').val('');
				$(parent).find('#span_product_name').html('');
				$(parent).find("input[name*='product_no]']").removeAttr("disabled").removeClass("disabled").val('').attr({'where':encodeURIComponent('factory_id='+fac_id),'jqac':true});
				$(parent).find("input[name*='product_no]']").initAutocomplete();
			}
		});
	}
}
/* 通过银行获取改厂家的默认币种 */
function getCurrencyIdByBank(obj, type){
    var prefix    = type ? type + '_' : '';
	var bank_id	= $(obj).val();
	if(bank_id>0){
		$.getJSON(APP+"/Ajax/getCurrencyIdByBank",{'bank_id':bank_id},function(data) {
			$dom.find('#' + prefix + 'currency').html(data.currency_name);
			$dom.find('#' + prefix + 'currency_id').val(data.currency_id);
            if (type === 'out') {
                prefix  = 'in_';
				$dom.find('#' + prefix + 'bank_id').val('');
				$dom.find('input[name*="' + prefix + 'account_name"]').val('').attr({'where':encodeURIComponent('currency_id!='+data.currency_id+' and id!='+bank_id),'jqac':true}).initAutocomplete();
                $dom.find('#' + prefix + 'currency').html('');
                $dom.find('#' + prefix + 'currency_id').val('');
            }
		});
	}
}
/* 选择现金 */
function getCurrencyIdComplete(){
	$dom.find('#currency').html('');
	$dom.find('#currency_id').val('');
	$dom.find('#currency_select').show();
}
/*同过产品获取产品名称和单价*/
function getProductInfo(obj){
	var p_id  	= $(obj).val();
	if(p_id>0){
		$.getJSON(APP+'/Ajax/getProductInfoById',{id:p_id},function(data){
			var tr_first = $(obj).parents("tr:first");
			tr_first.find("#span_product_name").html(data.product_name);
			tr_first.find("#price").val(data.dml_instock_price);
		});
	}
}



/*同过库位获取产品名称，数量和SKU*/
function getresultInfo (obj) {
    var id  = $(obj).val();
    if(id > 0){
        $dom.find('#select_product_show').load(APP+'/DomesticWaybill/selectProduct/' + $(obj).attr('id') + '/' + id);
    }
}


/* 装柜时根据订单获取订单的产品 */
function getOrderProduct(obj){
	var obj_parent  = $(obj).parent('td').parent('tr');
	var order_id 	= $(obj_parent).find('#order_id').val();
	var product_id 	= $(obj_parent).find('#product_id').val();
	var where;
	if(order_id>0){
		where = encodeURIComponent("orders_id="+order_id);
		var tr_first = $(obj).parents("tr:first").find("input[name*='product_no]']");
		tr_first.attr({'where':where,"jqac":true});
		tr_first.initAutocomplete();
	}else if(product_id>0){
		where = encodeURIComponent("product_id="+product_id);
		var tr_first = $(obj).parents("tr:first").find("input[name=order_no]");
		tr_first.attr({'where':where,"jqac":true,'url':APP+'/AutoComplete/orderNoByProduct'});
		tr_first.initAutocomplete();
	}
}
// 装柜明细中根据单号来查找装柜信息
//function getDataByOrderId(obj) {
//	getOrderProduct(obj);
//	var obj_parent  = $(obj).parent('td').parent('tr');
//	var p_id		= $(obj_parent).find('#product_id').val();
//	var order_id	= $(obj_parent).find('#order_id').val();
//	var color_id	= $(obj_parent).find('#color').val();
//	var size_id		= $(obj_parent).find('#size').val();
//	if(order_id>0 || p_id >0){
//		$.getJSON(APP+'/Ajax/getOrderDetails', {order_id:order_id,p_id:p_id,color_id:color_id,size_id:size_id}, function(data){
//			if (data[0] != null) {
//				var show_capbility	= data.show_capbility
//				data = data[0];
//				p_id>0 && $(obj_parent).find("#span_product_name").html(data.product_name);
//				var where_au	= '';
//				if(p_id>0){
//					where_au	= " product_id="+p_id;
//					order_id>0 && " and order_id="+order_id;
//					//颜色
//					var color_where = encodeURIComponent(where_au);
////					$(obj_parent).find("#color").val(data.color_id);
//					$(obj_parent).find("input[name=color_name]").attr({'where':color_where,'jqac':true,'url':$.U('/AutoComplete/orderProductColor')})/*.val(data.color_name)*/;
//					$(obj_parent).find("input[name=color_name]").initAutocomplete();
//					//尺码
////					$(obj_parent).find("#size").val(data.size_id+where_au);
//					$(obj_parent).find("input[name=size_name]").attr({'where':color_where,'jqac':true,'url':$.U('/AutoComplete/orderProductSize')})/*.val(data.size_name)*/;
//					$(obj_parent).find("input[name=size_name]").initAutocomplete();
//				}
//				//单价
//				$(obj_parent).find('#price').val(data.edml_price);
//				//规格
//				if(show_capbility>0){
//					$(obj_parent).find('#capability').val(data.order_capability);
//					$(obj_parent).find('#dozen').val(data.order_dozen);
//					$(obj_parent).find('#pieces').val(data.order_pieces);
//				}
//				$(obj_parent).find('#order_qn').html(data.edml_order_qn);
//				$(obj_parent).find('#unload_qn').html(data.edml_unload_quantity);
//			}else{
//				$(obj).val('');
//				$(obj).next().val('');
//			}
//		});
//
//	}
//}
// 装柜明细中根据产品号来获取颜色/尺码信息
	function getDataByIds(obj) {
		var obj_parent  = $(obj).parent('td').parent('tr');
		var order_id	= $(obj_parent).find('#order_id').val();
		var p_id		= $(obj_parent).find('#product_id').val();
		var obj_id		= $(obj).attr('id');
		var id			= $(obj).val();
		var color_id	= 0;
		var size_id		= 0;
		var param		= '';
		var index		= $(obj_parent).attr('index');
		if ((order_id > 0 || p_id > 0) && id > 0) {
			if (obj_id == 'order_id') {
					if(p_id > 0) { param = {'order_id':id,'p_id':p_id}} else {	param = {'order_id':id}};
			} else if (obj_id == 'product_id') { // 产品号
				$(obj_parent).find('#autoshow_img').attr('pid',id);
				if($(obj_parent).find('#order_no').val() != '' && order_id > 0) {
					param = {'order_id':order_id, 'p_id':id};
				} else {
					param = {'p_id':id};
				}
			}else if (obj_id == 'color') {  // 颜色
				param = {'order_id':order_id, 'p_id':p_id, 'color_id':id};
			}else if (obj_id == 'size') { // 尺码
				if ($(obj_parent).find("#color").length > 0) {
					param = {'order_id':order_id, 'p_id':p_id, 'color_id':$(obj_parent).find("#color").val(), 'size_id':id};
				} else {
					param = {'order_id':order_id, 'p_id':p_id, 'size_id':id};
				}
			}
			$.getJSON(APP+"/Ajax/getOrderDetails", param, function(data){
				if (data[0] != null) {
					var per_size 		= data.per_size;
					var weight   		= data.weight;
					var show_capbility	= data.show_capbility;
					var show_delivery	= data.show_delivery;
					var show_color		= data.show_color;
					var show_size		= data.show_size;
					data 				= data[0];
					p_id>0				&& $(obj_parent).find("#span_product_name").html(data.product_name);
					if(p_id>0 && order_id>0){
						where_au	= " product_id="+p_id+" and orders_id="+order_id;
					}else if(p_id>0){
						 where_au	= " product_id="+p_id;
					}else if(order_id>0){
						 where_au	= " orders_id="+order_id;
					}
					if(order_id>0){
						where = encodeURIComponent("orders_id="+order_id);
						$(obj_parent).find("input[name*='product_no]']").attr({'where':where,"jqac":true});
						$(obj_parent).find("input[name*='product_no]']").initAutocomplete();
					}
					$(obj_parent).find('#span_fac_name').html(data.factory_name);
					$(obj_parent).find("#currency_id").val(data.currency_id);
					$(obj_parent).find("#factory_id").val(data.factory_id);
					if(p_id>0){
						where = encodeURIComponent("product_id="+p_id+' and order_details.detail_state<3');
						$(obj_parent).find("input[name=order_no]").attr({'where':where,"jqac":true,'url':APP+'/AutoComplete/orderNoByProduct'});
						$(obj_parent).find("input[name=order_no]").initAutocomplete();
					}
					if(order_id>0 || p_id>0){
						var color_name = $(obj_parent).find("input[name=color_name]");
						if(show_color==2  && p_id>0 ){
							var color_where = encodeURIComponent("product_id="+p_id);
							$(obj_parent).find("#color").val(data.color_id);
							color_name.attr({'where':color_where,'jqac':true,'url':APP+'/AutoComplete/productColor'}).val(data.color_name);
							color_name.initAutocomplete();
						}else if(show_color==1 && (order_id>0 || p_id>0)){
							//颜色
							var color_where = encodeURIComponent(where_au);
							$(obj_parent).find("#color").val(data.color_id);
							color_name.attr({'where':color_where,'jqac':true,'url':APP+'/AutoComplete/orderProductColor'}).val(data.color_name);
							color_name.initAutocomplete();
						}else{
							color_name.attr({'jqac':true,'url':APP+'/AutoComplete/color'}).val(data.color_name);
							color_name.initAutocomplete();
						}
						var size_name = $(obj_parent).find("input[name=size_name]");
						if(show_size==2 && p_id>0){
							var color_where = encodeURIComponent("product_id="+p_id);
							$(obj_parent).find("#size").val(data.size_id);
							size_name.attr({'where':color_where,'jqac':true,'url':APP+'/AutoComplete/productSize'}).val(data.size_name);
							size_name.initAutocomplete();
						}else if(show_size==1  && (order_id>0 || p_id>0)){
							//尺码
							var color_where = encodeURIComponent(where_au);
							$(obj_parent).find("#size").val(data.size_id);
							size_name.attr({'where':color_where,'jqac':true,'url':'/AutoComplete/orderProductSize'}).val(data.size_name);
							size_name.initAutocomplete();
						}else{
							size_name.attr({'jqac':true,'url':APP+'/AutoComplete/size'}).val(data.size_name);
							size_name.initAutocomplete();
						}
					}
					//单价
					$(obj_parent).find('#price').val(data.edml_price);
					//规格
					if(show_capbility>0){
						$(obj_parent).find('input[name*=capability]').val(data.order_capability);
						$(obj_parent).find('input[name*=dozen]').val(data.order_dozen);
					}
					$(obj_parent).find('#order_qn').html(data.edml_order_qn);
					$(obj_parent).find('#unload_qn').html(data.edml_unload_quantity);
					if(show_delivery>0){
						$(obj_parent).find('input[name*="per_size]"]').val(per_size);
						$(obj_parent).find('input[name*="per_capability]"]').val(weight);
					}
					$(obj_parent).find('input[name*="quantity]"]').trigger('keyup');
				}
			});
		}
	}


	// 获取未装柜的订单(用于新装柜)
	function getUnLoadOrders(flow_color,flow_size,orders_norms) {
		var order_id 	= $dom.find('#order_id').val();
		var fac_id	 	= $dom.find('#factory_id').val();
		var p_id		= $dom.find('#product_id').val();
		if(order_id>0 || fac_id >0 || p_id >0){
			$dom.find('#loadContrain').load(APP+'/Orders/getUnloadOrder',{order_id:order_id,fac_id:fac_id,p_id:p_id});
		}else{
			alert('请输入要查询的信息!');
		}
	};

	// 清空通过查询到找的待装柜信息
	$.clearData	= function() {
		$dom.find('#loadContrain').html('');
	}

	// 装柜/整单装柜
	function load(detail_id, order_id,obj) {
		if (detail_id > 0 || order_id > 0) {
			$.getJSON(APP+"/Ajax/getLoadDetails", {'detail_id':detail_id, 'order_id':order_id}, function(data){
				if (data.list != null) {
					$.each(data.list, function(k,item){
						var detail_table_last = $dom.find('#detail_table:last').find('tbody');
						var first_obj 	= detail_table_last.find('tr:visible:first');
						var list_row	= detail_table_last.find('tr:visible').size();
						for (i = 1; i <= list_row; i++)
						{
							if (first_obj.find("#order_id").val() < 1 || (!first_obj.find("#order_no").length>0 && first_obj.find("#order_no").val())){
								first_obj	=	first_obj;
							}else{
								if(i==list_row){
									first_obj	=	first_obj;
								}else{
									first_obj	=	first_obj.next();
								}
							}
						}
						if (first_obj.find("#order_id").val() < 1 || (!first_obj.find("#order_no").length>0 && first_obj.find("#order_no").val())){
							var new_obj = first_obj;
						} else {
							var new_obj = $.copyRowWithFrom($(first_obj).find('td:last').find('span[class*="icon-add-plus"]'));
						}
						$(new_obj).find("#order_id").val(item.id);
						$(new_obj).find("#autoshow_img").attr('pid',item.product_id);
						$(new_obj).find("#factory_id").val(item.factory_id);
						$(new_obj).find("#currency_id").val(item.currency_id);
						$(new_obj).find("#order_no").val(item.order_no);
						$(new_obj).find("#span_fac_name").html(item.factory_name);
						$(new_obj).find("#product_id").val(item.product_id);
						$(new_obj).find("input[name*='product_no]']").val(item.product_no);
						$(new_obj).find("#span_product_name").html(item.product_name);
						$(new_obj).find("#color").val(item.color_id);
						$(new_obj).find("input[name=color_name]").val(item.color_name);
						$(new_obj).find("input[name*=size]").val(item.size_id);
						$(new_obj).find("input[name=size_name]").val(item.size_name);
						$(new_obj).find("input[name*=price]").val(item.edml_price);
						if(data.storage_format>0){
							$(new_obj).find('input[name*=capability]').val(item.order_capability);
							$(new_obj).find('input[name*=dozen]').val(item.order_dozen);
						}
						$(new_obj).find('#currency_id').val(item.currency_id);
						$(new_obj).find('#order_qn').html(item.sum_capability);	//订货数量
						$(new_obj).find('#unload_qn').html(item.min_capability);	//订货数量
						if(data.show_delivery>0){
							$(new_obj).find('input[name*="per_size]"]').val(item.edml_per_size);
							$(new_obj).find('input[name*="per_capability]"]').val(item.dml_weight);
						}
					});
					if(detail_id>0){
						$(obj).parents("tr:first").remove();
					}else{
						$dom.find("div[id=loadContrain]").find("tr[order_id='"+order_id+"']").remove();
					}
				}else{
					alert('失败了,请联系系统管理员!!')
				};
			});
		};
	}
	//通过销售单选择的币种显示银行信息
	function getBankCurrencry(currency_id){
		$dom.find('#currency_id').val(currency_id);
		//如果已存在银行插入的币种与选的币种提示客户回退
		if(currency_id>0){
			$dom.find('#pay_transfer_bank_id').val('');
			var pay_transfer_bank_name = $dom.find('input[name=pay_transfer_bank_name]');
        	pay_transfer_bank_name.val('').attr({'where':encodeURIComponent('currency_id='+currency_id),'jqac':true});
        	pay_transfer_bank_name.initAutocomplete();
		}

	}
	/****************销售预付款jS**********************************/
		var s	=new Array('','cash','bill','transfer');　
		function addPaidType(v){
			for(m=1;m<4;m++){
				$dom.find("#"+s[m]).hide();
			}
			$dom.find("#"+s[v]).show();
			var old_paid_type	=	$dom.find("#pay_paid_type").val();
			if(old_paid_type>0){
				clearPaidType(old_paid_type)
			}
			$dom.find("#pay_paid_type").val(v);
			$.dealWithPM();//计算销售单金额
			var preferential_money 				= $.turnToPoint($dom.find('#pr_money').val());//优惠金额
			var sum_after_dis_money				= $dom.find('td[total_col_dis_money]').html()!=null ? $.turnToPointShow($dom.find('td[total_col_dis_money]').html()) :$.turnToPointShow($dom.find('td[total_col_money]').html());//优惠后金额
			$.realMoneyWithSale(sum_after_dis_money,preferential_money);
			$dom.find("#"+s[v]).find("#user_type").val(v);   // 设置Select的Value值为4的项选中
//			if(s[v]=='transfer'){
//				var	currency_id		= $dom.find('#currency_id').val();
//				var	flow			= $dom.find('#flow').val();
//				if(flow=='sale'){
//					$dom.find('input[name=pay_transfer_bank_name]').attr({'where':encodeURIComponent('currency_id='+currency_id),'jqac':true});
//					$dom.find('input[name=pay_transfer_bank_name]').initAutocomplete();
//				}
//			}
		}
		//清除默认信息
		function clearHtmlValueArray(clear_array){
			for(var i in clear_array){
				$dom.find("#"+clear_array[i]).val('');
			}
		}

	/**************************************************/
//发票获取IVA
function getIVA(obj,from){
	var id = $(obj).val();
	if (id > 0) {
		$.getJSON(APP+"/Ajax/getIva",{id:id,from:from},function(data){
			$dom.find('#iva').val(data.iva);
			var import_type	= $dom.find('#import_type').val();
			switch(import_type){
				case 'instock':
					if(data.factory_from==1){
						$dom.find('input[name=relation_no]').attr('where',encodeURIComponent("factory_id="+id));
						var where	= encodeURIComponent("factory_id="+id);
						var detail_list_tr = $dom.find('.detail_list tr');
						detail_list_tr.find('input[name*=product_no]').attr('where',where);
						detail_list_tr.find('input[name*=product_name]').attr('where',where);
						detail_list_tr.each(function(){
							$(this).find('input[jqac]').initAutocomplete();
						});
					}else{
						$dom.find('input[name=relation_no]').removeAttr('where');
					}
					$.sumTax();
					return ;
					break;
				case 'saleorder':
					if(data.invoice_from==1){
						if(data.connect_client>0){
							$dom.find('input[name=relation_no]').attr('where',encodeURIComponent('client_id='+data.connect_client));
						}else{
							$dom.find('input[name=relation_no]').removeAttr('where');
						}
					}else{
						$dom.find('input[name=relation_no]').attr('where',encodeURIComponent('client_id='+id));
					}
					break;
				case 'return':
					if(data.invoice_from==1){
						if(data.connect_client>0){
							$dom.find('input[name=relation_no]').attr('where',encodeURIComponent('client_id='+data.connect_client));
						}else{
							$dom.find('input[name=relation_no]').removeAttr('where');
						}
					}else{
						$dom.find('input[name=relation_no]').attr('where',encodeURIComponent('client_id='+id));
					}
					break;
				default:
					$dom.find('input[name=relation_no]').removeAttr('where');
					break;
			}
			$dom.find('input[name=relation_id]').val('');
			$dom.find('input[name=relation_no]').val('').initAutocomplete();
		});
	}
}
//显示支票号
function displayCheckNo() {
	var pay_type = $dom.find('select[name=paid_type] option:selected').val();
	if (pay_type == 2) {
		$dom.find('#check_td_1').show();
		$dom.find('#check_td_2').show();
	}else {
		$dom.find('#check_td_1').hide();
		$dom.find('#check_td_2').hide();
	}
}
//发票导入
function importData(){
	var relation_id	= $dom.find('#relation_id').val();
	var import_type	= $dom.find('#import_type').val();
	var factory_id	= $dom.find('#factory_id').val();
	if(import_type=='instock'&&factory_id>0){
		$dom.find('.detail_list').find('tr').each(function(){
			$(this).find('#span_product_name,#total_money,#span_invoice_ingredient').html('');
			$(this).find('input').val('');
			$(this).find('td[total_quantity],td[total_col_money],td[tax_total_cost],td[tax_cost]').html('');
		});
	}
	if(relation_id>0){
		$dom.find('.detail_list').find('input').val('');
		$dom.find('.detail_list').find('tr').each(function(){
			$(this).find('#span_product_name').html('');
			$(this).find('#total_money').html('');
			$(this).find('#span_invoice_ingredient').html('');
		});
		$.ajax({
			type: "POST",
			url: APP+"/Ajax/getRelationInfo",
			dataType: "json",
			data:{relation_id:relation_id,import_type:import_type,factory_id:factory_id},
			cache: false,
			success: function(result){
				if(result.detail){
					var first_index	= $dom.find('.detail_list tbody tr').not('.none').first().attr('index');
					var index		= first_index;
					var obj			= $dom.find('.detail_list tbody tr[index='+index+']');
					$.each(result.detail,function(k,item){
						if($(obj).attr('index')==undefined){
							$.copyRowWithFrom($dom.find('.detail_list tbody').find("tr:last").find('td'));
							obj		= $dom.find('.detail_list tbody').find("tr:last");
						}
//						if(index>len){
//							$.copyRowWithFrom($dom.find('.detail_list tbody').find("tr:last").find('td'));
//						}
//						var obj	= $dom.find('.detail_list tbody').find("tr[index="+index+"]");
						$(obj).find("input[name*='product_no]']").initAutocomplete();
						$(obj).find("input[name*='product_id']").val(item.product_id);
						$(obj).find("input[name*=product_no]").val(item.product_no);
						$(obj).find("input[name*='product_name']").val(item.product_name);
						$(obj).find('#span_product_name').html(item.product_name);
						$(obj).find("input[name*='price']").val(item.edml_price);
						$(obj).find("input[name*='quantity']").val(item.edml_sum_quantity);
						$(obj).find("#total_money").html(item.edml_money);
						$(obj).find('input[name*=discount]').val(item.edml_discount);
						$(obj).find('td[total_row_dis_money]').html(item.dml_discount_money);
						$(obj).find('#span_invoice_ingredient').html(item.ingredient);
						$.sumTotal($(obj).find('input[name*=product_id]'),'');
						obj	= $(obj).next();
					});
					$.sumTax();
				}
			}
		});
	}
}
//发票类型
function setInvoiceType(){
	var invoice_type	= $dom.find('input[name=invoice_type]:checked').val();
	if(invoice_type==2){
		$dom.find('#lang_order_no').html(lang['orders']['return_no']+'：');
		$dom.find('input[name=relation_id]').val('');
		$dom.find('#import_type').val('return');
		$dom.find('input[name=relation_no]').attr('url',APP+'AutoComplete/invoiceReturnOrderNo').val('').initAutocomplete();
	}else{
		$dom.find('#lang_order_no').html(lang['orders']['sale_no']+'：');
		$dom.find('input[name=relation_id]').val('');
		$dom.find('#import_type').val('saleorder');
		$dom.find('input[name=relation_no]').attr('url',APP+'AutoComplete/invoiceSaleOrderNo').val('').initAutocomplete();
	}
}
//销售付款转账,获取银行名称,暂时
function getBankName(obj){
	var id	= $(obj).val();
	if(id>0){
		$.post(APP+"/Ajax/getBankName",{id:id},function(data){
			$dom.find('#span_bank_name').val(data);
		});
	}
}
/*读取实际到达日期 added by yyh 20140919*/
function getRealArriveDate(obj){
	var state_id	= $(obj).val();
	var arr			= ',9,10,11,14,';
	if(arr.indexOf(','+state_id+',')==-1){
		$('#real_arrive_date_dt').hide();
	}else{
		$('#real_arrive_date_dt').show();
   }
};
// 产品类别中地区管理表单验证特别处理
function productClassDistrict(result){
	var fid		= $dom.find("#form_name").val();
	var element = $dom.find('#'+fid);
	if(result.status==1){
		$('#loader').css("display","none");
		$("#tips").html(result.info).fadeIn().delay(1000).fadeOut(400);
		loadTab();
	}else if(result.status==2){
		validity(result.info,element);
	}
}
function setFormName(v){
	$dom.find("#form_name").val(v);
}
/**************转回国内开始*******************/
//转回国内银行
function getBankById(obj){
	var bank_id	= $(obj).val();
	if(bank_id>0){
		$.getJSON(APP+"/Ajax/getBankCurrencyId", {'bank_id':bank_id}, function(data){
			if(data){
				$dom.find('#in_bank_id').val('');
				var in_account_name = $dom.find('input[name*="in_account_name"]');
				in_account_name.val('').attr({'where':encodeURIComponent('currency_id='+data.currency_id+' and id!='+bank_id),'jqac':true});
				in_account_name.initAutocomplete();
			}
		});
	}
}

//根据币种限制银行
function getBankByCurrency(obj){
	var currency_id	 = $(obj).val();
	if(currency_id>0){
		$dom.find('input[name*="account_name"]').each(function(){
			$(this).val('').attr({'where':encodeURIComponent('currency_id='+currency_id),'jqac':true});
			$(this).initAutocomplete();
		})
	}
}


//根据币种限制银行
function getClientByFactory(obj){
	var factory_id	 = $(obj).val();
	if(factory_id>0){
		$dom.find('input[name*="client_name"]').each(function(){
			if ($(this).data('quicklyadd') == 1) {
				$(this).data('quicklyadd', 0);
			}else{
				$(this).val('').attr({'where':encodeURIComponent('factory_id='+factory_id),'jqac':true});
				$(this).initAutocomplete();
			}
		})
	}
}


function getBrtAccountNoByFactory(obj){
	var factory_id	 = $(obj).val();
	if(factory_id>0){
		$.getJSON(APP+'/Ajax/getBrtAccountNo',{factory_id:factory_id},function(data){
				$dom.find('#brt_account_no').val(data);
		});
	}

}


//转回国内计算
function getTotal(obj){
	var quantity	= $.cParseInt($dom.find('input[name*="quantity"]').val());//笔数
	var money		= $.cParseFloat($dom.find('input[name*="money"]').val());//金额
	var other_cost	= $.cParseFloat($dom.find('input[name*="other_cost"]').val());//每笔费用
	$dom.find('#sum_money').html($.turnToComma(eval(quantity+'*'+money),2));
	$dom.find('#sum_other_cost').html($.turnToComma(eval(quantity+'*'+other_cost),2));


}
/**************转回国内结束*******************/
//销售保存的时候,如果为已配货,提示用户
function checkSaleaState(formData, jqForm, options)  {
	if ($dom.find('#pre_delivery').val() ==2) {
		if (!confirm('该销售单已配货,是否重新配货?')) {
			$.removeLoading();
			return false;
		}
	}
	return true;
}

//入库检验 汇率
function checkInstockRate(formData, jqForm, options){
	var rn =true;
	$.ajax({
		url:APP+'/Ajax/validRate',
		type:'post',
		data:formData,
		async:false,
		dataType: "json",
		success:function(data){
			if(data){
				if(confirm(data['info'])){
					rn =true;
				}else{
					rn	= false;
					$('#s_loading').hide();
					return false;
				}
			}
		}
	});
	return rn;
}

/*多个产品库存显示*/
function multiStorage(pid,obj){
	if(pid<=0) return;
	if($dom.find("#product_"+pid).length>0){
		$("<div>"+lang['stat']['product_is_last_page']+"</div>").dialog({
			//		modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	}else{
		var url = $(obj).attr("url");
		$.ajax({
			type: "POST",
			url: url,
			data: "id="+pid,
			dataType: "text",
			cache: false,
			success: function(html){
				$dom.find("#print").append(html);
			}
		});
	}
}
/*销售根据客户和公司获取欠款*/
function getClientInfo(){
	var client_id	= $dom.find('#client_id').val();
	if(client_id>0){
		$.getJSON(APP+'/Ajax/getClientInfo',{id:client_id},function(data){
			$dom.find('#client_id').next().data('quicklyadd', 1);
			//买家信息
			var factory_id	= $.cParseInt($dom.find("#factory_id").val());
			if (factory_id <= 0 || factory_id != data.factory_id) {
				$dom.find('#factory_id').val(data.factory_id).trigger('change').next('input[jqac]').val(data.factory_name);
			}
			$dom.find('#company_name').val(data.company_name);
			$dom.find('#consignee').val(data.consignee);
			$dom.find('#transmit_name').val(data.transmit_name);
			$dom.find('#tax_no').val(data.tax_no);
			$dom.find('#email').val(data.email);
			$dom.find('#mobile').val(data.mobile);
			$dom.find('#country_id').val(data.country_id);
			$dom.find("#country_name").val(data.country_name);
			$dom.find("#full_country_name").val(data.full_country_name);
			$dom.find("#city_name").val(data.city_name);
			$dom.find('#address').val(data.edit_address);
			$dom.find('#address2').val(data.edit_address2);
			$dom.find('#post_code').val(data.post_code);
			$dom.find('#fax').val(data.fax);
			//默认选择城市
			//getCity('#country_id','',data.city_id);
		});
	}
}

/*获取销售单信息*/
function getSaleOrderInfo(obj){
	var sale_order_id = $dom.find('#sale_order_id').val();
    var return_sale_order_state = $dom.find('#return_sale_order_state').val();
    var is_related_sale_order   = $dom.find('#is_related_sale_order').val();
	var warehouse_id	= $dom.find('#warehouse_id').val();
    var id = $dom.find('#id').val();
	if(sale_order_id>0){
		$.getJSON(APP+'/Ajax/getSaleOrderInfo',{sale_order_id:sale_order_id,return_sale_order_state:return_sale_order_state,id:id,warehouse_id:warehouse_id},function(data){
			if(data){
                //基本信息
                $dom.find('#order_no').val(data.order_no);
                $dom.find('#client_id').val(data.client_id);
                $dom.find('#factory_id').val(data.factory_id);
                $dom.find('#warehouse_id').val(data.warehouse_id);
                $dom.find('#w_name').val(data.w_name);
                $dom.find('#client_name').val(data.client_name);
                $dom.find('#track_no').val(data.track_no);
                $dom.find('#order_date').val(data.fmd_order_date);
                //客户信息
                $dom.find('#consignee').val(data.consignee);
                $dom.find("#country_name").val(data.country_name);
                $dom.find("#city_name").val(data.city_name);
                $dom.find('#email').val(data.email);
                $dom.find('#tax_no').val(data.tax_no);
                $dom.find('#address').val(data.edit_address);
                $dom.find('#address2').val(data.edit_address2);
                $dom.find('#company_name').val(data.company_name);
                $dom.find('#post_code').val(data.post_code);
                $dom.find('#mobile').val(data.mobile);
                $dom.find('#fax').val(data.fax);
                $dom.find('#factory_id').val(data.factory_id);
                $dom.find('#transmit_name').val(data.transmit_name);
                $dom.find('#country_id').val(data.country_id);
                $dom.find("#full_country_name").val(data.full_country_name);
                $dom.find("#comments").val(data.edit_comments);
                //明细信息
                if (data.html) {
                    $dom.find('.detail_list').parent().html(data.html);
                    $('.detail_list tbody tr:visible').each(function() {
                        $(this).find("input[jqac]").each(function() {
                            $(this).initAutocomplete();
                        });
                    });

                    var detail_list = $('.detail_list');
                    if(detail_list){
                        detail_list.bandCache();
                        detail_list.bandTotalMethod();//明细表绑定合计事件
                        detail_list.bandProductMethod();//明细表绑定合计事件
                    }
                }
            }
		});
	}else{
		$.ajaxSettings.async = false;//禁用异步
        getReturnOrderDetail(is_related_sale_order);
        var type_name   = $(obj).attr('name');
        warehouseSetLocation(type_name);
        var factory_id  = $dom.find('#factory_id').val();
        if (factory_id) {
            setFacProduct($dom.find('#factory_id'));
        } else {
            getClientInfo();
        }
    }
    $.sumDetailCache();
}
/*获取销售单信息*/
function getQuestionInfo(){
	var sale_order_id   = $dom.find('#sale_order_id').val();
	var warehouse_id	= $dom.find('#warehouse_id').val();
    var id              = $dom.find('#id').val();
	if(sale_order_id>0){
		$.getJSON(APP+'/Ajax/getQuestionInfo',{sale_order_id:sale_order_id,id:id,warehouse_id:warehouse_id},function(data){
			if(data){
                //基本信息
                $dom.find('#order_no').val(data.order_no);
                $dom.find('#client_id').val(data.client_id);
                $dom.find('#factory_id').val(data.factory_id);
                $dom.find('#warehouse_id').val(data.warehouse_id);
                $dom.find('#w_name').val(data.w_name);
                $dom.find('#client_name').val(data.client_name);
                $dom.find('#track_no').val(data.track_no);
                $dom.find('#order_date').val(data.fmd_order_date);
				$dom.find('#express_id').val(data.express_id);
				$dom.find('#express_name').val(data.express_name);
                //客户信息
                $dom.find('#consignee').val(data.consignee);
                $dom.find("#country_name").val(data.country_name);
                $dom.find("#city_name").val(data.city_name);
                $dom.find('#email').val(data.email);
                $dom.find('#tax_no').val(data.tax_no);
                $dom.find('#address').val(data.edit_address);
                $dom.find('#address2').val(data.edit_address2);
                $dom.find('#company_name').val(data.company_name);
                $dom.find('#post_code').val(data.post_code);
                $dom.find('#mobile').val(data.mobile);
                $dom.find('#fax').val(data.fax);
                $dom.find('#factory_id').val(data.factory_id);
                $dom.find('#transmit_name').val(data.transmit_name);
                $dom.find('#country_id').val(data.country_id);
                $dom.find("#full_country_name").val(data.full_country_name);
                $dom.find("#comments").val(data.edit_comments);
                //明细信息
                if (data.html) {
                    $dom.find('.detail_list').parent().html(data.html);
                    $('.detail_list tbody tr:visible').each(function() {
                        $(this).find("input[jqac]").each(function() {
                            $(this).initAutocomplete();
                        });
                    });

                    var detail_list = $('.detail_list');
                    if(detail_list){
                        detail_list.bandCache();
                        detail_list.bandTotalMethod();//明细表绑定合计事件
                        detail_list.bandProductMethod();//明细表绑定合计事件
                    }
                }
            }
		});
	}else{
		/* 清空 */
		 //基本信息
		$dom.find('#order_no').val('');
		$dom.find('#client_id').val('');
		$dom.find('#w_name').val('');
		$dom.find('#client_name').val('');
		$dom.find('#track_no').val('');
		$dom.find('#order_date').val('');
		$dom.find('#express_id').val('');//express_id
		$dom.find('#express_name').val('');//express_name
		//客户信息
		$dom.find('#consignee').val('');
		$dom.find("#country_name").val('');
		$dom.find("#city_name").val('');
		$dom.find('#email').val('');
		$dom.find('#tax_no').val('');
		$dom.find('#address').val('');
		$dom.find('#address2').val('');
		$dom.find('#company_name').val('');
		$dom.find('#post_code').val('');
		$dom.find('#mobile').val('');
		$dom.find('#fax').val('');
		$dom.find('#transmit_name').val('');
		$dom.find('#country_id').val('');
		$dom.find("#full_country_name").val('');
		$dom.find("#comments").val('');


		$.ajaxSettings.async = false;//禁用异步
        getQuestionOrderDetail();
        var factory_id  = $dom.find('#factory_id').val();
        if (factory_id) {
            setFacProduct($dom.find('#factory_id'));
        } else {
            getClientInfo();
        }
    }
}

// 产品类别中地区管理表单验证特别处理
function statCheck(result){
	var element = $dom.find('#form');
	if(result['status']==2){
		var result	= eval('(' + result + ')');
	}
	if(result['status']==2){
		$dom.find('#print').hide();
		validity(result.info,element);
	}else{
		$dom.find('#print').show();
	}
}
//新增产品和修改产品计算每箱立方
function getToTtalCube(obj){
	var parent		= $(obj).parent('li').length > 0 ? $(obj).parent('li') : $(obj).parent('td').parent('tr');
	var cube_long	= $.cParseFloat($(parent).find('#cube_long').val());
	var cube_wide	= $.cParseFloat($(parent).find('#cube_wide').val());
	var cube_high	= $.cParseFloat($(parent).find('#cube_high').val());
	$(parent).find('#cube').val($.cParseFloat(cube_long*cube_wide*cube_high).toFixed(cube_length)).trigger('change');
}
//复核重量计算每箱立方
function getToTtalReviewCube(obj){
	var parent		= $(obj).parent('li').length > 0 ? $(obj).parent('li') : $(obj).parent('td').parent('tr');
	var review_long	= $.cParseFloat($(parent).find('#review_long').val());
	var review_wide	= $.cParseFloat($(parent).find('#review_wide').val());
	var review_high	= $.cParseFloat($(parent).find('#review_high').val());
	$(parent).find('#review_cube').val($.cParseFloat(review_long*review_wide*review_high).toFixed(cube_length)).trigger('change');
}

function changeColorByLimit(obj,limit,basic_obj,basic_val){
//	if (limit > 0) {
//		if ($("input[name='" + basic_obj + "']:checked").val() == basic_val && $(obj).val() > limit) {
//			$(obj).css('color', 'red');
//		} else {
//			$(obj).css('color', '');
//		}
//	}
}

function limitColor(){
//	$dom.find("#cube").trigger('change');
//	$dom.find("#weight").trigger('keyup');
}

function checkStatProduct(){
	var pid = $dom.find("#stat_p_id").val();
	if(pid){
		return true;
	}else{
		validity({"name":"product_id","value":lang['common']['require']},$dom,'.search_box');
		return false;
	}
	return false;
}

/**
 * 搜索页面必填验证
 * @author jph 20140528
 * @param {type} formData
 * @param {type} jqForm
 * @param {type} options
 * @returns {Boolean}
 */
function checkSearchForm(formData, jqForm, options){
    var info			= [];
	var err				= lang['common']['require'];
	jqForm.find('.valid-required').each(function (){
		if ($.trim($(this).val()).length === 0) {
			info.push({"name":$(this).attr('name'),"value": $(this).attr('errmsg') ? $(this).attr('errmsg') : err});
		}
	});
	if(info.length === 0){
		return true;
	}else{
		validity(info, jqForm);
		return false;
	}
}

//导出公共js类
function ExportMytable(type, id, module_name){
	var src;
	if (id > 0) {
		src 		= APP+"/Ajax/outPutExcel/state/"+type+'/id/'+id+'/module_name/'+module_name;
	} else {
		var queryString = $dom.find('#search_form').formSerialize();
		$dom.find('#ac_search').trigger('click');
		var rand		= $dom.find('#rand').val();
		src 		= APP+"/Ajax/outPutExcel/state/"+type+'/rand/'+rand;
	}
	var iframe		= $("<iframe style='display:none' name='iframe' src="+src+"></iframe>");
	$dom.find('iframe[name="iframe"]').remove();
	$dom.find('#search_form').append(iframe);
}

function quicklyAddCallback(module,result){
	switch (module){
		case 'Factory':
			$dom.find("#factory_id").val(result.id).next().val(result.comp_name);
		break;
		case 'Color':
			$dom.find("#add_color").before('<input type="checkbox" name="color[]" value="'+result.id+'" onclick="" checked>'+result.color_name+"&nbsp;&nbsp;");
		break;
		case 'Size':
			$dom.find("#add_size").before('<input type="checkbox" name="size[]" value="'+result.id+'" onclick="" checked>'+result.size_name+"&nbsp;&nbsp;");
		break;
		case 'Department':
			$dom.find("#department_id").val(result.id).next().val(result.department_name);
		break;
		case 'Position':
			$dom.find("#position_id").val(result.id).next().val(result.position_name);
		break;
		case 'Employee':
			$dom.find("#employee_id").val(result.id);
			$dom.find("#employee_name").val(result.employee_name);
		break;
		case 'PayClass':
			$dom.find("#pay_class_id").val(result.id).next().val(result.pay_class_name);
		break;
		case 'Product':
			ordersProduct(result);
		break;
		case 'Client':
			$dom.find("#client_id").val(result.id).trigger("change").next().val(result.comp_name).data('quicklyadd', 1);
		break;
		case 'District':
			$dom.find("#country_id").val(result.parent_id).next().val(result.country_name);
			getCity('#country_id','',result.id);
		break;
	}

	function ordersProduct(data){
		var factory_id = $dom.find("#factory_id").val();
		if(factory_id>0){// 是否已选择厂家未选择时退出
			if(data.factory_id!=factory_id){//判断是否选择的厂家与添加产品的厂家一致
				return false;
			}
		}else{
			return false;
		}
		var first_obj 	= $dom.find('.detail_list:last').find('tbody').find('tr:visible:first');
		var list_row	= $dom.find('.detail_list:last').find('tbody').find('tr:visible').size();
		for (i = 1; i <= list_row; i++)
		{
			if (first_obj.find("input[name*='product_id]']").val() < 1 || !first_obj.find("input[name*='product_no]']").val()){
				first_obj	=	first_obj;
			}else{
				if(i==list_row){
					first_obj	=	first_obj;
				}else{
					first_obj	=	first_obj.next();
				}
			}
		}
		if (first_obj.find("input[name*='product_id]']").val() < 1 || !first_obj.find("input[name*='product_no]']").val()){
			var obj = first_obj;
		} else {
			var obj = $.copyRowWithFrom($(first_obj).find('td:last').find('span[class*="icon-add-plus"]'));
		}
		$(obj).find('input[name*="product_no]"]').val(data.product_no);
		$(obj).find('input[name*="product_id]"]').val(data.id).trigger('change');
		return false;
	}
}
//装柜的时候如果装柜数量大于订货数量,给于错误提示
//修改订货的时候,不允许小于装柜数量
function checkLoadQuantity(obj,load_qn,flow){
	var parent		= $(obj).parent('td').parent('tr');
	$dom.find("#form_error_msg").css('display','none');
	if(flow=='orders'){
		var order_qn	= $.turnToPointShow($(parent).find('td[id=diff_quantity]').html());
		var re			= load_qn<order_qn;
		var err			= lang['orders']['error_order_quantity'];
	}else{
		var order_qn	= $.turnToPointShow($(parent).find('td[id=unload_qn]').html());
		var re			= load_qn>order_qn;
		var err			= lang['orders']['error_quantity'];
	}
	if(re){
		var result	= jQuery.parseJSON('{"info":[{"name":"'+$(parent).find('#quantity').attr('name')+'","value":"'+err+'"}]}');
		validity(result.info,$dom);
	}
}

function expandAllDetail(){
	var list	= $dom.find('.list');
	var html	= $("#s_success").html();
	$("#s_loading").show();
	$("#s_success").show().css('z-index', $.cParseInt($("#s_success").css('z-index'))+$.cParseInt($("#s_loading").css('z-index'))+1).html('数据加载中，请耐心等待');
	var expand	= $.cParseInt($(list).data('expand'));
	$(list).data('isExpandAll', 1).data('expand',expand === 0 ? 1 : 0);//1 全部展开 0 全部收缩
    $(list).find('tr[expand]').each(function(){
        $(this).find('td[expand]').find('a').trigger('click');
    });
	$("#s_loading").hide();
	$("#s_success").hide().css('z-index', $.cParseInt($("#s_success").css('z-index'))-$.cParseInt($("#s_loading").css('z-index'))-1).html(html);
	$(list).data('isExpandAll', 0);
}

/* 计算换汇金额 added by jp 20131211 */
function calculateSwapMoney(type){
    var out_money   = $.cParseFloat($dom.find('#out_money').val());
    var rate        = $.cParseFloat($dom.find('#rate').val());
    var in_money    = $.cParseFloat($dom.find('#in_money').val());
    switch(type) {
        case 'out':
        case 'rate':
            $dom.find('#in_money').val(rate > 0 ? (out_money*rate).toFixed(money_length) : '');
            break;
        case 'in':
        default:
            $dom.find('#rate').val(out_money > 0 ? (in_money/out_money).toFixed(money_length) : '');
            break;
    }
}

/* 合并订单处理 */
function CombineSaleOrderCheck(obj){
	var factory_id,factory_id2,post_code,post_code2,merge_address,merge_address2;
	var i=0,j=0,k=0;
	var chk_size = $('#index').find(':checked').size();
	if(chk_size<2){
		alert(lang['sale']['two_more']);
		return false;
	}
	var sale_order_ids = [];
	$('#index').find(':checked').each(function(){
		sale_order_ids.push(parseInt($(this).parents('tr:first').find('#sale_order_id').val()));
		factory_id    = parseInt($(this).parents('tr:first').find('#factory_id').val());
		merge_address = $(this).parents('tr:first').find('#merge_address').val();
		post_code     = $(this).parents('tr:first').find('#post_code').val();
		if(factory_id2!=factory_id){
			i++;
		}
		if(merge_address2!=merge_address){
			j++;
		}
		if(post_code2!=post_code){
			k++;
		}
		factory_id2	   = factory_id;
		merge_address2 = merge_address;
		post_code2	   = post_code;
	})
	if(i>1){
		alert(lang['sale']['factory_id_error']);
		return false;
	}
	if(j>1){
		alert(lang['sale']['merge_address_error']);
		return false;
	}
	if(k>1){
		alert(lang['sale']['post_code_error']);
		return false;
	}
	var url   = $(obj).attr("url");
	var title = $(obj).attr("title");
	$.ajax({
		type: "POST",
		url: url+'/sale_order_ids/'+sale_order_ids.join(','),
		dataType: "json",
		cache: false,
		success: function(result) {
			success(result);
		}
	});
}

/* 读取派送方式 */
function getExpressWay(obj){
	var warehouse_id	= $(obj).val();
	$dom.find("#express_id").val('');
	$dom.find("#express_date").val('');
	$.get(APP+'/Ajax/getExpressWay',{id:warehouse_id},function(data){
		$dom.find("#express_way").html(data);
		$dom.find("input[name='express_name']").initAutocomplete();
	});
};

//选择发货仓库订单明细出现
function setSaleDetail(obj){
    var async   = $.ajaxSettings.async;//禁用异步
    $.ajaxSettings.async    = true;
    $dom.find('#detail_table').find('span').each(function(){
        if($(this).attr('id') == 'express_way'){
            var warehouse_id	= $(obj).val();
            var express         = $(this);
            var index           = express.parents('tr:first').attr('index');
            express.find("#express_id").val('');
            express.find("#express_date").val('');
            $.get(APP+'/Ajax/getExpressWay',{id:warehouse_id,index:index},function(data){
                express.html(data);
                express.find('#express_id').attr("onchange","getDetailExpressInfo(this);");
                express.find("input[name*='express_name']").initAutocomplete();
            });
        }
    });
    $.ajaxSettings.async    = async;
}

/* 读取派送方式 */
function getExpressWayEdit(obj){
	var warehouse_id	= $(obj).val();
	$dom.find("#express_id").val('');
	$dom.find("#express_date").val('');
	$.get(APP+'/Ajax/getExpressWayEdit',{id:warehouse_id},function(data){
		$dom.find("#express_way").html(data);
		$dom.find("input[name='express_name']").initAutocomplete();
	});
}
/* 订单派送方式处理 */
function getExpressInfo(){
	var express_id	= $dom.find('#express_id').val();
	$dom.find('#express_img').attr('pid','');
	$dom.find('#express_date').val('');
	var warehouse_id =$dom.find('#warehouse_id').val();
	if(express_id>0 && warehouse_id>0){
		$dom.find('#express_img').attr('pid',express_id);
		$.getJSON(APP+'/Ajax/getExpressInfo',{id:express_id,warehouse_id:warehouse_id},function(data){
			$dom.find('#express_date').val(data.express_date);
			if(data.brt_init){
				$dom.find('#brt_li').show();
			}else{
				$dom.find('#brt_li').hide();
			}
            if(data.reg_init){
                $dom.find("#is_not_registered").attr("disabled",true);
                $dom.find("#is_not_registered").removeAttr("checked");
                $dom.find("#is_registered").attr("checked","checked");
            }else{
				$dom.find("#is_not_registered").attr("disabled",false);
                $dom.find("#is_not_registered").attr("checked","checked");
                $dom.find("#is_registered").removeAttr("checked","checked");
			}
            $dom.find('#detail_table').find('span').each(function(){
                if($(this).attr('id') == 'express_way'){
                    $(this).find("#express_id").val(express_id);
                    $(this).find("input[name*='express_name']").val(data.express_name);
                    $(this).find("input[name*='ship_name']").val(data.express_name);
                    $(this).parents('td:first').find('#express_img').attr('pid',express_id);
                }
            });
		});
	}
}

/* 订单明细派送方式处理 */
function getDetailExpressInfo(obj){
	var express_id	= $(obj).val();
	$(obj).parents('td:first').find('#express_img').attr('pid',express_id);
    return false;
}

//派送方式的处理（订单编辑时）
/* 订单派送方式处理 */
function getExpressInfoEdit(){
	var express_id	= $dom.find('#express_id').val();
	$dom.find('#express_img').attr('pid','');
	$dom.find('#express_date').val('');
	var warehouse_id =$dom.find('#warehouse_id').val();
	var flag =$dom.find('#flag').val();
	if(express_id>0){
		$dom.find('#express_img').attr('pid',express_id);
		$.getJSON(APP+'/Ajax/getExpressInfoEdit',{id:express_id,warehouse_id:warehouse_id},function(data){
			$dom.find('#express_date').val(data.express_date);
			if(data.brt_init){
				if(flag){
					$dom.find('#brt_li').show();
				}else{
					$dom.find('#brt_li_none').show();
				}
			}else{
				if(flag){
					$dom.find('#brt_li').hide();
				}else{
					$dom.find('#brt_li_none').hide();
				}
			}
            if(data.reg_init){
                $dom.find("#is_not_registered").attr("disabled",true);
                $dom.find("#is_not_registered").removeAttr("checked");
                $dom.find("#is_registered").attr("checked","checked");
            }else{
				$dom.find("#is_not_registered").attr("disabled",false);
                $dom.find("#is_not_registered").attr("checked","checked");
                $dom.find("#is_registered").removeAttr("checked","checked");
			}
            $dom.find('#detail_table').find('span').each(function(){
                if($(this).attr('id') == 'express_way'){
                    $(this).find("#express_id").val(express_id);
                    $(this).find("input[name*='express_name']").val(data.express_name);
                    $(this).find("input[name*='ship_name']").val(data.express_name);
                    $(this).parents('td:first').find('#express_img').attr('pid',express_id);
                }
            });
		});
	}
}
/**
 * 是否显示
 * @author jp 20140304
 * @param {int} value 1是 2否
 * @param {string} name
 * @returns {undefined}
 */
function changeDisplayStatus(value, name, is_select){
	var parent_obj	= $dom.find('#' + name + '_obj');
	var obj	=	$(parent_obj).find('#' + name);
	if (value != 1){
		$(parent_obj).hide();
		$(obj).removeAttr('name').val('');
		if (is_select == true){
			$(obj).next().find('input').val('');
		}
	} else {
		$(parent_obj).show();
		$(obj).attr('name',name);
	}
}

/**
 *
 * @param {type} obj
 * @param {type} type
 * @returns {undefined}
 */
function setFacProduct(obj){
    $.ajaxSettings.async = false;
    if(obj==null){
        var obj     = $dom.find('#factory_id');
        if($dom.find('#is_related_sale_order').val()!=0){
            type    = 0;
        }
    }
    var fac_id	= $(obj).val();
	var type	= type==0 ? 0 : 1;
	if(fac_id>0){
		if (type == 1) {
			var parent	= $(obj).parents('table').find('.detail_list tbody');
			$(parent).find('tr').each(function (){
				$(this).find('input[name*=product_id]').val('');
				$(this).find('#span_product_name').html('');
				$(this).find("input[name*='product_no]']").removeAttr("disabled").removeAttr("readonly").removeClass("disabled").val('').attr({'where':encodeURIComponent('factory_id='+fac_id),'jqac':true});
				$(this).find("input[name*='product_no]']").initAutocomplete();
                $(this).find("#product_id_show").removeAttr("disabled").removeAttr("readonly").removeClass("disabled").val('').attr({'where':encodeURIComponent('factory_id='+fac_id),'jqac':true});
				$(this).find("#product_id_show").initAutocomplete();
			})
		} else {
			var parent	= $(obj).parent('td').parent('tr');
			$(parent).find('input[name*=product_id]').val('');
			$(parent).find('#span_product_name').html('');
			$(parent).find("input[name*='product_no]']").removeAttr("disabled").removeAttr("readonly").removeClass("disabled").val('').attr({'where':encodeURIComponent('factory_id='+fac_id),'jqac':true});
			$(parent).find("input[name*='product_no]']").initAutocomplete();
		}
	}
}


/**
 * 设置箱号ID条件
 * @param {type} obj
 * @param {type} type
 * @returns {undefined}
 */
function setBoxWhere(obj){
	var instock_id = $.cParseInt($(obj).val());
	if(instock_id <= 0) return;
	var parent	= $(obj).parents('table').find('.detail_list tbody');
	$(parent).find('tr').each(function (){
		$(this).find("#box_id").val('');
		$(this).find(".box_id").removeAttr("disabled").removeAttr("readonly").removeClass("disabled").val('').attr({'where':encodeURIComponent('instock_id='+instock_id),'jqac':true});
		$(this).find(".box_id").initAutocomplete();
		$(this).find('#instock_detail_id').val('');
		$(this).find('#product_id').val('');
		$(this).find(".product_id").attr({disabled:'disabled',where:''}).addClass('disabled').val('');
		$(this).find('#product_no').text('');
		$(this).find('#autoshow_img').attr('pid','');
		$(this).find('#warehouse_id').val('');
		$(this).find('#location_id').val('');
		$(this).find('#barcode_no').val('');
		$(this).find('#barcode_no').removeAttr('where');
		$(this).find('#span_origin_quantity').text('');
		$(this).find('#origin_quantity').val('');
		$(this).find('#span_in_quantity').text('');
		$(this).find('#in_quantity').val('');
		$(this).find('#original_in_number').val('');
	});
}
/**
 * 设置产品ID条件
 * @param {type} obj
 * @param {type} type
 * @returns {undefined}
 */
function setProductWhere(obj){
	var box_id = $.cParseInt($(obj).val());
	var obj_parent = $(obj).parents('tr:first');
	if(box_id <= 0){ //清空
		$(obj_parent).find('#product_id').val('');
		$(obj_parent).find(".product_id").attr({disabled:'disabled',where:''}).addClass('disabled').val('');
		$(obj_parent).find('#product_no').text('');
		$(obj_parent).find('#autoshow_img').attr('pid','');
		$(obj_parent).find('#warehouse_id').val('');
		$(obj_parent).find('#location_id').val('');
		$(obj_parent).find('#barcode_no').val('');
		$(obj_parent).find('#barcode_no').removeAttr('where');
		$(obj_parent).find('#span_origin_quantity').text('');
		$(obj_parent).find('#origin_quantity').val('');
		$(obj_parent).find('#span_in_quantity').text('');
		$(obj_parent).find('#in_quantity').val('');
		$(obj_parent).find('#original_in_number').val('');
		return;
	}
	var instock_id = $.cParseInt($dom.find('#instock_id').val());
	$(obj_parent).find(".product_id").removeAttr("disabled").removeAttr("readonly").removeClass("disabled").val('').attr({'where':encodeURIComponent('instock_id='+instock_id+' and box_id='+box_id),'jqac':true});
	$(obj_parent).find(".product_id").initAutocomplete();
}

function in_array(needle, haystack) {
	type = typeof needle;
	if(type == 'string' || type =='number') {
		for(var i in haystack) {
			if(haystack[i] == needle)
				return true;
		}
	}
	return false;
}

function verifyQuantity(v){
	$error				  = $dom.find("#input_product_id_error");
	$error.html('');
	if(v){
		if(v>0){
			var product_id,quantity,verify_quantity;
			var product_array = [];
			var compelte_flag = false;
			$detail			  = $('.detail_list tbody tr:visible');
			$detail_length	  = $detail.length;
			$detail.each(function(key, value) {
				product_id	    = $.cParseFloat($(this).find('#product_id').val());
				quantity	    = $.cParseFloat($(this).find('#quantity').val());
				verify_quantity = $.cParseFloat($(this).find('#verify_quantity').val());
				product_array.push(product_id);
				if(product_id==v){
					if(quantity!=verify_quantity&&verify_quantity<quantity){
						$(this).find('#verify_quantity').val(verify_quantity+1);
						compelte_flag = false;
						return false;
					}else if(verify_quantity==quantity){
						compelte_flag = true;
					}
				}
			});
			if(!in_array(v,product_array)){
				$dom.find("#input_product_id").val('');
				$error.html(lang['sale']['no_product']+'：'+v);
				var t = setTimeout("$error.html('');",3000);
				return false;
			}
			if(compelte_flag==true){
				$dom.find("#input_product_id").val('');
				$error.html(lang['sale']['product_done']);
				var t = setTimeout("$error.html('');",3000);
				return false;
			}
		}else{
			$dom.find("#input_product_id").val('');
			$error.html(lang['sale']['no_product']+'：'+v);
			var t = setTimeout("$error.html('');",3000);
			return false;
		}
	}
}

function outStockReset(){
	$dom.find('#ac_search').trigger('click');
}

//出库订单自动加1
function autoQuantityPlus(v){
	if(v>0){
		var product_id,quantity,real_quantity;
		$('.detail_list tbody tr:visible').each(function() {
			product_id	  = $.cParseFloat($(this).find('#product_id').val());
			quantity	  = $.cParseFloat($(this).find('#quantity').val());
			real_quantity = $.cParseFloat($(this).find('#real_quantity').val());
			if(product_id==v&&quantity!=real_quantity&&real_quantity<quantity){
				$(this).find('#real_quantity').val(real_quantity+1);
				return false;
			}
		});
	}
}

function getWarehouseIdById(obj){
	var location_id = $.cParseInt(obj.value);
	if (location_id > 0) {
		$.getJSON(APP + '/Ajax/getWarehouseId', {location_id: location_id}, function(data) {
            $(obj).parents("tr:first").find("#warehouse_id").val(data.warehouse_id);
		});
	}
}

function updateRetuenService(obj){
	var quantity = $.cParseInt(obj.value);
	if(quantity==0){
		var big_obj				= $(obj).parents('tr:first');
		big_obj.find('#return_service').val('');
		big_obj.find('#icon').removeClass().addClass('icon icon-help');
	}
}

function submitImport(key,obj){
	$("#s_loading").show();
	clearTimeout(removeLoadTime);
	var removeLoadTime = setTimeout($.btnClose,30000);
	var extand_url	= '';
    if(key  == 'ExpressPost'){
        var in_type 	= $.cParseInt($(obj).parent().find("input[type='radio'][name='"+key+"_type']:checked").val());
    }else{
        var in_type 	= $.cParseInt($dom.find("input[type='radio'][name='"+key+"_type']:checked").val());
    }
    if(key =='ECPPSaleOrderImport' || key=='PayPalSaleOrderImport'){//新增速卖通	add by lxt 2015.07.22
        var file_name	= $(obj).parent().parent().find('#file_name').val();
    }else{
        var file_name	= $(obj).parent().find('#file_name').val();
    }
	var sheet		= $.cParseInt($(obj).attr('sheet'));
	var nowPage		= $.cParseInt($(obj).attr('nowPage'));
	var totalPages	= $.cParseInt($(obj).attr('totalPages'));
	var processCount= $.cParseInt($(obj).attr('processCount'));
	var parent_tr	= $(obj).parents('tr');
	var successCount= $.cParseInt($(obj).attr('successCount'));
    var sameRow     = $.cParseInt($(obj).attr('sameRow'));
	$("#progressbar").progressbar({
		value: nowPage == 1 ? 0 : nowPage,
		max: totalPages == 0 ? 100 : totalPages
	}).show();
	if (in_type == 3) {
		var main_field	= 'product';
		var parent		= $(obj).parents('th').parent().next();
		switch(key){
			case 'InstockDetail':
				var id	= $.cParseInt($dom.find("input[type='hidden'][name='id']").val());
				if (id >0) {
					extand_url	+= '/id/'+id;
				} else {
					main_field	= 'box';
				}
				break;
			case 'AdjustDetail':
				main_field	= 'detail';
				break;
			case 'AdjustInstockDetail':
				main_field	= 'detail';
				break;
            case 'InstockStorage':
                var id  = $dom.find("#instock_id").val();
                extand_url	+= '/instock_id/'+id;
                break;
		}
	}
	if (file_name) {
		if(key=='SaleOrderImport'||key=='ProductImport'||key=='ECPPSaleOrderImport'||key=='PayPalSaleOrderImport'||key=='ProductCheckImport'){//新增速卖通		add by lxt 2015.07.22
			$(obj).attr('disabled', 'disabled');
			parent_tr.find('#button_other').attr('disabled', 'disabled');
		}
		$.ajaxSettings.async = false;//禁用异步
		$.getJSON(APP+'/Ajax/imporExcel/key/'+key+'/file/'+file_name+'/in_type/'+in_type+'/sheet/'+sheet + '/nowPage/'+nowPage+'/sameRow/'+sameRow  + '/processCount/'+processCount + '/successCount/'+successCount + extand_url,function(result){
//			$.removeLoading();
			if (in_type == 3 && result.type == 3) {
				//填充input框值
				if(result.html_input){
					for(var i in result.html_input){
						$dom.find('#'+i).val(result.html_input[i]);
					}
				}
				if (result.html) {
					$(parent).find('.detail_list').parent().html(result.html);
					$(parent).find('.detail_list tbody tr:visible').each(function() {
						$(this).find("input[jqac]").each(function() {
							$(this).initAutocomplete();
						});
					});

					var detail_list = $(parent).find('.detail_list');
					if(detail_list){
						detail_list.bandCache();
						detail_list.bandTotalMethod();//明细表绑定合计事件
						detail_list.bandProductMethod();//明细表绑定合计事件
					}
				} else {
					var data	= result.data ? result.data : result.detail;
					if (data) {
						var first_obj = $(parent).find('.detail_list').find('tbody').find('tr:visible:first');
						var list_row = $(parent).find('.detail_list').find('tbody').find('tr:visible').size();
						for (i = 1; i <= list_row; i++){//查找插入行
							if (first_obj.find("input[name*='" + main_field +  "_id]']").val() < 1 || !first_obj.find("input[name*='" + main_field +  "_no]']").val() || i == list_row) {
								break;
							} else {
								first_obj = first_obj.next();
							}
						}
						for(var i in data){//循环插入数据
							var row	= data[i];
							var row_obj	= '';
							if (first_obj.find("input[name*='" + main_field +  "_id]']").val() < 1 || !first_obj.find("input[name*='" + main_field +  "_no]']").val()) {
								row_obj = first_obj;
							} else {
								row_obj = $.copyRowWithFrom($(first_obj).find('td:last').find('span[class*="icon-add-plus"]'));
							}
							for(var name in row){
								$(row_obj).find('input[name*="' + name +  ']"]').trigger('change').trigger('keyup');
							}
						}
					}
				}
				//将数据存放到textarea中，并隐藏导入按钮
				$(obj).parent().append('<textarea name="ser_detail">' + result.ser_detail + '</textarea>').parents('table:first').hide();
			} else if (result.type == 6 || result.type == 7) {
				$(obj).attr({
					'nowPage'		: result.nextPage,
					'totalPages'	: result.totalPages,
					'processCount'	: result.processCount,
					'successCount'	: result.successCount,
                    'sameRow'       : result.sameRow
				});
				submitImport(key, obj);
			} else {
				$("<div>"+result.msg+"</div>").dialog({
					width: 500,
					height: 300,
					buttons: {
						Ok: function() {
							$( this ).dialog( "close" );
						}
					},
					beforeClose: function(){
						if (in_type == 3) {
							$(obj).attr('disabled', 'disabled');
							parent_tr.find('#file_upload').val('');
							parent_tr.find('#upload_response').html('');
						} else {
							loadTab();
						}
					}
				});
			}
			//reload
	//		location.reload();
		})
	}
	$("#s_loading").hide();
	$("#progressbar").progressbar('destroy').hide();
	return true;
}


/**
 * 厂家限制关联单号
 * @author jph 20140522
 */
function factoryLimitFundsRelationDoc(type){
	var factory_id	= $dom.find('#comp_id').val();
    if(factory_id > 0){
        switch(type){
            case 1:
                var where	= 'factory_id=' + factory_id ;
                break;
            case 2:
                var where	= 'b.company_id=' + factory_id ;
                break;
            case 3:
                var where	= 'logistics_id=' + factory_id ;
                break;
            case 4:
                var where	= 'warehouse_id=' + factory_id ;
                break;
            default:
                var where	= 'factory_id=' + factory_id;
                break;
        }
    }else{
         var where = '';
    }
	$dom.find('#object_id').val('').trigger('change');
	$dom.find('#reserve_id').val('').attr('where', where).initAutocomplete();
}

/**
 * 款项类型设置关联单据
 * @author jph 20140522
 */
function setFundsRelationDoc(){
	var pay_class_id	= $dom.find('#pay_class_id').val();
	var relation_type	= 0;
	if (pay_class_id > 0) {
		$.ajax({
			url:APP+'/Ajax/getFundsRelationType',
			type:'post',
			data:{ 'id':pay_class_id },
			async:false,
			success:function(result){
				relation_type	= result;
                if(relation_type>0){
                    $dom.find('#relation_type').parent().show();
                }else{
                    $dom.find('#relation_type').parent().hide();
                }
            }
		});
	}
	if (relation_type > 0) {
        if (relation_type == 4) {
            $dom.find('#warehouse_id').parent().show();
            $dom.find('#warehouse_id').val('');
            $dom.find('#warehouse_name_use').val('');
        }else{
            $dom.find('#warehouse_id').parent().hide();
            $dom.find('#warehouse_id').val('');
            $dom.find('#warehouse_name_use').val('');
        }
		$dom.find('#reserve_require_span').show();
		$dom.find('#relation_doc_title').show();
		$dom.find('#relation_doc_content').show();
	} else {
        $dom.find('#warehouse_id').parent().show();
        $dom.find('#warehouse_id').val('');
        $dom.find('#warehouse_name_use').val('');
		$dom.find('#reserve_require_span').hide();
		$dom.find('#relation_doc_title').hide();
		$dom.find('#relation_doc_content').hide();
	}
	$dom.find('#relation_type').val(relation_type);
	$dom.find('#object_id').val('').trigger('change');
	$dom.find('#reserve_id').val('').attr('url', APP+'/AutoComplete/fundsRelationDocNo/relation_type/' + relation_type).initAutocomplete();
}


/**
 * 获取关联单据信息
 * @author jph 20140522
 */
function getFundsRelationDocInfo(){
	var id				= $dom.find('#object_id').val();
	var relation_type	= $dom.find('#relation_type').val();
	var html			= '';
	if (id > 0 && relation_type > 0) {
		$.ajaxSettings.async = false;//禁用异步
		$.getJSON(APP+'/Ajax/getFundsRelationDocInfo/id/'+id+'/relation_type/'+relation_type,function(result){
			html	= result.html;
            if(relation_type!=0&&relation_type!=4){
                $dom.find('#warehouse_id').val(result.info.warehouse_id);
            }
		});
	}
	$dom.find('#relation_doc_content').find('td').html(html);
}

function getFundsInfo(v){
	var funds_info	= $dom.find('#funds_info');
	if(v==1){
		if ($.cParseInt($(funds_info).parent().attr('is_load')) !== 1) {
			var html	= $("#s_success").html();
			$("#s_loading").show();
			$("#s_success").show().css('z-index', $.cParseInt($("#s_success").css('z-index'))+$.cParseInt($("#s_loading").css('z-index'))+1).html('数据加载中，请耐心等待');
			var url				= APP +'/Ajax/getFundsInfo';
			var url_parameter	= ['module_name', 'basic_id', 'comp_id', 'currency_id'];
			for (var i in url_parameter) {
				url		+= '/' + url_parameter[i] + '/' + $dom.find('#' + url_parameter[i]).val();
			}
			$.getJSON(url,function(result){
				$(funds_info).parent().html(result.html).attr('is_load', 1);
				$("#s_loading").hide();
				$("#s_success").hide().css('z-index', $.cParseInt($("#s_success").css('z-index'))-$.cParseInt($("#s_loading").css('z-index'))-1).html(html);
			});
		}
		$(funds_info).show();
//			$(funds_info).find("[name^='check_info']").attr("checked",'true');//全选
	}else{
		$(funds_info).hide().find("[name^='check_info']").attr("checked", false);//取消全选
	}
}

function checkAllInfo(obj) {
	var check_all	= $.cParseInt($(obj).data('check_all')) == 0 ? 1 : 0;
	$(obj).parents('table:first').find("[name^='check_info']").each(function (){
		$(this).attr('checked', check_all == 0 ? false : true);
	})
	$(obj).data('check_all', check_all);
}

/* 读取对应仓库的快递公司 */
function getExpressCompany(obj){
	var warehouse_id	= $(obj).val();
	$dom.find("#company_id").val('');
    $dom.find('#company_name').val('').attr({'where':encodeURIComponent('warehouse_id='+warehouse_id),'jqac':true}).initAutocomplete();
}

function toggle(obj, sign){
	if (sign) {
		$(obj).show();
	} else {
		$(obj).hide();
	}
}

/**
 * 退货切换是否关联处理单号
 * @author jph 20141110
 * @param {object} obj
 * @param {int} IS_RELATED_SALE_ORDER
 * @returns {undefined}
 */
function whetherRelatedDealNo(obj, IS_RELATED_SALE_ORDER){
	var parent		= $(obj).parent();
	var prev_value	= $(parent).data('prev_value');
	var fields = ['li_sale_order_no', 'li_track_no', 'li_order_date'];
	var is_related_sale_order	= $.cParseInt($(obj).val());
    if(is_related_sale_order == 1){
        $dom.find('#warehouse_name').attr({'where':encodeURIComponent('is_return_sold=1'),'jqac':true}).initAutocomplete();
    }else{
        $dom.find('#warehouse_name').attr({'where':'','jqac':true}).initAutocomplete();
    }
    $dom.find('#is_related_sale_order').val(is_related_sale_order);
	if (prev_value != 'undefined' && prev_value == is_related_sale_order){
		return;
	}
	$.loading();
	$(parent).data('prev_value', is_related_sale_order)
	var is_related	= is_related_sale_order == IS_RELATED_SALE_ORDER ? true : false;
	for(var i in fields){
		var cur_obj	= $dom.find('#' + fields[i]);
		toggle(cur_obj, is_related);
		$(cur_obj).find('input').val('');
	}
    if(is_related){
        $dom.find('#order_no').attr('readonly', true).addClass('disabled').val('');
    }else{
        $dom.find('#order_no').removeAttr("readonly").removeClass("disabled");
    }
    if($dom.find('#factory_name').val()!=undefined){
        $dom.find('#factory_id').val('');
    }
	$dom.find('#comments').val('');
	var li_client_name	= $dom.find('#li_client_name');
	var client_name		= $(li_client_name).find('#client_name');
	$(li_client_name).toggleClass('w320', !is_related);
	toggle($(li_client_name).find('#quicklyAddClient'), !is_related);
	toggleDisabledOrAutoComplete($(client_name), is_related, '/AutoComplete/buyer');
//	var li_warehouse	= $dom.find('#li_warehouse');
//	if (li_warehouse) {
//		toggle($(li_warehouse), !is_related);
//		toggleDisabledOrAutoComplete($(li_warehouse).find('#warehouse_name'), is_related, '/AutoComplete/warehouseNameUse');
//	}
	var li_factory	= $dom.find('#li_factory');
	if (li_factory) {
		toggle($(li_factory), !is_related);
//		toggleDisabledOrAutoComplete($(li_warehouse).find('#factory_name'), is_related, '/AutoComplete/factory');
	}
	getReturnOrderDetail(is_related_sale_order);
	getClientInfoHtml(!is_related);
	toggleDisabled($dom.find('#comments'), is_related);
	$.removeLoading();
	//getSaleOrderInfo();//防止切换导致库位无法autosearch	add by lxt 2015.07.06
}

/***
 * 切换文本框可写状态
 * @author jph 20141110
 * @param {object} obj
 * @param {boolean} disabled
 * @returns {undefined}
 */
function toggleDisabled(obj, disabled){
	$(obj).val('');
	if (disabled === true) {
		$(obj).addClass("disabled").attr('readonly', true);
	} else {
		$(obj).removeClass("disabled").removeAttr('readonly');
	}
}

/**
 * 切换文本框只读状态或autocomplete输入
 * @author jph 20141110
 * @param {object} obj
 * @param {Boolean} disabled
 * @param {string} url
 * @param {string} where
 * @returns {undefined}
 */
function toggleDisabledOrAutoComplete(obj, disabled, url, where){
	$(obj).val('').prev().val('');
	if (disabled === true) {
		$(obj).removeAttr("jqac").unbind("click").unbind("blur").autocomplete("destroy").addClass("disabled").attr('readonly', true);
	} else {
		url		= url ? APP + url : $(obj).attr('url');
		where	= where ? encodeURIComponent(where) : $(obj).attr('where');
		$(obj).removeClass("disabled").removeAttr('readonly').attr({jqac:true, url: url, where: where}).initAutocomplete();
	}
}

/**
 * 获取买家信息
 * @author jph 20141110
 * @param {boolean} not_readonly
 * @returns {undefined}
 */
function getClientInfoHtml(not_readonly){
	var async				= $.ajaxSettings.async;
	$.ajaxSettings.async	= true;//禁用异步
	$dom.find('#client_info')
	.load(APP+'/Ajax/getClientInfoHtml', {not_readonly: not_readonly ? 'true' : 'false', client_id: $dom.find('#client_id').val()}, function (response,status,xhr){
		$(this).find('input[jqac]').each(function(){
			$(this).initAutocomplete();
		});
	})
	$.ajaxSettings.async	= async;
}


/**
 * 获取关联单据信息
 * @author jph 20141110
 * @param {boolean} not_related
 * @returns {undefined}
 */
function getReturnOrderDetail(is_related_sale_order){
    var sale_order_id			= $dom.find('#sale_order_id').val();
    var return_sale_order_state = $dom.find('#return_sale_order_state').val();
    var id						= $dom.find('#id').val();
	var async					= $.ajaxSettings.async;
	$.ajaxSettings.async		= false;//禁用异步
	$dom.find('#return_order_detail')
	.load(APP+'/Ajax/getReturnOrderDetail', {is_related_sale_order: is_related_sale_order,return_sale_order_state:return_sale_order_state,id:id,sale_order_id:sale_order_id})
	.find('input[jqac]').each(function(){
		$(this).ready().initAutocomplete();
	});
    setFacProduct();
	$.ajaxSettings.async		= async;
}

/**
 * 获取关联单据信息
 */
function getQuestionOrderDetail(){
	var async				= $.ajaxSettings.async;
	$.ajaxSettings.async	= true;//禁用异步
    var warehouse_id		= $dom.find('#warehouse_id').val();
	$dom.find('#question_order_detail')
	.load(APP+'/Ajax/getQuestionOrderDetail', {warehouse_id:warehouse_id})
	.find('input[jqac]').each(function(){
		$(this).ready().initAutocomplete();
	});
    setFacProduct();
	$.ajaxSettings.async	= async;
}

    /**
     * 改变发货入库 发货按钮显示为保存
     * @param {type} obj
     * @returns {undefined}
     */

function changeSaveTitle(obj){
	var sale_order_state	= $(obj).val();
    if(sale_order_state == 8 || sale_order_state == 9 |sale_order_state == 13){
        $('.button_out_stock').children().eq(0).val(lang['common']['save']);
    }else{
        $('.button_out_stock').children().eq(0).val(lang['common']['out_stock']);
    }
};

    /**
     * 设置该开户人下的银行简称
     * @param {type} obj
     * @returns {undefined}
     */

function getPayBankSelect(obj,currency_id){
	var contact_name	= $(obj).val();
    $dom.find('#pay_transfer_bank_name').val('').attr({'where':encodeURIComponent("contact ='" +contact_name+"' and currency_id in "+currency_id),'jqac':true}).initAutocomplete();
};
function setPackState(obj){
    var return_reason  =$(obj).val();
    var outer_pack      = $dom.find('#outer_pack');
    var within_pack     = $dom.find('#within_pack');
    if(return_reason==3||return_reason==4||return_reason==5){//CHECK_PACK_RETURN_REASON
			$(outer_pack).parent().show();
			$(within_pack).parent().show();
            setOuterPack(outer_pack);
            setWithinPack(within_pack);
		} else {
        	$(outer_pack).parent().hide();
			$(within_pack).parent().hide();
            $dom.find('#outer_pack_id').parent().hide();
            $dom.find('#within_pack_id').parent().hide();
    }
};
function warehouseSetLocation(type_name){
    var warehouse_id    = $dom.find('#warehouse_id').val();
    if(warehouse_id>0){
        var where   = "warehouse_id in ("+warehouse_id+"_warehouse_id)";
    }else{
        var where   = 1;
    }
	if(warehouse_id>0){
        $dom.find('.detail_list tbody tr').each(function (){
            if(type_name != 'return_sale_order_state'){
                $(this).find('input[name*=location_id]').val('');
                $(this).find("input[name*='location_no]']").val('');
            }
            $(this).find("input[name*='location_no]']").removeAttr("disabled").removeAttr("readonly").removeClass("disabled").attr({'where':where,'jqac':true});
            $(this).find("input[name*='location_no]']").initAutocomplete();
        })
	}
}
function setLocationWhere(){
    var warehouse_id    = $dom.find('#warehouse_id').val();
    if(warehouse_id>0){
        var where   = "warehouse_id in ("+warehouse_id+")";
    }else{
        var where   = 1;
    }
    $dom.find('input[name*=location_id]').val('');
    $dom.find("input[name*='location_no]']").val('').attr({'where':where,'jqac':true});
    $dom.find("input[name*='location_no]']").initAutocomplete();
}

function editCell(obj,id,col){
    var cell_obj    = $(obj).parent().children();
    if ($(cell_obj).eq(0).is(":visible")) {
        var value   = $(cell_obj).eq(1).val();
        $.getJSON(APP + '/Ajax/editCell', {id: id,col:col,value:value,type:1}, function(data) {
            $(cell_obj).eq(1).val(data.result.value);
            $(cell_obj).eq(0).hide();
            $(cell_obj).eq(1).show();
            $(obj).removeClass("icon-list-edit");
            $(obj).addClass("icon-list-view");
        });
    } else {
        //保存input内容
        var value   = $(cell_obj).eq(1).val();
        $.getJSON(APP + '/Ajax/editCell', {id: id,col:col,value:value,type:2}, function(data) {
            $(cell_obj).eq(0).html(data.result.value);
            $(cell_obj).eq(0).show();
            $(cell_obj).eq(1).hide();
            $(obj).removeClass("icon-list-view");
            $(obj).addClass("icon-list-edit");
            if (data.status <= 0) {
                $(cell_obj).eq(1).val(data.result.value);
                $("<div>" + data.info + "</div>").dialog({
                    modal: true,
                    resizable: false,
                    show: "Clip",
                    buttons: {
                        Ok: function() {
                            $(this).remove();
                        }
                    }
                });
            }
		});
    }
}
/* 读取对应仓库的处理单号 */
function setSaleOrderWhere(){
	var warehouse_id	= $.cParseInt($dom.find('#warehouse_id').val());
    $dom.find('#sale_order_no').show();
    $dom.find('#readonly_sale_order_no').hide();
	$dom.find("#sale_order_id").val('');
    $dom.find('#sale_order_no').val('').attr({'where':encodeURIComponent('warehouse_id='+warehouse_id),'jqac':true}).initAutocomplete();
    $dom.find('#outer_pack_name').val('').attr({'where':encodeURIComponent('warehouse_id='+warehouse_id),'jqac':true}).initAutocomplete();
    $dom.find('#within_pack_name').val('').attr({'where':encodeURIComponent('warehouse_id='+warehouse_id),'jqac':true}).initAutocomplete();

    //基本信息
    $dom.find('#order_no').val('');
    $dom.find('#client_id').val('');
    if($dom.find('#factory_name').val()!=undefined || $dom.find('#is_related_sale_order').val()==1){
        $dom.find('#factory_id').val('');
    }
    $dom.find('#client_name').val('');
    $dom.find('#track_no').val('');
    $dom.find('#order_date').val('');
    //客户信息
    $dom.find('#consignee').val('');
    $dom.find("#country_name").val('');
    $dom.find("#city_name").val('');
    $dom.find('#email').val('');
    $dom.find('#tax_no').val('');
    $dom.find('#address').val('');
    $dom.find('#address2').val('');
    $dom.find('#company_name').val('');
    $dom.find('#post_code').val('');
    $dom.find('#mobile').val('');
    $dom.find('#fax').val('');
    $dom.find('#transmit_name').val('');
    $dom.find('#country_id').val('');
    $dom.find("#full_country_name").val('');
    $dom.find("#comments").val('');
    getSaleOrderInfo();
}

/* 读取对应仓库的处理单号 */
function setQuestionOrderWhere(){
	var warehouse_id	= $.cParseInt($dom.find('#warehouse_id').val());
    $dom.find('#sale_order_no').show();
    $dom.find('#readonly_sale_order_no').hide();
	$dom.find("#sale_order_id").val('');
    $dom.find('#sale_order_no').val('').attr({'where':encodeURIComponent('warehouse_id='+warehouse_id),'jqac':true}).initAutocomplete();

    //基本信息
    $dom.find('#order_no').val('');
    $dom.find('#client_id').val('');
	$dom.find('#express_name').val('');
    if($dom.find('#factory_name').val()!=undefined){
        $dom.find('#factory_id').val('');
    }
    $dom.find('#client_name').val('');
    $dom.find('#track_no').val('');
    $dom.find('#order_date').val('');
    //客户信息
    $dom.find('#consignee').val('');
    $dom.find("#country_name").val('');
    $dom.find("#city_name").val('');
    $dom.find('#email').val('');
    $dom.find('#tax_no').val('');
    $dom.find('#address').val('');
    $dom.find('#address2').val('');
    $dom.find('#company_name').val('');
    $dom.find('#post_code').val('');
    $dom.find('#mobile').val('');
    $dom.find('#fax').val('');
    $dom.find('#transmit_name').val('');
    $dom.find('#country_id').val('');
    $dom.find("#full_country_name").val('');
    $dom.find("#comments").val('');
    getQuestionInfo();
}



/*包装改变总质量也改变*/
function weightByPackage(obj){
    var package_id  = $(obj).val();
    var id          = $dom.find('#id').val();
    $.getJSON(APP + '/Ajax/weightByPackage', {id: id,package_id:package_id}, function(data) {
        $dom.find('#total_weight').html(data.s_unit_weight);
    });
}
//显示外包装
function setOuterPack(obj){
    var pack_state  = $(obj).val();
    if(pack_state == 2){
        $dom.find('#outer_pack_id').parent().show();
        $dom.find('#outer_pack_quantity').parent().show();
    }else{
        $dom.find('#outer_pack_id').parent().hide();
        $dom.find('#outer_pack_quantity').parent().hide();
    }
};
//显示内包装
function setWithinPack(obj){
    var pack_state  = $(obj).val();
    if(pack_state == 2){
        $dom.find('#within_pack_id').parent().show();
        $dom.find('#within_pack_quantity').parent().show();
    }else{
        $dom.find('#within_pack_id').parent().hide();
        $dom.find('#within_pack_quantity').parent().hide();
    }
};
function emptyClient(){
    $dom.find('#client_id').val('');
    $dom.find('#client_name').val('');
    $dom.find('#consignee').val('');
    $dom.find("#country_name").val('');
    $dom.find("#city_name").val('');
    $dom.find('#email').val('');
    $dom.find('#tax_no').val('');
    $dom.find('#address').val('');
    $dom.find('#address2').val('');
    $dom.find('#company_name').val('');
    $dom.find('#post_code').val('');
    $dom.find('#mobile').val('');
    $dom.find('#fax').val('');
    $dom.find('#country_id').val('');
    $dom.find("#full_country_name").val('');
}
function hiddenAdd(){
    var return_sale_order_state     = $dom.find('#return_sale_order_state').val();
    var is_related_sale_order       = $dom.find("input[name='is_related_sale_order']").val();
    if(is_related_sale_order==0 && (return_sale_order_state == 1 || return_sale_order_state == 9)){
        $dom.find("span[class='icon icon-add-plus']").show();
    }else{
        $dom.find("span[class='icon icon-add-plus']").hide();
    }
    hiddenReturnData($dom.find('#return_sale_order_state'));
}
function hiddenReturnData(obj){
    var return_sale_order_state = $(obj).val();
    if(return_sale_order_state == 4 || return_sale_order_state==17){
        $dom.find("#returned_date").parent().show();
    }else{
        $dom.find("#returned_date").parent().hide();
    }
}

function showRelationWarehouse(obj){
    var relation_warehouse_id     = $(obj).val();
    if(relation_warehouse_id == 2){
        $dom.find("#relation_warehouse_id").parent().parent('tr').show();
    }else{
        $dom.find("#relation_warehouse_id").parent().parent('tr').hide();
    }
}
function showWarehouse(obj){
    var relation_warehouse_id     = $(obj).val();
    if(relation_warehouse_id == 2){
        $dom.find("#warehouse_id").parent().show();
    }else{
        $dom.find("#warehouse_id").val('');
        $dom.find("#w_name").val('');
        $dom.find("#warehouse_id").parent().hide();
    }
    setLocationWhere();
}
function setFactory(obj){
    var factory_id	= $.cParseInt($(obj).val());
    var where		= 'factory_id='+factory_id;
	$dom.find('#stat_p_id').val('');
    $dom.find("#product_no").val('').attr({'where':where,'jqac':true}).initAutocomplete();
}
function isEditService(){
    var is_edit_service = $dom.find("#is_edit_service").val();
    if(is_edit_service  == 1){
        $("<div>"+lang['common']['return_service']+"</div>").dialog({
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
		});
    }
}
//新拣货导出 新增是否仓库自提 add by ljw 20150728
function isWareHousePickUp(){
    var sale_order_no             = $dom.find("#sale_order_no");
    var is_warehouse_pickup = $dom.find("#is_warehouse_pickup");
    if(is_warehouse_pickup.is(':checked')){
        sale_order_no.parent().show();
    }else{
        sale_order_no.val('');
        sale_order_no.parent().hide();
    }
}
//新拣货导出 过滤派送方式 add by lml 20151123
function  filterExpressWay(){
    var warehouse_id  = $dom.find("#warehouse_id").val();
    var where         ="warehouse_id="+warehouse_id;
    $dom.find('#is_warehouse_pickup').attr('disabled',false);
    $dom.find("#express_id").val('');
    $dom.find("#express_name").val('').attr({where:where,jqac:true}).initAutocomplete();
}

//新拣货导出 处理单号增加过滤 add by ljw 20150728
function  filterPickingSaleOrderNO(){
    var fields      = ['warehouse_id', 'factory_id', 'out_stock_type'];
    var where       = '';
    for (var i in fields) {
        var value  = $dom.find("#"+fields[i]).val();
        if (value > 0) {
            where	+= ' and a.' + fields[i] + ' = ' + value;
        }
    }
    $dom.find("#sale_order_no").val('').attr({'where':$dom.find("#sale_order_no").attr('init_where') + encodeURIComponent(where),'jqac':true}).initAutocomplete();
}
//控制自提
function controlPick(){
    var express_id  = $dom.find("#express_id").val();
    var company_id  = $dom.find("#company_id").val();
    if(express_id>0 || company_id>0 ){
	$dom.find('#is_warehouse_pickup').attr('disabled','disabled');
    }else{
	$dom.find('#is_warehouse_pickup').attr('disabled',false);
    }
}
//问题订单处理方式
function getProcessMode(){
    var question_order_state    = $dom.find("#question_order_state").val();
    var compensation    = $dom.find('#compensation').val();
    var proof_delivery  = $dom.find('#proof_delivery').val();
    if(question_order_state>10){
        switch(question_order_state){
            case '20':
                $dom.find('#process_mode').val('5');
                $dom.find('#process_mode_name').val(lang['question']['pending_warehouse']);
                $dom.find('#proof_delivery_fee').parent().show();
                $dom.find('#proof_delivery_fee').val(proof_delivery);
                $dom.find('#compensation_fee').parent().show();
                $dom.find('#compensation_fee').val(compensation);
                $dom.find('#finish_date').parent().hide();//已完成日期	add by lxt 2015.06.05
                $dom.find('#mobile').parent().show();//买家电话	add by lxt 2015.06.11
                break;
            case '30':
                $dom.find('#process_mode').val('50');
                $dom.find('#process_mode_name').val(lang['question']['has_compensation']);
                $dom.find('#proof_delivery_fee').parent().show();
                $dom.find('#proof_delivery_fee').val(proof_delivery);
                $dom.find('#compensation_fee').parent().show();
                $dom.find('#compensation_date').parent().show();
                $dom.find('#compensation_fee').val(compensation);
                //买家电话		add by lxt 2015.06.11
                $dom.find('#mobile').parent().hide();
                $dom.find('#mobile').attr("readonly",true).addClass("disabled").val('');
                break;
            default:
                $dom.find('#process_mode').val('');
                $dom.find('#process_mode_name').val('');
                break;
        }
        $dom.find('#process_mode').parent().show();
        ProcessMode();
        $dom.find('#process_mode_name').attr({"where":question_order_state,"jqac":true}).initAutocomplete(); ;
    }else{
        $dom.find('#process_mode').parent().hide();
        $dom.find('#proof_delivery_fee').parent().hide();
        $dom.find('#proof_delivery_fee').val('');
        $dom.find('#compensation_fee').parent().hide();
        $dom.find('#compensation_date').parent().hide();
        $dom.find('#compensation_fee').val('');
        $dom.find('#process_mode').val('');
        $dom.find('#finish_date').parent().hide();//已完成日期	add by lxt 2015.06.05
        //买家电话	  add by lxt 2015.06.11
        $dom.find('#mobile').parent().hide();
        $dom.find('#mobile').attr("readonly",true).addClass("disabled").val('');
        ProcessMode();
    }
}
//问题订单上传问题图片
function showUploadPic(){
    var question_reason =  $dom.find('#question_reason').val();
    if(question_reason == 30){
        $dom.find('#question_pics').show();
        $dom.find('#question_pics_show').show();
    }else{
        $dom.find('#question_pics').hide();
        $dom.find('#question_pics_show').hide();
    }
}
//问题订单上传签收证明方案1
function ProcessMode(){
    var process_mode = $dom.find('#process_mode').val();
    var compensation    = $dom.find('#compensation').val();
    var proof_delivery  = $dom.find('#proof_delivery').val();
    if(process_mode == 20){
        $dom.find('#invoice_file').show();
        $dom.find('#invoice_file_show').show();
        $dom.find('#mobile').attr("readonly",true).addClass("disabled").val($dom.find("#mobile").attr("org_value"));//买家电话	add by lxt 2015.06.11
    }else if(process_mode == 30){
        $dom.find('#proof_delivery_fee').removeAttr("readonly").removeClass("disabled");
        $dom.find('#compensation_fee').val(compensation);
        $dom.find('#compensation_fee').attr('readonly', true).addClass('disabled');
        $dom.find('#compensation_date').parent().hide();
        $dom.find('#compensation_date_show').show();
        $dom.find('#transaction_proof').show();
        $dom.find('#transaction_proof_show').show();
        $dom.find('#mobile').attr("readonly",true).addClass("disabled").val($dom.find("#mobile").attr("org_value"));//买家电话	add by lxt 2015.06.11
    }else if(process_mode==50){
        $dom.find('#compensation_fee').removeAttr("readonly").removeClass("disabled");
        $dom.find('#compensation_date').parent().show();
        $dom.find('#compensation_date_show').hide();
        $dom.find('#proof_delivery_fee').val(proof_delivery);
        $dom.find('#proof_delivery_fee').attr('readonly', true).addClass('disabled');
        $dom.find("#finish_date").parent().hide();
        $dom.find('#mobile').attr("readonly",true).addClass("disabled").val($dom.find("#mobile").attr("org_value"));//买家电话	add by lxt 2015.06.11
    }else if(process_mode==45){

        $dom.find("#mobile").parents().show();
    	$dom.find("#mobile").removeClass("disabled").removeAttr("readonly");//买家电话	add by lxt 2015.06.11
    }else{
    	//处理完成日期	add by lxt 2015.06.26
    	if(process_mode==60){
    		$dom.find("#finish_date").parent().show();
    	}else{
    		$dom.find("#finish_date").parent().hide();
    	}
        $dom.find('#compensation_fee').val(compensation);
        $dom.find('#proof_delivery_fee').val(proof_delivery);
        $dom.find('#proof_delivery_fee').attr('readonly', true).addClass('disabled');
        $dom.find('#compensation_fee').attr('readonly', true).addClass('disabled');
        $dom.find('#compensation_date').parent().hide();
        $dom.find('#compensation_date_show').show();
        $dom.find('#mobile').attr("readonly",true).addClass("disabled").val($dom.find("#mobile").attr("org_value"));//买家电话	add by lxt 2015.06.11
    }
}
function SetWarehouseLocation(){
    var is_return_sold  = $dom.find('input[type=radio]:checked').val();
    $dom.find('#w_name').val('');
    $dom.find('#warehouse_id').val('');
    $dom.find('#location_id').val('');
    $dom.find('#location_no').val('');
    $dom.find('#w_name').attr({"where":"is_return_sold="+is_return_sold,"jqac":true}).initAutocomplete();
    $dom.find('#location_no').attr({"where":"w.is_return_sold="+is_return_sold,"jqac":true}).initAutocomplete();
}

function AllDelete(){
    var error   = new Array();
    var num     = 0;
    var result  = '';
    $("#dialog:ui-dialog").dialog("destroy");
    $("#dialog-confirm").dialog({
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "yes": function() {
                $(this).dialog("close");
                $dom.find('.icon-pattern-check').each(function(){
                    var id  = $(this).attr('value');
                    $.ajax({
                        url:APP+'/SaleOrder/delete/id/'+id,
                        type:'post',
                        dataType:'json',
                        async : false,
                        data:{ 'referer':'js' },
                        success:function(data){
                            if(data.status == 0){
                                error[num++]  = id;
                            }else{
                               result   = data;
                            }
                        }
                    });
                });
                if(error && error.length > 0){
                    $.getJSON(APP + '/Ajax/getSaleOrderNo', {'id[]': error}, function(data) {
                        if(result != ''){
                            result.data.href += '/s_r/1';
                            linkTab(result.data.href,result.data.title,1);
                        }
                        $("<div>"+data+"</div>").dialog({
                            modal: true,
                            buttons: {
                                Ok: function() {
                                    $( this ).dialog( "close" );
                                }
                            }
                        });
                    });
                }else{
                    result.data.href += '/s_r/1';
                    linkTab(result.data.href,result.data.title,1);
                }
            },
            "no": function() {
                $(this).dialog("close");
            }
        }
    });
}

//订单处理费用按重量或者按数量	add by lxt 2015.06.19
function AccordType(value){
	if(value==1){
		$dom.find("#accord_weight").hide();
		$dom.find("#accord_weight").find("input").each(function(){
			$(this).val("").attr("disabled","true");
		});
		$dom.find(".accord_quantity").show().find("input").each(function(){
			$(this).removeAttr("disabled");
		});
	}else{
		$dom.find(".accord_quantity").hide();
		$dom.find(".accord_quantity").find("input").each(function(){
			$(this).val("").attr("disabled","true");
		});
		$dom.find("#accord_weight").show().find("input").each(function(){
			$(this).removeAttr("disabled");
		});
	}
}


function getLocationInfo () {
    var location_id     = $dom.find('#location_id').val();
    if(location_id > 0){
        $dom.find('#select_product_show').load(APP+'/DomesticWaybill/selectProduct',{location_id:location_id});
    }
}

function allCheck(){
    $dom.find('.icon-pattern-nocheck').removeClass().addClass('icon icon-pattern-check');
}

function reverseCheck(){
    $dom.find('#select_product_show').find('td').children().each(function(){
        var class_name  = $(this).attr('class');
        if(class_name   == 'icon icon-pattern-nocheck'){
            $(this).removeClass().addClass('icon icon-pattern-check');
        }else if(class_name   == 'icon icon-pattern-check'){
            $(this).removeClass().addClass('icon icon-pattern-nocheck');
        }
    });
}

/*
 * 国内运单新增产品
 */
function addProductToDetail(){
    var storage_id  = new Array();
    var key         = 0;
    $dom.find('.icon-pattern-check').each(function(){
        if($(this).attr('value')>0){
            storage_id[key]    = $(this).attr('value');
            key++;
        }
    });
    if(storage_id && storage_id.length > 0){//实际库存ID return array;
        $.getJSON(APP+"/Ajax/getStorageInfo",{"storage_id[]":storage_id},function(data){
            if(data != null){
                $.each(data,function(key,item){
                    var detail_table_last = $dom.find('#detail_table:last').find('tbody');
                    var first_obj 	= detail_table_last.find('tr:visible:first');
                    var list_row	= detail_table_last.find('tr:visible').size();
                    for (var i = 1; i <= list_row; i++)
                    {
                        if (first_obj.find("#product_id").val() < 1 || (!first_obj.find("#span_product_no").length>0 && first_obj.find("#span_product_no").val())){
                            first_obj	=	first_obj;
                        }else{
                            if(i==list_row){
                                first_obj	=	first_obj;
                            }else{
                                first_obj	=	first_obj.next();
                            }
                        }
                    }
                    if (first_obj.find("#product_id").val() < 1 || (!first_obj.find("#span_product_no").length>0 && first_obj.find("#span_product_no").val())){
                        var new_obj = first_obj;
                    } else {
                        var new_obj = $.copyRowWithFrom($(first_obj).find('td:last').find('span[class*="icon-del-plus"]'));
                    }
                    $(new_obj).find("#product_id").val(item.product_id);
                    $(new_obj).find("#span_product_no").html(item.product_no+$(new_obj).find("#span_product_no").html());
                    $(new_obj).find("#autoshow_img").attr('pid',item.product_id);
                    $(new_obj).find("input[name*='product_id]']").val(item.product_id);
                    $(new_obj).find("input[name*='barcode_no]']").val(item.location_no);
                    $(new_obj).find("#span_product_name").html(item.product_name);
                    $(new_obj).find("#location_id").val(item.location_id);
                    $(new_obj).find("#storage_quantity").val(item.quantity);
                    $(new_obj).find("#quantity").val(item.quantity);
                    $(new_obj).find("#warehouse_id").val(item.warehouse_id);
                    $.sumTotal(new_obj);
                });
            }else{
					alert('失败了,请联系系统管理员!!')
            };
        });
    }
}
function setProcessDiscountType(){
    var process_discount_type = $dom.find('input[type=radio]:checked').val();
    if(process_discount_type == 1){
        $dom.find("[name='step_price']").parent().parent().show();
        $dom.find("[name='max_price']").parent().parent().show();
    }else{
        $dom.find("[name='step_price']").parent().parent().hide();
        $dom.find("[name='max_price']").parent().parent().hide();
    }
}
function setNextStartDay(obj){
    var parent_obj      = $(obj).parent().parent();
    var this_day        = parent_obj.find("[name*='[end_days]']").val();
    if(this_day>0){
        var next_day    = Number(this_day)+1;
    }else{
        var next_day    = '0';
    }
    var next_obj    = parent_obj.next().find("[name*='[start_days]']");
    if(typeof next_obj.attr('name')=="undefined" && this_day>0){
        $.copyRowWithFrom(obj, '');
        parent_obj.next().find("[name*='[start_days]']").val(next_day);
    }else{
        next_obj.val(next_day);
    }
}
function deleteWarehouseFee(obj){
    var parent_obj  = $(obj).parent().parent();
    var is_exist    = parent_obj.next().find("[name*='[start_days]']").val();
    if(is_exist > 0 ){
        var prev_day    = parent_obj.prev().find("[name*='[end_days]']").val();
        if(prev_day>0){
            var next_day    = Number(prev_day)+1;
        }else{
            var next_day    = '';
        }
        parent_obj.next().find("[name*='[start_days]']").val(next_day);
    }else{
        parent_obj.prev().find("[name*='[end_days]']").val('');
    }
}

function shiftOutLocation(obj){
    var product_id  = $(obj).val();
    if(product_id > 0){
        $(obj).parents("tr:first").find("#out_warehouse_id").val('');
        $(obj).parents("tr:first").find("#out_location_id").val('');
        $(obj).parents("tr:first").find("input[name*='out_barcode_no]']").val('');
        $(obj).parents("tr:first").find("input[name*='out_barcode_no]']").attr({"where": 'product_id='+product_id, "jqac": true}).initAutocomplete();
    }
}
function shiftInLocation(obj){
    	var location_id = $.cParseInt(obj.value);
	if (location_id > 0) {
		$.getJSON(APP + '/Ajax/getWarehouseId', {location_id: location_id}, function(data) {
        $(obj).parents("tr:first").find("#in_warehouse_id").val('');
        $(obj).parents("tr:first").find("#in_location_id").val('');
        $(obj).parents("tr:first").find("input[name*='in_barcode_no]']").val('');
        $(obj).parents("tr:first").find("input[name*='in_barcode_no]']").attr({"where": 'warehouse_id in('+data.warehouse_id+'_warehouse_id)', "jqac": true}).initAutocomplete();
        });
    }
}

function getWarehouseIdByLocation(obj,warehouse_name){
	var location_id = $.cParseInt(obj.value);
	if (location_id > 0) {
		$.getJSON(APP + '/Ajax/getWarehouseId', {location_id: location_id}, function(data) {
            $(obj).parents("tr:first").find("#"+warehouse_name).val(data.warehouse_id);
		});
	}
}

function warehouseFeeStartDate(obj){
    var is_warehouse_fee = $(obj).val();
    if(is_warehouse_fee > 0){
        $dom.find('#warehouse_fee_start_date').show();
    }else{
        $dom.find('#warehouse_fee_start_date').hide();
    }
}

/* 卖家仓储费 */
function getWarehouseFeeInfo(){
	var warehouse_fee_id    = $dom.find('#warehouse_fee_id').val();
    if(warehouse_fee_id > 0){
        $dom.find('#warehouse_fee_img').attr('pid',warehouse_fee_id);
    }
}
function addReturnToDetail(){
    var warehouse_id        = $dom.find('#warehouse_id').val();
    var return_logistics_no = $dom.find('#select_return_logistics_no').val();
    var return_track_no     = $dom.find('#select_return_track_no').val();
    var is_aliexpress       = $dom.find('#is_aliexpress').val();
    var factory_id          = $dom.find('#factory_id').val();
    var error_info          = false;
    if(warehouse_id > 0 && (return_logistics_no != '' || return_track_no != '') && factory_id>0){//实际库存ID return array;
        $.getJSON(APP+"/Ajax/getReturnInfo",{"warehouse_id":warehouse_id,"return_logistics_no":return_logistics_no,"return_track_no":return_track_no,"is_aliexpress":is_aliexpress,"factory_id":factory_id},function(data){
            if(data != null){
                var is_unique   = true;
                $dom.find('input[name*="return_sale_order_id]"]').each(function(){
                            if($(this).val() == data.id){
                                $("<div>"+lang['batch']['pack_existed_detail']+"</div>").dialog({
                                    width: 300,
                                    height: 150,
                                    buttons: {
                                        Ok: function() {
                                            $( this ).dialog( "close" );
                                        }
                                    }
                                });
                                is_unique   = false;
                            }
                });
                if(is_unique){
                    var detail_table_last = $dom.find('#detail_table:last').find('tbody');
                    var first_obj 	= detail_table_last.find('tr:visible:first');
                    var list_row	= detail_table_last.find('tr:visible').size();
                    for (var i = 1; i <= list_row; i++)
                    {
                        if (first_obj.find("#return_sale_order_id").val()==''){
                            first_obj	=	first_obj;
                        }else{
                            if(i==list_row){
                                first_obj	=	first_obj;
                            }else{
                                first_obj	=	first_obj.next();
                            }
                        }
                    }
                    if (first_obj.find("#return_sale_order_id").val()==''){
                        var new_obj = first_obj;
                    } else {
                        var new_obj = $.copyRowWithFrom($(first_obj).find('td:last').find('span[class*="icon-del-plus"]'));
                    }
                    $(new_obj).find("#return_sale_order_id").val(data.id);
                    $(new_obj).find("#return_logistics_no").html(data.return_logistics_no);
                    $(new_obj).find("#return_track_no").html(data.return_track_no);
                    $(new_obj).find("#weight").html(data.dml_weight);
                    $.sumTotal(new_obj);
                }
            }else{
                $("<div>"+lang['batch']['not_exite_suitable_order']+"</div>").dialog({
                    width: 300,
                    height: 150,
                    buttons: {
                        Ok: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
            };
            //清空查询框
            $dom.find('#select_return_logistics_no').val('');
            $dom.find('#select_return_track_no').val('');
        });
    }else if(return_logistics_no == '' && return_track_no == ''){
        error_info  = lang['batch']['please_enter_return_logistics_no_or_return_track_no'];
    }else if(warehouse_id < 1){
        error_info  = lang['batch']['please_choose_warehouse'];
    }else{
        error_info  = lang['batch']['please_select_factory'];
    }
    if(error_info){
        $("<div>"+error_info+"</div>").dialog({
            width: 300,
            height: 150,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }
}

function setPackageWarehouse(obj){
    var warehouse_id = $(obj).val();
    $dom.find("input[name*='package_name]']").val('').attr({'where':encodeURIComponent('warehouse_id='+warehouse_id),'jqac':true}).initAutocomplete();
    cleanPackBoxDetail();
}

function aliexpress(obj){
    var order_type = $(obj).val();
    if(order_type==6){
        $dom.find('#aliexpress').show();
    }else{
        $dom.find('#aliexpress').hide();
    }
}

function recordCheckId(obj){
    var id  = $(obj).attr('value');
    var record_check_token  = $dom.find('#record_check_token').val();
    $.getJSON(APP + '/Ajax/recordCheckId', {id: id,record_check_token: record_check_token},function(data){
        var title = '';
        switch(data){
            case 1:
                title   = lang['batch']['please_choose_same_warehouse_box'];
                break;
            case 2:
                title   = lang['batch']['please_choose_same_factory_box'];
                break;
        }
        if(data>0){
            $("<div>"+title+"</div>").dialog({
                //		modal: true,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                        $(obj).removeClass().addClass('icon icon-pattern-nocheck');
                    }

                },
                beforeClose: function(){
                    $(obj).removeClass().addClass('icon icon-pattern-nocheck');
                }
            });
        }
    });
}

function cleanCheck(){
    var record_check_token  = $dom.find('#record_check_token').val();
    $.getJSON(APP + '/Ajax/cleanCheck', {record_check_token: record_check_token},function(){
        $dom.find('span[class*="icon-pattern-check"]').each(function(){
            $(this).removeClass().addClass('icon icon-pattern-nocheck');
        })
    });
}

function setNumber(obj){
    $(obj).parents().parents().nextAll().find('#number').html(function(){
        $(this).html($(this).html()-1);
    });
}
function isCheckPackBox(token,url,title){
    $.getJSON(APP + '/Ajax/isCheckPackBox', {token: token},function(data){
        if(data == 0){
            $("<div>"+lang['batch']['please_check']+"</div>").dialog({
                width: 300,
                height: 150,
                buttons: {
                    Ok: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }else{
            return linkTab(url,title,1);
        }
    });
}
function setDetailState(obj){
//    var state  = $(obj).val();
//    $.getJSON(APP + '/Ajax/setDetailState', {state: state},function(data){
        $(obj).parents('tr').find('#state').val('');
//    });
}

//退货状态为签收或者拒收	add by lxt 2015.08.27
function refuseReason(){
	var state	=	$.cParseInt($dom.find("#return_sale_order_state").val());
	if(state==12){
		$dom.find("#refuse_reason").parent().show();
	}else{
		$dom.find("#refuse_reason").parent().hide();
	}
}
//显示入库异常原因	add by lxt 2015.08.30
function showStorageAbnormalReason(obj){
	var state	=	$.cParseInt($(obj).val());
	if(state==1){
		$dom.find("#storage_abnormal_reason").parent().show();
	}else{
		$dom.find("#storage_abnormal_reason").parent().hide();
	}
}
//显示回邮费用		add by lxt 2015.08.31
function showReturnPostageFee(obj){
	var reason	=	$.cParseInt($(obj).val());
	if(reason==6){
		$dom.find("#return_postage_fee").parent().show();
	}else{
		$dom.find("#return_postage_fee").parent().hide();
	}
}

//退货状态为签收或者拒收	add by lxt 2015.08.27
function refuseReason(){
	var state	=	$.cParseInt($dom.find("#return_sale_order_state option:selected").val());
	if(state==12){
		$dom.find("#refuse_reason").parent().show();
	}else{
		$dom.find("#refuse_reason").parent().hide();
	}
}
//显示入库异常原因	add by lxt 2015.08.30
function showStorageAbnormalReason(obj){
	var state	=	$.cParseInt($(obj).val());
	if(state==1){
		$dom.find("#storage_abnormal_reason").parent().show();
	}else{
		$dom.find("#storage_abnormal_reason").parent().hide();
	}
}
//显示回邮费用		add by lxt 2015.08.31
function showReturnPostageFee(obj){
	var reason	=	$.cParseInt($(obj).val());
	if(reason==6){
		$dom.find("#return_postage_fee").parent().show();
	}else{
		$dom.find("#return_postage_fee").parent().hide();
	}
}
function cleanPackBoxDetail(){
    $dom.find('#detail_table').find('tr').find('#return_sale_order_id').val('');
    $dom.find('#detail_table').find('tr').find('#return_logistics_no').html('');
    $dom.find('#detail_table').find('tr').find('#return_track_no').html('');
    $dom.find('#detail_table').find('tr').find('#weight').html('');
    $dom.find('#detail_table').find('tr').find('select[name*="parcel_state]"]').val('0');
}
// 获取长度为len的随机字符串
function getRandomString(len) {
    len = len || 32;
    var $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; // 默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1
    var maxPos = $chars.length;
    var pwd = '';
    for (i = 0; i < len; i++) {
        pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
    }
    return pwd;
}


function setCustomBarcode(obj){
    var is_set_custom_barcode = $(obj).val();
    if(is_set_custom_barcode == 1){
        $dom.find('#set_custom_barcode').show();
    }else{
        $dom.find('#set_custom_barcode').hide();
    }
}

function isCustomBarcode(obj){
	if (obj.value <= 0) return;
    var url = APP+'/Ajax/isCustomBarcode/factory_id/'+obj.value;
	$.getJSON(url,function(data){
        if(data.is_custom_barcode == 1){
            $dom.find('#is_show_custom_barcode').show();
//            $dom.find('#custom_barcode_prompt').html("请输入" + data.custom_barcode_en + '加' + data.custom_barcode_num + '位数字');
//            $dom.find('#custom_barcode_prompt').show();
        }else{
            $dom.find('#is_show_custom_barcode').hide();
//            $dom.find('#custom_barcode').val('');
//            $dom.find('#custom_barcode_prompt').hide();
        }
	});
}

function showWCurrency(obj,str){
    var url = APP+'/Ajax/showWCurrency/warehouse_id/'+obj.value;
    $.ajax({
            url:url,
            success:function(result){
                $dom.find('span[id*="show_w_currency"]').each(function(){
                    $(this).html(str+result);
                    $(this).show();
                });
                $dom.find('#show_w_currency').html(str+result);
                $dom.find('#show_w_currency').show();
            }
        });
}

//通过汇率设置转换至金额
function setMoneyToByRate(){
	var money = $dom.find('#money').text();
	var opened_y = $dom.find('input[name="opened_y"]').val();
	if(opened_y != ''){
		money = money * opened_y;
		$dom.find('input[name="money_to"]').val(new Number(money).toFixed(2));
		$dom.find('#span_money_to').text(new Number(money).toFixed(2));
	}
}

//设置汇率和转换至金额
function setRateMoneyTo(){
	var currency_id = $dom.find('#currency_id').val();
	var confirm_date = $dom.find('input[name="confirm_date"]').val();
	var confirm_currency_id = $dom.find('select[name="confirm_currency_id"]').val();
	var money = $dom.find('#money').text();
	if(confirm_date != '' && confirm_currency_id != ''){
		//相同币种不用请求直接返回值显示
		if(currency_id == confirm_currency_id){
			$dom.find('input[name="opened_y"]').val(1);
			$dom.find('input[name="money_to"]').val(new Number(money).toFixed(2));
			$dom.find('#span_money_to').text(new Number(money).toFixed(2));
			return true;
		}
		//获取汇率
		var url = APP+'/Ajax/getRateMoneyTo/';
		$.getJSON(url,
					{currency_id:currency_id,
					confirm_date:confirm_date,
					confirm_currency_id:confirm_currency_id,
					money:money},
		function(data){
			$dom.find('input[name="opened_y"]').val(data.opened_y);
			if(data.money_to != null){
				$dom.find('input[name="money_to"]').val(data.money_to);
				$dom.find('#span_money_to').text(data.money_to);
			}
		});
	}else{
		$dom.find('input[name="rate"]').val('');
		$dom.find('input[name="money_to"]').val('');
		$dom.find('#span_money_to').text('');

	}
}

function changeTransportType(transport_type){
	var type	= transport_type == 1 ? 'sea' : 'air';
	$dom.find('#detail_table').html($dom.find('#' + type + '_transport').clone());
}

function changeStyle(){
	if($("#radiobutton").val()==1){
		$("#radiobutton").attr("value","0");
		$("#radiobutton").removeAttr("checked");
	} else {
		$("#radiobutton").val("1");
		$("#radiobutton").attr("checked","checked");
	}
}

/**
 * 获取仓储对账起始日期
 * @returns {undefined}
 */
function getWarehouseAccountStartDate(){
	var factory_id		= $.cParseInt($dom.find('#factory_id').val());
	var warehouse_id	= $.cParseInt($dom.find('#warehouse_id').val());
	if (factory_id > 0 && warehouse_id > 0) {
		var url = APP+'/Ajax/getWarehouseAccountStartDate/factory_id/'+factory_id + '/warehouse_id/'+warehouse_id;
		$.ajax({
            url:url,
            success:function(account_start_date){
				if (account_start_date) {
					$dom.find('#account_start_date').html(account_start_date);
					$dom.find('#account_start_date_li').show();
				} else {
					$dom.find('#account_start_date_li').hide();
				}
            }
        });
	} else {
		$dom.find('#account_start_date_li').hide();
	}
}

function checkForm(event){
    var keynum;
    if (window.event) // IE
    {
        keynum = event.keyCode;
    }
    else if (event.which) // Netscape/Firefox/Opera
    {
        keynum = event.which;
    }
    if (keynum == 13) {
        var product_barcode  = $.trim($dom.find('#custom_barcode').val());
        var list_row = $dom.find('.detail_list').find('tbody').find('tr:visible').size();
        $.ajax({
            type: "GET",
            url: APP+'/Ajax/showProduct/custom_barcode/'+product_barcode,
            dataType: "text",
            cache: false,
            async:false,
            success: function(product_id) {
                if (product_id > 0) {
                    for (i = 1; i <= list_row; i++){
                        if($dom.find("input[name='detail[" + i +  "][product_id]']").val()==product_id&&$dom.find("input[name='detail[" + i +  "][in_quantity]']").val()==""){
                            $dom.find("tr").removeAttr("style");
                            $dom.find("tr[index='" + i +  "']").attr("style","background-color:yellow");
                            $dom.find("input[name='detail[" + i +  "][in_quantity]']").focus();
                            $dom.find('#custom_barcode').val("");
                            break;
                        }
                    }
                }
            }
        });
		event.stopPropagation();
    }
}

function getSystemInfo(strINFOType,oResultOB){
	try{
		var LODOP; //声明为全局变量
	//	LODOP=getLodop();
		LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'),1);
		if (LODOP.CVERSION) CLODOP.On_Return=function(TaskID,Value){
			if(oResultOB) oResultOB.val(Value);
		};
		var strResult=LODOP.GET_SYSTEM_INFO(strINFOType);
		if (!LODOP.CVERSION){
			if(oResultOB) oResultOB.val(strResult);
		}
	} catch(err) {};
}