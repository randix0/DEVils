<div class="siteBlock photo-one">
{if isset($photo) && $photo}
	<div class="header">
		<h1>{$photo.iname}</h1>
	</div>
	<div class="body tCenter">
		<img class="photoB" src="{$photo.path}b/{$photo.file}" />
	</div>
	<div class="footer">
		<div class="photo-one-details">
			<a href="/users/profile/{$author.login}">{$author.login}</a>
		</div>
		{if isset($photo.idesc) && $photo.idesc}<div class="photo-one-idesc">{$photo.idesc}</div>{/if}
		{if isset($tags) && $tags}<div class="photo-one-tags">Tags: {$tags}</div>{/if}
		<div class="photo-one-voter">
			{if !$isVoted}<a onclick="ajaxLike(this, 2, {$photo.id});">iLike</a>{/if}
			<div class="">Summary likes: <span id="photo-rating">{$photo.rating}</div>
		</div>
   
			
		{if $LOGGED}
		
     <div class ="favorites">
      {if $isFav==0}
            <a onclick="ajaxFav(1, 2, {$photo.id});">Add to favorites</a>
      {else}
            <a onclick="ajaxFav(0, 2, {$photo.id});">Delete from favorites</a>
      {/if}
    </div>	
    
    
		<table class="collapse mB10px"><tr><td>
			{if $_userdata.access_level >= 50}
				<div class="photo-one-setDaily">
					<form id="setPhotosDaily" method="post" action="/ajax/setPhotosDaily">
						Photo of the day [<span class="photo-rating_daily">{$photo.rating_daily}</span>]:
						<input type="hidden" name="item[photos_id]" value="{$photo.id}">
						<input type="text" class="datepicker" name="item[date_from]" value="{$smarty.now|date_format:"%d-%m-%Y"}">
						<input type="submit" value="set">
					</form>				
				</div>
			{/if}
		</td><td>
			{if $_userdata.access_level >= 50 || $_userdata.users_id == $photo.users_id}
				<div class="photo-one-options">
						<a href="/photos/edit/{$photo.id}">edit</a>
						<a onclick="ajaxDelete(this, 2, {$photo.id});">delete photo</a>
				</div>
			{/if}
		</td></tr></table>
		
			{if isset($contestsTookPart) && $contestsTookPart}
			<div class="photo-one-contests-list">
				Contests already [<span class="photo-numContests">{$photo.num_contests}</span>]:
					{foreach $contestsTookPart item=item}
						<a href="/contests/one/{$item.id}">{$item.iname}</a>
					{/foreach}
			</div>		
			{/if}
			
			{if isset($contestsTakePart) && $contestsTakePart && ($_userdata.access_level >= 90 || $_userdata.users_id == $photo.users_id)}
			<div class="photo-one-contests-form">
				<form id="contestTakePart" method="post" action="/ajax/contestTakePart">
					<input type="hidden" name="item[photos_id]" value="{$photo.id}">
					<select name="item[contests_id]">
						{foreach $contestsTakePart item=item}
							<option value="{$item.id}">{$item.iname}</option>
						{/foreach}
					</select>
					<input type="submit" value="set">
				</form>				
			</div>		
			{/if}

			{if isset($exhibitionsTookPart) && $exhibitionsTookPart}
			<div class="photo-one-exhibitions-list">
				Exhibitions already [<span class="photo-numExhibitions">{$photo.num_exhibitions}</span>]:
					{foreach $exhibitionsTookPart item=item}
						<a href="/exhibitions/one/{$item.id}">{$item.iname}</a>
					{/foreach}
			</div>		
			{/if}
			
			{if isset($exhibitionsTakePart) && $exhibitionsTakePart && ($_userdata.access_level >= 90 || $_userdata.users_id == $photo.users_id)}
			<div class="photo-one-exhibitions-form">
				<form id="exhibitionTakePart" method="post" action="/ajax/exhibitionTakePart">
					<input type="hidden" name="item[photos_id]" value="{$photo.id}">
					<select name="item[exhibitions_id]">
						{foreach $exhibitionsTakePart item=item}
							<option value="{$item.id}">{$item.iname}</option>
						{/foreach}
					</select>
					<input type="submit" value="set">
				</form>				
			</div>		
			{/if}

		{/if}		
		{if isset($photo.allow_comments) && $photo.allow_comments}
			{if $commentsCount > 3}
			<div class="photo-one-showcomments">
				<a class="button mod-button-big" onclick="showAllComments(this)">Show other {$commentsCount-3} comments</a>
			</div>
			{/if}
			<div id="commentsTree" class="photo-one-comments-items">
				{if isset($comments) && $comments}
					{counter start=$commentsCount+1 direction=down assign=commentsNo}
					{foreach $comments item=item}
						{counter}
						<div id="comment_{$item.id}" class="photo-one-comments-item {if $commentsNo > 3}hidden{/if}">							
							<div class="barLeft">
								<a href="/users/profile/{$item.author.login}">
									<img class="avatarM vMiddle" src="{$item.author.avatar_m}">
								</a>
							</div>
							<div class="header">
								<a href="/users/profile/{$item.author.login}">{$item.author.login}</a>
							</div>
							<div class="body">{$item.idesc}</div>
							<div class="footer">{$item.add_date|date_format:"%d-%m-%y %H:%M:%S"}</div>
						</div>
					{/foreach}
				{/if}
			</div>

			{if $LOGGED}			
			<div class="photo-one-comments-form">
				<form id="addComment" method="post" action="/ajax/addComment">
					<input type="hidden" name="comment[parent_id]" value="0">
					<input type="hidden" name="comment[object_type]" value="2">
					<input type="hidden" name="comment[object_id]" value="{$photo.id}">
					<textarea name="comment[idesc]"></textarea>
					<div><input type="submit" class="button" value="add comment"></div>
				</form>
			</div>
			{/if}

			{literal}
			<div id="commentTemplate" class="hidden">
				<div id="comment_{item.id}" class="photo-one-comments-item">
					<div class="barLeft">
						<a href="/users/profile/{item.author.login}">
							<img class="avatarM vMiddle" src="{item.author.avatar_m}">
						</a>
					</div>
					<div class="header">
						<a href="/users/profile/{$item.author.login}">{item.author.login}</a>
					</div>
					<div class="body">{item.idesc}</div>
					<div class="footer">{item.add_date}</div>
				</div>
			</div>
			{/literal}			
		{/if}
	</div>
{else}
	<div class="header">Photo not found</div>
	<div class="body">Goto to <a href="/">main</a></div>
{/if}

