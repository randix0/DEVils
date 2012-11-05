{if isset($users_top_uploaders) && $users_top_uploaders}
<div class="siteBlock modules-usersTopUploaders">
	<div class="header"><h2>Top users-uploaders</h2></div>
	<div class="body">
		{foreach $users_top_uploaders item=item}
			<div class="modules-usersTopRated-item"><a class="userLink {if $item.sex}m{else}f{/if}" href="/users/profile/{$item.login}">{$item.login}</a></div>
		{/foreach}
	</div>
	<div class="footer"><a href="/users/top-rated">view all</a></div>
</div>
{/if}