<div class="div_main">
	{foreach key=key item=item from=$node}
		<div id="first_{$item.id}">
			<div class="div_role_operate">
				<p class="role_operate_p">
					<input id="parent_{$item.id}" type="checkbox" value="1" {if $access[$item.id]}checked{/if} onclick="selectCheckbox(this,'first_{$item.id}')">
					{if show_data_right|C==1}
         			 		<select onchange="setSelectValue(this,'first_{$item.id}')">
         			 		<option value="1">{$item.id|title}</option>
         			 		<!--option value="2">{$item.id|title}-{$lang.own_department}</option-->
         			 		<option value="3">{$item.id|title}-{$lang.ownself}</option>
         			 		</select>
        		 	{else}
						{if $item.group_id eq 0}
							{$lang["node_`$item.id`"]}
						{else}
							{$item.id|title}
						{/if}
        		 	{/if}
			    </p>
			    {foreach item=row key=sub_caption from=$item.sub}
			    	<dl class="role_add_two" id="second_{$item2.id}">
			    		<dd>
			    			<input name="flow[{$row.id}]" id="sub_{$row.id}" type="checkbox" value="1" parent="first_{$item.id}" onclick="setParentCheckbox(this)" {if $access[$row.id]}checked{/if}>{if show_data_right|C==1}
				    		<select name="data_rights[{$row.id}]">
         			 		<option value="1" {if $access[$row.id].data_rights==1}selected{/if}>{$row.id|title}</option>
         			 		<!--option value="2" {if $access[$row.id].data_rights==2}selected{/if}>{$row.id|title}-{$lang.own_department}</option-->
         			 		<option value="3" {if $access[$row.id].data_rights==3}selected{/if}>{$row.id|title}-{$lang.ownself}</option>
         			 		</select>
				    	{else}
				    		{$row.id|title} 
				    	{/if}
			    		</dd>	
				    </dl>
				{/foreach}
			</div>
		</div>
	{/foreach}
</div>