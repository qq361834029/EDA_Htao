var lang = new Array();
lang['common'] = new Array(); // 公用信息
lang['common']['delete'] 	= 'löschen'; 
lang['common']['require'] 	= 'darf nicht leer sein';
lang['common']['pst_integer'] 	= 'Bitte eine ganze Zahl eingeben > 0';
lang['common']['valid_money'] 	= 'Bitte ein gültiges Nummernformat eingeben';
lang['common']['reset'] 		= 'zurücksetzen'; 
lang['common']['sku'] 			= 'bitte SKU eingeben';
lang['common']['return_quantity']	= 'bitte Anzahl eingeben';
lang['common']['coexistence']   = 'darf nicht leer sein';
lang['common']['return_service']   = 'Bitte Überprüfung der Bearbeitungsart';
lang['common']['sent_success']      = 'Mail erfolgreich gesendet!';
lang['common']['sent_defaut']       = 'Senden der Nachricht fehlgeschlagen';
lang['common']['sent_email_defaut'] = 'Some email failed to send, please click to send';
lang['common']['apply_api_prompt']  = 'Danke für die API-Schnittstellen-Anfrage; wir werden diese innerhalb von zwei Werktagen bearbeiten.';
lang['common']['confirm_cancel'] 	= 'Deaktivieren?';
lang['common']['confirm_delete'] 	= 'Löschen?';
lang['common']['confirm_restore'] 	= 'Wiederherstellen?';
lang['common']['confirm'] 	= 'Bestätigen?';
lang['common']['search_success'] 	= 'Ladevorgang abgeschlossen';
lang['common']['error_msg'] = 'Fehlermeldung';
lang['common']['success'] 	= 'erfolgreich';
lang['common']['error'] 	= 'fehlgeschlagen!';
lang['common']['index']		= 'Hauptseite';
lang['common']['query_info_require']	= 'Eingabe von Anfragedetails nötig';
lang['common']['query_not_exist'] 		= 'Anfrage existiert nicht!';
lang['common']['load']		= 'beladen';
lang['common']['load_all']	= '整单装柜';
lang['common']['fill_comments'] = 'Audit-Anweisungen eingeben';
lang['common']['last_row_cant_del'] = 'Kann nicht gelöscht werden!';
lang['common']['normal']		= 'normal';
lang['common']['order_normal']		= 'wird nicht geladen';
lang['common']['op_error']		= '操作错误！',
lang['common']['restore']		= 'Bedienungsfehler!',
lang['common']['submit']		= 'aufgeben',
lang['common']['close']			= 'schließen',
lang['common']['add_open']		= 'aufklappen',
lang['common']['load_error']	= 'Ladevorgang fehlgeschlagen',
lang['common']['sextindexsucc']  = 'Einstellungen erfolgreich aktualisiert, werden bei Neustart geladen';
lang['common']['upload_file']	 = 'Durchsuchen …';
lang['common']['no_filename']	 = 'Datei existiert nicht!';
lang['common']['select_one']	 = 'Wählen Sie mindestens ein Retourebearbeitungsservice!';
lang['common']['please_input_export_quantity']	 = 'Bitte für Export eine Anzahl eingeben';
lang['common']['print_quantity']	 = 'Anzahl Exemplare eingeben!';
lang['common']['save']	 = 'Speichern';
lang['common']['out_stock']	 = 'Auslieferung';
lang['common']['back_shelves']  = 'Details Wiedereinlagerung';
lang['common']['tel']           = 'Telefon';
lang['common']['return_process_fee']=	'Retoure Bearbeitungsgebühr:';
lang['common']['batch_upload']  = 'Batch-Upload';
lang['common']['edit_insure_price'] = 'Versicherungssumme ändern';
lang['common']['message_announced_success']  = '信息发布成功';
lang['common']['message_announced_error']  = '信息发送失败';
lang['common']['new_message']   = '您有新消息未读!';
lang['common']['message_list']   = '信息列表';
lang['common']['show']          = '查看';
lang['common']['ignore']        = '忽略';
lang['common']['copied_successfully']	= '复制成功';
lang['common']['gls_api_reprint_error']	= 'Die GLS - Api für docking - aufträge, unter Druck zu unterschiedlichen - Dan, bestätigen Oder nicht drucken?';

lang['basic'] = new Array(); // 基本信息
lang['basic']['class_repeat'] 	= 'Artikel bereits eingeben, verdoppelt';
lang['basic']['err_excel']		= 'Ihre Auswahl ist keine EXCEL-Datei.';
lang['basic']['class_parent']	= 'Kategorie Info:';
lang['basic']['yes']			= 'ja';
lang['basic']['no']				= 'nein';
lang['basic']['btn_confirm']     = 'bestätigen';
lang['basic']['btn_clear']       = 'leer';
lang['basic']['btn_add']	     = 'hinzufügen';
lang['basic']['btn_cancel']		 = 'abbrechen';
lang['basic']['select_country']  = 'bitte Land auswählen!';

