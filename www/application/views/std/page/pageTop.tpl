<header class="toolbar">
	<div class="w990px">
		<a href="/">index</a>
		<a href="/contests">contests</a>
		<a href="/exhibitions">exhibitions</a>
		{*<a onclick="$('.siteBlock, footer').toggle()">TOGGLE BLOCKS</a>*}
		{if isset($_userdata) && $_userdata && isset($_userdata.login)}
			<a href="/mail/">mail</a>
			<a href="/uploader">upload</a>
			{if $_userdata.access_level >= 50}
				<a href="/admin">admin</a>
			{/if}
			<div class="right">
				<a href="/my"><img class="avatarS h30px vMiddle" src="{$_userdata.avatar_s}"></a>
				<a href="/users/profile/{$_userdata.login}">{$_userdata.login}</a>
				<a href="/my">my</a>
				<a href="/logout">logout</a>
			</div>
		{else}
			<a href="/register">register</a>
			<form class="right" action="/login" method="post">
				<input type="text" name="signin[login]" value="" placeholder="login...">
				<input type="password" name="signin[password]" value="" placeholder="pasword...">
				<input type="submit" value="Sign-In">
			</form>
		{/if}
	</div>
</header>