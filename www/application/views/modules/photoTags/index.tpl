<div class="siteBlock">
	<div class="header"><h1>Tags</h1></div>
	<div class="body">
		{foreach $tags_top item=item}
			<div><a href="/photos/by_tag/{$item.id}">{$item.tag}</a> ({$item.count})</div>
		{/foreach}
	</div>
	{*<div class="footer tRight"><a>view all</a></div>*}
</div>