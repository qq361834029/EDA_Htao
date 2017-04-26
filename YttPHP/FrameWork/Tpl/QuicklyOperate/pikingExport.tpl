<script>
function getState(value){
	var state  =   $.cParseInt(value);
	switch(state){
	   case 1:
		   $("#piking_export").find("p#delivery").hide();
		   $("#piking_export").find("p#drop").show();
		   break;
	   case 2:
		   $("#piking_export").find("p#delivery").show();
		   $("#piking_export").find("p#drop").hide();
		   break;
		   default:
			   $("#piking_export").find("p#delivery,p#drop").show();
		       break;
	}
}
</script>
<form id="form_id" action="" method="POST">
	<div class="table_autoshow_return"
		style="border-style: none !important;">
		<table class="list" cellspacing="0" cellpadding="0" width="100%"
			id="piking_export">
			<thead>
				<tr>
					<th>{$lang.is_aliexpress}</th>
					<th>{$lang.treatment}</th>
					<th>{$lang.belongs_warehouse}</th>
					<th>{$lang.return_sale_order_state}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="t_center">{radio data=C('YES_NO') name="is_aliexpress"
						id="is_aliexpress" initvalue="1"}</td>
					<td class="t_center">{select data=C('TREATMENT') itemto='dialog-export_piking'
						name="service_detail_id" id="service_detail_id" combobox=""
						onchange="getState(this.value)"}</td>
					<td class="t_center"><input type="hidden" name="warehouse_id"
						id="warehouse_id" value=""> <input itemto='dialog-export_piking' type="text"
						name="warehouse_name" id="warehouse_name"
						url="{'/AutoComplete/warehouseName'|U}" jqac></td>
					<td class="t_center">
						<p id="delivery" style="width: 70px">{$lang.return_for_delivery}</p>
						<p id="drop" style="width: 70px">{$lang.dropped}</p>
					</td>

				</tr>
			</tbody>
		</table>
	</div>
</form>