<!--{foreach item=item key=key from=$list}-->
		 <li><a href="javascript:;" onclick="$.linkBaiscTab(this,3);$.closeAllToolbar();" title="<!--{$item.link_title}-->" url="<!--{$item.link_url}-->"><!--{$item.caption}-->  <!--{$item.total}--></a></li>
<!--{/foreach}-->