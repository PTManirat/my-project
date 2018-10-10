<?php
	require 'phpmailer/PHPMailerAutoload.php';
	session_start(); 
	include("mydb.php");
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Page1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="jquery-3.1.1.js"></script>

	<style>
		html,body,h1,h2,h3,h4,h5,h6 {
		    font-family: "Roboto", sans-serif
		}
		/*body{
			background-color: #FDC167;
		}*/
		#loginButton{
			font-size: 16px;
			margin-top: 15px;
		}
		#nextButton{
			width: 80px;
		}
		body,html{
			height: 100%;
			margin: 0;
		}
		.bgimg{
			background-image: url('pic/children-1879907_1280.jpg');
			height: 100%;
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
		}
		#forgot{
			cursor: pointer;
			font-size: 15px;
		}

	</style>
</head>

<body>
<?php
	if(isset($_POST['search'])){
		$search = $_POST['target_name'];
		$search_qurey = mysql_query("SELECT email FROM register WHERE username = '$search' OR email = '$search' ");
		if(mysql_num_rows($search_qurey) > 0 ){
			$result = mysql_fetch_array($search_qurey);
			$email = $result['email'];
			echo "<script type='text/javascript'>
					$(document).ready(function(){
						$('#myModalx').modal('show');
					});
				</script>";

		}	
		else{
			echo "<script language=\"JavaScript\">";
			echo "alert('Could not find your account with that information.');";
			echo "</script>";
		}
	}

	if(isset($_POST['new_login'])){
		$email_user = $_POST['email_user'];
		$detail_user = mysql_query("SELECT * FROM register WHERE username = '$email_user' OR email = '$email_user' ");
		$row = mysql_fetch_array($detail_user);
		$old_pass = $row['password'];
		$new_pass = rand(72891,92729);
		$encode_new_pass = md5($new_pass);
		//$new_pass = md5($new_pass);
		$subject = "Login Information";
	    $message = "Your password has been changed to $new_pass";
	    $from = "From: example@example.com";

	    $mail = new PHPMailer();
	    $mail->Host = "smtp-mail.outlook.com"; //smtp.gmail.com
	    $mail->isSMTP();
	    $mail->SMTPAuth = true;
	    $mail->Username = "Patboice1621@hotmail.co.th";
	    $mail->Password = "imagine";
	    $mail->SMTPSecure = "tls"; //ssl
	    $mail->Port = 587; //or 587 if TLS 465 if ssl

	    $mail->FromName = $from;
	    $mail->Subject =$subject; 
	    $mail->isHTML(true);
	    $mail->Body = $message;

	    $mail->setFrom("Patboice1621@hotmail.co.th"); //FROM
	    $mail->addAddress($email_user); //TO  
	             
	      if($mail->send()){
	        $update_pass = mysql_query("UPDATE register SET password = '$encode_new_pass' WHERE password = '$old_pass' AND email = '$email_user' ");
	        echo "<script language=\"JavaScript\">";
			echo "alert('Send E-mail success.');";
			echo "window.open(\"logout.php\",\"_self\");";
			echo "</script>";
	      }
	      else{
	        echo 'Mailer Error: ' . $mail->ErrorInfo;
	      }
	}


	if(isset($_POST['loginButton'])){
		$loginUsername = $_POST['loginUsername']; 
		$loginPassword = md5($_POST['loginPassword']); 

		$sql = mysql_query("SELECT * FROM register WHERE username = '$loginUsername' AND password = '$loginPassword' ");
		if(mysql_num_rows($sql)==0){
			echo "<script language=\"JavaScript\">";
			echo "alert('Username or Password Incorrect');";
			//echo "window.open(\"page1.php\",\"_self\");";
			echo "</script>";
		}
		else{
			$result = mysql_fetch_array($sql);
			$my_id = $result['Id'];
			$user = $result['username'];
			$_SESSION['my_id'] = $my_id;
			$_SESSION['user'] = $user;
			header("location:homepage.php");
		}
	}


?>
	<div class="bgimg w3-opacity-min w3-sepia-min">
	</div>
	
	<div class="w3-display-middle w3-black w3-opacity-min w3-padding w3-hover-opacity-off w3-round" style="width: 35%;">
		<h1 class="w3-text-light-grey w3-text-shadow">Login</h1>
		<hr  class="w3-opacity">
		<form name="loginForm" action="page1.php" method="POST">
			<!--<iframe id="iframe1" name="iframe1" src="#" style="width: 0; height: 0; border: 0px solid #fff;"></iframe>-->
				<div>
				<label class="w3-label w3-slim w3-text-light-grey w3-large">Username :</label>
				<input class="w3-input w3-hover-grey w3-round-large w3-text-black" type="text" id="loginUsername" maxlength="10"
						name="loginUsername" value="<?php echo (isset($_POST['loginUsername']))?$_POST['loginUsername']:'';?>" required autocomplete="off">
				</div>
				<div>
				<label class="w3-label w3-slim w3-text-light-grey w3-large">Password :</label>
				<input class="w3-input w3-hover-grey w3-round-large w3-text-black" type="password" maxlength="8" id="loginPassword" 
						name="loginPassword" required>
				</div>
				<div>	
					<p><center><b><input id="loginButton" type="submit" value="Login" name="loginButton"
										class="w3-btn w3-hover-grey w3-light-grey w3-round-large"></b></center></p>
				</div>
		</form>

		<div>
			<center>
				Not a member? <a href="page2.php" class="w3-text-light-grey" style="font-size: 15px;">Create account.</a><br>
				<a id="forgot" class="w3-text-light-grey" data-toggle="modal" data-target="#myModal" >Forgot password?</a>
			</center><br>
		</div>
	</div>

	<!--Model-->
	<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog">
	  
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Find your account?</h4>
	        </div>
	        <div class="modal-body">
	          <p>Please enter your email or username.</p>
	          <form id="search_user" method="POST" action="">
	          <input type="text" class="form-control" name="target_name" maxlength="50" required style="width: 60%;">
	        </div>
	        <div class="modal-footer">
	          <button type="submit" name="search" class="btn btn-info">Search</button>
	          </form>
	        </div>
	      </div>
	      
	    </div>
	</div>
	
	<!--Model-->
	<div class="modal fade" id="myModalx" tabindex="-1" role="dialog">
	    <div class="modal-dialog">
	  
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Do you want to reset your password?</h4>
	        </div>
	        <div class="modal-body">
	          <p>We found email : <?php echo $email ?> was associated with your account.</p>
	        </div>
	        <div class="modal-footer">
	       		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" data-dismiss="modal" style="float: left;">Back</button>
	         	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModaly" data-dismiss="modal">Reset password</button>
	        </div>
	      </div>
	      
	    </div>
  	</div>

  	<!--Model-->
	<div class="modal fade" id="myModaly" role="dialog">
	    <div class="modal-dialog">
	  
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title">Check your email.</h4>
	        </div>
	        <div class="modal-body">
	          <p>We've sent new password to '<?php echo $email ?>' , Please try to login with new password again.</p>
	        </div>
	        <div class="modal-footer">
	          <form id="new_login" action="" method="POST">
	          	<input type="hidden" name="email_user" value="<?php echo $email ?>">
	            <button type="submit" name="new_login" class="btn btn-success">New Login</button>
	          </form>
	        </div>
	      </div>
	      
	    </div>
	</div>

</body>

</html>

