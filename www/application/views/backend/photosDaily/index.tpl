<div class="siteBlock">
	<div class="header"><h3>Set daily photo</h3></div>
	<div class="body">
		{if isset($photos) && $photos}
			{foreach $photos item=item}
				<a href="/photos/one/{$item.id}" title="{$item.iname}"><img src="{$item.thumb}" class="photoS b-index-photos-item" alt="{$item.iname}"></a>
			{/foreach}
		{/if}
	</div>
	<div class="footer"></div>
</div>