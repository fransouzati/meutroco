(function($){
	/* ***** Open popUp ***** */
	$().popUp({
		type:'addAccount',
		ajax:siteInfo.url+'/views/accounts/addAccount.php',
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
					url:siteInfo.apiUrl+'/'+siteInfo.userId+'/accounts/token='+getToken(),
					type:'put',
					data:$data,
					error: function(XMLHttpRequest, textStatus, errorThrown){
						$('.popUp form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
					},
					success: function(data){
						/* Ok */
						GLOBAL_MESSAGE = {type:'success', message: 'A conta <strong>'+$('.popUp form #accountName').val()+'</strong> foi criada com sucesso.'};
						jQuery().blackout({action:'close'}, function() {
							reloadPage(null, true);
						});
					}
				});
			}
		}
	}, function (){
		/* Mask */
		$('.popUp #initialBalance').css('text-align','right').priceFormat();
		
		/* Type */
		$('.popUp form #accountType').selectToIconConvert();
	});
})(jQuery);	