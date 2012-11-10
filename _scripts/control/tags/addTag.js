(function($){
	/* ***** Open popUp ***** */
	$().popUp({
		type:'addTag',
		ajax:siteInfo.url+'/views/tags/addTag.php',
		oklabel: 'Adicionar',
		cancellabel: 'Cancelar',
		okaction: function(){
			/* Verify */
			if($('.popUp form').verifyInputs()) {
				/* Ajax */
				var $data = {};
				$.each($('.popUp form input, .popUp form select'), function(index, elem){
					$data[$(elem).attr('name')] = $(elem).val();
				});
				$.ajax({
					url:siteInfo.apiUrl+'/'+siteInfo.userId+'/tags/token='+getToken(),
					type:'put',
					data:$data,
					error: function(XMLHttpRequest, textStatus, errorThrown){
						$('.popUp form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
					},
					success: function(data){
						/* Ok */
						GLOBAL_MESSAGE = {type:'success', message: 'A tag <strong>' + $('.popUp').find('#tagName').val() + '</strong> foi adicionada com sucesso.'};
						jQuery().blackout({action:'close'});

						if(window.location.actualPage == "marcadores") {
							reloadPage();
						}
					}
				});
			}
		}
	});
})(jQuery);	