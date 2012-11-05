<div class="siteBlock">
{if isset($exhibition) && $exhibition}	
	<div class="header"><h1>{$exhibition.iname}</h1></div>
	<div class="body">
		<h3>Description</h3>
		<p>{$exhibition.idesc}</p>
		
	</div>
	<div class="body smartClear">
		{if isset($photos) && $photos}
			{foreach $photos item=item}
				<a href="/photos/one/{$item.id}" title="{$item.iname}"><img src="{$item.thumb}" class="photoS b-index-photos-item" alt="{$item.iname}"></a>
			{/foreach}
		{/if}
	</div>
	<div class="footer"><a href="/exhibitions/edit/{$exhibition.id}">edit</a></div>
{else}
	<div class="header"><h3>Exhibition</h3></div>
	<div class="body">
		There is no exhibition with this id
	</div>
	<div class="footer"></div>
{/if}	
</div>