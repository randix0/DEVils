<div class="siteBlock b-index-photos-top">
	<div class="header"><h2>Top photos</h2></div>
	<div class="body smartClear">
		{if isset($photos_top) && $photos_top}
			{foreach $photos_top item=item}
				<a href="/photos/one/{$item.id}" title="{$item.iname}"><img src="{$item.thumb}" class="photoS b-index-photos-item" alt="{$item.iname}"></a>
			{/foreach}
		{/if}
	</div>
	<div class="footer tRight"><a href="/photos/top">view all</a></div>
</div>