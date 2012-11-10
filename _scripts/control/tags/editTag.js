(function($){
	/* ***** Get Meta Data ***** */
	var element = $('[data-id="'+querystring.get('id')+'"][data-role="tag"]', '#mainContent');
	var query = {
		id: element.attr('data-id'),
		name: element.attr('data-name'),
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
		type:'addTag',
		ajax:siteInfo.url+'/views/tags/editTag.php',
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
					url:siteInfo.apiUrl+'/'+siteInfo.userId+'/tags/token='+getToken(),
					type:'POST',
					data:$data,
					error: function(XMLHttpRequest, textStatus, errorThrown){
						$('.popUp form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
						
					},
					success: function(data){
						/* Ok */
						GLOBAL_MESSAGE = {type:'success', message: 'A tag <strong>'+query.name+'</strong> fo alterada com sucesso.</strong>.'};
						reloadSidebar();
						jQuery().blackout({action:'close'});
					}
				});
			}
			
			return false;
		}	
	});
})(jQuery);	