<?php

	include("mydb.php");

	/*$ftp_server = "192.168.0.13";
	$ftp_user_name = "User";
	$ftp_user_pass = "4624631993";

	$conn_id = ftp_connect($ftp_server);
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		if((!$conn_id) || (!$login_result)){
			echo "FTP connection has failed! <br />";
			echo "Attempted to connect to $ftp_server for user $ftp_user_name";
			exit;
		}

	function detectFolder($x, $y){
   	 	$pushd = ftp_pwd($x);
		if ($pushd !== false && @ftp_chdir($x, $y)){
        	ftp_chdir($x, $pushd);   
        	return 1;  //found
    	}		
    	else{
    		return 0;  //not found
    	}
	}*/
	
	function detectNameImage($a,$b,$c){
		$strSQL = mysql_query("SELECT * FROM user_images WHERE username = '$a' 
				  AND album_id = '$b' AND image_name = '$c'");
		$result = mysql_num_rows($strSQL);
		if($result == 0){
			return 0;	//not found
		}
	    else{
			return 1;	//found
		}
	}

	function getUsername($id, $field){
		$query = mysql_query("SELECT $field FROM register WHERE Id = '$id' ");
		$result = mysql_fetch_array($query);
			if(!empty($result)){
				return $result[$field];
			}
			else{
				return 0;
			}
	}

	function getId($user,$field){
		$query = mysql_query("SELECT $field FROM register WHERE username = '$user' ");
		$result = mysql_fetch_array($query);
			if(!empty($result)){
				return $result[$field];
			}
			else{
				return 0;
			}
	}

	function checkEmptyImage($fileImage){
		foreach ($_FILES[$fileImage]['name'] as $key => $value) {
			if(empty($value)){
				return 0;	#none
			}
			else{
				return 1;	#found
			}
		}
	}

	function getAlbumId($user,$nameAlbum,$field){
		$query = mysql_query("SELECT $field FROM album WHERE username = '$user' AND album_name = '$nameAlbum'");
		$result = mysql_fetch_array($query);
			if(!empty($result)){
				return $result[$field];
			}
			else{
				return 0;
			}
	}

	
	
	/*function createToThumbnail($fileName,$target_folder,$thumb_folder,$thumb = FALSE,$thumb_width,$thumb_height,$file_ext){
		
		$thumb_path = $thumb_folder;
		$target_path = $target_folder;
		$user_image = $target_path.basename($fileName);

		if($thumb == TRUE){
			$thumbnail = $thumb_path.$fileName;
			list($width,$height) = getimagesize($user_image);
			$thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
			switch ($file_ext) {
				case 'jpg':
					$source = imagecreatefromjpeg($user_image);
					break;
				case 'jpeg':
					$source = imagecreatefromjpeg($user_image);
					break;
				case 'png':
					$source = imagecreatefrompng($user_image);
					break;
				default:
					$source = imagecreatefromjpeg($user_image);
			}

			imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
			switch ($file_ext) {
				case 'jpg' || 'jpeg':
					imagejpeg($thumb_create,$thumbnail,100);
					break;
				case 'png':
					imagepng($thumb_create,$thumbnail,100);
					break;
				default:
					imagejpeg($thumb_create,$thumbnail,100);
			}
		}
		move_uploaded_file($thumbnail,$fileName);
		return $fileName;
	}*/

	/*function checkUser($data){
		$query = mysql_query("SELECT Id FROM register WHERE Id = '$data' ");
		if(mysql_num_rows($query) == 1){
			return 1;
		}
		else{
			return 0;
		}
	}*/

	class Zipper{
		private $_files = array(),
				$_zip;

		public function __construct(){
			$this->_zip = new ZipArchive;
		}

		public function add($input){
			if(is_array($input)){
				$this->_files = array_merge($this->_files, $input);
			}
			else{
				$this->_files[] = $input;
			}
		}

		public function store($location = null){
			if(count($this->_files) && $location){
				foreach ($this->_files as $key => $value) {
					if(!file_exists($value)){    //check directory of image (have/not have)
						unset($this->_files[$key]);   //delete element that array
					}
				}

				if($this->_zip->open($location, file_exists($location)? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE)){  //open zip
					foreach ($this->_files as $key => $value) {		//loop through files and add to zip
					
						$this->_zip->addFile($value , substr($value,-19));
					}
					$this->_zip->close(); 			//close zip
				}
			}
		}
	}

	
?>