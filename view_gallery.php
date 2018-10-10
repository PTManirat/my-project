<?php
	include("mydb.php");
	include("function.php");
	session_start();
	$Username = $_SESSION['user'];
	$target_dir = "user/".$Username."/";

	if(!isset($_SESSION['user'])){
		header("location:page1.php");
		exit();
	}

	/*$ftp_server = "192.168.137.52";
	$ftp_user_name = "User";
	$ftp_user_pass = "4624631993";

	$conn_id = ftp_connect($ftp_server);
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
	if((!$conn_id) || (!$login_result)){
		echo "FTP connection has failed! <br/>";
		echo "Attempted to connect to $ftp_server for user $ftp_user_name";
		exit;
	}*/

	if(isset($_GET['album_id'])){
		$album_id = $_GET['album_id'];
	}

	if(isset($_POST['btnDelete'])){
		if(!empty($_POST['num'])){
			$array_image = $_POST['num'];
			while (list($key,$val) = @each($array_image)) {
				$del_imageName = $val;
				/*if(ftp_delete($conn_id, $del_imageName))*/
				if(unlink($del_imageName)){
					$del_user_image = mysql_query("DELETE FROM user_images WHERE image_name = '$del_imageName' ");
					$query_predict_image = mysql_query("SELECT * FROM facedetectpedict WHERE username = '$Username' ");
					if(mysql_num_rows($query_predict_image) > 0){
						while ($row = mysql_fetch_array($query_predict_image)) {
							$path_image = $row['pathImage'];
							$path_cut = substr($row['pathImage'],24);
							if($path_cut == $del_imageName){
								$detect_image = $row['detectImage'];
								unlink($detect_image);
								$del_predict_image = mysql_query("DELETE FROM facedetectpedict WHERE pathImage = '$path_image' ");

							}
						}
					}
					header('location: view_gallery.php?album_id='.$album_id);
				}
				else{
					echo "<script language=\"JavaScript\">";
					echo "alert('Could not delete this select.');";
					echo "window.open(\"view_gallery.php\",\"_self\");";
					echo "</script>";
				}
			}
		}
		else{
			echo "<script language=\"JavaScript\">";
			echo "alert('Please select photo.');";
			echo "</script>";
			//header('refresh:view_gallery.php?album_id='.$album_id);
		}
	}

	if(isset($_POST['btnSend'])){
		if(!empty($_POST['num'])){
			$name_image = $_POST['num'];
			$zipper = new Zipper();
			$zipper->add($name_image);
			$zipper->store('zip_file/zipped.zip');
			$file_size = filesize('zip_file/zipped.zip');    //Returns the size of the file in bytes
			if($file_size < 25000000){
				$count = count($_POST['num']);
				//$array_pic = serialize($_POST['num']);
				header('location: sendImages.php?count='.$count.'&album_id='.$album_id.'&action=fromview');
			}
			else{
				$array_pic = serialize($_POST['num']); 
				echo ("<script language='JavaScript'>
         				window.location.href='view_gallery.php?album_id=$album_id&action=rechoose&name_image=$array_pic';
         				window.alert('File size larger than 25 MB.')
      				</script>");
				//header('location: view_gallery.php?name_image='.$array_pic.'&album_id='.$album_id.'&action=rechoose');
			}
		}
		else{
			echo "<script language=\"JavaScript\">";
			echo "alert('Please select photo.');";
			echo "</script>";
			header('refresh:view_gallery.php?album_id='.$album_id);
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
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
		.row3{
			background: linear-gradient(to top, #b1cadd 0%, #a1d7fc 50%, #e8f2f9 100%);
			margin: 20px auto;
			border: 2px solid #b7b5b5;
			padding-top: 13px;
			padding-bottom: 13px;
		}
		#block{
			margin-bottom: 10px;
		}
		img.img-responsive{
			width: 100%; 
			height: 180px;
		}
		img.img-responsive:hover{
			border: 2px solid #000;
		}
		#block #checkbox{
			margin-right: 18px;
			width: 23px;
			height: 23px;
		}
		.msg{
			text-align: center;
		}
		.button-control{
			margin-top: 30px;
		}
		.btn.btn-info{
			float: left;
		}
		.btn-group{
			float: right;
		}
		.btn.btn-danger{
			float: right;
			margin-left: 10px;
		}
		.btn.btn-default{
			float: right;
			margin-left: 10px;
		}
		/*.modal{
			display: none;
			position: fixed;
			padding-top: 70px;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgb(0,0,0);
			background-color: rgba(0,0,0,0.9);  
		}
		.modal-content{
			margin: auto;
			display: block;
			width: 40%;
			-webkit-animation-name: zoom;
			-webkit-animation-duration: 0.3s;
			animation-name: zoom;
			animation-duration: 0.3s; 
		}
		@-webkit-keyframes zoom{
			from {-webkit-transform:scale(0)}
			to {-webkit-transform:scale(1)}
		}
		@keyframes zoom{
			from {transform:scale(0)}
			to {transform:scale(1)}
		}
		.close{
			position: absolute;
			top: 20px;
			right: 40px;
			color: #e2dcd7;
			font-size: 40px;
			font-weight: bold;
			transition: 0.3s;
		}
		.close:hover,
		.close:focus{
			color: #fff;
			text-decoration: none;
			cursor: pointer;
		}*/
		
	</style>
</head>
<body>
	<?php
	include("header.php");
	?>

		<div class="container col-lg-12">
			<div class="button-control">
				<a href="view_album.php"><button type="button" class="btn btn-info btn-md" name="btnBackAlbum">
				<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Albums
				</button></a>
				<form name="form1" action="" method="POST"> 
				<input type="submit" class="btn btn-danger btn-md" name="btnDelete" value="Delete selected" 
					onclick="return confirm('Are you sure to delete this select?');" >
				<button type="submit" class="btn btn-default btn-md" name="btnSend">Send</button>
				<div class="btn-group">
					<a href="javascript:void(0)" onclick="unSelectAll()" class="btn btn-warning btn-md">Unselect all</a>
					<a href="javascript:void(0)" onclick="selectAll()" class="btn btn-warning btn-md">Select all</a>
				</div>
			</div>
			<div class="page-header" style="padding-top: 30px;"></div>

			<div class="row3 col-lg-12">
			<div class="row">
			<div class='list-group gallery'>
			<?php
			include("mydb.php");	
				if (isset($_GET['action']) == 'rechoose') {
					$x = unserialize($_GET['name_image']);			
				}

			 		$result = mysql_query("SELECT * FROM user_images WHERE album_id = '$album_id' ");
			 		if(mysql_num_rows($result) > 0){ 
			 			while ($objResult = mysql_fetch_array($result)){ 
			 			$userImage = $objResult['image_name']; ?>
					 		<div id="block" class="col-lg-2 col-md-1 col-sm-4 col-xs-6">
								<img src="<?php echo $userImage ?>" onclick="onClick(this)" class="img-responsive">
									<div class="w3-display-topright w3-large">
									<?php
									if (isset($x)) {
										if(in_array($userImage,$x)){ ?>
												<input checked="checked" type="checkbox" name="num[]" value="<?php echo $userImage ?>" id="checkbox">
										<?php }
										else{ ?>
											<input type="checkbox" name="num[]" value="<?php echo $userImage ?>" id="checkbox">
										<?php }
									}
									else{ ?>
										<input type="checkbox" name="num[]" value="<?php echo $userImage ?>" id="checkbox">
									<?php }
									?>
									</div>
							</div>
			 			<?php } ?>
			 			</form> <?php
			 		}
			 		else{ ?>
						<div class="msg">
							<h3>Not found photo.</h3>
							<a href="upload_gallery.php?album_id=<?php echo $album_id ?>">
							<button type="button" class="btn btn-primary" name="btnUpload">
							<span class="glyphicon glyphicon-save"></span>&nbsp;Upload Photos
							</button></a>
						</div>
			 		<?php }
			 		 	
				?>
			</div>
			</div>
			</div>
		</div>

	<div id="userModal" class="w3-modal" onclick="this.style.display='none'">
		<span class="w3-button w3-xlarge w3-red w3-display-topright">&times;</span>
		<div class="w3-modal-content w3-animate-zoom" style="width: 45%;">
			<img id="img01" style="width: 100%">
		</div>
	</div>

	<script type="text/javascript">
	function onClick(element) {
  		document.getElementById("img01").src = element.src;
  		document.getElementById("userModal").style.display = "block";
	}
	function selectImg(element){
		element.style.border = "2px solid red";
	}
	function selectAll(){
		num = document.forms[0].length;
		for(i=0;i<num;i++){
			document.forms[0].elements[i].checked = true;
		}
	}
	function unSelectAll(){
		num = document.forms[0].length;
		for(i=0;i<num;i++){
			document.forms[0].elements[i].checked = false;
		}
	}
	/*function showImage(dir_image){
		var theSource = dir_image;
		var modal = document.getElementById('userModal');
		var modalImg = document.getElementById('img01');
		modal.style.display = "block";
		modalImg.src = theSource;
	}
	function closeWin(){
		var modal = document.getElementById('userModal');
		modal.style.display = "none";
	}*/
	</script>
	
	</div>
</body>
</html>