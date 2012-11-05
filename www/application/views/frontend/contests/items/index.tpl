<div class="siteBlock">
	<div class="header"><h3>Contests</h3></div>
	<div class="body">
		<ul>
			{if isset($contests) && $contests}
				{foreach $contests item=item}
					<li><a href="/contests/one/{$item.id}">{$item.iname}</a></li>
				{/foreach}
			{/if}
		</ul>
	</div>
	<div class="footer"><a href="/contests/add">Create contest</a></div>
</div>