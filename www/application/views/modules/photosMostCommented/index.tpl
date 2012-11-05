<div class="siteBlock b-index-photos-new">
	<div class="header"><h2>Most commented</h2></div>
	<div class="body smartClear">
		{if isset($photos_most_commented) && $photos_most_commented}
			{foreach $photos_most_commented item=item}
				<a href="/photos/one/{$item.id}" title="{$item.iname}"><img src="{$item.thumb}" class="photoS b-index-photos-item" alt="{$item.iname}"></a>
			{/foreach}
		{/if}
	</div>
	<div class="footer tRight"><a href="/photos/most_commented">view all</a></div>
</div>