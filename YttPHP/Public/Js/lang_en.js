var lang = new Array();
lang['common'] = new Array(); // 公用信息
lang['common']['delete'] 	= 'Delete';
lang['common']['require'] 	= 'cannot be empty';
lang['common']['pst_integer'] 	= 'please enter a whole number bigger than 0';
lang['common']['valid_money'] 	= 'please enter the correct numerical format';
lang['common']['reset'] 		= 'reset';
lang['common']['sku'] 			= 'please enter SKU!';
lang['common']['return_quantity']	= 'please enter the refund quantity!';
lang['common']['coexistence']   = 'cannot be empty';
lang['common']['return_service']   = 'please check the ticked handling method!';
lang['common']['sent_success']      = 'emails sent successfully!';
lang['common']['sent_defaut']       = "emails sent unsuccessfully";
lang['common']['sent_email_defaut'] = "part of the emails has been sent unsuccessfully, please resent";
lang['common']['apply_api_prompt']  = 'thank you for applying for the API, we will solve your enquiry within two working days.';
lang['common']['confirm_cancel'] 	= 'confirm to void?';
lang['common']['confirm_delete'] 	= 'confirm to delter?';
lang['common']['confirm_restore'] 	= 'confirm to restroe?';
lang['common']['confirm'] 	= 'confirm the operation?';
lang['common']['search_success'] 	= 'data loading complete';
lang['common']['error_msg'] = 'wrong hint';
lang['common']['success'] 	= 'operation successful!';
lang['common']['error'] 	= 'operation failed!';
lang['common']['index']		= 'my homepage';
lang['common']['query_info_require']	= 'please enter the required search information!';
lang['common']['query_not_exist'] 		= 'the record does not exist!';
lang['common']['load']		= 'loading';
lang['common']['load_all']	= 'whole list loading';
lang['common']['fill_comments'] = 'please enter the check details';
lang['common']['last_row_cant_del'] = 'can not be deleted!';
lang['common']['normal']		= 'normal';
lang['common']['order_normal']		= 'did not load';
lang['common']['op_error']		= 'wrong operations!',
lang['common']['restore']		= 'restore',
lang['common']['submit']		= 'submit',
lang['common']['close']			= 'close',
lang['common']['add_open']		= 'open',
lang['common']['load_error']	= 'data loading failed...',
lang['common']['sextindexsucc']  = 'successfully reedit the home page! effective from the next logon!';
lang['common']['upload_file']	 = 'browse...';
lang['common']['no_filename']	 = 'file does not exist!';
lang['common']['select_one']	 = 'please choose at least one refund method!';
lang['common']['please_input_export_quantity']	 = 'please enter export quantity!';
lang['common']['print_quantity']	 = 'please enter printing quantity!';
lang['common']['save']	 = 'save';
lang['common']['out_stock']	 = 'deliver goods';
lang['common']['back_shelves']  = 'detailed reshelves information';
lang['common']['tel']           = 'phone number';
lang['common']['return_process_fee']=	'refund cost: ';//add by lxt 2015.08.14
lang['common']['batch_upload']  = 'mass loading';
lang['common']['edit_insure_price'] = 'adjust insurance amount';
lang['common']['message_announced_success']  = 'successfully upload the information';
lang['common']['message_announced_error']  = 'unsuccessfully upload the information';
lang['common']['new_message']   = 'new unread message!';
lang['common']['message_list']   = 'information list';
lang['common']['show']          = 'check';
lang['common']['ignore']        = 'ignore';
lang['common']['copied_successfully']	= 'successfully copy';
lang['common']['gls_api_reprint_error']	= 'The saleorder is GLS API order, print will have a different track order, confirm the print?';

lang['basic'] = new Array(); // 基本信息
lang['basic']['class_repeat'] 	= 'style code repetition!';
lang['basic']['err_excel']		= 'you did not choose the Excel file.';
lang['basic']['class_parent']	= 'information type: ';
lang['basic']['yes']			= 'yes';
lang['basic']['no']				= 'no';
lang['basic']['btn_confirm']     = 'confirm';
lang['basic']['btn_clear']       = 'empty';
lang['basic']['btn_add']	     = 'add';
lang['basic']['btn_cancel']		 = 'cancel';
lang['basic']['select_country']  = 'please choose the country name!';

