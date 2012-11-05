<div class="siteBlock">
	<div class="header"><h3>

	{if $mode=='top'}
  		Top photos
	{elseif $mode=='favorit'}
		Favorit photos
	{elseif $mode=='most_commented'}
		Most commented photos
	{elseif $mode=='by_tag'}
		Photos with tag: {if isset($tag) && $tag}{$tag.tag}{/if}
	{else}
		New photos
	{/if}
  
  
  </h3></div>
	<div class="body">
		{if isset($photos) && $photos}
			{foreach $photos item=item}
				<a href="/photos/one/{$item.id}" title="{$item.iname}"><img src="{$item.thumb}" class="photoS b-index-photos-item" alt="{$item.iname}"></a>
			{/foreach}
		{/if}
	</div>
	<div class="footer"></div>
</div>