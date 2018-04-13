<?php

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/
$env = $app->detectEnvironment(function(){
	$envFolder = dirname(__DIR__);

	$setEnv = "local";

	if( !empty($_SERVER) && !empty($_SERVER['HTTP_HOST']) ){
		switch( $_SERVER['HTTP_HOST'] ){
			case "3ringprototype.com":
			case "wwe_video_suplex.3ringprototype.com":
				$setEnv = "production";
				break;
		}
	}


	putenv("APP_ENV=$setEnv");


	if (getenv('APP_ENV') && file_exists($envFolder.'/.' .getenv('APP_ENV') .'.env')) {

		$dotenv = new Dotenv\Dotenv( dirname(__DIR__), "." . $setEnv.'.env');

		$dotenv->load();
	} 

});
