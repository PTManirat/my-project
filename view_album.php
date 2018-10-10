<?php
	include("mydb.php");
	session_start();
	$Username = $_SESSION['user'];

	if(!isset($_SESSION['user'])){
		header("location:page1.php");
		exit();
	}

	/*$ftp_server = "192.168.0.13";
	$ftp_user_name = "User";
	$ftp_user_pass = "4624631993";

	$conn_id = ftp_connect($ftp_server);
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		if((!$conn_id) || (!$login_result)){
			echo "FTP connection has failed! <br />";
			echo "Attempted to connect to $ftp_server for user $ftp_user_name";
			exit;
		}*/

	$target_dir = "user/".$Username."/";

	if(isset($_GET['album_id'])){
		$album_id = $_GET['album_id'];
		$check = mysql_query("SELECT * FROM album WHERE album_id = '$album_id' ");
		if(mysql_num_rows($check) > 0){
			$sqlDelA = mysql_query("DELETE FROM album WHERE album_id = '$album_id' ");
			$sql = mysql_query("SELECT image_name FROM user_images WHERE album_id = '$album_id' ");
			if(mysql_num_rows($sql) > 0){
				while ($row = mysql_fetch_array($sql)) {
				$image = $row['image_name'];
				/*$dirImage = "$target_dir".basename($image);
				ftp_delete($conn_id, $image);*/
				unlink($image);
				$sqlDelB = mysql_query("DELETE FROM user_images WHERE image_name = '$image' ");
				$fullImage = "C:/xampp/htdocs/project/".$image;
				$search_img = mysql_query("SELECT * FROM facedetectpedict WHERE pathImage = '$fullImage' ");
					if(mysql_num_rows($search_img) > 0){
						while ($del_img = mysql_fetch_array($search_img)) {
							$path_del = $del_img['detectImage'];
							unlink($path_del);
							//$sqlDelC = mysql_query("DELETE FROM facedetectpedict WHERE detectImage = '$path_del' ");
						}
					}
				$sqlDelC = mysql_query("DELETE FROM facedetectpedict WHERE pathImage = '$fullImage' ");
				}
				
			}
		}

		if($sqlDelA && $sqlDelB && $sqlDelC){
			header('location:view_album.php');
		}
		else if($sqlDelA){
			header('location:view_album.php');
		}
		else{
			echo '<script type="text/javascript">'; 
			echo 'alert("Cannot delete this album.");'; 
			echo 'window.location.href = "view_album.php";';
			echo '</script>';
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
		thead{
			font-size: 18px;
			background-color: #FFF;
		}
		table{
			font-weight: bold;
		}
		.content{
			text-align: center;
		}

	</style>
</head>
<body>
	
	<?php
	include("header.php");
	?>
		<div class="col-lg-12">
			<h1 class="page-header" style="padding-left: 20px;">View Albums</h1>
		</div>

	<?php
		include "mydb.php";
		$strSQL = "SELECT * FROM album WHERE username = '$Username' ";
		$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
	?> 

		<div class="container">
			
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="content">Album Name</th>
						<th class="content">Edit</th>
						<th class="content">Gallery</th>
						<th class="content">Delete</th>
					</tr>
				</thead>
				
				<tbody>
				<?php
					while ($objResult = mysql_fetch_array($objQuery)){
				?>

					<tr>
						<td><div><a href="view_gallery.php?album_id=<?php echo $objResult["album_id"] ?>"><img src="pic/photos-icon-8.png" style="width: 100px; height: 100px;">
							<?php echo $objResult["album_name"];?></a></div></td>
						<td class="content_a"><a href="edit_album.php?album_id=<?php echo $objResult["album_id"];?>">Edit</a></td>
						<td class="content_a"><a href="upload_gallery.php?album_id=<?php echo $objResult["album_id"];?>">Upload</a></td>
						<td class="content_a"><a href="view_album.php?album_id=<?php echo $objResult["album_id"];?>" 
							onclick="return confirm('Are you sure to delete this album?')">Delete</a></td>
					</tr>

				<?php
					}
				?>
				</tbody>
			</table><br>

			<a href="create_album.php"><button type="button" id="createAlbum" class="w3-btn w3-light-grey w3-round" 
			style="margin-right: 100px; margin-bottom: 50px;"><b>Create Album</b></button></a>

			</div>
		</div>
	</div>
	</div>

</body>
</html>