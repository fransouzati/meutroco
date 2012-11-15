/* ***** Privated ***** */
var interface = {};
interface.i18n = {};

/* ***** Internationalization ***** */
interface.i18n = {
	text: {
		close: 'Fechar',
		open: 'Abrir',
		previous: 'Anterior',
		next: 'Próximo',
		loading: 'Carregando...',
		resetZoom: 'Retirar zoom'
	},
	date: {
		monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		currentDay: 'Hoje'
	},
	money: {
		currencySymbol: 'R$',
		decimalPoint: ',',
		thousandsSep: '.'
	}
};


/* ***** Sets ***** */
var date = new Date();
var monthsList = new Array(); //List of months
for(i=0; i <= date.getMonth(); i++) { monthsList[i] = convertMonth(i, true);}
var daysList = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];

/* ***** Ajax Requests ***** */
$.ajaxSetup({
	beforeSend: function(jqXHR, settings){
		$('#loadingRequest').fadeIn(300);
		if(settings.type == "PUT") {
			settings.type = "POST";
			settings.data = settings.data+'&method=put';
		} else if (settings.type == "DELETE") {
			settings.url = encodeURI(settings.url+'&'+settings.data+"&method=delete");
			settings.type = "GET";
		}
	},
	complete: function(jqXHR, textStatus) {
		$('#loadingRequest').fadeOut(300);
	}
});
/* ***** Highcharts ***** */
Highcharts.setOptions({
		lang: {
			loading: interface.i18n.text.loading,
			resetZoom: interface.i18n.text.resetZoom,
			decimalPoint: interface.i18n.money.decimalPoint,
			months: interface.i18n.date.monthNames,
			shortMonths: interface.i18n.date.monthNamesShort,
			weekdays: interface.i18n.date.dayNames,
			thousandsSep: interface.i18n.money.thousandsSep
		},
		tooltip: {
			shared: false,
			crosshairs: {
				width:3,
				color:'rgba(0,0,0,.05)'
			},
			style: {
				fontSize:'10px'
			},
			borderWidth: 1
		},
		chart: {
            defaultSeriesType: 'line',

			style: {
				fontFamily:'Verdana, Arial',
				fontSize:'10px'
			},
			zoomType: 'x'
        },
		legend: {
			borderWidth: 0,
			itemHoverStyle: {
				color: '#73A8C0'
			},
			itemWidth: 200,
			itemStyle: {
				fontSize: '10px',
				paddingBottom: '10px',
				color: '#666'
			}
		},
		credits: {
			enabled: false
		},
		title: {
        	text: null
		},
		yAxis: {
			title: {
				text: null
			},
			gridLineDashStyle: 'longDash',
			alternateGridColor: '#f7f7f7',
			labels: {
				style: {
					fontSize:'9px',
					color: '#999'
				}
			}
		},
		xAxis: {
			labels: {
				style: {
					fontSize:'9px',
					color: '#999'
				}
			}
		},
		plotOptions: {
			pie: {
				borderWidth: '1',	
				size: '90%',
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: false
				},
				showInLegend: false
			}
		}
});

/* ***** Datepicker ***** */
$.datepicker.regional['pt-BR'] = {
	closeText: 'Fechar',
	prevText: '&#x3c;'+interface.i18n.text.previous,
	nextText: interface.i18n.text.next+'&#x3e;',
	currentText: interface.i18n.date.currentDay,
	monthNames: interface.i18n.date.monthNames,
	monthNamesShort: interface.i18n.date.monthNamesShort,
	dayNames: interface.i18n.date.dayNames,
	dayNamesShort: interface.i18n.date.dayNamesShort,
	dayNamesMin: interface.i18n.date.dayNamesMin,
	weekHeader: 'Sm',
	dateFormat: 'dd/mm/yy',
	firstDay: 0,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
$.datepicker.setDefaults({
	duration: 100,
	beforeShow: function(input, inst) {
		$("#ui-datepicker-div").removeClass('fullCalendar');
	}
});