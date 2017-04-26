var CreatedOKLodop7766=null;

//====判断是否需要安装CLodop云打印服务器:====
function needCLodop(){
    try{
	var ua=navigator.userAgent;
	if (ua.match(/Windows\sPhone/i) !=null) return true;
	if (ua.match(/iPhone|iPod/i) != null) return true;
	if (ua.match(/Android/i) != null) return true;
	if (ua.match(/Edge\D?\d+/i) != null) return true;
	if (ua.match(/QQBrowser/i) != null) return false;
	var verTrident=ua.match(/Trident\D?\d+/i);
	var verIE=ua.match(/MSIE\D?\d+/i);
	var verOPR=ua.match(/OPR\D?\d+/i);
	var verFF=ua.match(/Firefox\D?\d+/i);
	var x64=ua.match(/x64/i);
	if ((verTrident==null)&&(verIE==null)&&(x64!==null))
		return true; else
	if ( verFF !== null) {
		verFF = verFF[0].match(/\d+/);
		if ( verFF[0] >= 42 ) return true;
	} else
	if ( verOPR !== null) {
		verOPR = verOPR[0].match(/\d+/);
		if ( verOPR[0] >= 32 ) return true;
	} else
	if ((verTrident==null)&&(verIE==null)) {
		var verChrome=ua.match(/Chrome\D?\d+/i);
		if ( verChrome !== null ) {
			verChrome = verChrome[0].match(/\d+/);
			if (verChrome[0]>=42) return true;
		};
	};
        return false;
    } catch(err) {return true;};
};

//====页面引用CLodop云打印必须的JS文件：====
if (needCLodop()) {
    //让其它电脑的浏览器通过本机打印（适用例子）：
//    oscript = document.createElement("script");
//    oscript.src =PUBLIC+"/Js/CLodopfuncs.js";
//    var head = document.head || document.getElementsByTagName("head")[0] || document.documentElement;
//    head.insertBefore( oscript,head.firstChild );
    //让本机浏览器打印(更优先)：
    var oscript = document.createElement("script");
    oscript.src ="http://localhost:8000/CLodopfuncs.js?priority=1";
    var head = document.head || document.getElementsByTagName("head")[0] || document.documentElement;
    head.insertBefore( oscript,head.firstChild );
};

