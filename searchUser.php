<?php
	include("mydb.php");
	include("function.php");
	session_start();
	$Username = $_SESSION['user'];
	$my_id = $_SESSION['my_id'];

	if(!isset($_SESSION['user'])){
		header("location:page1.php");
		exit();
	}

	$search_user = $_GET['search_user'];
	if(strtolower($search_user) == strtolower($Username)){
		$successMsg = "found";
	}
	else{
		$friend_id = getId($search_user,'Id');
		$query = mysql_query("SELECT * FROM friends WHERE (user_one = '$my_id' AND user_two = '$friend_id') 
			OR (user_one = '$friend_id' AND user_two = '$my_id') ");
		if(mysql_num_rows($query) > 0 ){
			$successMsg = "found";
		}
		else{
			$sql = mysql_query("SELECT Id FROM register WHERE Id = '$friend_id' ");
			if(mysql_num_rows($sql) > 0){
				$x = mysql_fetch_array($sql);
				$name_friend = $x['Id'];
				header('location: sendFriendRequest.php?name_friend='.$name_friend);
			}
			else{
				$errorMsg = "not found";
			}
		}
	}
	
	if(isset($_POST['btnSend'])){
		if(!empty($_POST['num'])){
			$name_image = $_POST['num'];
			
			if(empty($_POST['album_num'])){
				$album_id = 0; 
			}
			else{
				$album_id = $_POST['album_num'];
			}
		
			$zipper = new Zipper();
			$zipper->add($name_image);
			$zipper->store('zip_file/zipped.zip');
			$file_size = filesize('zip_file/zipped.zip'); 
			if($file_size < 25000000){
				$count = count($_POST['num']);
				echo $file_size;
				//$array_pic = serialize($_POST['num']);
				header('location: sendImages.php?count='.$count.'&search_user='.$search_user.'&action=fromsearch');
			}
			else{
				$array_pic = serialize($_POST['num']); 
				echo ("<script language='JavaScript'>
         				window.location.href='searchUser.php?action=rechoose&search_user=$search_user&name_image=$array_pic&album_id=$album_id';
         				window.alert('File size larger than 25 MB.')
      				</script>");
				//header('location: view_gallery.php?name_image='.$array_pic.'&album_id='.$album_id.'&action=rechoose');
			}
			/*$count = count($_POST['num']);
			$array_pic = serialize($_POST['num']);
			header('location: sendImages.php?name_image='.$array_pic.'&count='.$count.'&search_user='.$search_user.'&action=fromsearch');*/
		}
		else{
			echo "<script language=\"JavaScript\">";
			echo "alert('Please select photo.');";
			echo "</script>";
			header('refresh:searchUser.php');
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
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


	<style>
		html,body,h1,h2,h3,h4,h5,h6 {
		    font-family: "Roboto", sans-serif
		}
		body{
			background-color: /*#FDC167*/#FFBE7D;
		}
		div.alert.alert-danger{
			margin-top: 50px;
		}
		#picNotFound{
			width: 100px;
			margin-bottom: 20px; 	
			margin-top: 10px;
		}
		h3{
			padding-left: 120px;
		}
		.row3{
			border-radius: 5px;
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
			height: 170px;
		}
		img.img-responsive:hover{
			border: 2px solid #000;
		}
		#block #checkbox{
			margin-right: 18px;
			width: 20px;
			height: 20px;
		}
		.btn.btn-default{
			float: right;
		}
		.btn.btn-default{
			width: 80px;
			margin-right: 50px;
		}
		.row2{
			margin-top: 20px;
			padding: 20px;
			margin-bottom: 0px;
		}
		.btn-group,.btn.btn-danger{
			margin-left: 30px;
		}
		/*
		.gallery-item{
			float: left;
			background: #fff;
			width: 13.4%;
			height: 165px;
			margin: 5px;
			box-shadow: 5px 5px 20px rgba(0,0,0,.6);
		}
		.gallery-item #picc{
			width: 100%;
			height: 100%;
			cursor: pointer;
		}
		.gallery-item #picc:hover{
			border: 2px solid #000;
		}*/

	</style>

</head>
<body>
	<?php
		include("header.php");
		include("mydb.php"); 
	?>
		<div class="container col-lg-12">
			<?php 
			if(isset($successMsg)){ ?>
				<div class="row1 col-lg-11" style="margin-top: 30px;">
					<div class="col-lg-3"><h3><?php echo $search_user ?> : &nbsp;</h3></div>
					<div class="col-lg-8" style="margin-top: 15px;">
					<form method="POST" action="">
						<div class="col-lg-4"><select name="framework" id="framework" class="form-control" onchange="myFunction()">
							<option value="All">All</option>
							<?php 
							$album_user = mysql_query("SELECT * FROM album WHERE username = '$Username' ");
							while ($row = mysql_fetch_array($album_user)) { ?>
							<option value="<?php echo $row['album_id'] ?>"><?php echo $row['album_name'] ?></option>
							<?php } ?>
						</select></div>
						<div class="col-lg-4"><input type="submit" name="submit" class="btn btn-info" value="Search" /></div>
					</form>
					</div>
				</div>

				<form id="display_image" method="POST" enctype="multipart/form-data">
				<div class="row2 col-lg-12" style="border:1px solid #fff; border-radius: 5px;">
					<button type="submit" name="btnSend" class="btn btn-default">Send</button>
					<div class="btn-group">
						<a href="javascript:void(0)" onclick="unSelectAll()" class="btn btn-warning btn-md">Unselect all</a>
						<a href="javascript:void(0)" onclick="selectAll()" class="btn btn-warning btn-md">Select all</a>
					</div>
				</div>
				
				<div class="row3 col-lg-12">
				<div class="row">
				<div class='list-group gallery'>
				<?php

				if(isset($_GET['action'])){
					$x = unserialize($_GET['name_image']);	
				}

					if(isset($_POST['submit']) || isset($_GET['album_id'])){

						if(isset($_POST['submit'])){
							$album_id = $_POST['framework'];
						}
						else{
							$album_id = $_GET['album_id'];
						}

						if($album_id > 0){ 
							$old_path = "";
							$result = mysql_query("SELECT pathImage FROM facedetectpedict WHERE predict = '$search_user' ");
							if(mysql_num_rows($result) > 0){
								while ($row = mysql_fetch_array($result)){ 
									$pathImage = substr($row['pathImage'],24); 
									$img_result = mysql_query("SELECT image_name FROM user_images WHERE image_name = '$pathImage' AND album_id = '$album_id' ");
									if(mysql_num_rows($img_result) > 0){
										while ($img_name = mysql_fetch_array($img_result)) { 
											$new_path = $img_name['image_name']; 
											if($new_path != $old_path){ ?>
											<div id="block" class="col-lg-2 col-md-1 col-sm-4 col-xs-6">
												<input type="hidden" name="album_num" value="<?php echo $album_id ?>">
												<img src="<?php echo $new_path ?>" onclick="onClick(this)" class="img-responsive">
												<div class="w3-display-topright w3-large">
													<?php
													if (isset($x)) {
														if(in_array($new_path,$x)){ ?>
															<input checked="checked" type="checkbox" name="num[]" value="<?php echo $new_path ?>" id="checkbox">
														<?php }
														else{ ?>
															<input type="checkbox" name="num[]" value="<?php echo $new_path ?>" id="checkbox">
														<?php }
													}
													else{ ?>
														<input type="checkbox" name="num[]" value="<?php echo $new_path ?>" id="checkbox">
													<?php }
													?>
												</div>
											</div>
											<?php 
												$old_path = $new_path;
											}
										}
									}
								}
							}
						}
						else{ 
							$result = mysql_query("SELECT pathImage FROM facedetectpedict WHERE predict = '$search_user' 
									AND username = '$Username'");
							$old_path = "";
							if(mysql_num_rows($result) > 0){
								while ($row = mysql_fetch_array($result)){
									$new_path = $row['pathImage']; 
									if($new_path != $old_path){ ?>
									<div id="block" class="col-lg-2 col-md-1 col-sm-4 col-xs-6">
										<img src="<?php echo substr($new_path,24) ?>" onclick="onClick(this)" class="img-responsive">
											<div class="w3-display-topright w3-large">
												<?php
													if (isset($x)) {
														if(in_array($new_path,$x)){ ?>
															<input checked="checked" type="checkbox" name="num[]" value="<?php echo $new_path ?>" id="checkbox">
														<?php }
														else{ ?>
															<input type="checkbox" name="num[]" value="<?php echo $new_path ?>" id="checkbox">
														<?php }
													}
													else{ ?>
														<input type="checkbox" name="num[]" value="<?php echo $new_path ?>" id="checkbox">
													<?php }
												?>												
											</div>
									</div>
									<?php 
										$old_path = $new_path;
									}		
								}
							}
						}
					}
					else { 
						$result = mysql_query("SELECT pathImage FROM facedetectpedict WHERE predict = '$search_user' 
								AND username = '$Username'");
						$old_path = "";
						if(mysql_num_rows($result) > 0){
							while ($row = mysql_fetch_array($result)){ 
								$new_path = $row['pathImage'];
								if($new_path != $old_path){ ?>
									<div id="block" class="col-lg-2 col-md-1 col-sm-4 col-xs-6">
									<img src="<?php echo substr($new_path,24) ?>" onclick="onClick(this)" class="img-responsive">
										<div class="w3-display-topright w3-large">
											<?php
												if (isset($x)) {
													if(in_array($new_path,$x)){ ?>
														<input checked="checked" type="checkbox" name="num[]" value="<?php echo $new_path ?>" id="checkbox">
													<?php }
													else{ ?>
														<input type="checkbox" name="num[]" value="<?php echo $new_path ?>" id="checkbox">
													<?php }
												}
												else{ ?>
													<input type="checkbox" name="num[]" value="<?php echo $new_path ?>" id="checkbox">
												<?php }
											?>
										</div>
									</div>
								<?php
									$old_path = $new_path;
							 	}	
							}
						}
					} ?>
				</div>
				</div>
				</div>
				</form>
			<?php } 
			if(isset($errorMsg)){ ?>
				<div class="row4">
					<div class="col-lg-3"></div>
					<div class="alert alert-danger col-lg-6">	
						<center><img id="picNotFound" src="pic/search_red.png"><br>
						<h4><strong>Username is not found.</strong></h4></center>
					</div>
				</div>
			<?php }  ?>
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
		function selectAll(){
		num = document.forms[1].length;
			for(i=0;i<num;i++){
				document.forms[1].elements[i].checked = true;
			}
		}
		function unSelectAll(){
			num = document.forms[1].length;
			for(i=0;i<num;i++){
				document.forms[1].elements[i].checked = false;
			}
		}
		function myFunction(){
			var name = document.getElementById('framework').value;
		}
	</script>
	</div>
</body>
</html>