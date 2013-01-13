/*
 * Meu Troco Project
 * 
 * @project		meuTroco
 * @site		--
 * @version		1.0
 * @package		Effects and self plugins
 * @author		Rafael Heringer Carvalho
 * @copyright	2011 Letsrider!
 */
 
/********************************************/
/************** GLOBALS *********************/
/********************************************/

//If set "type" and "message", show message after called page load.
//Ex.: GLOBAL_MESSAGE = {type:'success', message: 'A tag <strong>lorem</strong> foi adicionada com sucesso.'};
GLOBAL_MESSAGE = {};

//Title of website
DEFAULT_TITLE = jQuery('title').text();

//Debug mode?
DEBUG_MODE = true;

//AJAX request
XHR = null;

//Others
HAS_MODIFICATION = true;



/********************************************/
/************* FUNCTIONS ********************/
/********************************************/

/*
 * Fn: include
 * Desc: Include any script on document
 * Usage: include(file_path, revert)
 *
 * file_path	str		The SRC of script file
 * revert		bol		Set true to add script at the end of body
 */
function include(file_path,revert){
	var j = document.createElement("script");
	j.type = "text/javascript";
	j.src = file_path;
	if(!revert)
		document.getElementsByTagName("head")[0].insertBefore(j,document.getElementsByTagName("head")[0].childNodes[0]);
	else
		document.getElementsByTagName('body')[0].appendChild(j);
}

/*
 * Fn: tips
 * Description: Show tips on mouveover in elements
 */
jQuery.fn.tips = function(options, callback){
	//Options
	options = jQuery.extend({
		fade: true,
		fadeDuration: 200,
		tipId: 'ui-tip',
		attribute: 'data-tip',
		mouseFollow: true,
		calcPosition: true,
		offset: [5,10]
	},options);
	
	//Variables
	var self = this;
	self.tip = jQuery(document.getElementById(options.tipId));
	
	
	//Verify if container exists
	if(!self.tip.get(0)) {
		self.tip = $('<div id="'+options.tipId+'" class="'+options.tipId+'-container"><div class="'+options.tipId+'-text"></div></div>').appendTo('body');
	}
	
	//Add styles
	if(options.calcPosition)
		self.tip.css({'left':'0','top':'0','position':'absolute'});
	
	//Call for move
	self.callTip = function(element, text){
		element.isOn = false;
		
		jQuery(element).bind('mouseenter', function(){
			this.isOn = true;
			
			//Fade or show
			if(options.fade)
				self.tip.show().stop(true,true).fadeIn(options.fadeDuration);
			else
				self.tip.show();
			
			//Position
			if(options.calcPosition) {
				self.tip.css({'left':element.offset().left + options.offset[0], 'top':element.offset().top + options.offset[1]});
			}
			
			//Mouse follow
			if(options.mouseFollow) {
				$(document).bind('mousemove.tip',function(event){
						self.tip.css({'left':event.pageX + options.offset[0], 'top':event.pageY + options.offset[1]});
				});
			}
			
			//Add text
			self.tip.children('div').html(text);
		});
		
		jQuery(element).bind('mouseleave', function(){
			element.isOn = false;
			
			//Fade or hide
			if(options.fade)
				self.tip.stop(true,true).fadeOut(options.fadeDuration, function(){jQuery(this).hide();});
			else
				self.tip.hide();
				
			//Mouse follow disable
			$(document).unbind('mousemove.tip');
		});
	};
	
	//Each
	jQuery(this).each(function(){
		//Verify if has attribute
		if(jQuery(this).attr(options.attribute)) {
			self.callTip(jQuery(this), jQuery(this).attr(options.attribute));
		}
	});
		
	//Callback
	if(typeof eval(callback)== 'function') {
		jQuery.fn.callback = callback;
		jQuery(this).callback();
	}
				
	//Return
	return this;
};

/*
 * Fn: clouds
 * Description: Move the clouds :D
 */
