<div class="siteBlock">
	<div class="header"><h3>Exhibitions</h3></div>
	<div class="body">
		<ul>
			{if isset($exhibitions) && $exhibitions}
				{foreach $exhibitions item=item}
					<li><a href="/exhibitions/one/{$item.id}">{$item.iname}</a></li>
				{/foreach}
			{/if}
		</ul>
	</div>
	<div class="footer"><a href="/exhibitions/add">Create exhibition</a></div>
</div>