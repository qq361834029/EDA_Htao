<table id="index" class="list" border="1">
	<thead>
		<tr>
			{foreach from=$list.title item=item}
				{foreach from=$item item=item1}
					<th width="">{$item1}</th>
				{/foreach}
			{/foreach}
		</tr>
	</thead>
	<tbody>
		{foreach from=$list.list item=info}
			<tr>
				<td width="">{$info.product_no}</td>
				<td width="">{$info.product_name}</td>
				<td width="" class="t_right">{$info.last_age}</td>
				<td width="" class="t_right">{$info.age_a}</td>
				{if $smarty.post.age.b}
					<td width="" class="t_right">{$info.age_b}</td>
				{/if}
				{if $smarty.post.age.c}
					<td width="" class="t_right">{$info.age_c}</td>
				{/if}
				{if $smarty.post.age.d}
					<td width="" class="t_right">{$info.age_d}</td>
				{/if}
			</tr>
		{/foreach}
	</tbody>
</table>