{literal}
    <script type="text/javascript">
    $(document).ready(function(){ 
    	//绑定事件
    	var addEvent = document.addEventListener ? function(el,type,callback){
    		el.addEventListener( type, callback, !1 );
    	} : function(el,type,callback){
    		el.attachEvent( "on" + type, callback );
    	}

    	//移除事件
    	var removeEvent = document.removeEventListener ? function(el,type,callback){
    		el.removeEventListener( type, callback );
    	} : function(el,type,callback){
    		el.detachEvent( "on" + type, callback);
    	}

    	//精确获取样式
    	var getStyle = document.defaultView ? function(el,style){
    		return document.defaultView.getComputedStyle(el, null).getPropertyValue(style)
    	} : function(el,style){
    		style = style.replace(/\-(\w)/g, function($, $1){
    			return $1.toUpperCase();
    		});
    		return el.currentStyle[style];
    	}

    	var dragManager = {
    		clientY:0,
    		draging:function(e){//mousemove时拖动行
    			var dragObj = dragManager.dragObj;
    			if(dragObj){
    				e = e || event;
    				if(window.getSelection){//w3c
    					window.getSelection().removeAllRanges();
    				}else  if(document.selection){
    					document.selection.empty();//IE
    				}
    				var y = e.clientY;
    				var down = y > dragManager.clientY;//是否向下移动
    				var tr = document.elementFromPoint(e.clientX,e.clientY);
    				if(tr && tr.nodeName == "TD"){
    					tr = tr.parentNode
    					dragManager.clientY = y;
    					if( dragObj !== tr){
    						tr.parentNode.insertBefore(dragObj, (down ? tr.nextSibling : tr));
    					}
    				};
    			}
    		},

    		dragStart:function(e){
    			e = e || event;
    			var target = e.target || e.srcElement;
    			if(target.nodeName === "TD"){
    				target = target.parentNode;
    				dragManager.dragObj = target;
    				if(!target.getAttribute("data-background")){
    					var background = getStyle(target,"background-color");
    					target.setAttribute("data-background",background)
    				}
    				//显示为可移动的状态
    				target.style.backgroundColor = "#DEF2FC";
    				target.style.cursor = "move";
    				dragManager.clientY = e.clientY;
    				addEvent(document,"mousemove",dragManager.draging);
    				addEvent(document,"mouseup",dragManager.dragEnd);
    			}
    		},
    		dragEnd:function(e){
    			var dragObj = dragManager.dragObj
    			if (dragObj) {
    				e = e || event;
    				var target = e.target || e.srcElement;
    				if(target.nodeName === "TD"){
    					target = target.parentNode;
    					dragObj.style.backgroundColor = dragObj.getAttribute("data-background");
    					dragObj.style.cursor = "default";
    					dragManager.dragObj = null;
    					removeEvent(document,"mousemove",dragManager.draging);
    					removeEvent(document,"mouseup",dragManager.dragEnd);
    				}
    			}
    			updateOrder(dragObj);
    		},
    		main:function(el){
    			addEvent(el,"mousedown",dragManager.dragStart);
    		}
    	}
    	var el = document.getElementById("table");
    	dragManager.main(el);
    	
    	
    })
    function updateOrder(obj){
    		var data = '';
    		$(obj).parents("table").find("tr").each(function(){
    			var order = parseInt($(this).index());
    			data += this.id+':'+order+',';
    		})
    		$.post(APP+'/Ajax/updateShortMenu', {data:data},function(){
    			$.resetShortcutMenu();
			});
    	}
    function moveup(obj){
    		$(obj).parents("tr:first").insertBefore($(obj).parents("tr:first").prev());
    		updateOrder(obj);
    }
    function movedown(obj){
    		$(obj).parents("tr:first").insertAfter($(obj).parents("tr:first").next());
    		updateOrder(obj);
    }
    function deleteShortMenu(id,obj){
    	$.post(APP+'/Ajax/deleteShortMenu', {id:id},function(){
    		$(obj).parents("tr:first").remove();
    		updateOrder(obj);
    	});
    }
    </script>
{/literal}	
<div class="nav_bg"><div class="nav_word">{$lang.current_position}：<span class="tbold">{$lang.title_key}</span></div></div>
<div class="fill_top"></div>
<div class="add_box">
    <table  id="table" class="table_drag"  border="0">
      <tbody>
      {foreach item=item from=$list}
      <tr id="{$item.id}">
         <td class="t_left">{$item.menu_name}</td>
         <td width="100"><span class="drag_up" onclick="moveup(this);">&nbsp;</span><span class="drag_down" onclick="javascript:movedown(this);">&nbsp;</span></td>
         <td width="100"><a href="javascript:;" onclick="deleteShortMenu({$item.id},this)">{$lang.delete}</a></td>
        </tr>
      {/foreach}
      </tbody>
</table>
</div>
