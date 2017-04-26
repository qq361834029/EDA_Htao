var lang = new Array();
lang['common'] = new Array(); // 公用信息
lang['common']['delete'] 	= '删除'; 
lang['common']['require'] 	= '不能为空';
lang['common']['pst_integer'] 	= '请输入大于0的整数';
lang['common']['valid_money'] 	= '请输入正确的数字格式';
lang['common']['reset'] 		= '重置'; 
lang['common']['sku'] 			= '请输入SKU!'; 
lang['common']['return_quantity']	= '请输入退货数量!';
lang['common']['coexistence']   = '不能为空';
lang['common']['return_service']   = '请检查勾选的处理方式!';
lang['common']['sent_success']      = '邮件发送成功!';
lang['common']['sent_defaut']       = "邮件发送失败";
lang['common']['sent_email_defaut'] = "部分收件箱发送失败，请点击重新发送";
lang['common']['apply_api_prompt']  = '感谢您申请API,我们会在2个工作日之内处理您的请求。';
lang['common']['confirm_cancel'] 	= '确认是否作废?'; 
lang['common']['confirm_delete'] 	= '确认是否删除?'; 
lang['common']['confirm_restore'] 	= '确认是否还原?'; 
lang['common']['confirm'] 	= '确认执行该操作?'; 
lang['common']['search_success'] 	= '数据加载完成'; 
lang['common']['error_msg'] = '错误提示'; 
lang['common']['success'] 	= '操作成功！'; 
lang['common']['error'] 	= '操作失败！'; 
lang['common']['index']		= '我的首页';
lang['common']['query_info_require']	= '请输入要查询的信息!';
lang['common']['query_not_exist'] 		= '记录不存在!';
lang['common']['load']		= '装柜';
lang['common']['load_all']	= '整单装柜';
lang['common']['fill_comments'] = '请填写审核说明';
lang['common']['last_row_cant_del'] = '不可以删除!';
lang['common']['normal']		= '正常';
lang['common']['order_normal']		= '未装柜';
lang['common']['op_error']		= '操作错误！',
lang['common']['restore']		= '还原',
lang['common']['submit']		= '提交',
lang['common']['close']			= '关闭',
lang['common']['add_open']		= '展开',
lang['common']['load_error']	= '加载数据出错...',
lang['common']['sextindexsucc']  = '设置首页成功！下次登录生效！'; 
lang['common']['upload_file']	 = '浏览...';
lang['common']['no_filename']	 = '文件不存在！';
lang['common']['select_one']	 = '至少选择一个退货服务！'; 
lang['common']['please_input_export_quantity']	 = '请输入导出数量！'; 
lang['common']['print_quantity']	 = '请输入打印数量！'; 
lang['common']['save']	 = '保存'; 
lang['common']['out_stock']	 = '发货'; 
lang['common']['back_shelves']  = '重新上架详情';
lang['common']['tel']           = '电话';
lang['common']['return_process_fee']=	'退货处理费：';//add by lxt 2015.08.14
lang['common']['batch_upload']  = '批量上传';
lang['common']['edit_insure_price'] = '修改投保金额';
lang['common']['message_announced_success']  = '信息发布成功';
lang['common']['message_announced_error']  = '信息发送失败';
lang['common']['new_message']   = '您有新消息未读!';
lang['common']['message_list']   = '信息列表';
lang['common']['show']          = '查看';
lang['common']['ignore']        = '忽略';
lang['common']['copied_successfully']	= '复制成功';
lang['common']['gls_api_reprint_error']	= '该单为GLS API对接订单，重复打印会产生不同的追踪单号，是否确认打印?';
        
lang['basic'] = new Array(); // 基本信息
lang['basic']['class_repeat'] 	= '款式编码重复!';
lang['basic']['err_excel']		= '您选择的不是EXCEL文件。'; 
lang['basic']['class_parent']	= '类别信息：'; 
lang['basic']['yes']			= '是'; 
lang['basic']['no']				= '否'; 
lang['basic']['btn_confirm']     = '确定';
lang['basic']['btn_clear']       = '清空';
lang['basic']['btn_add']	     = '添加';
lang['basic']['btn_cancel']		 = '取消';
lang['basic']['select_country']  = '请选择国家名称!';

