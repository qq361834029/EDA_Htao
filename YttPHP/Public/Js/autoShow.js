var closetime = 0;
// 计算控件的坐标值
function getAbsoluteCoords (e) {
  var t = e.offsetTop; 
  var l = e.offsetLeft; 
  var w = e.offsetWidth; 
  var h = e.offsetHeight;
  while  (e=e.offsetParent) { t += e.offsetTop; l += e.offsetLeft; }; 
  return { top: t, left: l, width: w, height: h, bottom: t+h, right: l+w };
}

function autoShow(el,module_name,id){
	var ext=arguments[3];	
	window.clearTimeout(closetime);
	var place 	= getAbsoluteCoords(el);	
	var o = document.getElementById("autoShowDiv");
	var bgImg = '';
	// 设置div位置的偏移量
	var offNum = 10;
	// 设置div的位置
	if (place.left > 450){
		o.style.left = place.left-400+'px';
	}else{
		o.style.left = place.right+5+'px';
	}
	if (place.top < 400){
		o.style.top = place.top-offNum+'px';
	}else{
		o.style.top = place.bottom-300+offNum+'px';
	}	
	//o.style.zIndex = 1000;
	o.style.display = 'block';
	$("#autoShowDiv").load(APP+'/AutoShow',{"id":id,"module":module_name},function(){
				
	});
}


function atClose(){
	closetime = setTimeout("closeThis()",100);
}

function closeThis(){
	var o = document.getElementById("autoShowDiv");
	o.style.display = 'none';
}

function showThis(el){
	window.clearTimeout(closetime);
	el.style.display = 'block';
}



var flag=false; 
function DrawImage(ImgD,iwidth,iheight){ 
//参数(图片,允许的宽度,允许的高度) 
	var image=new Image(); 
	image.src=ImgD.src; 
	
	if(image.width > iwidth ){
		if(image.width>0 && image.height>0){ 
			flag=true; 
			if(image.width/image.height>= iwidth/iheight){ 
				if(image.width>iwidth){ 
					ImgD.width=iwidth; 
					ImgD.height=(image.height*iwidth)/image.width; 
				}else{ 
					ImgD.width=image.width; 
					ImgD.height=image.height; 
				} 
				ImgD.alt=image.width+"×"+image.height; 
			} 
			else{ 
				if(image.height>iheight){ 
					ImgD.height=iheight; 
					ImgD.width=(image.width*iheight)/image.height; 
				}else{ 
					ImgD.width=image.width; 
					ImgD.height=image.height; 
				} 
				ImgD.alt=image.width+"×"+image.height; 
			} 
		} 
		
	}
} 
