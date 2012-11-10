(function($){
	/* ***** Get Meta Data ***** */
	var element = $('[data-id="'+querystring.get('id')+'"]', '#mainContent');
	if(element.length == 0)
		var element = $('[data-id="'+querystring.get('id')+'"][data-role="account"]', '#sidebar');
	var query = {
		id: querystring.get('id'),
		accountType: element.attr('data-accountType'),
		name: element.attr('data-name'),
		initialBalance: element.attr('data-initialBalance')
	};
	
	/* ***** Verify ***** */
	if(element.length == 0) {
		GLOBAL_MESSAGE = {type:'error', message: 'Ops! Não encontramos a conta selecionada.'};
		history.go(-1);
		return false;
	}
	
	/* ***** Open popUp ***** */
	$().popUp({
		data:query,
		type:'editAccount',
		ajax:siteInfo.url+'/views/accounts/editAccount.php',
		oklabel: 'Salvar',
		okaction: function(){
			/* Verify */
			if($('.popUp form').verifyInputs()) {
				/* Ajax */
				var $data = {};
				$.each($('.popUp form input, .popUp form select'), function(index, elem){
					$data[$(elem).attr('name')]=$(elem).val();
				});
				$.ajax({
					url:siteInfo.apiUrl+'/'+siteInfo.userId+'/accounts/token='+getToken(),
					type:'POST',
					data:$data,
					error: function(XMLHttpRequest, textStatus, errorThrown){
						$('.popUp form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
						
					},
					success: function(data){
						/* Ok */
						GLOBAL_MESSAGE = {type:'success', message: 'A conta <strong>'+query.name+'</strong> foi alterada com sucesso.'};
						jQuery().blackout({action:'close'});
						reloadSidebar();
					}
				});
			}
		}
	}, function() {
		/* Mask */
		$('.popUp #initialBalance').css('text-align','right').priceFormat();
		
		/* Type */
		$('.popUp form #accountType').selectToIconConvert();
	});
	
})(jQuery);	