function getLodop(oOBJECT,oEMBED,showError){
	/**************************
	  本函数根据浏览器类型决定采用哪个页面元素作为Lodop对象：
	  IE系列、IE内核系列的浏览器采用oOBJECT，
	  其它浏览器(Firefox系列、Chrome系列、Opera系列、Safari系列等)采用oEMBED,
	  如果页面没有相关对象元素，则新建一个或使用上次那个,避免重复生成。
	  64位浏览器指向64位的安装程序install_lodop64.exe。
	**************************/
	var strHtmInstall		= "<br><font color='#FF00FF'>打印控件未安装!点击这里<a href='" + PUBLIC + "/Data/install_lodop32.exe'>执行安装</a>,安装后请刷新页面或重新进入。</font>";
	var strHtmUpdate		= "<br><font color='#FF00FF'>打印控件需要升级!点击这里<a href='" + PUBLIC + "/Data/install_lodop32.exe'>执行升级</a>,升级后请重新进入。</font>";
	var strHtm64_Install	= "<br><font color='#FF00FF'>打印控件未安装!点击这里<a href='" + PUBLIC + "/Data/install_lodop64.exe'>执行安装</a>,安装后请刷新页面或重新进入。</font>";
	var strHtm64_Update		= "<br><font color='#FF00FF'>打印控件需要升级!点击这里<a href='" + PUBLIC + "/Data/install_lodop64.exe'>执行升级</a>,升级后请重新进入。</font>";
	var strHtmFireFox		= "<br><br><font color='#FF00FF'>（注意：如曾安装过Lodop旧版附件npActiveXPLugin,请在【工具】->【附加组件】->【扩展】中先卸它。）</font>";
	var strHtmChrome		= "<br><br><font color='#FF00FF'>(如果此前正常，仅因浏览器升级或重安装而出问题，需重新执行以上安装）</font>";
    var strCLodopInstall	= "<br><font color='#FF00FF'>CLodop云打印服务(localhost本地)未安装启动!点击这里<a href='" + PUBLIC + "/Data/CLodopPrint_Setup_for_Win32NT.exe'>执行安装</a>,安装后请刷新页面。</font>";
    var strCLodopUpdate		= "<br><font color='#FF00FF'>CLodop云打印服务需升级!点击这里<a href='" + PUBLIC + "/Data/CLodopPrint_Setup_for_Win32NT.exe'>执行升级</a>,升级后请刷新页面。</font>";
	var lodop_error			= '';
	var LODOP;
	try{
	     //=====判断浏览器类型:===============
	     var isIE	 = (navigator.userAgent.indexOf('MSIE')>=0) || (navigator.userAgent.indexOf('Trident')>=0);
	    if (needCLodop()) {
            try{LODOP=getCLodop();} catch(err) {};
			if (!LODOP && document.readyState!=="complete") {
				if(showError!=1){
					$("<div>C-Lodop没准备好，请稍后再试！</div>").dialog();
				}
				return;
			};
			if (!LODOP) {
				if(showError!=1){
					$("<div>"+strCLodopInstall+"</div>").dialog();
				}
				return;
			} else {
				if (CLODOP.CVERSION<"2.0.6.8") {
					if(showError!=1){
						$("<div>"+strCLodopUpdate+"</div>").dialog();
					}
					return;
				};
				if (oEMBED && oEMBED.parentNode) oEMBED.parentNode.removeChild(oEMBED);
				if (oOBJECT && oOBJECT.parentNode) oOBJECT.parentNode.removeChild(oOBJECT);
			};
        } else {
			var is64IE  = isIE && (navigator.userAgent.indexOf('x64')>=0);
			//=====如果页面有Lodop就直接使用，没有则新建:==========
			if (oOBJECT!=undefined || oEMBED!=undefined) {
				LODOP	= isIE ? oOBJECT : oEMBED;
			} else if (CreatedOKLodop7766==null){
				LODOP	= document.createElement("object");
				LODOP.setAttribute("width",0);
				LODOP.setAttribute("height",0);
				LODOP.setAttribute("style","position:absolute;left:0px;top:-100px;width:0px;height:0px;");
				if (isIE) {
					LODOP.setAttribute("classid","clsid:2105C259-1E0C-4534-8141-A753534CB4CA");
				} else {
					LODOP.setAttribute("type","application/x-print-lodop");
				}
				document.documentElement.appendChild(LODOP);
				CreatedOKLodop7766	= LODOP;
			} else {
				LODOP	= CreatedOKLodop7766;
			};
			//=====判断Lodop插件是否安装过，没有安装或版本过低就提示下载安装:==========
			if ((LODOP==null)||(typeof(LODOP.VERSION)=="undefined")) {
				if (navigator.userAgent.indexOf('Chrome')>=0) {
					lodop_error	+= strHtmChrome;
				}
				if (navigator.userAgent.indexOf('Firefox')>=0) {
					lodop_error	+= strHtmFireFox;
				}
				if (is64IE) {
					lodop_error	+= strHtm64_Install;
				} else if (isIE) {
					lodop_error	+= strHtmInstall;
				} else {
					lodop_error	+= strHtmInstall;
				}
				if(showError!=1){
					$("<div>"+lodop_error+"</div>").dialog();
				}
				return LODOP;
			}
		}
		if (LODOP.VERSION<"6.2.0.8") {
			if (needCLodop()) {
				lodop_error	+= strCLodopUpdate;
			}else if (is64IE) {
				lodop_error	+= strHtm64_Update;
			} else if (isIE) {
				lodop_error	+= strHtmUpdate;
			} else {
				lodop_error	+= strHtmUpdate;
			}
			if(showError!=1){
				$("<div>"+lodop_error+"</div>").dialog();
			}
			return LODOP;
		};
	     //=====如下空白位置适合调用统一功能(如注册码、语言选择等):====
		 LODOP.SET_LICENSES("厦门展联软件科技有限公司","923381078EE17DE9F97194BCA683CAEA","廈門展聯軟件科技有限公司","C96763F7C00CDD1EFD3EDCD86C358152");
		 LODOP.SET_LICENSES("THIRD LICENSE","","Top Union Software Technology Co.,Ltd","928594710E5435C615480FB2E72CED90");
		//=======================================
	     return LODOP;
	} catch(err) {
	    if (needCLodop()) {
			lodop_error	+= "Error:"+strCLodopInstall;
		}else if (is64IE)	{
			lodop_error	+= "Error:"+strHtm64_Install;
	    } else {
			lodop_error	+= "Error:"+strHtmInstall;
	    }
		if(showError!=1){
			$("<div>"+lodop_error+"</div>").dialog();
		}
	     return LODOP;
	}
}

/*
 *
 * @param {mixed} print_obj
 * @returns {object}
 */
function getPrintObj(print_obj){
	if (typeof(print_obj) !== 'object') {
		if(!print_obj){
			switch (true) {
				case $dom.find("#print").length>0 :
					print_obj = "#print";
					break;
				case $dom.find(".add_box").length>0 :
					print_obj = ".add_box";
					break;
				default:
					print_obj = ".add_table";
					break;
			}
		}
		print_obj	= $dom.find(print_obj);
	}
	return print_obj;
}

/**
 *
 * @param {object|string} print_obj
 * @param {int|string} width
 * @param {int|string} height
 * @returns {undefined}
 */
