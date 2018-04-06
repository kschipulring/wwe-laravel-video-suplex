<?php
if (!class_exists('Helpers')) {
	class Helpers{
		public static function getMaxFileUploadSize(){
			$max_upload = (int)(ini_get('upload_max_filesize'));
			$max_post = (int)(ini_get('post_max_size'));
			$memory_limit = (int)(ini_get('memory_limit'));
			$upload_mb = min($max_upload, $max_post, $memory_limit);

			$upload_b = $upload_mb * 1024 * 1024;

			return $upload_b;
		}
	}
}
