(function($){
	/* ***** Get Meta Data ***** */
	var element = $('[data-id="'+querystring.get('id')+'"][data-role="transaction"]', '#mainContent');
	var query = {
		id: querystring.get('id'),
		description: element.attr('data-description')
	};
	
	/* ***** Verify ***** */
	if(element.length == 0) {
		GLOBAL_MESSAGE = {type:'error', message: 'Ops! Não encontramos a transação selecionada'};
		history.go(-1);
		return false;
	}
	
	/* ***** Open popUp ***** */
	$().popUp({
		data:query,
		type:'addTransaction',
		ajax:siteInfo.url+'/views/transactions/removeTransaction.php',
		oklabel: 'Remover',
		okaction: function(){
			/* Ajax */
			$.ajax({
				url:siteInfo.apiUrl+'/'+siteInfo.userId+'/transactions/token='+getToken()+'&id='+query.id,
				type:'delete',
				error: function(XMLHttpRequest, textStatus, errorThrown){
					$('.popUp form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
				},
				success: function(data){
					/* Ok */
					GLOBAL_MESSAGE = {type:'success', message: 'A transação <strong>'+query.description+'</strong> foi removida com sucesso.'};
					reloadSidebar();
					jQuery().blackout({action:'close'});
				}
			});
		}
	});
	
	
})(jQuery);	