lang['basic']['belong_seller']	  = 'Partner / Verkäufer:';
lang['basic']['belong_warehouse'] = 'zugehöriges Lager:';
lang['basic']['long'] = 'Länge';
lang['basic']['wide'] = 'Breite';
lang['basic']['high'] = 'Höhe';
///单位配置
lang['basic']['size_unit']		  = 'cm';
lang['basic']['weight_unit']	  = 'g';
lang['basic']['volume_size_unit'] = 'cm³';

lang['basic']['stat_product_info']				= 'Produktdetails'; 
lang['basic']['lang_index']		= 'Sprachpaketliste';

lang['orders'] = new Array(); // 订货信息
lang['orders']['change_fac_tip'] = 'nach Bearbeiten der Fabrikdetails wird Datentabelle leer sein, weiterbearbeiten?';
lang['orders']['lc_qn_tip']		 = 'auszulagernde Pakete überschreitet die Anzahl der Bestellungen!';
lang['orders']['currency_tip']	 = 'Änderung der Währung, Einheitspreis überprüfen!';
lang['orders']['sale_no']		 = 'Sales Order No.';
lang['orders']['return_no']		 = 'Retoure Auftragsnummer';


lang['audit']  = new Array(); // 审核信息
lang['audit']['audit_title'] = 'Audit Information';
lang['audit']['audit_succ'] = 'erfolgreich geprüft!';
lang['audit']['audit_info'] = 'Audit Informationsprotokoll';
lang['audit']['audit_repeat'] = 'bereits geprüft, bitte nicht wiederholen';
lang['audit']['audit_failed'] = 'Audit Ausfall!';

lang['lc'] = new Array(); // 装柜信息
lang['lc']['mf_existed'] = '装柜信息中存在手动完成的订单,请确定是否装柜?';

lang['sale'] = new Array(); //销售信息
lang['sale']['pre_delivery_tip'] = '该销售单己配货,是否重新配货?';
/*******合并订单******/
lang['sale']['two_more']	        = 'Kombination! mindestens zwei Aufträge notwendig';
lang['sale']['factory_id_error']    = 'ausgewählte Aufträge gehören nicht den Verkäufern';
lang['sale']['merge_address_error'] = 'ausgewählte Aufträge mit unterschiedlichen Zustellungsadressen';
lang['sale']['post_code_error']		= 'ausgewählte Aufträge mit unterschiedlichen PLZ';

//出库订单
lang['sale']['no_product']		    = 'Produkt bei Auftrag nicht gefunden';
lang['sale']['product_done']		= 'Scan abgeschlossen';
/*******合并订单******/
lang['stat'] = new Array(); // 报表语言包
lang['stat']['view_instock'] = 'Statistik Einlagerung anzeigen';
lang['stat']['bank_money_stat'] = 'Bankenstatistik';
lang['stat']['product_is_last_page'] = 'Dieses Produkt in der letzten Ergebnisseite enthalten';
lang['stat']['product_is_not_stock'] = 'eingebene Artikel ohne Bestand';


lang['orders']['error_quantity']		= 'Auslagernde Menge größer als Anzahl der Bestellungen ';
lang['orders']['error_order_quantity']	= 'Auslagernde Menge kleiner als Anzahl der Bestellungen ';

//问题订单
lang['question'] = new Array(); // 报表语言包
lang['question']['wait_response']         = 'Anfrage bei Kurierdienst gestellt';
lang['question']['has_compensation']      = 'Entschädigung erhalten';
lang['question']['pending_warehouse']     = '待海外仓处理';


//装箱/出库批次
lang['batch'] = new Array(); // 基本信息
lang['batch']['abnormal']                   = 'fehlgeschlagen!';
lang['batch']['customs_seized']             = 'Beschlagnahme durch Zoll';
lang['batch']['reporting_discrepancies']    = 'Berichterstattung Diskrepanzen';
lang['batch']['pack_existed_detail']        = 'Paketdetails bereits vorhanden';
lang['batch']['not_exite_suitable_order']   = 'Keine Übereinstimmung mit der Bestellung !';
lang['batch']['please_enter_return_logistics_no_or_return_track_no'] = 'Eingabe inländischer Frachtbriefnummer';
lang['batch']['please_choose_warehouse']    = 'Auswahl Warehouse!';
lang['batch']['please_choose_same_warehouse_box']   = 'gewählte Artikel müssen aus gleichem Warehouse sein!';
lang['batch']['please_check']   = 'bitte wählen:';
lang['batch']['please_choose_same_factory_box'] = '速卖通不能和其他卖家同一批次!'
lang['batch']['please_select_factory']      = 'Auswahl des Verkäufers';