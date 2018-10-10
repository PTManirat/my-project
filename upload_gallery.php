<?php
	include("mydb.php");
	include("function.php");
	session_start();
	$Username = $_SESSION['user'];
	$target_dir = "user/".$Username."/";
	//$thumb_dir = "user/thumbphotos/";

	if(!isset($_SESSION['user'])){
		header("location:page1.php");
		exit();
	}


	if(isset($_GET['album_name'])){
		$album_name = $_GET['album_name'];
		$album_id = getAlbumId($Username,$album_name,'album_id');
		$sql = mysql_query("SELECT album_name FROM album WHERE album_id = '$album_id' ");
		if(mysql_num_rows($sql) > 0){
			$row = mysql_fetch_assoc($sql);
		}
	}

	/*$ftp_server = "192.168.0.13";
	$ftp_user_name = "User";
	$ftp_user_pass = "4624631993";

	$conn_id = ftp_connect($ftp_server);
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	if((!$conn_id) || (!$login_result)){
		echo "FTP connection has failed! <br/>";
		echo "Attempted to connect to $ftp_server for user $ftp_user_name";
		exit;
	}*/

	
	//ftp_close($conn_id);	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
	<style>
		html,body,h1,h2,h3,h4,h5,h6 {
		    font-family: "Roboto", sans-serif
		}
		body{
			background-color: /*#FDC167*/#FFBE7D;
		}	
		.spinner {
		  	width: 100px;
		  	height: 100px;
		  	background: #eee;
		  	border-radius: 50%;
		  	position: relative;
		  	margin: 100px;
		  	display: inline-block;
		}
		.spinner:after, .spinner:before {
		  	content: "";
		  	display: block;
		  	width: 100px;
		  	height: 100px;
		  	border-radius: 50%;
		}
		.spinner-1:after {
			position: absolute;
			top: -4px;
			left: -4px;
			border: 4px solid transparent;
			border-top-color: orangered;
			border-bottom-color: orangered;
			-webkit-animation: spinny 1s linear infinite;
			animation: spinny 1s linear infinite;
		}
		@-webkit-keyframes spinny {
		  0% {
		    -webkit-transform: rotate(0deg) scale(1);
		            transform: rotate(0deg) scale(1);
		  }
		  50% {
		    -webkit-transform: rotate(45deg) scale(1.2);
		            transform: rotate(45deg) scale(1.2);
		  }
		  100% {
		    -webkit-transform: rotate(360deg) scale(1);
		            transform: rotate(360deg) scale(1);
		  }
		}
		@keyframes spinny {
		  0% {
		    -webkit-transform: rotate(0deg) scale(1);
		            transform: rotate(0deg) scale(1);
		  }
		  50% {
		    -webkit-transform: rotate(45deg) scale(1.2);
		            transform: rotate(45deg) scale(1.2);
		  }
		  100% {
		    -webkit-transform: rotate(360deg) scale(1);
		            transform: rotate(360deg) scale(1);
		  }
		}
	</style>
</head>
<body>

	<?php

	include("header.php");

	if(isset($_GET['album_id'])){
		$album_id = $_GET['album_id'];
		$sql = mysql_query("SELECT album_name FROM album WHERE album_id = '$album_id' ");
		if(mysql_num_rows($sql) > 0){
			$row = mysql_fetch_assoc($sql);
		}
	}

	if(isset($_POST['btnUpload'])){

		$checkEmpImg = checkEmptyImage('files');
		
		if($checkEmpImg == 1){
			for($i=0;$i<count($_FILES['files']['name']);$i++){
				$imageName = $_FILES['files']['name'][$i];
				$imgName = strtolower($imageName);
				$imgTmp = $_FILES['files']['tmp_name'][$i];
				$imgSize = $_FILES['files']['size'][$i];
				
				$imgExt = pathinfo($imgName, PATHINFO_EXTENSION);
				/*$ext = explode('.', basename($_FILES['file']['name'][$i]));*/
				$allowExt = array('jpeg','jpg','png');
				$userImg = time().'_'.rand(1000,9999).'.'.$imgExt;

				if(in_array($imgExt, $allowExt)){
					if($imgSize < 10000000){
						/*if(detectFolder($conn_id ,$target_dir) == 0){
							ftp_mkdir($conn_id,$target_dir);
						}*/
						if(!file_exists($target_dir)){
							mkdir($target_dir);
						}
						$destination_file = "$target_dir".basename($userImg);
						//$upload = ftp_put($conn_id, $destination_file, $imgTmp, FTP_BINARY);
						$uploadFile = move_uploaded_file($imgTmp, $destination_file);
						$status = 0;
						$strSQL = mysql_query("INSERT INTO user_images (album_id,username,image_name,image_size,status) 
					 			 VALUES ('".$album_id."','".$Username."','".$destination_file."','".$imgSize."','".$status."') ");
					}
				}
				else{
					$errorMsg = '*** Please select a valid image.';
				}
			}
		}
		else{
			$errorMsg = '*** Please select photo.';
		}

		if(!isset($errorMsg)){
			$successMsg = 'Your photos is successfully uploded.';
			$inputDir = "C:\Users\ADMIN\Desktop\matlab";
			$command = "matlab -sd ".$inputDir." -r faceDetection3('$Username')";
			exec($command);
	
			/*echo "<script type='text/javascript'>
					$(document).ready(function(){
						$('#myModalx').modal('show');
					});
				</script>";*/

		}
	}

	?>
		<div id="editAlbum">
			<div class="col-lg-12">
				<h1 class="page-header" style="padding-left: 20px;">Add images</h1>	
			</div>

			<?php
 				if(isset($errorMsg)){ ?>
 					<div class="row">
 						<div class="col-lg-5">
							<div class="alert alert-danger">
								<span><?php echo $errorMsg; ?></span>
							</div>
						</div>
 					</div>
 				<?php }
 				if(isset($successMsg)){ ?>
 					<div class="row">
 						<div class="col-lg-5">
							<div class="alert alert-success">
								<span><?php echo $successMsg; ?></span>&nbsp;
								<a href='view_gallery.php?album_id=<?php echo $album_id; ?>'>View Photos</a> |
								<a href='upload_gallery.php?album_id=<?php echo $album_id; ?>'> Add new photos</a>
							</div>
						</div>
 					</div>
 				<?php }
			?>

			<div class="row">
				<div class="col-lg-5" style="float: left;">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h4>Album name : <?php echo $row['album_name'] ?></h4>
						</div>
						<div class="panel-body">
							<form  action="" name="uploadImg" method="POST" enctype="multipart/form-data">
								<input type="file" name="files[]" multiple="multiple" /><br>
								<button type="submit" class="btn btn-primary" name="btnUpload">
									<span class="glyphicon glyphicon-save"></span>&nbsp;Upload Photos
								</button>
							</form>
						</div>
					</div>
				</div>	
			</div>
		</div>

	<div class="modal fade" id="myModalx" role="dialog" style="margin-top: 8%;">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	      	<div class='spinner spinner-1'></div>
	      </div>
	    </div>
  	</div>
  	
	</div>

</body>
</html>