function PrintMytable(print_obj, width, height){
	print_obj	= getPrintObj(print_obj);
	if($(print_obj).length>0){
		if(typeof(width) === 'undefined') {
			width	= 300;
		}
		if(typeof(height) === 'undefined') {
			height	= 1080;
		}
		LODOP				= getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
		var strBodyStyle	= '';
		var strStyleCSS		= "<link href='"+PUBLIC+"/Css/printstyle.css' type='text/css' rel='stylesheet'>";
		var strFormHtml		= strStyleCSS + strBodyStyle + "<body>"+$(print_obj).html()+"</body>";
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_样式风格");
		LODOP.ADD_PRINT_HTM(5,10, width, height, strFormHtml);
		LODOP.PREVIEW();
	}
}
function printProductBarcode(id, quantity, width, height) {
    var top     = 604;
    var left    = 0;
    if (typeof (width) === 'undefined') {
        width = '210mm';
    }
    if (typeof (height) === 'undefined') {
        height = '297mm';
    }
    LODOP = getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
    //var strBodyStyle	= '';
    //var strStyleCSS		= "<link href='"+PUBLIC+"/Css/printstyle.css' type='text/css' rel='stylesheet'>";
    //var strFormHtml		= strStyleCSS + strBodyStyle + "<body>"+$(print_obj).html()+"</body>";
    LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_样式风格");
    LODOP.SET_PRINT_PAGESIZE(0, width, height, 'A4');
    if (quantity > 40) {
        var page    = Math.ceil(quantity/40);
        LODOP.SET_PRINT_COPIES(page);
        quantity    = 40;
    }
    for (var key = 1; quantity >= key; key++) {
        LODOP.ADD_PRINT_IMAGE((top/100)+'mm', (left/100)+'mm', '50.75mm', '16.92mm', "<img width='100%' border='0' src='./Runtime/Barcode/Product/" + id + ".gif' />");
        if (key % 40 == 0) {
            LODOP.NewPage();
            var left    = 0;
             var top     = 604;
        } else if (key % 4 == 0) {
            var top     = top + 2900;
            var left    = 0;
        } else {
            left = left + 5075;
        }
    }
		LODOP.PREVIEW();
}
function printSaleOrder(print_obj, width, height,direct_print,is_it_nexive){
    if (typeof (print_obj) === 'string' && print_obj.indexOf('/')) {
        var src = print_obj;
    } else {
        print_obj = getPrintObj(print_obj);
        var src = $(print_obj).length > 0 ? $(print_obj).find('#barcode').attr('src') : print_obj;
    }
	if($(print_obj).length>0){
		if(typeof(width) === 'undefined') {
			width	= '210mm';
		}
		if(typeof(height) === 'undefined') {
			height	= '297mm';
		}
		LODOP				= getLodop(document.getElementById('LODOP_OB'), document.getElementById('LODOP_EM'));
		var strBodyStyle	= '';
		var strStyleCSS		= "<link href='"+PUBLIC+"/Css/printstyle.css' type='text/css' rel='stylesheet'>";
		var strFormHtml		= strStyleCSS + strBodyStyle + "<body>"+$(print_obj).html()+"</body>";
		LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_样式风格");
        if(is_it_nexive){
         LODOP.SET_PRINT_PAGESIZE(1, width, height, 'A4');
        }else{
            LODOP.SET_PRINT_PAGESIZE(0, width, height, 'A4');
        }
		LODOP.ADD_PRINT_HTM(0,0, width, height, strFormHtml);
//        LODOP. PRINT_DESIGN ();//打印设计
        if (direct_print) {
            if (LODOP.SELECT_PRINTER() >= 0) {//手动选择打印机
                LODOP.PRINT(); //直接打印
			}
        } else {
            LODOP.PREVIEW();
		}
	}
}


	function printBarcode(print_obj, width, height){
		if (typeof(print_obj) === 'string' && print_obj.indexOf('/')) {
			var src		= print_obj;
		} else {
			print_obj	= getPrintObj(print_obj);
			var src		= $(print_obj).length>0 ? $(print_obj).find('#barcode').attr('src') : print_obj;
		}
		if(typeof(width) === 'undefined') {
			width	= '75mm';
		}
		if(typeof(height) === 'undefined') {
			height	= '25mm';
		}
		LODOP		= getLodop();
		LODOP.PRINT_INIT("打印条形码");
		LODOP.SET_PRINT_PAGESIZE(0, width, height, 'A4');
		LODOP.ADD_PRINT_IMAGE(0, 0, width, height, "<img border='0' src='" + src + "' />");
		LODOP.SET_PRINT_STYLEA(0,"Stretch",2);
		//LODOP.SET_PRINTER_INDEXA(-1);//选择默认打印机
		if (LODOP.SELECT_PRINTER()>=0) {//手动选择打印机
			LODOP.PRINT(); //直接打印
		}
	}