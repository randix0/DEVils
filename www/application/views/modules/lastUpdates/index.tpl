<div class="siteBlock modules-lastUpdates">
	<div class="header"><h2>Last updates</h2></div>
	<div class="body">
		{if isset($last_updates) && $last_updates}
			<table>
			{foreach $last_updates item=item}
					<tr class="modules-lastUpdates-item">
						<td width="50">
							<a href="/users/profile/{$item.author.login}">
								<img class="avatarS vMiddle" src="{$item.author.avatar_s}">
							</a>						
						</td>
						<td>
							<a href="/users/profile/{$item.author.login}">{$item.author.login}</a>
							{if $item.action == 1}added{elseif $item.action == 0}deleted{/if}
							{if $item.object_type == 1}
								post
							{elseif $item.object_type == 2}
								photo <a href="/photos/one/{$item.object_id}">{$item.object.iname}</a>
							{elseif $item.object_type == 6}
								comment 
								{if $item.object.object_type == 2}
									<a href="/photos/one/{$item.object.object_id}#comment_{$item.object_id}">{$item.object.idesc|truncate:30:"...":true}</a>
								{/if}
							{/if}

							<div>{$item.add_date|date_format:"%H:%M:%S"}</div>
						</td>
					</tr>
				</div>
			{/foreach}
			</table>
		{/if}
	</div>
	{*
	<div class="footer tRight">
		<a>view all</a>
	</div>
	*}
</div>