jQuery.fn.clouds = function(options, callback){
	//Options
	options = jQuery.extend({
		id: 'clouds',
		append: true,
		width: 'auto',
		height: 'auto',
		position: {left: 'auto', top: 'auto'},
		speed: 90,
		frames: 1
	},options);
	
	//Variables
	var _this = this;
	var element = $('<div id="'+options.id+'" style="position:absolute;" />');
	
	//Create element
	if(!document.getElementById(options.id))
		options.append ? _this.after(element) : $('body').prepend(element);
	
	//Set size
	options.width == 'auto' ? element.width(_this.width()) : element.width(options.width);
	options.height == 'auto' ? element.height(_this.height()) : element.height(options.height);
	
	//Set Position
	options.position.left == 'auto' ? element.css('left', _this.offset().left) : element.css('left', options.position.left);
	options.position.top == 'auto' ? element.css('top', _this.offset().top) : element.css('top', options.position.top);
	
	//Set data
	_this.data('animaPos',0);
	
	
	
	//Set animation
	this.animation = function(){
		
		var animaPos = _this.data('animaPos');
		animaPos -= options.frames;
		element.css({backgroundPosition:animaPos+'px 0px'});
		_this.data('animaPos',animaPos);
		
	}; setInterval(this.animation, options.speed);

	//Callback
	if(typeof eval(callback)== 'function') {
		jQuery.fn.callback = callback;
		jQuery(this).callback();
	}
				
	//Return
	return this;
};

/*
 * Fn: blackout
 * Description: Give a lightbox effect
 * Parameters: 
 * *** animationspeed: the speed of all animations (default: medium)
 * *** blackoutclass: the class of blackout element (default: blackout)
 * *** content: the content inside box
 * *** action: action to to with blackout (default: open) (accept: close or open)
 * *** zindex: the zindex control of element (default: 1000)
 */
jQuery.fn.blackout = function(options, callback) {
	options = jQuery.extend({
		animationspeed: 'normal',
		blackoutclass: 'blackout',
		blackoutid: 'blackout',
		content: null,
		action: 'open',
		zindex: 1000
	},options);
	

	if(options.action != 'close' && options.action != "remove") {
		//Prevent
		if(jQuery('#'+options.blackoutid).length != 0) {
			jQuery('#'+options.blackoutid).fadeOut(options.animationspeed,function(){jQuery(this).remove();});
		}

		jQuery('<div id="'+options.blackoutid+'" class="'+options.blackoutclass+'" style="width:100%; height:100%; top:0; left:0; position:fixed; z-index:'+options.zindex+';"><div class="wrapper">'+options.content+'</div></div>').prependTo('body')
			.hide()
			.fadeIn(options.animationspeed, function(){
				//On complete
				if(typeof eval(callback)== 'function') {
					jQuery.fn.callback = callback;
					jQuery(this).callback();
				}
			});
			mouse_is_inside = false;
			jQuery('#'+options.blackoutid).find('.wrapper').hover(function(){ 
				mouse_is_inside = true; 
			}, function(){ 
				mouse_is_inside = false; 
			});
			
			jQuery('#'+options.blackoutid).bind('click', function(){
				if(mouse_is_inside == false)
					jQuery().blackout({action:'close'});
			});
		
		//On hit ESC key
		jQuery(document).bind('keyup',function(e){
			if(e.keyCode === 27)
		        jQuery().blackout({action:'close'});
		});
	}
	else if(options.action == "remove") {
		jQuery('#'+options.blackoutid).fadeOut(options.animationspeed,function(){
			jQuery(this).remove();
			//On complete
			if(typeof eval(callback)== 'function') {
				jQuery.fn.callback = callback;
				jQuery(this).callback();
			}
		});
		jQuery('body, html').unbind('keydown.preventScroll');
		jQuery(document).unbind('keyup');
	}
	else {
		jQuery('#'+options.blackoutid).fadeOut(options.animationspeed,function(){
			jQuery(this).remove();
			//On complete
			if(typeof eval(callback)== 'function') {
				jQuery.fn.callback = callback;
				jQuery(this).callback();
			}
		});
		jQuery('body, html').unbind('keydown.preventScroll');
		jQuery(document).unbind('keyup');
		if(history.length > 2)
			history.go(-1);
	}
	
	return this;
};

/*
 * Fn: popUp
 * Description: Give an lightbox popUp with actions
 * Author: Rafael Heringer Carvalho
 * Parameters: 
 * *** type: the type of popUp (default: success) (accept: success, alert, confirm)
 * *** popupclass: the class of popUp container (default: popUp)
 * *** text: the text of box (accept: text HTML)
 * *** title: the title of box
 * *** okaction: url to go when click in ok button (default:success) (accept: success, close or function)
 * *** closeaction: url to go when click in close button (default: close) (accept: close or function)
 * *** popclose: if set to true, give a link to close the popUp (default: true)
 * *** ajax: load ajax content (accept: url)
 * *** centered: if set to true, automatic center the popUp (default:true)
 */
