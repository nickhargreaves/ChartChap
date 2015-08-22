<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader extends CI_Controller {

	public function upload()
	{
		// Destination folder for downloaded files
		$upload_folder = base_url().'assets/data';

		// If the browser supports sendAsBinary () can use the array $ _FILES
		if(count($_FILES)>0) {
			if( move_uploaded_file( $_FILES['upload']['tmp_name'] , $upload_folder.'/'.$_FILES['upload']['name'] ) ) {
				echo 'done';
			}
			else
			{
				echo 'not done';
			}
			exit();
		} else if(isset($_GET['up'])) {
			// If the browser does not support sendAsBinary ()
			if(isset($_GET['base64'])) {
				$content = base64_decode(file_get_contents('php://input'));
			} else {
				$content = file_get_contents('php://input');
			}

			$headers = getallheaders();
			$headers = array_change_key_case($headers, CASE_UPPER);

			if(file_put_contents($upload_folder.'/'.$headers['UP-FILENAME'], $content)) {
				echo 'done';
			}
			exit();
		}
	}
}