lang['basic']['belong_seller']	  = '合作伙伴/卖家：'; 
lang['basic']['belong_warehouse'] = '所属仓库：'; 
lang['basic']['long'] = '长';
lang['basic']['wide'] = '宽';
lang['basic']['high'] = '高';
///单位配置
lang['basic']['size_unit']		  = 'CM';
lang['basic']['weight_unit']	  = 'G';
lang['basic']['volume_size_unit'] = 'CM³';

lang['basic']['stat_product_info']				= '产品详细信息'; 
lang['basic']['lang_index']		= '语言包列表';

lang['orders'] = new Array(); // 订货信息
lang['orders']['change_fac_tip'] = '编辑厂家信息，系统将清空列表数据，是否确定';
lang['orders']['lc_qn_tip']		 = '装柜数量超过订货数量!';
lang['orders']['currency_tip']	 = '币种己改变,请核实单价!';
lang['orders']['sale_no']		 = '销售单号';
lang['orders']['return_no']		 = '退货单号';


lang['audit']  = new Array(); // 审核信息
lang['audit']['audit_title'] = '审核信息'; 
lang['audit']['audit_succ'] = '审核成功'; 
lang['audit']['audit_info'] = '审核记录'; 
lang['audit']['audit_repeat'] = '已审核无需重复'; 
lang['audit']['audit_failed'] = '审核失败!'; 

lang['lc'] = new Array(); // 装柜信息
lang['lc']['mf_existed'] = '装柜信息中存在手动完成的订单,请确定是否装柜?';

lang['sale'] = new Array(); //销售信息
lang['sale']['pre_delivery_tip'] = '该销售单己配货,是否重新配货?';
/*******合并订单******/
lang['sale']['two_more']	        = '合并订单必须有两个或者两个以上';
lang['sale']['factory_id_error']    = '所选订单的卖家名称不相同';
lang['sale']['merge_address_error'] = '所选订单的地址不相同';
lang['sale']['post_code_error']		= '所选订单的邮编不相同';

//出库订单
lang['sale']['no_product']		    = '订单不包含此产品';
lang['sale']['product_done']		= '此产品扫描已经完成';
/*******合并订单******/
lang['stat'] = new Array(); // 报表语言包
lang['stat']['view_instock'] = '查看入库统计';
lang['stat']['bank_money_stat'] = '银行统计';
lang['stat']['product_is_last_page'] = '此产品已在结果页';
lang['stat']['product_is_not_stock'] = '您输入的产品没有相关库存信息'; 


lang['orders']['error_quantity']		= '装柜数量大于订货数量';
lang['orders']['error_order_quantity']	= '订货数量小于装柜数量';

//问题订单
lang['question'] = new Array(); // 报表语言包
lang['question']['wait_response']         = '待快递公司回复';
lang['question']['has_compensation']      = '已赔偿';
lang['question']['pending_warehouse']     = '待海外仓处理';


//装箱/出库批次
lang['batch'] = new Array(); // 基本信息
lang['batch']['abnormal']                   = '异常';
lang['batch']['customs_seized']             = '海关查扣';
lang['batch']['reporting_discrepancies']    = '申报不符';
lang['batch']['pack_existed_detail']        = '小包已存在明细中!';
lang['batch']['not_exite_suitable_order']   = '不存在符合的订单!';
lang['batch']['please_enter_return_logistics_no_or_return_track_no'] = '请输入退货物流编号或国内运单号!';
lang['batch']['please_choose_warehouse']    = '请选择仓库!';
lang['batch']['please_choose_same_warehouse_box']   = '请选择同仓库的装箱!';
lang['batch']['please_check']   = '请勾选!';
lang['batch']['please_choose_same_factory_box'] = '速卖通不能和其他卖家同一批次!';
lang['batch']['please_select_factory']      = '请选择卖家';