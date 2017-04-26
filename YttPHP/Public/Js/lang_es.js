var lang = new Array();
lang['common'] = new Array(); // 公用信息
lang['common']['delete'] 	= 'Eliminar'; 
lang['common']['require'] 	= '¡No puede estar vacío!';
lang['common']['pst_integer'] 	= 'Introduzca N. entrero mayor que 0';
lang['common']['valid_money'] 	= 'Introduzca N. en formato correcto';
lang['common']['reset'] 		= 'Resetear'; 
lang['common']['sku'] 			= 'Intoduzca SKU!'; 
lang['common']['return_quantity']	= '¡Intrduzca Cant. de devolución!';
lang['common']['coexistence']   = '¡No puede estar vacío!';
lang['common']['return_service']   = 'Revisar el tipo de proceso elegido!';
lang['common']['sent_success']      = 'Email ha sido enviado!';
lang['common']['sent_defaut']       = "Email no enviado";
lang['common']['sent_email_defaut'] = "Parte de los buzones no se ha enviado con éxito,dale a vuelta a enviar";
lang['common']['apply_api_prompt']  = 'Gracias por solicitar API, vamos a procesar su solicitud en un plazo de dos días hábiles.';
lang['common']['confirm_cancel'] 	= '¿Está seguro de anularlo?'; 
lang['common']['confirm_delete'] 	= '¿Está seguro de cancelarlo?'; 
lang['common']['confirm_restore'] 	= '¿Esta seguro de recuperarlo?'; 
lang['common']['confirm'] 	= '¿Esta seguro de seguir? ';
lang['common']['search_success'] 	= 'Datos cargados con éxito'; 
lang['common']['error_msg'] = 'Aviso de error'; 
lang['common']['success'] 	= '¡Operación realizada con éxito!';
lang['common']['error'] 	= '¡Operación errónea!'; 
lang['common']['index']		= 'Mi página principal';
lang['common']['query_info_require']	= 'Por favor introduzca lo que desea buscar!';
lang['common']['query_not_exist'] 		= '¡No existe registro!';
lang['common']['load']		= 'Carga';
lang['common']['load_all']	= 'Carga completa';
lang['common']['fill_comments'] = 'introduzca las instruciones de comprobación';
lang['common']['last_row_cant_del'] = '¡No se puede eliminar!';
lang['common']['normal']		= 'Normal';
lang['common']['order_normal']  = 'Sin cargar';
lang['common']['op_error']		= '¡Error en la operación!',
lang['common']['restore']		= 'Restablecer',
lang['common']['submit']		= 'Entregar',
lang['common']['close']			= 'Cerrar',
lang['common']['add_open']		= 'Desdoblar',
lang['common']['load_error']	= 'Error al cargar los datos ...',
lang['common']['sextindexsucc']  = '¡Establecido con éxito como página principal!'; 
lang['common']['upload_file']	 = 'Buscando...';
lang['common']['no_filename']	 = '¡No existe archivo!';
lang['common']['select_one']	 = '¡Elija por lo menos un servicio de devolución!'; 
lang['common']['please_input_export_quantity']	 = '¡introduzca la Cant. a exportar!';
lang['common']['print_quantity']	 = '¡introduzca la Cant. a imprimir!';
lang['common']['save']	 = 'Guardar'; 
lang['common']['out_stock']	 = 'Enviar'; 
lang['common']['back_shelves']  = 'Detalle de volver a stock';
lang['common']['tel']           = 'Teléfono';
lang['common']['return_process_fee']=	'Gasto por servicio de devolución:';
lang['common']['batch_upload']  = 'Subida masiva';
lang['common']['edit_insure_price'] = 'Valor asegurado corregido';
lang['common']['message_announced_success']  = 'Publicado con éxito';
lang['common']['message_announced_error']  = 'Publicación fallida';
lang['common']['new_message']   = 'Tienes mensajes sin leer!';
lang['common']['message_list']   = 'Tablón de notas';
lang['common']['show']          = 'Ver';
lang['common']['ignore']        = 'Omitir';
lang['common']['copied_successfully']	= 'Copiado con éxito';
lang['common']['gls_api_reprint_error']	= 'The saleorder is GLS API order, print will have a different track order, confirm the print?';

lang['basic'] = new Array(); // 基本信息
lang['basic']['class_repeat'] 	= 'Duplicado N. de modelo!';
lang['basic']['err_excel']		= 'No ha selecionado un archivo Excel.';
lang['basic']['class_parent']	= 'Tipo de información:'; 
lang['basic']['yes']			= 'SI'; 
lang['basic']['no']				= 'No'; 
lang['basic']['btn_confirm']     = 'Aceptar';
lang['basic']['btn_clear']       = 'Limpiar';
lang['basic']['btn_add']	     = 'Añadir';
lang['basic']['btn_cancel']		 = 'Cancelar';
lang['basic']['select_country']  = 'Por favor seleccione país!';

