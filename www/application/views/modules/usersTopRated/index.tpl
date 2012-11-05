{if isset($users_top_rated) && $users_top_rated}
<div class="siteBlock modules-usersTopRated">
	<div class="header"><h2>Top rated users</h2></div>
	<div class="body">
		{foreach $users_top_rated item=item}
			<div class="modules-usersTopRated-item"><a class="userLink {if $item.sex}m{else}f{/if}" href="/users/profile/{$item.login}">{$item.login}</a></div>
		{/foreach}
	</div>
	<div class="footer"><a href="/users/top-rated">view all</a></div>
</div>
{/if}