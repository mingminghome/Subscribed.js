//by mingminghomework

(function($){

	$.fn.SubscribedJS = function(setting){

		// Default parameters

      var options = $.extend({},{
          	event : "",
			url : "",
			height : "auto",
			width : "80%",
			top: "20%",
			left: "10%",
			placeholder:"&#xf003; E-mail",
			title:"",
			desc:"",
			btnText:"Submit",
			tc:"",
			gaEvent:"Subscribe Event",
			err:{	"01":"&#xf059; May I know your E-mail address?",
					"02":"&#xf06a; Please enter a vaild E-mail address!",
					"03":"&#xf119; We found something unusual on our server! Please try again later!",
					"04":"&#xf119; We found something unusual on network! Please try again later!",
					"05":"&#xf119; You have already applied!"
				},
			succ:{	"title":"&#xf00c;",
					"desc":"Thanks for your application!"
				}
			//gKey: "", //Default google reCaptcha site key
		},setting);
			
				
		return this.click(function(e){
			add_pop_background();
			add_pop_box();
			add_pop_content();
			
			add_style();
			//load_captcha();
			form_submit();
			
			$('.pop_box_reminder').fadeIn();
		});
		
		 function add_style(){			
			$('.pop_box_reminder').css({ 
				'left':options.left,
				'top':options.top,
				'height': options.height,
				'width': options.width
			});
		}
		
		function add_pop_background(){
			var formBase = $('<div class="pop_background"><i class="pop_box_close fa fa-times"></i></div>');
			$(formBase).appendTo('body');
		}

		function add_pop_box(){
			var popUp = $('<div class="pop_box_reminder"><div class="pop_content"></div></div>');
			$(popUp).appendTo('.pop_background');
			 			 
			$('.pop_box_close').click(function(){
				$('.pop_box_reminder').fadeOut().remove();
				$('.pop_background').fadeOut().remove();				 
			});
			
			$('.pop_background').click(function(event){
			    if (!$(event.target).closest('.pop_box_reminder').length) {
					$('.pop_box_reminder').fadeOut().remove();
					$('.pop_background').fadeOut().remove();		
				}
			});
		}
		
		function add_pop_content(){
			/*var form = $('<div class="erFormTitle">'+ options.title +'</div><div class="erFormContainer"><form class="erForm" action="javascript:void(0)"><div id="erFormError"></div><input id="erFormBox" type="text" placeholder="'+ options.placeholder +'"><div class="g-recaptcha-warp"><div class="g-recaptcha" data-sitekey="'+ options.gKey +'"></div></div><input id="erFormSubmit" type="submit" value="Submit"></form></div>');*/
			var form = $('<div class="erFormTitle"><h1>'+ options.title +'</h1><p>'+ options.desc +'</p></div><div class="erFormError"></div><div class="erFormContainer"><form class="erForm" action="javascript:void(0)"><div class="erFormInputWrapper"><input id="erFormBox" type="text" placeholder="'+ options.placeholder +'"><input id="erFormSubmit" type="submit" value="'+ options.btnText +'"></div><div class="erFormTc">'+ options.tc +'</div></form></div>');
			$(form).appendTo('.pop_content');
		}
		
		/*
		function load_captcha(){
			var gApi = $('<script src="https://www.google.com/recaptcha/api.js" async defer></script>');
			$(gApi).appendTo('head');
		}
		
		*/
		
		function form_submit(){
			
			$(' .erForm input[type="text"] ').focus(function() {
				$('.erFormError').html('');
			});
			
			$('#erFormSubmit').click(function(e){
			e.preventDefault();
				
			//var gr = grecaptcha.getResponse();
			var ui = $('#erFormBox').val();
			var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
			//var rt = /[0-9]{8}/;
					
			/*
			if (!gr	){
				//console.log('Empty Captcha');
			}else if (!ui	|| !( re.test(ui)	||	rt.test(ui) )){
			*/
				
			if (!ui){
				displayError(options.err['01']);
			}else if ( !re.test(ui) ){
				displayError(options.err['02']);
			}else{
				$.ajax({
					url: options.url,
					type: 'POST',
					//data: {'k': options.event , 'i': ui ,'c': gr } ,
					data: {'k': options.event , 'i': ui } ,
					dataType:'json',
					success: function(r){
						if ("error" in r) { 
							if (r.error.code == 999){
								displayError(options.err['05']);
							}else{
								displayError(options.err['03']);
							}
						}else{
							displaySuccess();
							if(typeof ga !== 'undefined') {
								ga('send', 'event','Subscribe','Submit Success',options.gaEvent);
							}
						}
					},
					error: function(e) { 
						displayError(options.err['03']);
					}  
				});
			}
			
			$('#erFormBox').val('');
				var that = this; 
				$(this).attr("disabled", true);
				setTimeout(function() {$(that).removeAttr("disabled")}, 1000);
				//grecaptcha.reset();
			});
		}
		
		function displaySuccess(){
			$('.erFormContainer, .erFormError').fadeOut(500, function() { $(this).remove(); });
			
			var sc ='';
			sc += '<div class="erFormTitle"><h2>'+ options.succ['title'] +'</h2><p>'+ options.succ['desc'] +'</p></div>';
			sc += '<div class="erFormRecomm">';
			sc += '</div>';
			
			var successContent = $(sc);
			
			$(successContent).fadeIn(500, function() { $(this).appendTo('.pop_content'); })
		}
		
		function displayError(eMsg){
			var errDiv = $('.erFormError');
			$(errDiv).html(eMsg);
			$('#erFormSubmit').addClass("disable");
		}
		
		return this;
	};
	
})(jQuery);