jQuery.fn.popUp = function(options, callback) {
	options = jQuery.extend({
		type: 'success',
		popupclass: 'popUp',
		text: null,
		content:null,
		title: null,
		oklabel: 'Salvar',
		cancellabel: 'Cancelar',
		okaction: 'close',
		closeaction: 'close',
		popclose: true,
		popclosetext: 'Fechar',
		ajax: false,
		centered:true,
		beforestart:null,
		data:null,
		blackoutclass: 'blackout'
	}, options);	
	
	//////////Set
	var html;
	var _THIS = jQuery(this);
	
	/////////On start
	if(typeof eval(options.beforestart) == 'function') {
		jQuery.fn.beforestart = options.beforestart;
		jQuery(this).beforestart();
	}
	
	////////First HTML Part
	html = '<div class="'+options.popupclass+' '+options.type+'" id="popUp" style="position:absolute;">';
	
	////////Header HTML Part
	html += '<div class="header"> \n';
	if(options.popclose)
		html = html += '<a class="popClose" title="" href="#">'+options.popclosetext+'</a> \n';
	if(options.icoimg)
		html += '<img src="'+options.icoimg+'" alt="" class="ico" /> \n'; //Ico
	if(options.title)
		html += '<h2>'+options.title+'</h2> \n'; //Title
	if(!options.title && options.text)
		html += '<h5>'+options.text+'</h5> \n'; //Title
	html += '</div> \n';
	
	////////Middle HTML Part
	html += '<div class="content"> \n';
	//Text Content
	if(options.text && options.title)
		html += '<p>'+options.text+'</p> \n'; //Text
	//HTML content
	if(options.content)
		html += '<div class="middleContent">'+options.content+'</div> \n'; //Text
	//Ajax content
	if(options.ajax) {
		html += '<div class="ajaxContent"> \n';
		html += '</div> \n';
	}
	//Action Buttons
	html += '<div class="fieldset"> \n';
	if(options.type == 'success') {
		html += '<input type="button" class="btnOk" value="'+options.oklabel+'" />';
	} else {
		if(options.oklabel)
			html += '<input type="button" class="btnOk" value="'+options.oklabel+'" />';
		if(options.cancellabel)
			html += '<input type="button" class="btnCancel" value="'+options.cancellabel+'" />';
	}		
	html += '</div> \n';
	html += '</div> \n';
	
	////////Footer HTML Part
	html += '</div> \n';
	
	////////Actions
	//Create elements
	if(jQuery().blackout) 
		jQuery().blackout({content:html, blackoutclass: options.blackoutclass}, function(){
			//On complete
			if(options.ajax == false && typeof eval(callback)== 'function')  {
				jQuery.fn.callback = callback;
				_THIS.callback();
			}
		}); 
	else
		jQuery('body').prepend(html, function(){
			//On complete
			if(options.ajax == false && typeof eval(callback)== 'function') {
				jQuery.fn.callback = callback;
				_THIS.callback();
			}
		});
		
	//Set position
	if(options.centered)
		jQuery('.'+options.popupclass+'.'+options.type).css({left:'50%',top:'50%',marginLeft:jQuery('.'+options.popupclass+'.'+options.type).outerWidth()/-2,marginTop:jQuery('.'+options.popupclass+'.'+options.type).outerHeight()/-2});
		
	//Prevent Scroll on page
	$('body, html').bind('keydown.preventScroll',function(e) {
		 var key = e.which;
		  if(key == '40') {
			  e.preventDefault();
			  return false;
		  }
	});
	
	//Buttons Actions
	jQuery('.'+options.popupclass+' .btnOk').bind('click', function(){ //OK
		if(options.okaction == 'close' || options.okaction == null) {
			jQuery().blackout({action:'close'});
		} else if(typeof eval(options.okaction) == 'function') {
			jQuery.fn.okaction = options.okaction;
			if(_THIS.okaction())
				jQuery().blackout({action:'close'});
		}
		return false;
	});
	jQuery('.'+options.popupclass+' .btnCancel, '+'.'+options.popupclass+' .popClose').bind('click', function(){ //Close
		if(options.closeaction == 'close' || options.closeaction == null) {
			jQuery().blackout({action:'close'});
		} else if(typeof eval(options.closeaction)== 'function') {
			jQuery.fn.closeaction = options.closeaction;
			if(_THIS.closeaction())
				jQuery().blackout({action:'close'});
		}
		//Set Hash
		return false;
	});
	
	//Ajax load
	if(options.ajax) {
		jQuery('.'+options.type).find('.fieldset').hide();
		jQuery.ajax({
			url: options.ajax,
			beforeSend: function(XMLHttpRequest, settings){
				//Add loading
				jQuery('.'+options.type).find('.ajaxContent').loading();
				
				//Set
				HAS_MODIFICATION = false;
			},
			data:options.data,
			success: function(data, textStatus, XMLHttpRequest){
				//Populate
				jQuery('.'+options.type).find('.ajaxContent').html(data);
				
				//Show fieldset control
				jQuery('.'+options.type).find('.fieldset').show();
				
				//Center the DIV
				if(options.centered)
					jQuery('.'+options.popupclass+'.'+options.type).css({marginLeft:jQuery('.'+options.popupclass+'.'+options.type).outerWidth()/-2,marginTop:jQuery('.'+options.popupclass+'.'+options.type).outerHeight()/-2});
				
				//Keyboard event
				jQuery('.'+options.popupclass+'.'+options.type).keypress(function(event){
					if(event.keyCode == 13) {
						jQuery('.'+options.popupclass+' .btnOk').trigger('click');
					}
				});
				
				//Focuses
				$('input','.'+options.type).eq(0).trigger('focus');
				
				//On complete
				if(typeof eval(callback)== 'function') {
					jQuery.fn.callback = callback;
					jQuery('.'+options.type).callback();
				}
				
			}
		});
	}
	
	//On press ESC key
	jQuery(document).bind('keypress', function(e) {
		if(e.keyCode==27) {
			_THIS.blackout({action:'close'});
			jQuery(document).unbind('keypress');
		}
	});

	return _THIS;
};

