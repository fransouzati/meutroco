(function($){
	/* ***** Get Meta Data ***** */
	var element = $('[data-id="'+querystring.get('id')+'"][data-role="tag"]', '#mainContent');
	var query = {
		id: querystring.get('id'),
		name: element.attr('data-name')
	};
	
	/* ***** Verify ***** */
	if(element.length == 0) {
		GLOBAL_MESSAGE = {type:'error', message: 'Ops! Não encontramos a tag selecionada.'};
		history.go(-1);
		return false;
	}
	
	/* ***** popUp ***** */
	$().popUp({
		data:query,
		type:'removeTag',
		ajax:siteInfo.url+'/views/tags/removeTag.php',
		oklabel: 'Remover',
		okaction: function(){
			/* Ajax */
			$.ajax({
				url:siteInfo.apiUrl+'/'+siteInfo.userId+'/tags/token='+getToken()+'&id='+query.id,
				type:'delete',
				error: function(XMLHttpRequest, textStatus, errorThrown){
					$('.popUp form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
				},
				success: function(data){
					/* Ok */
					GLOBAL_MESSAGE = {type:'success', message: 'A tag <strong>'+query.name+'</strong> foi removida com sucesso.'};
					reloadSidebar();
					jQuery().blackout({action:'close'});
				}
			});
		}
	});
})(jQuery);	