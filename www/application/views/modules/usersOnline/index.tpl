<div class="siteBlock">
	<div class="header">
		<h2>Online users</h2>
	</div>
	<div class="body">
		{if isset($users_online) && $users_online}
		{foreach $users_online item=item}
			<div class="modules-usersTopRated-item"><a class="userLink {if $item.sex}m{else}f{/if}" href="/users/profile/{$item.login}">{$item.login}</a></div>
		{/foreach}
		{/if}
	</div>
	<div class="footer"></div>
</div>