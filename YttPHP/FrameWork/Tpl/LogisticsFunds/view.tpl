{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr>
      <td class="width15">{$lang.logistics_name}：</td>
      <td class="t_left">{$rs.rs.logistics_name}
      </td>
    </tr> 
    <tr>
      <td>{$lang.date}：</td>
      <td class="t_left">{$rs.rs.fmd_paid_date}
      </td>
    </tr>
    <tr>
      <td>{$lang.money_type}：</td>
      <td class="t_left">{$rs.rs.currency_no}
      </td>
    </tr>
     <tr>
      <td>{$lang.money}：</td>
      <td class="t_left">{$rs.rs.dml_befor_money}({$rs.rs.before_currency_no})
      </td>
    </tr>
     <tr>
      <td>{$lang.rate}：</td>
      <td class="t_left">{$rs.rs.befor_rate}
      </td>
    </tr>
    <tr>
      <td>{$lang.money}：</td>
      <td class="t_left">{$rs.rs.dml_money}({$rs.rs.currency_no})
      </td>
    </tr>
     <tr>
      <td>{$lang.account_money}：</td>
      <td class="t_left">{$rs.rs.dml_account_money}({$rs.rs.currency_no})
      </td>
    </tr>
    <tr>
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left"><p class="line_24">{$rs.rs.comments}</p>
      </td>
    </tr>  
    </tbody>
  </table> 
{foreach key=key item=lst from=$rs.for_list} 
<table cellspacing="0" cellpadding="0" class="add_table">
	<tr><th colspan="2">{$lang.specifi}</th></tr>
	<tr><td colspan="2">
	  <table id="show_funs_info" border="0" cellspacing="0" cellpadding="0" class="detail_list" align="center">
		<thead>
			<tr>
				<th>{$lang.date}</th> 
				<th>{$lang.money}</th>
				<th>{$lang.allot_money}</th> 
				<th>{$lang.type}</th>
			</tr>
		</thead>
		<tbody>
		{foreach key=key2 item=lst2 from=$lst}
		<tr  > 
			<td >{$lst2.fmd_paid_date}&nbsp;</td>
			<td {if $lst2.income_type>0} class="word_red" {else} class="word_green" {/if} >{$lst2.dml_should_paid}&nbsp;</td>
			<td >{$lst2.dml_paid_for_money}&nbsp;</td>
			<td > 
			{$lst2.dd_object_type}&nbsp; 
			{if $lst2.link}
			<a href="javascript:;" onclick="addTab('{$lst2.link}','{$lang.view_detail}',1); "> 
			{$lst2.account_no}&nbsp; 
			</a>
			{/if}
			</td>
			</tr>
			{/foreach}
			</tbody>
		</table> 
	</td></tr>
</table>
{/foreach}
</div>
