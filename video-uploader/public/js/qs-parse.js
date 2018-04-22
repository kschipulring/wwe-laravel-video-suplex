function qsParse(){
	var e_split = [];
	var url_config = [];

	for(var i=1; i<src_split.length; i++){

		e_split = src_split[i].split("=");

		//console.log( e_split[1] );
		url_config[ e_split[0] ] = e_split[1];

	}

	return url_config;
}