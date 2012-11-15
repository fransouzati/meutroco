(function($){
	/* ***** Open popUp ***** */
	$().popUp({
		type:'addTransaction',
		ajax:siteInfo.url+'/views/transactions/addTransaction.php?acc='+querystring.get('acc'),
		oklabel: 'Adicionar',
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
					type:'PUT',
					data:$data,
					error: function(XMLHttpRequest, textStatus, errorThrown){
						$('.popUp form').message(JSON.parse(XMLHttpRequest.responseText).message, {type:'alert'});
						
					},
					success: function(data){
						/* Ok */
						GLOBAL_MESSAGE = {type:'success', message: 'A transação <strong>'+$('.popUp form #transDescription').val()+'</strong> foi adicionada com sucesso.'};
						jQuery().closePopUp(function(){
							reloadPage(false, true);
						});
					}
				});
			}
		}
	}, function(){
		/* Type and title */
		$('h3', this).text();
		
		/* Calendar */
		$('.fullCalendar', this).datepicker({
			beforeShow: function(input, inst) {
				$("#ui-datepicker-div").addClass('fullCalendar');
			}
		}).next('.calendarIco').bind('click', function(){
			$(this).prev().trigger('focus');
		});
		
		/* Type */
		$('#transType', this);		
		$('.transfer', this).hide();
		$('#transType', this).selectToIconConvert().bind('change', function(){
			$(this).val() == 3 ? $('.transfer', '#popUp').show() : $('.transfer', '#popUp').hide();
		});
		
		/* Mask */
		$('#transAmount', this).priceFormat();
		$('#dateSelect', this).mask('99/99/9999');
		
		/* Auto Complete */
		$('#selectTags', this).suggestTags();
	});
})(jQuery);	