lang['basic']['belong_seller']	  = 'colaborador/vendedor:'; 
lang['basic']['belong_warehouse'] = 'Almacén:';
lang['basic']['long'] = 'Largo';
lang['basic']['wide'] = 'Ancho';
lang['basic']['high'] = 'Alto';
///单位配置
lang['basic']['size_unit']		  = 'Cm.';
lang['basic']['weight_unit']	  = 'Gr.';
lang['basic']['volume_size_unit'] = 'Cm³';

lang['basic']['stat_product_info']				= 'Detalles del producto'; 
lang['basic']['lang_index']		= 'La lista de idioma';

lang['orders'] = new Array(); // 订货信息
lang['orders']['change_fac_tip'] = 'Editar información de fabricante , el sistema borrará los datos de la lista, SI o NO!';
lang['orders']['lc_qn_tip']		 = 'Cant. de cargar mayor que Cant. de pedido!';
lang['orders']['currency_tip']	 = 'Comprobar pedido, moneda cambiada';
lang['orders']['sale_no']		 = 'Ref. de venta';
lang['orders']['return_no']		 = 'Ref. de devolución';


lang['audit']  = new Array(); // 审核信息
lang['audit']['audit_title'] = 'Información para comprobar'; 
lang['audit']['audit_succ'] = 'Comprobación con éxito'; 
lang['audit']['audit_info'] = 'Registro de comprobación'; 
lang['audit']['audit_repeat'] = 'Ya revisado, no repita';
lang['audit']['audit_failed'] = '¡Comprobación errónea!'; 

lang['lc'] = new Array(); // 装柜信息
lang['lc']['mf_existed'] = 'Existe parte realizada de forma manual, ¿esta seguro de cargar la mercancia?';

lang['sale'] = new Array(); //销售信息
lang['sale']['pre_delivery_tip'] = 'Este pedido esta preparado, ¿esta seguro de volver a  prepararlo?';
/*******合并订单******/
lang['sale']['two_more']	        = 'Debe tener 2 o más pedidos para adjutar';
lang['sale']['factory_id_error']    = 'El pedido seleccionado no conicide con el nombre de vendedor';
lang['sale']['merge_address_error'] = 'El pedido seleccionado no conicide la dirección';
lang['sale']['post_code_error']		= 'El pedido seleccionado no conicide el código postal';

//出库订单
lang['sale']['no_product']		    = 'Este  pedido no contiene producto seleccionado';
lang['sale']['product_done']		= 'El escaneo de este producto ya está terminado';
/*******合并订单******/
lang['stat'] = new Array(); // 报表语言包
lang['stat']['view_instock'] = 'Ver las estadísticas de almacenamiento ';
lang['stat']['bank_money_stat'] = 'Estadísticas bancarias ';
lang['stat']['product_is_last_page'] = 'Este producto ya está en la página';
lang['stat']['product_is_not_stock'] = 'No encontrado información de stock';


lang['orders']['error_quantity']		= 'Cant. de cargar mayor que Cant. de pedido';
lang['orders']['error_order_quantity']	= 'Cant. de pedido menor que Cant. de carga';

//问题订单
lang['question'] = new Array(); // 报表语言包
lang['question']['wait_response']         = 'Espere contestación';
lang['question']['has_compensation']      = 'Ya indemnizado';
lang['question']['pending_warehouse']     = 'Pendiente';


//装箱/出库批次
lang['batch'] = new Array(); // 基本信息
lang['batch']['abnormal']                   = 'Anomalía';
lang['batch']['customs_seized']             = 'Retenido por la aduana';
lang['batch']['reporting_discrepancies']    = 'Declaración no coincidente';
lang['batch']['pack_existed_detail']        = 'Paquete existente en la lista!';
lang['batch']['not_exite_suitable_order']   = '¡No existen registro que cumplan los requisitos!';
lang['batch']['please_enter_return_logistics_no_or_return_track_no'] = '¡Introduzca la Ref. devolución o el N. seguimiento nacional!';
lang['batch']['please_choose_warehouse']    = '¡Seleccione almacén!';
lang['batch']['please_choose_same_warehouse_box']   = '¡Seleccione las cajas del mismo almacén!';
lang['batch']['please_check']   = '¡Seleccione!';
lang['batch']['please_choose_same_factory_box'] = 'Aliexpress no puede estar en el mismo lote que otros vendedores!';
lang['batch']['please_select_factory']      = 'Select vendedor';