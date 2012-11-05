<div class="siteBlock">
{if $LOGGED}
	<div class="header"><h1>Upload</h1></div>
	<div class="body">
		{if isset($thumb) && $thumb}<div><img class="photoS" src="{$thumb}"></div>{/if}
		{*if isset($photo_b) && $photo_b}<div><img class="photoM" src="{$photo_b}"></div>{/if*}
		<form method="post" enctype="multipart/form-data">
		<input type="file" name="uploaded_image" />
		<label class="block"><input type="text" name="photo[iname]" value="" placeholder="Name"></label>
		<label class="block"><textarea name="photo[idesc]"></textarea></label>
		<label class="block"><input type="checkbox" name="photo[allow_comments]" value="1" checked="checked" placeholder="Name"> allow comments</label>
		<input type="submit" name="submit" value="Upload" />
		</form>
	</div>
{else}
	<div class="header">You have o sign-in first</h1>
	<div class="body">Back to <a href="/">main</a></div>
{/if}
</div>