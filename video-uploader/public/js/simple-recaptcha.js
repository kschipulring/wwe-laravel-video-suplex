var onloadCallback = function() {

	//recaptcha widget html element id
	var recapId = "recapturethemoment";

	//placeholder for the recaptcha widget
	$( "#" + window.php_config.e ).before( "<div id='"+recapId+"'></div><br/>" );

	//onsubmit="return verifyCallback(widgetId1)"
	$( "#" + window.php_config.f ).attr("onsubmit", "return verifyCallback(recaptchaObj)");
	
    // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
    // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
    recaptchaObj = grecaptcha.render(recapId, {
        'sitekey': window.php_config.k,
        'theme': 'light'
    });
};

var verifyCallback = function(obj) {
    var r = grecaptcha.getResponse(obj);

    return (r.length > 0)? true : false;
}

var recaptchaObj;
var s_src = document.currentScript.src;


//good init function to call global functions defined in app.js
(function($){
	window.php_config = qsParse( s_src );

	scriptLoader("https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit");
}(jQuery));
