var recaptcha_template = `<vue-recaptcha
                  ref="recaptcha"
                  @verify="onCaptchaVerified"
                  @expired="onCaptchaExpired"
                  size="invisible"
                  sitekey="6LfJA0gUAAAAAA4YDXBubWMll55x5xLpyzu6n60G">
                </vue-recaptcha>`;

var vue_recaptcha = new Vue({
	el: '#vue-app-recaptcha',
	components: {
		'vue-recaptcha': VueRecaptcha
	},
	methods: {
		submit: function() {
			// this.status = "submitting";
			this.$refs.recaptcha.execute();
		},
		onCaptchaVerified: function(recaptchaToken) {
			const self = this;
			self.status = "submitting";
			self.$refs.recaptcha.reset();
			axios.post("https://vue-recaptcha-demo.herokuapp.com/signup", {
				email: self.email,
				password: self.password,
				recaptchaToken: recaptchaToken
			}).then((response) => {
				self.sucessfulServerResponse = response.data.message;
			}).catch((err) => {
				self.serverError = getErrorMessage(err);


				//helper to get a displayable message to the user
				function getErrorMessage(err) {
					let responseBody;
					responseBody = err.response;
					if (!responseBody) {
						responseBody = err;
					} else {
						responseBody = err.response.data || responseBody;
					}
					return responseBody.message || JSON.stringify(responseBody);
				}

			}).then(() => {
				self.status = "";
			});


		},
		onCaptchaExpired: function() {
			this.$refs.recaptcha.reset();
		}
	},
	data() {
		return {
			email: "",
			password: "",
			passwordConfirmation: "",
			status: "",
			sucessfulServerResponse: "",
			serverError: ""
		};
	}
});


/*
Vue.http.options.emulateJSON = true; // send as 

new Vue({
    el: '#vueAppRecaptcha',
    data: {
        debug: true,
        domain: '',
        ajaxRequest: false,
        postResults: []
    },
    methods: {
        checkWebsite: function() {
            this.ajaxRequest = true;
            this.$http.post('http://demo8159500.mockable.io/post/check', {
                domain: this.domain
            }, function(data, status, request) {
                this.postResults = data;

                this.ajaxRequest = false;
            });
        }
    }
});
*/