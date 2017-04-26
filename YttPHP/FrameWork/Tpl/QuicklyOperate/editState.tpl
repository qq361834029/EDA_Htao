<form action="{"`$smarty.get.module`/editStateUpdate"|U}" method="POST" onsubmit="return false">
    <div class="table_autoshow" style="border-style:none!important; width: 260px!important;">
        <table cellspacing="0" cellpadding="0" width="100%">
            <tbody>
                <tr>
                    <dt>
                        <label>{$lang.state}：</label>
                        <input type="hidden" name="id" value="{$smarty.get.id}">
                        {select itemto="dialog-edit_state" data=$state_data name="{$state_name}" initvalue={$smarty.get.state} combobox="1" onchange="getRealArriveDate(this)" no_default=true}
					</dt>
					<dt style="{if $smarty.get.module != 'Instock' || !in_array($smarty.get.state,array(9,10,14,11))}display:none;{/if}width: -moz-max-content;margin:10px auto;" id="real_arrive_date_dt">
						<label>{$lang.real_arrive_date}:</label>
						<input type="text" name="real_arrive_date" value="{$real_arrive_date|default:$smarty.now|date_format:'%Y-%m-%d'}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__
					</dt>
                </tr>
            </tbody>
        </table>
    </div>
</form>