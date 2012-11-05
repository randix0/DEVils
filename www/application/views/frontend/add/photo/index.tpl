<form id="savePhoto" method="post" action="/ajax/savePhoto">
<input type="hidden" name="id" value="{if isset($photo.id) && $photo.id}{$photo.id}{else}0{/if}">
<table class="plain"><tr><td>
	<div class="siteBlock mR20px">
		<div class="header"><h1>{if isset($photo.id) && $photo.id}Edit photo{else}Upload photo{/if}</h1></div>
		<div class="body">
			
			<div class="module-ajax-success">
				Saved!
			</div>
			
			<table>
				<tr><td class="tRight w100px">Name:</td><td><input type="text" name="item[iname]" value="{if isset($photo.iname) && $photo.iname}{$photo.iname}{/if}" /></td></tr>
				<tr><td class="tRight">Describtion:</td><td><textarea name="item[idesc]">{if isset($photo.idesc) && $photo.idesc}{$photo.idesc}{/if}</textarea></td></tr>
				<tr><td class="tRight">Album:</td><td>
						<select name="item[album_id]" onchange="chAlbum(this)">
							<option value="0">no album</option>
							{if isset($albums) && $albums}
								{foreach $albums item=item}
									<option {if $photo.album_id == $item.id}selected="selected"{/if} value="{$item.id}">{$item.iname}</option>
								{/foreach}
							{/if}
							<option value="-1">- create album</option>
						</select>
						<input id="new_album" class="hidden" type="text" class="hidden" name="additional[album_iname]" value="" placeholder="new album name" />
					</td></tr>
					<tr><td class="tRight"></td><td><label id="album_cover" class="{if isset($photo.album_id) && $photo.album_id == 0}hidden{/if}" ><input type="checkbox" name="additional[album_cover]" value="1" /> set as album cover</label></td></tr>
				<tr><td class="tRight">Tags:</td><td><input type="text" name="additional[tags]" value="{if isset($photo.tags) && $photo.tags}{$photo.tags}{/if}" /></td></tr>
				<tr><td class="tRight"></td><td><label><input type="checkbox" name="item[allow_comments]" value="1" {if isset($photo.allow_comments) && $photo.allow_comments}checked="checked"{/if} /> allow comments</label></td></tr>
				<tr><td></td><td><input type="submit"></td></tr>
			</table>
		</div>
		{if isset($photo.id) && $photo.id}<div class="footer">Goto <a href="/photos/one/{$photo.id}">photo</a></div>{/if}
	</div>

</td><td width="310">
<img src="{$photo.path}b/{$photo.file}" width="300" class="photoM">
</td></tr></table>

{literal}
<script type="text/javascript">
	function chAlbum(sel)
	{
		if (typeof(sel) == 'undefined') return false;
		var selVal = $(sel).val();
		if (selVal == '-1') $('#new_album').show();
		else $('#new_album').hide();
		
		if (selVal == '0') $('#album_cover').hide();
		else $('#album_cover').show();
		
	}

	$('#savePhoto').ajaxForm({
		dataType:  'json',
		beforeSend: function(){
			$('.module-ajax-success').hide();
		},
		success: function(data){
			console.log('Request delivered');
			if (data.status == 'success'){
				console.log('status: success');
				$('.module-ajax-success').show();
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

<script type="text/javascript">
{literal}
{/literal}
</script>