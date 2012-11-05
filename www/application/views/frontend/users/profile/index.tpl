{if isset($user) && $user}
<div class="siteBlock users-profile">
	<table class="plain">
		<tr>
			<td width="315">
				<img class="avatarM photoM vMiddle" src="{$user.avatar_b}">
			</td>
			<td>
				<h2>{$user.fname} ({$user.login}) {$user.lname}</h2>
				<div>{$user.email}</div>
				<div>Birthday: {$user.birth_date|date_format:"%d-%m-%Y"}</div>
				<div>Since: {$user.add_date|date_format:"%d-%m-%Y"}</div>
				<div><a href="/mail/to/{$user.id}">send message</a></div>				
			</td>
		</tr>
	</table>
	
	<div>
		<h3>User`s albums</h3>
		<div>
			{if isset($photos) && $photos}
				{foreach $photos item=item}
					<a href="/photos/one/{$item.id}" title="{$item.iname}"><img src="{$item.thumb}" class="photoS b-index-photos-item" alt="{$item.iname}"></a>
				{/foreach}
			{/if}
		</div>
	</div>
</div>
{else}
<div class="siteBlock">
	<div class="header"><h1>There are no such user exist</h1></div>
	<div class="body"></div>
</div>
{/if}