/*
 * Fn: closePopUp
 * Description: Close the lighbox
 * Author: Rafael Heringer Carvalho
 */
jQuery.fn.closePopUp = function(callback) {
	if(history.length > 2)
		history.go(-1);

	if(typeof eval(callback)== 'function') {
		setTimeout(function(){
			callback();
		}, 200);
	}

};

/*
 * Fn: updateLoggedTime
 * Desc: Update the loggedTime
 */
function updateLoggedTime(){
	var timeLoggedString = siteInfo.thisSession.split(' ');
	var timeLogged = {};
	timeLogged.year = timeLoggedString[0].split('-')[0];
	timeLogged.month = timeLoggedString[0].split('-')[1] - 1;
	timeLogged.day = timeLoggedString[0].split('-')[2];
	timeLogged.hour = timeLoggedString[1].split(':')[0];
	timeLogged.minutes = timeLoggedString[1].split(':')[1];
	timeLogged.seconds = timeLoggedString[1].split(':')[2];

	var timeLogged = new Date(timeLogged.year, timeLogged.month, timeLogged.day, timeLogged.hour, timeLogged.minutes, timeLogged.seconds);
	var today = new Date();
	var timeDiff = new Date(today - timeLogged);
	var minutes = today.getMinutes() - timeLogged.getMinutes();
	var hours = today.getHours() - timeLogged.getHours();

	if(hours < 0) {
		hours = 24 + hours;
		hours++;
	}
	if(minutes < 0) {
		minutes = 60 + minutes;
		hours--;
	}
	var text = '';
	if(hours != 0)
		text += hours+'h ';
	text += minutes+'min';
	
	//Update counter	
	document.getElementById('loggedTime').innerHTML = text;
};

/*
 * Fn: getToken
 * Desc: Get token via cookie
 */
function getToken() {
	return siteInfo.token;
};

/*
 * Fn: reloadSidebar
 * Desc: Reload the sidebar values
 * Usage: reloadSidebar(callback)
 *
 * callback		fn		Callback function after load
 */
function reloadSidebar(callback) {
	
	//Set
	HAS_MODIFICATION = true;
	
	jQuery.ajax({
		url:siteInfo.url+'/views/sidebar.php',
		success: function(data, textStatus, XMLHttpRequest){
			//Show HTML
			jQuery('#sidebar','#contentWrap').html(data);
			
			//Callback
			if(typeof eval(callback)== 'function')
				callback();
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			if(DEBUG_MODE)
				alert('Ops! Ocorreu algum erro ao carregar o sidebar.');
			return false;
		}
	});
};

/*
 * Fn: reloadPage
 * Desc: Reload the page
 * Usage: reloadPage(string, sidebar)
 *
 * string		str		Insert info after "?" in URL
 * sidebar		bol		Reload sidebar?
 */
