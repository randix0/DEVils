	function ajaxLike(el, object_type, object_id)
	{
		if (typeof(el) == 'undefined' || typeof(object_type) == 'undefined' || typeof(object_id) == 'undefined') return false;
		$.ajax({
			url: '/ajax/like/'+object_type+'/'+object_id,
			dataType:  'json',
			success: function(data){
				$(el).hide();
				if (object_type == 2){
					var rating = $('#photo-rating').html();
					$('#photo-rating').html(parseInt(rating)+1);
				}
			}
		});
	}

	function ajaxDelete(el, object_type, object_id)
	{
		if (typeof(el) == 'undefined' || typeof(object_type) == 'undefined' || typeof(object_id) == 'undefined') return false;
		$.ajax({
			url: '/ajax/delete/'+object_type+'/'+object_id,
			dataType:  'json',
			beforeSend: function(){
				return confirm('Are you sure?');
			},
			success: function(data){
				$(el).addClass('deleted').html('deleted');
				
			}
		});
	}

$(document).ready(function(){
	$( ".datepicker" ).datepicker({ dateFormat:'dd-mm-yy'});
	
	$.ajax({
		url : '/ajax/setOnline',
		success : function(data){
			if (data.status == 'success')
				console.log('setOnline: OK '+data.details);
			else
				console.log('setOnline: ERROR '+data.details);
		}
	});
});