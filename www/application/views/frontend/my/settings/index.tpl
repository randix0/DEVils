<div class="siteBlock">
	<div class="header"><h1>Settings</h1></div>
	<div class="body">
{if $LOGGED}
		<form id="uploadAvatar" method="post" enctype="multipart/form-data" action="/ajax/uploadAvatar">
			Avatar: <input type="file" name="avatar_image" />	
			<input type="submit" name="submit" value="Upload" />
		</form>
		
		{literal}
		<div id="resultsTemplate" class="hidden">
			<h2>New avatar uploaded!</h2>
			<div class="tCenter">
				<img class="photoB" src="{src}">
			</div>
		</div>
		{/literal}
{/if}
	</div>
	<div class="fooder"></div>
</div>

{literal}
<script type="text/javascript">
	$('#uploadAvatar').ajaxForm({
		dataType:  'json',
		success: function(data){
			$('#uploadAvatar').hide();
			if (data.status == 'success'){
				var template = $('#resultsTemplate').html();
				template = template.replace('{src}',data.src);
				$('#resultsTemplate').html(template).show();
				
			}
			else {
				$('#resultsTemplate').html('Sorry... Some bug happened');
			}
			
		}
	});
</script>
{/literal}