lang['basic']['belong_seller']	  = 'business partner/seller: ';
lang['basic']['belong_warehouse'] = 'warehouse based: ';
lang['basic']['long'] = 'length';
lang['basic']['wide'] = 'width';
lang['basic']['high'] = 'height';
///单位配置
lang['basic']['size_unit']		  = 'CM';
lang['basic']['weight_unit']	  = 'G';
lang['basic']['volume_size_unit'] = 'CM³';

lang['basic']['stat_product_info']				= 'detailed product information';
lang['basic']['lang_index']		= 'language package list';

lang['orders'] = new Array(); // 订货信息
lang['orders']['change_fac_tip'] = 'adjust factory detail, the system will empty the list statistics';
lang['orders']['lc_qn_tip']		 = 'loading amount exceeds order amount!';
lang['orders']['currency_tip']	 = 'currency changed, please check the god price!';
lang['orders']['sale_no']		 = 'sales number';
lang['orders']['return_no']		 = 'refund number';


lang['audit']  = new Array(); // 审核信息
lang['audit']['audit_title'] = 'audit information';
lang['audit']['audit_succ'] = 'audit success';
lang['audit']['audit_info'] = 'audit record';
lang['audit']['audit_repeat'] = 'already audited, do not need to repeat';
lang['audit']['audit_failed'] = 'audit failed!';

lang['lc'] = new Array(); // 装柜信息
lang['lc']['mf_existed'] = 'There is a manual completion of the order in the order information. Please confirm whether it is installed or not.';

lang['sale'] = new Array(); //销售信息
lang['sale']['pre_delivery_tip'] = 'The order has been distributed, re distribution?';
/*******合并订单******/
lang['sale']['two_more']	        = 'only more than two orders can be combined';
lang['sale']['factory_id_error']    = 'the order selected can not have the same sellers name';
lang['sale']['merge_address_error'] = 'the order selected does not have the same address';
lang['sale']['post_code_error']		= 'the order selected does not have the same post code';

//出库订单
lang['sale']['no_product']		    = 'the order does not contain this product';
lang['sale']['product_done']		= 'this product has finished scanning';
/*******合并订单******/
lang['stat'] = new Array(); // 报表语言包
lang['stat']['view_instock'] = 'View storage statistics';
lang['stat']['bank_money_stat'] = 'bank statistics';
lang['stat']['product_is_last_page'] = 'this product is at the ending page';
lang['stat']['product_is_not_stock'] = 'the product you entered does not have the related storage information';


lang['orders']['error_quantity']		= 'loading amount exceeds order amount';
lang['orders']['error_order_quantity']	= 'order quanity smaller than loading quantity';

//问题订单
lang['question'] = new Array(); // 报表语言包
lang['question']['wait_response']         = 'Waiting for reply from delivery company';
lang['question']['has_compensation']      = 'already compensated';
lang['question']['pending_warehouse']     = 'Waiting Overseas warehouse processing';


//装箱/出库批次
lang['batch'] = new Array(); // 基本信息
lang['batch']['abnormal']                   = 'abnormal';
lang['batch']['customs_seized']             = 'Customs seized';
lang['batch']['reporting_discrepancies']    = 'wrong custom declaration';
lang['batch']['pack_existed_detail']        = '	small bag details already exist!';
lang['batch']['not_exite_suitable_order']   = 'does not exist in accepted order list!';
lang['batch']['please_enter_return_logistics_no_or_return_track_no'] = 'plese enter the refund order number or china order number!';
lang['batch']['please_choose_warehouse']    = 'please choose warehouse!';
lang['batch']['please_choose_same_warehouse_box']   = 'please load from the same warehouse!';
lang['batch']['please_check']   = 'please tick!';
lang['batch']['please_choose_same_factory_box'] = 'quick seller can not be divided into the other seller category!';
lang['batch']['please_select_factory']      = 'please select seller';