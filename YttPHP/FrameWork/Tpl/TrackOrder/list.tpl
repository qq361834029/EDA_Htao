        {if $smarty.const.ACTION_NAME neq 'exportSaleOrderList'}
		{assign var=lang_time	value=$lang.import_time}
        {else}
		{assign var=lang_time	value=$lang.export_time}
        {/if}
{ytt_table 
show=[
		["value"=>"upload_date","title"=>$lang_time],
		["value"=>"add_real_name","title"=>$lang.operate_person],
		["value"=>"cpation_name","title"=>$lang.filename,'span'=>['onclick'=>"$.exportCsv(this,'TrackOrder')"],
			'hidden'=>[
				['name'=>'object_id','id'=>'object_id','value'=>'id'],
				['name'=>'relation_type','id'=>'relation_type','value'=>'relation_type'],
				['name'=>'file_exists','id'=>'file_exists','value'=>'file_exists']
				  ]
		],
		["value"=>"comments","title"=>$lang.comments,'show'=>$smarty.const.ACTION_NAME=='exportSaleOrderList']
	]
listType='flow'
flow="sale"
from=$list.list
}