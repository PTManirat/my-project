
<?php
	session_start();
	include("mydb.php");
	include("function.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="jquery-3.1.1.js"></script>
	<style>
		html,body,h1,h2,h3,h4,h5,h6 {
		    font-family: "Roboto", sans-serif
		}
		body{
			background-color: #FFBE7D;
		}
	</style>
</head>
<body>

		<div id="create_account" class="w3-container w3-display-middle" style="width: 60%;">
			<div class="w3-container w3-text-white" style="background-color: #6699AA;">
				<h2>Create account</h2>
			</div>
			<div class="w3-container w3-white">
				<form name="registerForm" action="page2.php" method="POST" /*target="iframe1" class="w3-padding">
				<br>
					<!--<iframe id="iframe1" name="iframe1" src="#" style="width: 0; height: 0; border: 0px solid #fff;"></iframe>
						<script language="JavaScript">
							function showResultRegister(result){
								if(result==1){
									document.getElementById("show_result_register").innerHTML = "<font color=green>Save successfully!!</font><br>";
								}
								if(result){
									document.getElementById("show_result_register").innerHTML = "<font color=red>Error!! Cannot save data</font><br>";
								}
							}
						</script>
					<div id="show_result_register" class="w3-large" style="size: 25px; margin-bottom: 15px;"></div>-->
					<div class="w3-row" style="margin-bottom: 15px;">
						<label>Username</label>
						<input class="w3-round" type="text" name="username" maxlength="10" value="<?php echo (isset($_POST['username']))?$_POST['username']:'';?>" style="margin-left: 5px;" required autocomplete="off">
					</div>
					<div clss="w3-row">
						<div class="w3-half">
							<label>Password</label>
							<input class="w3-round" type="password" name="ipassword" maxlength="8" style="margin-left: 5px;" required>
						</div>
						<div class="w3-half" style="margin-bottom: 15px;">
							<label>Re-enter Password</label>
							<input class="w3-round" type="password" name="conPassword" maxlength="8" required>
						</div>
					</div>
					<div class="w3-row">
						<div class="w3-half">
							<label>First name</label>
							<input class="w3-round" type="text" name="firstName" value="<?php echo (isset($_POST['firstName']))?$_POST['firstName']:'';?>" maxlength="64" required autocomplete="off">
						</div>
						<div class="w3-half"  style="margin-bottom: 15px;">
							<label>Last name</label>
							<input class="w3-round" type="text" name="lastName" value="<?php echo (isset($_POST['lastName']))?$_POST['lastName']:'';?>" maxlength="64" required autocomplete="off">
						</div>
					</div>
					<div class="w3-row">
						<label>E-mail</label>
						<input class="w3-round" type="email" name="e-mail" value="<?php echo (isset($_POST['e-mail']))?$_POST['e-mail']:'';?>" style="width: 40%;" required autocomplete="off">
					</div><br><br><br><br>
					<div>
						<button type="submit" name="btnRegister" class="w3-btn w3-display-bottomleft w3-round"
							style="margin-bottom: 20px; margin-left:45px;">SUBMIT</button>
					</div>
					<!--<div>
						<button type="button" id="btnNext" class="w3-btn w3-display-bottomright w3-round"
							style="margin-bottom: 20px; margin-right:45px; display: none;">NEXT</button>
					</div>-->
				</form>
			</div> 
		</div>

</body>
</html>

<?php	
	if(isset($_POST['btnRegister'])){
		$user = $_POST['username'];
		$password = md5($_POST['ipassword']);
		$con_password = md5($_POST['conPassword']);
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = $_POST['e-mail'];
		$folder_target = "myfiles/";
		
		if($password != $con_password){
			echo "<script language=\"JavaScript\">";
			echo "alert('Password not match');";
			//echo "window.open(\"page2.php\",\"_self\");";
			echo "</script>";
		}
		else{
			$checkUser = mysql_query("SELECT * FROM register WHERE username = '$user' ");
			if(mysql_num_rows($checkUser) > 0){
				echo "<script language=\"JavaScript\">";
				echo "alert('Username is already exists');";
				//echo "window.open(\"page2.php\",\"_self\");";
				echo "</script>";
			}
			else{
				$checkEmail = mysql_query("SELECT * FROM register WHERE email = '$email' ");
				if(mysql_num_rows($checkEmail) > 0){
					echo "<script language=\"JavaScript\">";
					echo "alert('E-mail is already exists');";
					//echo "window.open(\"page2.php\",\"_self\");";
					echo "</script>";
				}
				else{
					$addData = mysql_query("INSERT INTO register (username,password,firstName,lastName,email) 
								VALUES ('".$user."','".$password."','".$firstName."','".$lastName."','".$email."') ");
					$_SESSION['user'] = $user;
					$my_id = getId($user,'Id');
					$_SESSION['my_id'] = $my_id;

					$check_query = mysql_query("SELECT * FROM filesample WHERE username = '$user' ");
						if(mysql_num_rows($check_query) > 0){
							while ($row = mysql_fetch_array($check_query)) {
								$sampleImage = $row['sampleImage'];
								$destination_file = "$folder_target".basename($sampleImage);
								if(unlink($destination_file)){
									$clear = mysql_query("DELETE FROM filesample WHERE username = '$user' AND sampleImage = '$sampleImage' ");
								}
							}
							echo '<script type="text/javascript">'; 
							echo 'alert("Register complete");'; 
							echo 'window.location.href = "page3.php";';
							echo '</script>';
						}
						else{
							echo '<script type="text/javascript">'; 
							echo 'alert("Register complete");'; 
							echo 'window.location.href = "page3.php";';
							echo '</script>';
						}
				}
			}
		}
	}
	
?>