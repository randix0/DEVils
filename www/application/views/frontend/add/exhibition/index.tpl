<div class="siteBlock">
	<div class="header"><h1>{if isset($exhibition.id) && $exhibition.id}Edit{else}Add{/if} exhibition</h1></div>
	<div class="body">

		<div class="module-ajax-success">
			Saved!
		</div>	
	
		<form id="saveExhibition" method="post" action="/ajax/saveExhibition">
			<input id="item_id" type="hidden" name="id" value="{if isset($exhibition.id) && $exhibition.id}{$exhibition.id}{else}0{/if}">
			<table>
			<tr><td class="tRight w100px">Name:</td><td><input type="text" name="item[iname]" value="{if isset($exhibition.id) && $exhibition.id}{$exhibition.iname}{/if}"></td></tr>
			<tr><td class="tRight w100px">Description:</td><td><textarea name="item[idesc]">{if isset($exhibition.id) && $exhibition.id}{$exhibition.idesc}{/if}</textarea></td></tr>
			<tr><td></td><td>
				Date from: <input type="text" class="datepicker" name="item[date_from]" value="{if isset($exhibition.id) && $exhibition.id}{$exhibition.date_from|date_format:"%d-%m-%Y"}{else}{$smarty.now|date_format:"%d-%m-%Y"}{/if}">
				Date till: <input type="text" class="datepicker" name="item[date_till]" value="{if isset($exhibition.id) && $exhibition.id}{$exhibition.date_till|date_format:"%d-%m-%Y"}{else}{$smarty.now|date_format:"%d-%m-%Y"}{/if}">
			</td></tr>
			<tr><td class="tRight w100px">Access:</td><td>
				<select name="item[access_level]">
					<option value="10">registered</option>
					<option value="50">moderators</option>
					<option value="90">administrators</option>
				</select>			
			</td></tr>
			<tr><td></td><td><input type="submit" value="Save"></td></tr>
			</table>
		</form>
	</div>
	<div class="footer"></div>
</div>

<script type="text/javascript">
	$('#saveExhibition').ajaxForm({
		dataType:  'json',
		beforeSend: function(){
			$('.module-ajax-success').hide();
		},
		success: function(data){
			console.log('Request delivered');
			if (data.status == 'success'){
				console.log('status: success');
				$('.module-ajax-success').show();
				if (data.id > 0)
				{
					$('#item_id').val(data.id);
					$('.header hi').html('Edit exhibition');
				}				
			}
			else {
				alert('Sorry... Some bug happened');
			}
			
		}
	});
</script>