(function($){
	/* ***** PopUp ***** */
	$().popUp({
		type:'myProfile',
		ajax:siteInfo.url+'/views/myProfile/profile.php?'+querystring.get(),
		oklabel: 'Salvar',
		cancellabel: 'Cancelar',
		okaction: function(){
			/* Verify */
			if($('.popUp form').verifyInputs()) {
				
				/* Test */
				var verified = false;
				if($('#profilePassword', '.popUp form').val() != $('#checkProfilePassword', '.popUp form').val()) {
					$('.popUp form').message('As duas senhas não são iguais. Por favor, verifique.', {type:'alert'});
				} 
				else 
					 verified = true;
				if(verified) {
					/* Ok */
					GLOBAL_MESSAGE = {type:'success', message: 'A sua conta foi editada com sucesso.'};
					return true;
				}
			}
			
			return false;
		}
	}, function(){
		/* ***** Calendar ***** */
		$(".fullCalendar").datepicker({
			duration: 100,
			beforeShow: function(input, inst) {
				$("#ui-datepicker-div").addClass('fullCalendar');
			}
		});
	});
	
	
})(jQuery);