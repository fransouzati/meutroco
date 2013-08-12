(function($){
	/* ***** Get Meta Data ***** */
	var element = $('[data-id="'+querystring.get('id')+'"][data-role="account"]', '#mainContent');
	if(element.length == 0)
		var element = $('[data-id="'+querystring.get('id')+'"][data-role="account"]', '#sidebar');
	var query = {
		id: querystring.get('id'),
		name: element.attr('data-name')
	};
	
	/* ***** Verify ***** */
	if(element.length == 0) {
		GLOBAL_MESSAGE = {type:'error', message: 'Ops! Não encontramos a conta selecionada'};
		history.go(-1);
		return false;
	}
	
	/* ***** Open popUp ***** */
	$().popUp({
		data:query,
		type:'removeAccount',
		ajax:siteInfo.url+'/views/accounts/removeAccount.php',
		oklabel: 'Remover',
		okaction: function(){
			/* Ajax */
			$.ajax({
				url:siteInfo.apiUrl+'/'+siteInfo.userId+'/accounts/token='+getToken()+'&id='+query.id,
				type:'delete',
				error: function(XMLHttpRequest, textStatus, errorThrown){
					$('.popUp form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
				},
				success: function(data){
					/* Ok */
					GLOBAL_MESSAGE = {type:'success', message: 'A conta <strong>'+query.name+'</strong> foi removida com sucesso.'};
					jQuery().blackout({action:'close'}, function() {
						reloadSidebar();
					});
				}
			});
		}
	});
	
	
})(jQuery);	