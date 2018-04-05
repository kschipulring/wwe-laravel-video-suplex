var app = new Vue({
	el: '#app',

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