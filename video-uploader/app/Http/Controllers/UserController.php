<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function getUser($user_id){
    	$user = DB::table('users')->where('id', $user_id)->first();


		$videos = DB::table('videos AS v')
		->selectRaw("(SELECT COUNT(vid) FROM `video_likes` WHERE
		vid = v.id) AS num_likes, v.title, v.original_file_name, v.file_name")
		->leftJoin('metadata AS m', 'm.vid', '=', 'v.id')
		->where("v.uploaded_by_uid", $user_id)
		->orderBy('v.id', 'desc')
		->get();


    	return view('user', ['user' => $user, 'videos' => $videos]);
    }
}
