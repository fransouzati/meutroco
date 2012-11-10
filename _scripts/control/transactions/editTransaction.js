(function($){
	/* ***** Get Meta Data ***** */
	var element = $('[data-id="'+querystring.get('id')+'"][data-role="transaction"]', '#mainContent');
	var query = {
		id: querystring.get('id'),
		description: element.attr('data-description'),
		type: element.attr('data-type'),
		date: element.attr('data-date'),
		acc: element.attr('data-acc'),
		accto: element.attr('data-accto'),
		tags: element.attr('data-tags'),
		amount: element.attr('data-amount')
	};
	
	/* ***** Verify ***** */
	if(element.length == 0) {
		GLOBAL_MESSAGE = {type:'error', message: 'Ops! Não encontramos a transação selecionada.'};
		history.go(-1);
		return false;
	}
	
	/* ***** Open popUp ***** */
	$().popUp({
		data:query,
		type:'editTransaction',
		ajax:siteInfo.url+'/views/transactions/editTransaction.php',
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
					url:siteInfo.apiUrl+'/'+siteInfo.userId+'/transactions/token='+getToken(),
					type:'POST',
					data:$data,
					error: function(XMLHttpRequest, textStatus, errorThrown){
						$('.popUp form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
					},
					success: function(data){
						/* Ok */
						GLOBAL_MESSAGE = {type:'success', message: 'A transação <strong>'+query.description+'</strong> foi alterada com sucesso.'};
						reloadSidebar();
						jQuery().blackout({action:'close'});
					}
				});
			}
		}	
	}, function(){
		/* Calendar */
		$(".popUp .fullCalendar").datepicker({
			beforeShow: function(input, inst) {
				$("#ui-datepicker-div").addClass('fullCalendar');
			}
		}).next('.calendarIco').bind('click', function(){
			$(this).prev().trigger('focus');
		});
		
		/* Type */
		$('.popUp form #transType').selectToIconConvert();
		
		if($('.popUp form #transType').val() != 3)
			$('.popUp form .transfer').hide();
		$('.popUp form #transType').bind('change', function(){
			if($(this).val() == 3)
				$('.popUp form .transfer').show();
			else
				$('.popUp form .transfer').hide();
		});
		
		/* Mask */
		$('.popUp #transAmount').priceFormat();
		$('.popUp #dateSelect').mask('99/99/9999');	
		
		/* Auto Complete */
		$('.popUp #selectTags').suggestTags();
		
	});
	
	
})(jQuery);	