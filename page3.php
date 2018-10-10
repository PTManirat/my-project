<?php
	include("mydb.php");
	include("function.php");
	session_start();
	$Username = $_SESSION['user'];

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

	$folder_target = "myfiles/";

	if(isset($_POST['upload'])){

		$checkEmpImp = checkEmptyImage('files');

		if($checkEmpImp == 1){
			for($i=0;$i<count($_FILES['files']['name']);$i++){
				$samName = $_FILES['files']['name'][$i];
				$sampleNmae = strtolower($samName);
				$samTmp = $_FILES['files']['tmp_name'][$i];
				$samSize = $_FILES['files']['size'][$i];

				$samExt = pathinfo($sampleNmae, PATHINFO_EXTENSION);
				/*$ext = explode('.', basename($_FILES['file']['name'][$i]));*/
				$allowExt = array('jpeg','jpg','png');
				$sampleImg = time().'_'.rand(1000,9999).'.'.$samExt;

				if(in_array($samExt, $allowExt)){
					if($samSize < 10000000){
						$file_dir = "$folder_target".basename($sampleImg);
						//$uploadFile = ftp_put($conn_id, $file_dir, $samTmp, FTP_BINARY);
						$uploadFile = move_uploaded_file($samTmp, $file_dir);
						$sql = mysql_query("INSERT INTO filesample (username,sampleImage) 
								VALUES ('".$Username."','".$sampleImg."') ");
					}
				}
				else{
					$errorMsg = '*** Please select a valid photo. (.jpeg,.jpg,.png)';
				}
			}
		}
		else{
			$errorMsg = '*** Please select photo.';
		}

		if(!isset($errorMsg)){
			$successMsg = 'Your photos is successfully uploded.';
		}
	}

	if(isset($_GET['sampleImage'])){
		$sampleImage = $_GET['sampleImage'];
		$destination_file = "$folder_target".basename($sampleImage);
		/*if(ftp_delete($conn_id, $destination_file)){*/
		if(unlink($destination_file)){
			$strSQL = mysql_query("DELETE FROM filesample WHERE sampleImage = '$sampleImage' ");
			header('location: page3.php');
		}
		else{
			$errorMsg = '***Could not delete photo.';
		}
	}
	
	if(isset($_GET['check'])){
		$check = mysql_query("SELECT sampleImage FROM filesample WHERE username = '$Username' ");
		if(mysql_num_rows($check) >= 10){
			$inputDir  = "C:\Users\ADMIN\Desktop\matlab";
			$command = "matlab -sd ".$inputDir." -r faceDetection2('$Username')";
			exec($command);
			//$del = mysql_query("DELETE FROM filesample WHERE username = '$Username' ");
			header('location:homepage.php');
		}
		else{
			echo "<script language=\"JavaScript\">";
			echo "alert('Please add photo at least ten.');";
			echo "window.open(\"page3.php\",\"_self\");";
			echo "</script>";
		}
	}

	/*ftp_close($conn_id);*/
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" >
	<style>
		html,body,h1,h2,h3,h4,h5,h6 {
		    font-family: "Roboto", sans-serif
		}
		body{
			background-color: #FFBE7D;
		}
		form{
			width: 40%;
			margin: 30px auto;
			padding: 10px;
			border-style: outset;
			border-radius: 10px;
			clear: left;
		}
		div.alert.alert-danger,
		div.alert.alert-success{
			width: 97.5%;
			margin-left: 5.5px;
			border-radius: 0px;
		}
		.formUpload{
			display: inline-block;
		}
		img.img-responsive{
			width: 100%; 
			height: 140px;
		}
		img.img-responsive:hover{
			border: 2px solid #000;
		}
		#cross{
			width: 15px;
			height: 15px;
		}
		#block{
			position: relative;
			margin-bottom: 30px;
			margin-top: 10px;
		}
		#block #cross{
			position: absolute;
			top: 0px;
			right: 15px;
			background-color: #fff; 
		}
		div#btnFinish{
			margin-left: 45%;
			margin-bottom: 15px;
			margin-top: -20px;
		}

	</style>
</head>
<body>

	<div id="uploadSimpleImage" class="w3-container w3-display-topmiddle" style="width: 80%;">
		<div class="w3-container w3-text-white" style="background-color: #6699AA;">
			<h2>Add photos</h2>
		</div>
		<div class="w3-container w3-white" style="margin-bottom: 50px;">
			<b><h3>Username : <?php echo $_SESSION['user']; ?></h3>
			<p>- You must be upload your full face.</p>
			<p>- Recommend facial photo, single photo and brightness enough.</p>
			<p>- Add photo at least ten.</p></b>
				
			<div class="row3 col-lg-12">
			<div class="row">
			<div class='list-group gallery'>
				<?php
					include("mydb.php");
						$objResult = mysql_query("SELECT sampleImage FROM filesample WHERE username = '$Username' ");
						if(mysql_num_rows($objResult) > 0){
							while ($rowResult = mysql_fetch_array($objResult)) {
							$display = $rowResult['sampleImage']; ?>
							<div id="block" class="col-md-2 col-sm-4 col-xs-6">
								<img src="<?php echo $folder_target.basename($display) ?>" class="img-responsive">
								<a href="page3.php?sampleImage=<?php echo $display ?>">
									<img src="pic/cross.png" id="cross" alt="Remove this photo.">
								</a>
							</div>
							<?php }
						}
				?>
			</div>
			</div>
			</div>
		
				<form class="addSamplePhotoForm" action="page3.php" method="POST" enctype="multipart/form-data">
					<?php
						if(isset($errorMsg)){ ?>
							<div class="row">
								<div class="alert alert-danger">
									<span><?php echo $errorMsg ?></span>
								</div>
							</div>
						<?php }
						if(isset($successMsg)){ ?>
							<div class="row">
								<div class="alert alert-success">
									<span><?php echo $successMsg ?></span>
								</div>
							</div>
						<?php }
					?>
					<div class="formUpload">
						<input type="file" name="files[]" multiple="multiple" />
					</div>
					<div class="formUpload">
						<button type="submit" class="btn btn-info" name="upload">
						<span class="glyphicon glyphicon-save"></span>&nbsp;Upload
						</button>
					</div>
				</form>
				
				<div id="btnFinish">
					<a href="page3.php?check=checkImg"><button type="button" class="btn btn-success" name="finish" style="width: 20%;">
						<span class="glyphicon glyphicon-ok"></span>&nbsp;Finish
					</button></a>
				</div>
		</div>
	</div>
</body>
</html>

