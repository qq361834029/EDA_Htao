
{ytt_table from=$run_info
    show=[
    		['title'=>$lang.unload_quantity,'value'=>'unload_quantity','link'=>['url'=>'StatProduct/orderUnload','link_id'=>['type'=>'order','id'=>$id]]],
    		['title'=>$lang.uninstock_quantity,'value'=>'unstock_quantity','link'=>['url'=>'StatProduct/loadUninstock','link_id'=>['type'=>'load','id'=>$id],'title'=>$lang.load_detail]]
    	]
    operate=false
}