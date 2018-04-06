<?php
namespace App\Http;

if (!class_exists('Helpers')) {
	class Helpers{
		
		//returned in bytes
		public static function getMaxFileUploadSize(){
			$max_upload = (int)(ini_get('upload_max_filesize'));
			$max_post = (int)(ini_get('post_max_size'));
			$memory_limit = (int)(ini_get('memory_limit'));
			$upload_mb = min($max_upload, $max_post, $memory_limit);

			$upload_b = $upload_mb * 1024 * 1024;

			return $upload_b;
		}

		//get the client IP Address
		public static function getRealIpAddr(){
			if (!empty($_SERVER['HTTP_CLIENT_IP'])){   //check ip from share internet
				$ip=$_SERVER['HTTP_CLIENT_IP'];
			}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
				$ip=$_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
	}
}
