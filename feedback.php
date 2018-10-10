<?php
	include("mydb.php");
	session_start();
	$Username = $_SESSION['user'];
	$my_id = $_SESSION['my_id'];

	if(!isset($_SESSION['user'])){
		header("location:page1.php");
		exit();
	}

	if(isset($_GET['search_user'])){
		$search_user = $_GET['search_user'];
		$query = mysql_query("SELECT username FROM register WHERE username = '$search_user' ");
		$sql_query = mysql_fetch_array($query);
		$feedbackName = $sql_query['username'];
		$target = "faceDetectionImage/".$feedbackName."/";
	
	}

	if(isset($_POST['submit'])){
		if(!empty($_POST['num'])){
			$feedbackImage = $_POST['num'];
			$type_cut = "faceDetectImagePredict\\".$Username."\\";
			while (list($key,$val) = @each($feedbackImage)) {
				$cut = explode($type_cut,$val); 
				$name_image = trim($cut[1]);   
				$path_target = $target.basename($name_image);
				copy($val,$path_target);     //(from,to)		
			}
			echo "<script language=\"JavaScript\">";
			echo "alert('Thank you.');";
			echo "window.open('homepage.php','_self');";
			echo "</script>";
		}
		else{
			echo "<script language=\"JavaScript\">";
			echo "alert('Please select photo.');";
			echo "</script>";
		}
	}

	if(isset($_POST['noImage'])){
		echo "<script language=\"JavaScript\">";
		echo "alert('Thank you.');";
		echo "window.open('homepage.php','_self');";
		echo "</script>";
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>

	<style>
		html,body,h1,h2,h3,h4,h5,h6 {
		    font-family: "Roboto", sans-serif
		}
		body{
			background-color: /*#FDC167*/#FFBE7D;
		}
		.row3{
			margin-bottom: 10px;
		}
		#block{
			margin-bottom: 18px;
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
	</style>

</head>
<body>
	<?php
		include("header.php");
		include("mydb.php"); 
	?>	
		<div class="w3-container w3-margin-top w3-white" style="max-width:1400px;">
			<div class="w3-container">
				<h2 class="w3-text-grey" style="margin-top: 2%;">Please select "<b><?php echo $feedbackName ?></b>" images for the best performance.</h2>
			</div>
			<hr>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="row3 col-lg-12">
			<div class="row">
			<div class='list-group gallery'>
			<?php 
			 	$result = mysql_query("SELECT detectImage FROM facedetectpedict WHERE predict = '$search_user' AND username = '$Username' ");
			 		if(mysql_num_rows($result) > 0){ 
			 			while ($objResult = mysql_fetch_array($result)){ 
			 			$pathImage = substr($objResult['detectImage'],24); ?>
					 		<div id="block" class="col-lg-2 col-md-1 col-sm-4 col-xs-6">
								<img src="<?php echo $pathImage ?>" class="img-responsive">
									<div class="w3-display-topright w3-large">
										<input type="checkbox" name="num[]" value="<?php echo $pathImage ?>" id="checkbox">
									</div>
							</div>
			 			<?php } 
			 		}
			 		else{ ?>
						<div class="msg">
							<h3 class="w3-text-grey">No "<b><?php echo $feedbackName ?></b>" image.</h3>
						</div>
			 		<?php }
				?>
			</div>
			</div>
			<hr>
			</div>
			<div class="col-sm-offset-8 col-sm-4">
				<button type="submit" name="noImage" class="btn btn-defult" style="width: 150px; margin-bottom: 20px; margin-right: 50px;">No "<b><?php echo $feedbackName ?></b>" Image</button>
                <button type="submit" name="submit" class="btn btn-warning" style="width: 150px; margin-bottom: 20px;">Submit</button>
            </div>
            </form>
		</div>
	</div>
</body>
</html>
