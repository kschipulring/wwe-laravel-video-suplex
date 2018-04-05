//this is my view on how to make vue and jquery work nicely together
$( document ).ready(function() {
	$.ajax({
		url: window.uploaderTemplateFile,
		context: document.body
	}).done(function(data) {

		//load the template
		$("#vueuploadapp").html( data );

		//now comes the vue, or view or whatever
		var app = new Vue({
			el: '#vueuploadapp',

			data: {
				form: {
					title: ""
				},
				disabled: 0,
				uploaddisabled: 1,
				uploadbuttontitle: "Please attach a .mp4 video to continue"
			},
			methods: {
			  processFile(event) {
			    if( event.target.files[0] && event.target.files[0].type === "video/mp4" ){
				    this.uploaddisabled = 0;
				    this.uploadbuttontitle = "";
			    }else{
				    this.uploaddisabled = 1;
				    this.uploadbuttontitle = "Please attach a .mp4 video to continue";
			    }
			  }
			}
		});
	});
});
