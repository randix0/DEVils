<div class="siteBlock b-index-photos-new">
	<div class="header"><h2>New photos</h2></div>
	<div class="body smartClear">
		{if isset($photos_new) && $photos_new}
			{foreach $photos_new item=item}
				<a href="/photos/one/{$item.id}" title="{$item.iname}"><img src="{$item.thumb}" class="photoS b-index-photos-item" alt="{$item.iname}"></a>
			{/foreach}
		{/if}
	</div>
	<div class="footer tRight"><a href="/photos/">view all</a></div>
</div>