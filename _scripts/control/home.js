$(function(){
	$('#loginForm').on('submit', function(event){
		$.ajax({
			url: $(this).attr('action'),
			type: $(this).attr('method'),
			data: $(this).serialize(),
			success: function(xhr){
				window.location.href = siteInfo.url + '/minha-conta/?token=' + xhr;
			},
			error: function(xhr){
				var response = jQuery.parseJSON(xhr.responseText);
				$('#errors').show().html( response.message );
			}
		});

		event.preventDefault();
	});
});