{literal}
<script type="text/javascript">
	$('#addComment').ajaxForm({
		dataType:  'json',
		success: function(data){
			console.log('Request delivered');
			if (data.status == 'success'){
				console.log('status: success');
				var template = $('#commentTemplate').html();
				template = template.replace(/{item.author.login}/gi,data.item.author.login).replace(/{item.author.avatar_m}/gi,data.item.author.avatar_m).replace(/{item.id}/gi,data.item.id).replace(/{item.idesc}/gi,data.item.idesc).replace(/{item.add_date}/gi,data.item.add_date);
				$('#commentsTree').append(template);
				$('#addComment textarea').val('');			
			}
			else {
				alert('Sorry... Some bug happened');
			}
			
		}
	});
	
	$('#setPhotosDaily').ajaxForm({
		dataType:  'json',
		success: function(data){
			console.log('Request delivered');
			if (data.status == 'success'){
				console.log('status: success');
				var rating_daily = $('.photo-rating_daily').html();
				rating_daily = parseInt(rating_daily) + 1;
				$('.photo-rating_daily').html(rating_daily);
				$('#setPhotosDaily input[type=submit]').remove();
				$('#setPhotosDaily input').attr('disabled','disabled');
			}
			else {
				alert('Sorry... Some bug happened');
			}
			
		}
	});

	$('#contestTakePart').ajaxForm({
		dataType:  'json',
		success: function(data){
			console.log('Request delivered');
			if (data.status == 'success'){
				console.log('status: success');
				var numContests = $('.photo-numContests').html();
				numContests = parseInt(numContests) + 1;
				$('#contestTakePart').remove();
				$('.photo-numContests').html(numContests);
			}
			else {
				alert('Sorry... Some bug happened');
			}
			
		}
	});
	
	$('#exhibitionTakePart').ajaxForm({
		dataType:  'json',
		success: function(data){
			console.log('Request delivered');
			if (data.status == 'success'){
				console.log('status: success');
				var numContests = $('.photo-numContests').html();
				numContests = parseInt(numContests) + 1;
				$('#contestTakePart').remove();
				$('.photo-numContests').html(numContests);
			}
			else {
				alert('Sorry... Some bug happened');
			}
			
		}
	});	

	function showAllComments(el)
	{
		$('.photo-one-comments-item.hidden').removeClass('hidden');
		$(el).hide();
	}

</script>
{/literal}