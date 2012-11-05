<div class="siteBlock">
{if isset($contest) && $contest}	
	<div class="header"><h1>{$contest.iname}</h1></div>
	<div class="body">
		<h3>Description</h3>
		<p>{$contest.idesc}</p>
		
		<h3>Rules</h3>
		<p>{$contest.rules}</p>
		
		<h3>Limit of photos: {$contest.limit}</h3>
	</div>
	<div class="body smartClear">
		{if isset($photos) && $photos}
			{foreach $photos item=item}
				<a href="/photos/one/{$item.id}" title="{$item.iname}"><img src="{$item.thumb}" class="photoS b-index-photos-item" alt="{$item.iname}"></a>
			{/foreach}
		{/if}
	</div>
	<div class="footer"><a href="/contests/edit/{$contest.id}">edit</a></div>
{else}
	<div class="header"><h3>Contest</h3></div>
	<div class="body">
		There is no contest with this id
	</div>
	<div class="footer"></div>
{/if}	
</div>