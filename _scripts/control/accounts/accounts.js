(function($){
	
	/* ***** Calendar ***** */
	var date = new Date();
	$(".monthCalendar").datepicker({
		duration: 100,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
		minDate: new Date(2010, 0, 1), /* Pegar a data de cadastro */
		maxDate: new Date(date.getFullYear(), date.getMonth(), 1),
        onClose: function(dateText, inst) { 
            var month = parseInt($("#ui-datepicker-div .ui-datepicker-month :selected").val())+1;
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			$(this).datepicker('setDate', new Date(year, month, 1)).trigger('blur');
			reloadPage('m='+month+'&y='+year);
        },
		beforeShow: function(input, inst) {
			if ((datestr = $(this).val()).length > 0) {
				year = datestr.substring(datestr.length-4, datestr.length);
				month = jQuery.inArray(datestr.substring(0, datestr.length-5), $(this).datepicker('option', 'monthNames'));
				$(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
				$(this).datepicker('setDate', new Date(year, month, 1));
				$("#ui-datepicker-div").removeClass('fullCalendar');
			}
		}
	});
})(jQuery);