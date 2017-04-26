<div class="div_main">
	{foreach key=key item=item from=$node}
		<div id="first_{$item.id}">
			<div class="div_role_operate">
				<p class="role_operate_p">
					<input name="flow[{$item.id}]" id="parent_{$item.id}" type="checkbox" value="1" {if $access[$item.id]}checked{/if} onclick="selectCheckbox(this,'first_{$item.id}')">
					{if show_data_right|C==1}
         			 		<select onchange="setSelectValue(this,'first_{$item.id}')">
         			 		<option value="1">{$item.title}</option>
         			 		<!--option value="2">{$item.title}-{$lang.own_department}</option-->
         			 		<option value="3">{$item.title}-{$lang.ownself}</option>
         			 		</select>
        		 	{else}
        		 		{$item.title}
        		 	{/if}
			    </p>
			    {foreach item=row key=sub_caption from=$item.sub}
			    	<dl class="role_add_two3" id="second_{$row.id}" style="width:100%;padding-bottom:10px;text-align:left;float:left;border-bottom:1px #CCCCCC dashed;">
				    	<dt><input name="flow[{$row.id}]" id="sub_{$row.id}" type="checkbox" value="1" {if $access[$row.id]}checked{/if} parent="first_{$item.id}" onclick="selectCheckbox(this,'second_{$row.id}')">
				    	{if show_data_right|C==1} 
		         			 <select name="data_rights[{$row.id}]" onchange="setSelectValue(this,'second_{$row.id}')">
		         			 <option value="1" {if $access[$row.id].data_rights==1}selected{/if}>{$row.title}</option>
		         			 <!--option value="2" {if $access[$row.id].data_rights==2}selected{/if}>{$row.title}-{$lang.own_department}</option-->
		         			 <option value="3" {if $access[$row.id].data_rights==3}selected{/if}>{$row.title}-{$lang.ownself}</option>
		         			 </select>
	         			 {else}
        		 			{$row.title} 
        		 		{/if}	
				    	</dt>
				    	{if $row.rights}
					    	{foreach item=rights from=$row.rights}
					    	<div style="width:200px;float:left;padding-left:20px;">
					    	<dd>
					    		<input name="flow[{$rights.id}]" id="sub_{$rights.id}" type="checkbox" value="1" {if $access[$rights.id]}checked{/if} onclick="setParentCheckbox(this)" parent="second_{$row.id}">
					    		{if show_data_right|C==1}
		         			 		<select name="data_rights[{$rights.id}]">
		         			 		<option value="1" {if $access[$rights.id].data_rights==1}selected{/if}>{$rights.title}</option>
		         			 		<!--option value="2" {if $access[$rights.id].data_rights==2}selected{/if}>{$rights.title}-{$lang.own_department}</option-->
		         			 		<option value="3" {if $access[$rights.id].data_rights==3}selected{/if}>{$rights.title}-{$lang.ownself}</option>
		         			 		</select>
	         			 		{else}
        		 					{$rights.title}
        		 				{/if}
					    	</dd>
					    	</div>
					    	{/foreach}
				    	{/if}
				    </dl>
				{/foreach}
			</div>
		</div>
	{/foreach}
</div>