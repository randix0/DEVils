<div class="siteBlock b-siteOfTheDay">
	<div class="header"><h1>Photo of the day</h1></div>
	{if $photoOfDay}
	<div class="body">
		<a href="/photos/one/{$photoOfDay.id}"><img src="{$photoOfDay.path}b/{$photoOfDay.file}" width="340"></a>
	</div>
	<div class="footer"><a href="/users/profile/{$photoOfDay.author.login}">{$photoOfDay.author.login}</a></div>
	{/if}
</div>