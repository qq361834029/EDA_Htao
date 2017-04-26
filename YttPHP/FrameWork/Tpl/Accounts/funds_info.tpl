<table cellspacing="0" cellpadding="0" class="add_table" id="funds_info">	
	{if $module_name eq 'FactoryFunds' or $module_name eq 'FactoryFundsExtend'}
		{assign var=lang_ini_info	value='factory_ini_info'}
		{assign var=lang_sale_info	value='factory_sale_info'}
		{assign var=lang_other_info value='factory_other_info'}
		{assign var=lang_funds_info value='factory_funds_info'}
	{elseif $module_name eq 'LogisticsFunds'}
		{assign var=lang_ini_info	value='logistics_ini_info'}
		{assign var=lang_sale_info	value='logistics_sale_info'}
		{assign var=lang_other_info value='logistics_other_info'}
		{assign var=lang_funds_info value='logistics_funds_info'}
	{else}
		{assign var=lang_ini_info	value='client_ini_info'}
		{assign var=lang_sale_info	value='client_sale_info'}
		{assign var=lang_other_info value='client_other_info'}
		{assign var=lang_funds_info value='client_funds_info'}
	{/if}
	{if $fund.Ini neq ""}
		<tr id="show_funs_ini_tr"><th colspan="4">{$lang.$lang_ini_info}</th></tr>   
		<tr id="show_funs_ini_info"><td colspan="4" class="t_center">
				<table border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
					<thead>
						<tr>
							<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th>
							<th width="16%">&nbsp;</th>
							<th width="16%">&nbsp;</th>
							<th width="16%">{$lang.date}</th>
							<th width="16%">{$lang.money}</th>
							<th width="16%">{$lang.allot_money}</th>
							<th>{$lang.need_paid_money}</th>
						</tr>
					</thead>
					<tbody>
						{foreach key=key item=lst from=$fund.Ini}
							<tr >
								<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
								<td width="16%">&nbsp;</td>
								<td width="16%">&nbsp;</td>
								<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
								<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
							</tr>
						{/foreach}
					</tbody>
				</table></td>
		</tr>
	{/if}
	{if $fund.sale neq ""}
		<tr id="show_funs_sale_tr" ><th colspan="4">{$lang.$lang_sale_info}</th></tr>   
		<tr id="show_funs_sale_info" ><td colspan="4" class="t_center">
				<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
					<thead>
						<tr>
							<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th> 
							<th width="16%">{$lang.funds_class}</th>
							<th width="16%">
								{if $module_name=='FactoryFundsExtend'}
									{$lang.comments}
								{else}
									{$lang.doc_no}
								{/if}
							</th>
							<th width="16%">{$lang.date}</th>
							<th width="16%">{$lang.money}</th>
							<th width="16%">{$lang.allot_money}</th>
							<th>{$lang.need_paid_money}</th>
						</tr>
					</thead>
					<tbody>
						{foreach key=key item=lst from=$fund.sale}
							<tr >
								<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
								<td width="16%">{$lst.pay_class_name}</td>
								<td width="16%">
									{if $module_name=='FactoryFundsExtend'}
										{$lst.comments}
									{elseif $lst.comments_url}
										<a href="javascript:;" onclick="addTab('{$lst.comments_url}', '{$lang.view_detail}', 1);">
											{$lst.account_no}
										</a>
									{else}
										{$lst.account_no}
									{/if}
									&nbsp;
								</td>
								<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
								<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
							</tr>
						{/foreach}
					</tbody>
				</table></td>
		</tr>
	{/if}
	{if $fund.other neq ""}
		<tr id="show_funs_other_tr"><th colspan="4">{$lang.$lang_other_info}</th></tr>   
		<tr id="show_funs_other_info"><td colspan="4" class="t_center">
				<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
					<thead>
						<tr>
							<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th>
							<th width="16%">{$lang.funds_class}</th>
							<th width="16%">{$lang.doc_no}</th>
							<th width="16%">{$lang.date}</th>
							<th width="16%">{$lang.money}</th>
							<th width="16%">{$lang.allot_money}</th>
							<th>{$lang.need_paid_money}</th>
						</tr>
					</thead>
					<tbody>
						{foreach key=key item=lst from=$fund.other}
							<tr >
								<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
								<td width="16%">{$lst.pay_class_name}</td>
								<td width="16%">
									{if $lst.comments_url}
										<a href="javascript:;" onclick="addTab('{$lst.comments_url}', '{$lst.comments_url_title}', 1);">
											{$lst.account_no}
										</a>
									{else}
										{$lst.account_no}
									{/if}
									&nbsp;
								</td>
								<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
								<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
							</tr>
						{/foreach}
					</tbody>
				</table></td>
		</tr>
	{/if}
	{if $module_name eq 'ClientFunds' and $fund.return neq ""}
		<tr id="show_funs_return_tr"><th colspan="4">{$lang.client_return_info}</th></tr>   
		<tr id="show_funs_return_info"><td colspan="4" class="t_center">
				<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
					<thead>
						<tr>
							<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th>
							<th width="16%">{$lang.funds_class}</th>
							<th width="16%">{$lang.doc_no}</th>
							<th width="16%">{$lang.date}</th>
							<th width="16%">{$lang.money}</th>
							<th width="16%">{$lang.allot_money}</th>
							<th>{$lang.need_paid_money}</th>
						</tr>
					</thead>
					<tbody>
						{foreach key=key item=lst from=$fund.return}
							<tr >
								<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
								<td width="16%">{$lst.pay_class_name}</td>
								<td width="16%">
									{if $lst.comments_url}
										<a href="javascript:;" onclick="addTab('{$lst.comments_url}', '{$lang.view_detail}', 1);">
											{$lst.account_no}
										</a>
									{else}
										{$lst.account_no}
									{/if}
									&nbsp;
								</td>
								<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
								<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
							</tr>
						{/foreach}
					</tbody>
				</table></td>
		</tr>
	{/if} 

	{if $fund.funds neq ""}
		<tr id="show_funs_funds_tr"><th colspan="4">{$lang.$lang_funds_info}</th></tr>   
		<tr id="show_funs_funds_info"><td colspan="4" class="t_center">
				<table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
					<thead>
						<tr>
							<th width="10%">{$lang.please_choose}<input type="checkbox" onclick="checkAllInfo(this)"></th>
							<th width="16%">{$lang.funds_class}</th>
							<th width="16%">{$lang.doc_no}</th>
							<th width="16%">{$lang.date}</th>
							<th width="16%">{$lang.money}</th>
							<th width="16%">{$lang.allot_money}</th>
							<th>{$lang.need_paid_money}</th>
						</tr>
					</thead>
					<tbody>
						{foreach key=key item=lst from=$fund.funds}
							<tr >
								<td width="10%"><input type="checkbox" value="{$lst.paid_id}" name="check_info[]">&nbsp;</td>
								<td width="16%">{$lst.pay_class_name}</td>
								<td width="16%">
									{if $lst.comments_url}
										<a href="javascript:;" onclick="addTab('{$lst.comments_url}', '{$lang.view_detail}', 1);">
											{$lst.account_no}
										</a>
									{else}
										{$lst.account_no}
									{/if}
									&nbsp;
								</td> 
								<td width="16%">{$lst.fmd_paid_date}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_should_paid}&nbsp;</td>
								<td width="16%" class="t_right">{$lst.dml_have_paid}&nbsp;</td>
								<td class="t_right">{$lst.dml_need_paid}&nbsp;</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			</td>
		</tr>
	{/if}
</table>		