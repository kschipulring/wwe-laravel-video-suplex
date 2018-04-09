<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class VideosController extends Controller
{
    

	//GPS DMS to decimal conversion (better for Google Maps)
	protected function beliefmedia_dms_dec($deg, $min, $sec, $round = 0) {
		$dec = $deg + ((($min * 60) + ($sec)) / 3600);
		if ($round != 0) $dec = round($dec, $round);
		return $dec;
	}

	protected function dms_str_to_arr( $gps_dms_str ){
		//list($deg, $minsec) = explode(",", "45,40.200000N");

		$gps_dms_str = preg_replace("/[a-zA-Z]/", "", $gps_dms_str);

		list($deg, $minsec) = explode(",", $gps_dms_str);	

		$minsecRound = round( floatval($minsec), 2);

		$minsecRoundStr = strval($minsecRound);

		$minsecRoundArr = explode(".", $minsecRoundStr);

		return $this->beliefmedia_dms_dec($deg, $minsecRoundArr[0], $minsecRoundArr[1]);
	}


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


		$filesize = (!empty($ThisFileInfo["filesize"]))? $ThisFileInfo["filesize"] : "";

		$fileformat = (!empty($ThisFileInfo["fileformat"]))? $ThisFileInfo["fileformat"] : "";

		$playtime_seconds = (!empty($ThisFileInfo["playtime_seconds"]))? $ThisFileInfo["playtime_seconds"] : "";

		$bitrate = (!empty($ThisFileInfo["bitrate"]))? $ThisFileInfo["bitrate"] : "";


		/*
		copies data from all subarrays of [tags] into [comments] so
 		metadata is all available in one location for all tag formats
 		*/
		\getid3_lib::CopyTagsToComments($ThisFileInfo);



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

		
		//location
		$location = "";

		if( array_key_exists("quicktime", $ThisFileInfo) &&
		 array_key_exists("uuid", $ThisFileInfo["quicktime"]) &&
		 array_key_exists("data", $ThisFileInfo["quicktime"]["uuid"])
		  ){
			$somecoords =  trim( $ThisFileInfo["quicktime"]["uuid"]["data"] );

			//relying on DMS GPS, initially
			preg_match("/([0-9\,\.\-])+(N)+/", $somecoords, $matchesNarr);
			preg_match("/([0-9\,\.\-])+(E)+/", $somecoords, $matchesEarr);

			//convert DMS coords to decimal coords
			if( count($matchesNarr) > 1 && count($matchesEarr) > 1 &&
			 strlen($matchesNarr[0]) > 1 && strlen($matchesEarr[0]) > 1 ){
				$loc_n = $this->dms_str_to_arr( $matchesNarr[0] );

				$loc_e = $this->dms_str_to_arr( $matchesEarr[0] );

				//final location string for this scenario
				$location = "{$loc_n},{$loc_e}";		
			}else{
				//relying on decinal GPS, but only if there is no DMS
				preg_match("/([0-9\.\-\;])+\;/", $somecoords, $matches2arr);

				if( count($matches2arr) > 0 ){
					list($loc_n, $loc_e) = explode(";", $matches2arr[0]);

					//get rid of any remaining semicolons
					$loc_e = str_replace(";", "", $loc_e);

					//final location string for this scenario
					$location = "{$loc_n},{$loc_e}";
				}
			}
		}



		//echo "<pre> location =" . $location;

		//die( $somecoords );

		$keywords = (!empty($ThisFileInfo['comments']))? json_encode($ThisFileInfo['comments']) : "";

		
		//id	vid	keywords	location_city	location_stateprovince	location_country	created_at	updated_at
		DB::table('metadata')->insert(
			['vid' => $vid,
			'keywords' => $keywords,
			'location' => $location,
			'created_at' => new \DateTime(),
			'updated_at' => new \DateTime() ]
		);
		

		$message = base64_encode( $file->getClientOriginalName() . " has been uploaded!" );

		return redirect()->route('home', ['message' => $message]);
    }

    public function vidlist(){
    	$authId = Auth::id();

    	$videos = DB::table('videos AS v')
    	->selectRaw("DISTINCT v.id, v.title, v.file_name, v.original_file_name, v.duration,
    	v.size, v.format, v.bitrate, v.uploaded_by_uid, u.name as username,
    	IFNULL(m.keywords,'') AS keywords, CONCAT(IFNULL(m.location_city, ''),
    	', ',  IFNULL(m.location_stateprovince, ''), ', ',
    	IFNULL(m.location_country, '') ) AS location, count(vl.vid) AS num_likes,
    	IF( (vl2.vid = v.id AND vl2.uid = $authId), 1, 0) AS ifcurrentuserlike")
    	->leftJoin('metadata AS m', 'm.vid', '=', 'v.id')
    	->leftJoin('users AS u', 'v.uploaded_by_uid', '=', 'u.id')
    	->leftJoin('video_likes AS vl', 'v.id', '=', 'vl.vid')
    	->leftJoin('video_likes AS vl2', 'v.id', '=', 'vl2.vid')
    	->orderBy('v.id', 'desc')
    	->groupBy( "v.title", "v.file_name", "v.original_file_name", "v.duration",
    	"v.size", "v.format", "v.bitrate", "v.uploaded_by_uid", "u.name", "m.keywords",
    	"m.location_city", "m.location_stateprovince", "m.location_country", "vl.vid",
    	"vl2.vid", "vl2.uid", "v.id")
    	->get();
	

/*
    	$videos = DB::table('videos AS v')
    	->selectRaw("DISTINCT v.id, v.title, v.file_name, v.original_file_name, v.duration,
    	v.size, v.format, v.bitrate, v.uploaded_by_uid, u.name as username,
    	IFNULL(m.keywords,'') AS keywords, CONCAT(IFNULL(m.location_city, ''),
    	', ',  IFNULL(m.location_stateprovince, ''), ', ',
    	IFNULL(m.location_country, '') ) AS location, count(vl.vid) AS num_likes,
    	IF( (vl2.vid = v.id AND vl2.uid = $authId), 1, 0) AS ifcurrentuserlike")
    	->leftJoin('metadata AS m', 'm.vid', '=', 'v.id')
    	->leftJoin('users AS u', 'v.uploaded_by_uid', '=', 'u.id')
    	->leftJoin('video_likes AS vl', 'v.id', '=', 'vl.vid')
    	->leftJoin('video_likes AS vl2', 'v.id', '=', 'vl2.vid')
    	->orderBy('v.id', 'desc')
    	->groupBy( DB::raw("v.id") )
    	->get();
    	*/

    	echo "<pre>";
    	var_dump( $videos );
//DB::enableQueryLog();

//var_dump( dd(DB::getQueryLog()) );

    	//echo $videos->toSql();

    	//print_r( get_class_methods( $videos ) );

    	//print_r( get_object_vars( $videos ) );

    	die();

    	return view('uploads', ['videos' => $videos]);
    }

    //must be logged in in order to upload a video
    public function inspectauth(){

    	if( empty(Auth::id()) || Auth::id() < 1 ){
    		return redirect('login');
    	} else {
    		return view('uploader');
    	}
    }

    public function videolikeajax(Request $request){
    	list($vid, $uid) = explode(",", $request->ids);

    	//find out if this particular like already exists
		$existingLike = DB::table('video_likes')
		->selectRaw("id")
		->where([
			['uid', '=', $uid],
			['vid', '=', $vid],
		])->get();

		//we should like how there is an if clause here.  avoids errors.
		if( count($existingLike) < 1 ){
			DB::table('video_likes')->insert(
				['uid' => $uid,
				'vid' => $vid,
				'created_at' => new \DateTime(),
				'updated_at' => new \DateTime() ]
			);
		}
    }

    public function videounlikeajax(Request $request){
    	list($vid, $uid) = explode(",", $request->ids);

    	var_dump( explode(",", $request->ids) );

		DB::table('video_likes')
		->where([
			['uid', '=', $uid],
			['vid', '=', $vid],
		])
		->delete();
    }


    public function __construct(){
    	require_once( base_path() . '/getid3/getid3.php');
    }
}
