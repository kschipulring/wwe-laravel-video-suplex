//core recaptcha object
var recaptchaObj = {	
	/*
	core recaptcha widget html element id,
	not to be confused with the placeholder that this gets placed before
	*/
	recapId: "recapturethemoment",

	/*
	populated later by the 'onloadCallback' method.
	string id for the main parent element for the onscreen recaptcha instance
	*/
	placeholderId: null,

	/*
	populated later by the 'onloadCallback' method.
	string id for the form where the recaptcha instance is placed
	*/
	formId: null,

	/*
	populated later by the 'onloadCallback' method.
	string id for the recaptcha account 'public key'
	*/
	siteKey: null,

	/*
	populated later by the 'onloadCallback' method.
	contains the rendered recaptcha instance that is inside the element with
	same id as 'recapId'
	*/
	instance: null,
};

//this occurs when the google recaptcha library is loaded, this is the callback function
recaptchaObj.onloadCallback = function() {

	//I promise this is worthwhile, because it relies on DOM event handlers
	var reCaptchaLoadPromise_e = elementPromise( this.placeholderId );
	var reCaptchaLoadPromise_f = elementPromise( this.formId );

	//attach the placeholder before the designated element.  typically, the submit button
	reCaptchaLoadPromise_e.then((successElem) => {
		//placeholder for the recaptcha widget
		successElem.before( "<div id='" + this.recapId + "'></div><br/>" );
	});

	//attach the verifyCallback method to the form for the recaptcha
	reCaptchaLoadPromise_f.then((successElem) => {
		successElem.attr("onsubmit", "return recaptchaObj.verifyCallback()");
	});

	//this is for recaptcha error messages
	var reCaptchaLoadPromise_h = elementPromise( "recaptcha_help" );

	//attach the error message before the designated element.  typically, the submit button
	reCaptchaLoadPromise_h.then((successElem) => {
		//placeholder for the recaptcha error message
		successElem.insertBefore( "#"+window.php_config.e );
	});

	/* 
	reCaptchaLoadPromise_h is not a part of this,
	because it is only present in failed recaptcha entry error scenarios
	*/
	Promise.all([this, reCaptchaLoadPromise_e, reCaptchaLoadPromise_f]).then(function(values) {

		/*
		Because of how quirky javascript can be with parameters and scope,
		we have to resort to odd techniques to get equivalent of "this",
		sometimes.
		*/
		var that = values[0];

		//attach the widget to the page
		that.render();
	});
};

//this occurs when the targeted form has been submitted. js side validation
recaptchaObj.verifyCallback = function() {
	var r = grecaptcha.getResponse(this.instance);

	return (r.length > 0)? true : false;
}

recaptchaObj.render = function(){
	// Renders a HTML element with as a reCAPTCHA widget.
	// The id of the reCAPTCHA widget is assigned to the setting given to the script url.
	this.instance = grecaptcha.render(this.recapId, {
		'sitekey': this.siteKey,
		'theme': 'light'
	});
}

//this is called by the google recaptcha library file
recaptchaObj_init = function(){

	//the html element placeholder
	recaptchaObj.placeholderId = window.php_config.e;

	//the form
	recaptchaObj.formId = window.php_config.f;

	//recaptcha public key from the .env file
	recaptchaObj.siteKey = window.php_config.k;

	//now lets really get started
	recaptchaObj.onloadCallback();
}


//must be called from only the root scope of the script file
var s_src = document.currentScript.src;


//good init function to call global functions defined in app.js
(function($){

	//settings from the javascript query string
	window.php_config = qsParse( s_src );

	//when the vars load from env, then load the core recaptcha js file
	window.envVarsProm.then((successObj) => {
		scriptLoader( successObj.getItem("RECAPTCHA_MASTER") + "onload=recaptchaObj_init&render=explicit" );
	});
}(jQuery));