function reloadPage(string, sidebar) {
	string ? window.location.hash = window.location.hash.split('?')[0] + '?' + string : jQuery(window).hashchange();
	if(sidebar == true)
		reloadSidebar();
};

/*
 * Fn: convertMonth
 * Desc: Convert month (int) to string
 * Usage: convertMonth(month, abbr)
 *
 * month		int		Month (0 to 11)
 * abbr			bol		Abbreviantion?
 */
function convertMonth(month, abbr) {
	var $value = null;
	if(abbr)
		var array = {0: 'Jan', 1: 'Fev', 2: 'Mar', 3: 'Abr', 4: 'Mai', 5: 'Jun', 6: 'Jul', 7: 'Ago', 8: 'Set', 9: 'Out', 10: 'Nov', 11: 'Dez'};
	else
		var array = {0: 'Janeiro', 1: 'Fevereiro', 2: 'Março', 3: 'Abril', 4: 'Maio', 5: 'Junho', 6: 'Julho', 7: 'Agosto', 8: 'Setembro', 9: 'Outubro', 10: 'Novembro', 11: 'Dezembro'};
	jQuery.each(array, function(key, value) {
		if(key == month) {
			$value = value;
			return false;
		}
	});
	return $value;
}

/*
 * Fn: findMask
 * Desc: Add mask in pre-selected inputs
 * Usage: $(sel).findMak();
 *
 */
jQuery.fn.findMask = function(){
	return this;
};

/*
 * 
 * Fn: selectToIconConvert
 * Desc: Transform selects options to elements (divs) with classes.
 * Usage:
 *
 */
jQuery.fn.selectToIconConvert = function(){
	//Verify if is select
	if(jQuery(this).is('select')) {
		
		$(this).hide();
		
		//Variables
		var _THIS = jQuery(this);
		var options = jQuery(this).find('option');
		
		//Create element
		var html = '';
		var myClass = '';
		html += '<div class="selectOptions '+_THIS.attr('name')+'">';
			options.each(function(){
				myClass = jQuery(this).is(':selected') ? 'selected' : '';
				html += '<span class="' + myClass + ' option" data-value="' + jQuery(this).attr('value') + '" title="' + jQuery(this).text() + '">';
				html += jQuery(this).html();
				html += '</span>';
			});
		html += '</div>';
		
		//Append
		jQuery(this).before(html);
		var element = jQuery(this).prev();
		
		//Events
		element.find('.option').bind('click', function(){
			_THIS.find('option[value="' + jQuery(this).attr('data-value') + '"]').attr('selected','selected').trigger('change');
			jQuery(this).addClass('selected').siblings().removeClass('selected');
		});
	}
	
	//Return
	return this;
};

/*
 * Fn: verifyInputs
 * Desc: Validate pre-selected inputs
 * Usage: $(parent).verifyInputs()
 *
 */
