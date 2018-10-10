<?php
	include("mydb.php");
	session_start();
	$Username = $_SESSION['user'];

	if(!isset($_SESSION['user'])){
		header("location:page1.php");
		exit();
	}
	
	if(isset($_POST['btnCreAlbum'])){
	$albumName = $_POST['albumName'];
	$strSQL = mysql_query("SELECT * FROM album WHERE username = '$Username' AND album_name = '$albumName'");
		if(@mysql_num_rows($strSQL) > 0){
			$errorMsg = 'This name album is already exists.';
		}
		else{
			$strSQL = mysql_query("INSERT INTO album (album_name,username) VALUES ('".$albumName."','".$Username ."') ");
			if($strSQL){
				$successMsg = 'Create album name completed!';
			}
			else{
				$errorMsg = 'Have a problem.';
			}
		}
	}

	mysql_close($conn);
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
		.createNameAlForm{
			background-color: #f7f4f4;
			height: 163px;
			margin-left: 10px;
			padding-left: 30px;
			padding-top: 38px;
		}
	</style>
</head>
<body>
	
	<?php
	include("header.php");
	?>
		<div id="editAlbum">
			<div class="col-lg-12">
				<h1 class="page-header" style="padding-left: 20px;">Create Album</h1>
					
				<?php
				if(isset($errorMsg)){ ?>
					<div class="row">
						<div class="col-lg-6">
							<div class="alert alert-danger" style="margin-left: 10px;">
								<span><?php echo $errorMsg; ?></span>
							</div>
						</div>
					</div>
				<?php }
				if(isset($successMsg)){ ?>
					<div class="row">
						<div class="col-lg-6"> 
							<div class="alert alert-success" style="margin-left: 10px;">
								<span><?php echo $successMsg; ?></span>&nbsp;
								<a href='view_album.php'>View all albums</a> |
								<a href='upload_gallery.php?album_name=<?php echo $albumName; ?>'> Add Photos</a>
							</div>
						</div>
					</div>
				<?php }
				?>

				<div class="row">
					<div class="col-lg-6">
						<div class="createNameAlForm"> 
							<form name="create_album" method="POST" action="create_album.php" enctype="multipart/form-data">
								<label style="font-size: 18px;">Album name : </label>
								<input type="text" name="albumName" class="form-control" style="width: 95%;" 
										maxlength="50" required autofocus autocomplete="off">
								<button type="submit" name="btnCreAlbum" class="btn btn-default btn-md" style="margin-top: 5px;">Create</button>
							</form>
						</div>	
					</div>
				</div>	
			</div>		
		</div>
	
	</div>

</body>
</html>