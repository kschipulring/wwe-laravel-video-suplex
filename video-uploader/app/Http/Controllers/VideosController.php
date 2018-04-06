<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class VideosController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request){

    	//redirect if not logged in
    	if( empty(Auth::id()) || Auth::id() < 1 ){
    		$message = base64_encode( "not logged in!" );

    		return redirect()->route('home', ['message' => $message]);
    	}

        //the uploaded file
    	$file = $request->file('videofile');


        $getID3 = new \getID3;


        //getting file name and saving the video someplace all in one
		$path = $file->store('uploadedvideos');


		//now that it is stored, it can be analyzed
		$ThisFileInfo = $getID3->analyze( storage_path("app/" . $path) );


		//var_dump( $ThisFileInfo );  die();


		$filesize = (!empty($ThisFileInfo["filesize"]))? $ThisFileInfo["filesize"] : "";

		$fileformat = (!empty($ThisFileInfo["fileformat"]))? $ThisFileInfo["fileformat"] : "";

		$playtime_seconds = (!empty($ThisFileInfo["playtime_seconds"]))? $ThisFileInfo["playtime_seconds"] : "";

		$bitrate = (!empty($ThisFileInfo["bitrate"]))? $ThisFileInfo["bitrate"] : "";

		/*
		copies data from all subarrays of [tags] into [comments] so
 		metadata is all available in one location for all tag formats
 		*/
		\getid3_lib::CopyTagsToComments($ThisFileInfo);


		//echo('<pre>'.htmlentities(print_r($ThisFileInfo['comments'], true), ENT_SUBSTITUTE).'</pre>');


		//db insert for the basic video information
		DB::table('videos')->insert(
			['title' => $request->title,
			'file_name' => $path,
			'original_file_name' => $file->getClientOriginalName(),
			'duration' => $playtime_seconds,
			'size' => $filesize,
			'format' => $fileformat,
			'bitrate' => $bitrate,
			'uploaded_by_uid' => Auth::id(),
			'created_at' => new \DateTime(),
			'updated_at' => new \DateTime() ]
		);


		$vid = DB::getPdo()->lastInsertId();

		//die( '<br/>$vid =' . $vid );

		$keywords = (!empty($ThisFileInfo['comments']))? json_encode($ThisFileInfo['comments']) : "";
		$location = (!empty($ThisFileInfo['comments']['location']))? json_encode($ThisFileInfo['comments']['location']) : "";


		//hack trick to make 'list' work below at all times
		$location_info = explode(",", $location . ",,,");
		list($city, $state, $country) = $location_info;

		
		//id	vid	keywords	location_city	location_stateprovince	location_country	created_at	updated_at
		DB::table('metadata')->insert(
			['vid' => $vid,
			'keywords' => $keywords,
			'location_city' => $city,
			'location_stateprovince' => $state,
			'location_country' => $country,
			'created_at' => new \DateTime(),
			'updated_at' => new \DateTime() ]
		);
		

		$message = base64_encode( $file->getClientOriginalName() . " has been uploaded!" );

		return redirect()->route('home', ['message' => $message]);
    }

/*Full texts	
id
title
file_name
original_file_name
duration
size
format
bitrate
uploaded_by_uid
created_at*/
    public function vidlist(){
    	$videos = DB::table('videos AS v')
    	->selectRaw("v.id, v.title, v.file_name, v.original_file_name, v.duration,
    		v.size, v.format, v.bitrate, v.uploaded_by_uid, u.name as username,
    		IFNULL(m.keywords,'') AS keywords, CONCAT(IFNULL(m.location_city, ''),
    		', ',  IFNULL(m.location_stateprovince, ''), ', ',
    		IFNULL(m.location_country, '') ) AS location")
    	->leftJoin('metadata AS m', 'm.vid', '=', 'v.id')
    	->leftJoin('users AS u', 'v.uploaded_by_uid', '=', 'u.id')
    	->leftJoin('video_likes AS vl', 'v.id', '=', 'vl.vid')
    	->get();


    	/*echo "<pre>";
    	var_dump($videos);
    	die();*/

    	return view('uploads', ['videos' => $videos]);
    }

    //must be logged in in order to upload a video
    public function inspectauth(){

    	if( empty(Auth::id()) || Auth::id() < 1 ){
    		return redirect('login');
    	} else {
    		//return "fools = " . Auth::id();

    		return view('uploader');
    		//return view('layouts.app');
    	}
    }

    public function __construct(){
    	require_once( base_path() . '/getid3/getid3.php');
    }
}
