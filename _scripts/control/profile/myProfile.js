(function($){
	/* ***** New Page ***** */
	$().popUp({
		type:'myProfile',
		ajax: siteInfo.url+'/views/profile/myProfile.php',
		popupclass: 'myProfile',
		blackoutclass: 'newPageBlackout',
		okaction: function(){
			/* Verify */
			if($('.myProfile form').verifyInputs()) {
				/* Ajax */
				var $data = {};
				$.each($('.myProfile form input, .myProfile form select'), function(index, elem){
					$data[$(elem).attr('name')] = $(elem).val();
				});

				$.ajax({
					url: siteInfo.apiUrl+'/user/token='+getToken(),
					type: 'POST',
					data: $data,
					error: function(XMLHttpRequest, textStatus, errorThrown){
						$('.myProfile form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
					},
					success: function(data){
						/* Ok */
						GLOBAL_MESSAGE = {type:'success', message: 'O seu perfil foi alterado com sucesso.'};
						jQuery().blackout({action:'close'});
						setTimeout(function(){
							window.location.reload();
						}, 1000);
					}
				});
			}
			
			return false;
		}
	}, function() {
		/* ***** Calendar ***** */
		$(".fullCalendar").datepicker({
			duration: 100,
			beforeShow: function(input, inst) {
				$("#ui-datepicker-div").addClass('fullCalendar');
			}
		});
	});
})(jQuery);