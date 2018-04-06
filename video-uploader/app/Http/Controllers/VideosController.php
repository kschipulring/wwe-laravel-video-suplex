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
    public function upload(Request $request)
    {
        
    	$file = $request->file('videofile');

        //return view('home');
		echo "<pre>";
        //var_dump( $request->file('videofile') );


        //var_dump( get_class_methods($file) );

        //file name
		$path = $file->store('uploadedvideos');


		//db insert for the video information
		DB::table('videos')->insert(
			['title' => $request->title, 'file_name' => $path,
			'original_file_name' => $file->getClientOriginalName(),
			'uploaded_by_uid' => Auth::id(), 'created_at' => new \DateTime(),
			'updated_at' => new \DateTime() ]
		);


		$message = base64_encode( $file->getClientOriginalName() . " has been uploaded!" );

		return redirect()->route('home', ['message' => $message]);
    }

    public function vidlist(){
    	
    }
}
