//this occurs when the google recaptcha library is loaded, this is the callback function
var onloadCallback = function() {

	//recaptcha widget html element id
	var recapId = "recapturethemoment";

	//
	var reCaptchaLoadPromise_e = elementPromise(window.php_config.e);
	var reCaptchaLoadPromise_f = elementPromise(window.php_config.f);


	reCaptchaLoadPromise_e.then((successElem) => {
		//placeholder for the recaptcha widget
		successElem.before( "<div id='"+recapId+"'></div><br/>" );
	});

	reCaptchaLoadPromise_f.then((successElem) => {
		successElem.attr("onsubmit", "return verifyCallback(recaptchaObj)");
	});

	Promise.all([reCaptchaLoadPromise_e, reCaptchaLoadPromise_f]).then(function(values) {
		
		// Renders the HTML element with id 'example1' as a reCAPTCHA widget.
		// The id of the reCAPTCHA widget is assigned to the setting given to the script url.
		recaptchaObj = grecaptcha.render(recapId, {
			'sitekey': window.php_config.k,
			'theme': 'light'
		});
	});
};

//this occurs when the targeted form has been submitted
var verifyCallback = function(obj) {
    var r = grecaptcha.getResponse(obj);

    return (r.length > 0)? true : false;
}

//core recaptcha object
var recaptchaObj;

//must be called from only the root scope of the script file
var s_src = document.currentScript.src;


//good init function to call global functions defined in app.js
(function($){
	window.php_config = qsParse( s_src );

	//when the vars load from env, then load the core recaptcha js file
	window.envVarsProm.then((successObj) => {
		scriptLoader( successObj.getItem("RECAPTCHA_MASTER") + "onload=onloadCallback&render=explicit" );
	});
}(jQuery));
