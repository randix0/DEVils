<div class="siteBlock">
	<div class="header"><h1>Mail</h1></div>
	<div class="body">
		<div class="module-mail-usersList">
			{if isset($mailUsers) && $mailUsers}
				{foreach from=$mailUsers item=item}
					{if $_userdata.users_id == $item.users_id_1}
						<a href="/mail/to/{$item.users_id_2}" class="module-mail-usersList-item {if isset($to_users_id) && $to_users_id == $item.users_id_2}active{/if}">
							{$item.user2.login}
							{if ($item.unread_msg_1 > 0)}({$item.unread_msg_1}){/if}
						</a>
					{else}
						<a href="/mail/to/{$item.users_id_1}" class="module-mail-usersList-item {if isset($to_users_id) && $to_users_id == $item.users_id_1}active{/if}">
							{$item.user1.login}
							{if ($item.unread_msg_2 > 0)}({$item.unread_msg_2}){/if}
						</a>
					{/if}
				{/foreach}
			{/if}
		</div>
		<div class="module-mail-messages">
			{if isset($mailMessages) && $mailMessages}
				{foreach from=$mailMessages item=item}
					<div class="module-mail-messages-item">{$item.from.login} > {$item.idesc}</div>
				{/foreach}
			{/if}
		</div>
		<div class="module-mail-messages-form">
			<form id="sendMail" action="/ajax/sendMail" method="post">
				<input type="hidden" name="item[to_users_id]" value="{if isset($to_users_id) && $to_users_id}{$to_users_id}{/if}">
				<textarea name="item[idesc]"></textarea>
				<input type="submit" value="Send">
			</form>
		</div>
	</div>
	<div class="footer"></div>
</div>

<script type="text/javascript">

	$('#sendMail').ajaxForm({
		dataType:  'json',
		success: function(data){
			console.log('Request delivered');
			if (data.status == 'success'){
				console.log('status: success');
				console.log('Mail: sent');
			}
			else {
				alert('Sorry... Some bug happened');
			}
			
		}
	});
</script>