jQuery.fn.verifyInputs = function(){
	
	//Set
	var _THIS = jQuery(this);
	var valid = true;
	var msg = "Por favor, verifique os campos abaixo.";
	var regexInputs = {
		'#transDescription': /^.{3,50}$/,
		'#tagName': /^.{3,28}$/,
		'#accountName': /^.{3,28}$/,
		'#transAmount': /^([1-9]{1}[0-9]{0,2}(\.[0-9]{3})*(\,[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\,[0-9]{0,2})?|0(\,[0-9]{0,2})?|(\,[0-9]{1,2})?)$/,
		'#dateSelect': /^[\d]{2}[\/][\d]{2}[\/][\d]{4}$/,
		'#profileName': /^.{3,100}$/,
		'#profileBirthday': /^[\d]{2}[\/][\d]{2}[\/][\d]{4}$/,
		'#profilePassword': /^.{6,12}$/,
		'#initialBalance': /^([1-9]{1}[0-9]{0,2}(\.[0-9]{3})*(\,[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\,[0-9]{0,2})?|0(\,[0-9]{0,2})?|(\,[0-9]{1,2})?)$/,
		'#profileEmail': /^[\w-]+(\.[\w-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)*?\.[a-z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{4})?$/
	};
	
	//Regex verify
	jQuery.each(regexInputs, function(input, regex){
		if(jQuery(input, _THIS).length) {
			jQuery(input, _THIS).removeClass('verify');
			if(jQuery(input, _THIS).next().is('.exclamation'))
				jQuery(input, _THIS).next().remove();
			var re = new RegExp(regex);
			if(!jQuery(input, _THIS).val().match(re)) {
				jQuery(input, _THIS).addClass('verify').after('<img src="'+siteInfo.url+'/_img/icons/exclamation-diamond.png" class="exclamation" />');
				valid = false;
			}
		}
	});
	
	//Message
	if(valid == false) {
		_THIS.message(msg, {type:'alert'});
	}
	
	//Return
	return valid;

};

/*
 * Desc: Get previous hash like history-go(-1)
 * Ex: window.location.previous
 *
 */
window.location.previous = null;
window.location.locationPreviousCount = 0;
window.location.actualPage = window.location.hash;
jQuery(window).hashchange(function(){
	window.location.previous = window.location.actualPage;
	window.location.actualPage = window.location.hash;
	window.location.locationPreviousCount++;
});

/*
 * Str: querystring
 * Desc: Get or set hash string like ?key=value
 * Usage: querystring.get(key)
 *
 * key			str		If is not null, get the value of key. If is null, get all strings
 *
 * Usage: querystring.set(key, value, previouspage)
 *
 * key			str		Set the key name
 * value		str		Set value of key
 * previousPage	bol		If set to true, return to the previous page (and se querystring)
 */
/*
 * Fn: querystring
 */
querystring = {
	//Get Key
	get: function(key){
		if(!key) {
			if(window.location.hash.split('?')[1] != null)
				return window.location.hash.split('?')[1];
			else
				return null;
		}
		else {
			var s = window.location.hash.split('?')[1];
			if(s == null || s == '')
				return null;
			var h = s.split("&"); 
			for(i=0;i<h.length;i++){
				f = h[i].split("=");
				if(f[0] == key)
					return f[1];
					break;
				}
			}
	},
	set: function(key, value, previousPage){
		//If set in previous page
		if(previousPage == true && window.location.previous != null) {
			window.location.href = window.location.previous+'?'+key+'='+value
		} else if(previousPage == true) {
			window.location.href = '#resumo?'+key+'='+value
		} else {
			
		}
	}
};

/*
 * Fn: convertToUnicode
 * Desc: Convert characters to unicode
 * Usage: conterToUnicode(string)
 *
 * string		str		String to convert
 */
function convertToUnicode(string){
	if(string) {
		var rep = ["&aacute;","&agrave;","&acirc;","&atilde;","&auml;","&eacute;","&egrave;","&ecirc;","&euml;","&iacute;","&igrave;","&icirc;","&iuml;","&oacute;","&ograve;","&ocirc;","&otilde;","&ouml;","&uacute;","&ugrave;","&ucirc;","&uuml;","&ccedil;","&Aacute;","&Agrave;","&Acirc;","&Atilde;","&Auml;","&Eacute;","&Egrave;","&Ecirc;","&Euml;","&Iacute;","&Igrave;","&Icirc;","&Iuml;","&Oacute;","&Ograve;","&Ocirc;","&Otilde;","&Ouml;","&Uacute;","&Ugrave;","&Ucirc;","&Uuml;","&Ccedil;"];
		var by = ["á","à","â","ã","ä","é","è","ê","ë","í","ì","î","ï","ó","ò","ô","õ","ö","ú","ù","û","ü","ç","Á","À","Â","Ã","Ä","É","È","Ê","Ë","Í","Î","Î","Ï","Ó","Ò","Ô","Õ","Ö","Ú","Ù","Û","Ü","Ç"];
		for(var i = 0; i <= rep.length; i++) {
			string = string.replace(rep[i],by[i]);
		}
		
		return string;
	}
};


/*
 * Fn: getTags
 * Desc: 
 * Usage: 
 *
 */
function getTags(callback){
	 jQuery.ajax({
		url:siteInfo.apiUrl+'/'+siteInfo.userId+'/tags/token='+getToken(),
		type:'GET',
		success: function(data, textStatus, XMLHttpRequest){
			var json = JSON.parse(data);
		
			//Callback
			if(typeof eval(callback)== 'function') {
				jQuery.fn.callback = callback;
				_THIS.callback(json);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			if(DEBUG_MODE)
				alert('Ops! Ocorreu algum erro.. Lembrar de tratar esse erro..');
			return false;
		}
	 });
};


/* 
 * Fn: suggestTags
 *
 */
jQuery.fn.suggestTags = function(callback){
	var _this = jQuery(this);
	getTags(function(json){
		var availableTags = [];
		jQuery.each(json, function(key, value){
			availableTags[key] = convertToUnicode(value.name);
		});
		function split(val) {
			return val.split(/,\s*/);
		}
		function extractLast(term) {
			return split(term).pop();
		}
		
		_this
		.bind("keydown", function(event) {
				if (event.keyCode === jQuery.ui.keyCode.TAB && jQuery(this).data("autocomplete").menu.active) {
					event.preventDefault();
				}
			})
		.bind('focus', function(){
			$(this).autocomplete("search" , "");
		})
		.autocomplete({
			minLength: 0,
			delay: 0,
			autoFocus: true,
			source: function(request, response) {
				// delegate back to autocomplete, but extract the last term
				response(jQuery.ui.autocomplete.filter(availableTags, extractLast(request.term)));
			},
			focus: function() {
				// prevent value inserted on focus
				return false;
			},
			select: function(event, ui) {
				var terms = split(this.value);
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push(ui.item.value);
				// add placeholder to get the comma-and-space at the end
				terms.push("");
				this.value = terms.join(", ");
				return false;
			}
		});


	});
};

/*
 * Fn: loading
 * Desc: Include loading elem
 * Usage: $(elem).loading(id, text, callback);
 *
 * id			str		The id of element to create
 * text			str		The default text is "Carregando..."
 * callback		fnc		Callback
 */
jQuery.fn.loading = function(id, text, callback){
	
	//Verify
	if(id == null || id == '')
		id = "loading";
	if(jQuery(this) == null)
		_THIS = jQuery('body');
	else
		_THIS = jQuery(this);
	if(text == null)
		text = "Carregando...";
	
	//Add
	_THIS.prepend('<div id="'+id+'" class="loading"><p>'+text+'</p></div>');
	
	return this;
	
};
 
/*
 * Fn: message
 */
jQuery.fn.message = function(text, options, callback){
	
	//Verify
	if(jQuery(this).length == 0)
		_THIS = jQuery('body');
	else
		_THIS = jQuery(this);
	
	//Options
	options = jQuery.extend({
		type:'normal', //normal, error, alert or success
		appendto:_THIS
	}, options);
	
	var html = '<div class="message '+options.type+'" style="display:none;"><div class="wrap">'+text+'</div></div>';
	
	//Appears
	var element = jQuery(html).prependTo(options.appendto).slideDown(800, function(){
		//Callback
		if(typeof eval(callback)== 'function') {
			jQuery.fn.callback = callback;
			_THIS.callback();
		}
	});
	
	//Desappear
	setTimeout(function(){
		element.fadeOut(3200, function(){
			jQuery(this).remove();
		});
	}, 6000);
	
};

/*
 * Fn: call
 * Desc:
 * Usage:
 */

window.call = function(url, data, options, callback){
	//Verify
	if(url == '') {
		alert('A função "call" requer uma URL válida.');
		return false;
	}
	
	var _THIS = jQuery('section#mainContent');
	
	//Options
	options = jQuery.extend({
		type:'GET',
		username:'',
		password:'',
		dataType:''
	}, options);
	
	//Abort others AJAX
	if(XHR)
		XHR.abort();

	//Ajax
	XHR = jQuery.ajax({
		dataType:options.dataType,
		url:url,
		data:data,
		type:options.type,
		username:options.username,
		password:options.password,
		beforeSend: function(XMLHttpRequest, settings){
			_THIS.html('').loading('contentLoading');
		},
		success: function(data, textStatus, XMLHttpRequest){
			_THIS.html(data);
			//Callback
			if(typeof eval(callback)== 'function') {
				jQuery.fn.callback = callback;
				_THIS.callback();
			}
			return true;
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			return false;
		}
	});
};

/********************************************/
/************ PAGES CONTROL *****************/
/********************************************/
/*
 * Fn: hashEnable
 * Desc:
 * Usage:
 *
 */	
jQuery.fn.hashEnable = function(){
	_THIS = jQuery(this);
	
	//Paths
	var viewsPath = siteInfo.url+'/views/';
	var controlPath = siteInfo.url+'/_scripts/control/';
	
	//Page list
	var views = [
		/* [hashTag, file, normal or popUp, pageTitle] */
		['#resumo',viewsPath+'resume.php', 'normal', 'Resumo'],
		['#contas', viewsPath+'accounts/accounts.php', 'normal', 'Contas'],
		['#editarConta', controlPath+'accounts/editAccount.js', 'popUp', 'Editar conta'],
		['#adicionarConta', controlPath+'accounts/addAccount.js', 'popUp', 'Adicionar conta'],
		['#removerConta', controlPath+'accounts/removeAccount.js', 'popUp', 'Remover conta'],
		['#tags', viewsPath+'tags/tags.php', 'normal', 'tags'],
		['#editarTags', viewsPath+'tags/editTags.php', 'normal', 'Editar tags'],
		['#verTag', viewsPath+'tags/viewTag.php', 'normal', 'Ver tag'],
		['#adicionarTag', controlPath+'tags/addTag.js', 'popUp', 'Adicionar tag'],
		['#editarTag', controlPath+'tags/editTag.js', 'popUp', 'Editar tag'],
		['#removerTag', controlPath+'tags/removeTag.js', 'popUp', 'Remover tag'],
		['#adicionarTransacao',controlPath+'transactions/addTransaction.js','popUp', 'Adicionar transação'],
		['#editarTransacao',controlPath+'transactions/editTransaction.js','popUp', 'Editar transação'],
		['#removerTransacao',controlPath+'transactions/removeTransaction.js','popUp', 'Remover transação'],
		['#meuPerfil', controlPath+'profile/myProfile.js','popUp','Editar meu perfil']
	];
	
	//On hash change
	jQuery(window).hashchange(function(){
		var hash = window.location.hash.split('?');
		var havePage = false;
		hash = hash[0];
		
		//Close any popUp Instance
		jQuery().blackout({action:'remove'});
		
		//Get the page on list
		jQuery.each(views,function(i,view){
			if(hash == view[0]) {
				havePage = true;
				jQuery('body').find('script').remove();
				if(view[2] == 'normal') {
					//Call page
					var qw = querystring.get() != null ? querystring.get() : '';
					if(HAS_MODIFICATION) {
						window.call(view[1]+'?'+qw, null, null, function(){
							//Insert script
							include(view[1].replace(viewsPath,controlPath).replace('.php','.js'), true);
							
							//Has message for display?
							if(GLOBAL_MESSAGE['type']) {
								jQuery().message(GLOBAL_MESSAGE['message'], {type:GLOBAL_MESSAGE['type']});
								GLOBAL_MESSAGE = {};
							}
							
							//Set height of content
							$('#mainContent').height('');
							$('#mainContent').height($('#mainContent').height());
							
							/* Call tips */
							$('td[data-tip]').tips();

							/* Activate goBack buttons */
							$('.goBack').bind('click', function(){
								history.go(-1);
							});
						});
					}
					//Change window title
					jQuery('title').text(view[3]+' '+DEFAULT_TITLE);
					
				} else {
					//Insert script
					include(view[1], true);
					
					//Change window title
					jQuery('title').text(view[3]+' '+DEFAULT_TITLE);
				}
			}
		});
		
		if(!havePage) {
			$().message('Ops! A página que você tentou acessar não existe.',{type:'error'});
			history.go(-1);
			return false;
		}
		
		//Modify Menu
		jQuery('#navigation > ul > li > a[href="'+hash+'"]').parent().addClass('active').siblings().removeClass('active');
		jQuery('#navigation > ul > li > ul > li a[href="'+hash+'"]').parent().parent().parent().addClass('active').siblings().removeClass('active');
		
		//Reset
		HAS_MODIFICATION = true;
	}); 
		
	//Return
	return this;
};


/********************************************/
/********* CALL FUNCTIONS (INI) *************/
/********************************************/

jQuery(document).ready(function(){
	/* Hash Enable */
	if(window.location.hash == "")
		window.location.hash = 'resumo';
	jQuery('body').hashEnable();
	jQuery(window).hashchange();

	/* Reload Sidebar */
	reloadSidebar();
	
	/* Start logged time */
	updateLoggedTime();
	setInterval(updateLoggedTime, 1000 * 60);
	
	/* Start clounds */
	jQuery('#header').clouds({width:'100%', position:{left:0, top:0}});
	
	/* Hover in navigation */
	jQuery('#navigation li').each(function(){
		var element = $(this);
		this.time = null;
		
		element.bind('mouseover', function(){
			clearTimeout(this.time);
			element.find('ul').show();
		});
		
		element.bind('mouseout', function(){
			this.time = setTimeout(function(){
				element.find('ul').hide();
			}, 100);
		});
		
		element.siblings().bind('mouseover', function(){
			element.find('ul').hide();
		}); 
	});
});