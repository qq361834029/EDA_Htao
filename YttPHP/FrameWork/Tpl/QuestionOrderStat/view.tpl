<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>  
    	<tr>
    		<th colspan="4">
    			<div class="titleth">
    				<div class="titlefl">{$lang.question_rate_detail}</div>
    			</div>
    		</th>
    	</tr>
    	<tr>
    		<td colspan="4">
    			<div class="basic_tb">  
					<ul> 
                        <li>
                            {$lang.express_way}： {$rs.main.ship_name}
                        </li>					
						<li>
							{$lang.question_order_number}：{$rs.main.question}
						</li>
						<li>
							{$lang.total_rate}：{$rs.main.rate}
						</li>
						<li>
							{$lang.express_number}： {$rs.main.sale}
						</li>
                        </div>
					</ul>
				</div>
			</td>
		</tr>
    	<tr>
    		<table class="detail_list" cellspacing="0" cellpadding="0">
    			<thead>
		    		<th width="40%">{$lang.question_reason}</th>
		    		<th width="30%">{$lang.question_order_number}</th>
		    		<th width="30%">{$lang.question_rate}</th>
		    	</thead>
		    	{foreach from=$rs.detail item=item}
		    		<tr>
		    			<td width="40%">{$item.dd_question_reason|default:$lang.unknow_reason}</td>
		    			<td width="30%">{$item.question}</td>
		    			<td width="30%">{$item.question_rate}</td>
		    		</tr>
		    	{/foreach}
    		</table>
    	</tr>
 	</tbody>
</table>
</div>