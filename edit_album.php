<?php
	include("mydb.php");
	session_start();
	$Username = $_SESSION['user'];

	if(!isset($_SESSION['user'])){
	header("location:page1.php");
	exit();
	}

	if(isset($_GET['album_id'])){
		$album_id = $_GET['album_id'];
	}

	if(isset($_POST['btnUpdate'])){
		$newAlbumName = $_POST['newAlbumName'];
		$checkExist = mysql_query("SELECT album_id FROM album WHERE username = '$Username' AND album_name = '$newAlbumName' ");
		if(mysql_num_rows($checkExist) > 0){
			$errorMsg = 'This name album is already exists.';
		}
		else{
			$strSQL = mysql_query("UPDATE album SET album_name = '".$newAlbumName."' WHERE album_id = '$album_id' ");
			$successMsg = 'Create new album name completed!';
			//header('refresh:4;view_album.php');
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" >
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<style>
		html,body,h1,h2,h3,h4,h5,h6 {
		    font-family: "Roboto", sans-serif
		}
		body{
			background-color: /*#FDC167*/#FFBE7D;
		}
		.inputEditForm{
			background-color: #f7f4f4;
			height: 163px;
			margin-left: 10px;
			padding-left: 30px;
			padding-top: 38px;
			border-radius: 5px;
		}
	</style>
</head>
<body>
	
	<?php
		include("header.php");
	?>
			<div id="editAlbum">
				<div class="col-lg-12">
					<h1 class="page-header" style="padding-left: 20px;">Edit Album</h1>
				</div>

					<?php
						if(isset($errorMsg)){ ?>
							<div class="row">
								<div class="col-lg-6" style="padding-left: 25px;">
									<div class="alert alert-danger">
										<span><?php echo $errorMsg; ?></span>
									</div>
								</div>
							</div>
						<?php }
 						if(isset($successMsg)){ ?>
 							<div class="row">
 								<div class="col-lg-6" style="padding-left: 25px;">
									<div class="alert alert-success">
										<span><?php echo $successMsg; ?></span>&nbsp;
										<a href='view_album.php'>View all albums.</a>
									</div>
								</div>
 							</div>
 						<?php }
					?>
					
				<div class="row">
					<div class="col-lg-6">
						<div class="inputEditForm"> 
							<form name="editAlbumName" action="" method="POST" enctype="multipart/form-data">
								<label style="font-size: 18px;">Create new album name : </label>
								<input type="text" name="newAlbumName" class="form-control" maxlength="50" required autofocus 
								style="width: 95%;" autocomplete="off">
								<button type="submit" class="btnEditAlbum btn btn-default btn-md" name="btnUpdate" style="margin-top: 5px;">Update</button>
							</form>
						</div>	
					</div>	
				</div>		
			</div>
	</div>

</body>
</html>