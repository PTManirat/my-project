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

	$action = $_GET['action'];
	
	if($action == 'fromsearch'){
		$countpic = $_GET['count'];
		//$x = unserialize($_GET['name_image']);
		$search_user = $_GET['search_user'];
	}

	if($action == 'fromview'){
		$countpic = $_GET['count'];
		//$x = unserialize($_GET['name_image']);
		$album_id = $_GET['album_id'];
	}

	require 'phpmailer/PHPMailerAutoload.php';
	$mail = new PHPMailer();
	/*$zipper = new Zipper();
	$zipper->add($x);
	$zipper->store('zip_file/zipped.zip');*/

	if(isset($_POST['send'])){
		if(!empty($_POST['framework'])){
			$count = count($_POST['framework']);
			$count_num = 0;
			$text = $_POST['text'];
			//$select = $_POST['radio'];
			while (list($key,$val) = @each($_POST['framework'])) {
				$sql = mysql_query("SELECT * FROM register WHERE Id = '$val' ");
				$result = mysql_fetch_array($sql);
				$email_friend = $result['email'];
				$firstname_friend = $result['firstName'];
				$lastname_friend = $result['lastName'];
				$msg = "Dear $firstname_friend $lastname_friend<br>$text";
						
				$mail->Host = "smtp-mail.outlook.com"; //smtp.gmail.com
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->Username = "Patboice1621@hotmail.co.th";  
				$mail->Password = "imagine"; 
				$mail->SMTPSecure = "tls"; //ssl
				$mail->Port = 587; //or 587 if TLS 465 if ssl

				$mail->CharSet = "utf-8";
				$mail->FromName = "Admin";
				$mail->Subject = "Send Images"; 
				$mail->isHTML(true);
				$mail->Body = $msg;
				$mail->addAttachment('zip_file/zipped.zip');

				$mail->setFrom("Patboice1621@hotmail.co.th"); //FROM
				$mail->addAddress($email_friend); //TO	
			 
				if($mail->send()){
					$count_num++;
					if($count_num == $count){
						if(!empty($search_user)){
							echo "<script language=\"JavaScript\">";
        					echo "alert('Send E-mail success.');";
        					echo "window.open('feedback.php?search_user=$search_user','_self');";
        					echo "</script>";
						}
						else{
							echo "<script language=\"JavaScript\">";
        					echo "alert('Send E-mail success.');";
        					echo "</script>";
						}
					}
				}
				else{
					echo 'Mailer Error: ' . $mail->ErrorInfo;
				}
				$mail->ClearAllRecipients(); 
    			$mail->ClearAttachments();
			}
		}
		else{
			echo "<script language=\"JavaScript\">";
			echo "alert('Please select an item in the list.');";
			echo "</script>";
		}	
	}

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

 </head>
	<style>
		html,body,h1,h2,h3,h4,h5,h6 {
		    font-family: "Roboto", sans-serif
		}
		body{
			background-color: /*#FDC167*/#FFBE7D;
		}
		.container{
			margin-top: 40px;
			background-color: #fff;
			padding-bottom: 15px;
		}
		#block1{
			background-color: #445e6f;
			height: 60px;
		}
		#block1 h2{
			color: #fff;
			margin-left: 13px;
		}
		#g1{
			margin-top: 23px;
		}

	</style>
	
<body>
	<?php
		include("header.php");
	?>
	<div class="container col-md-8 col-md-offset-2"> 
		<div class="row" id="block1">
			<h2>Send image : <?php echo $countpic ?> &nbsp;files</h2>
		</div>
		<div class="row" id="block2">
			<form method="POST" class="form-horizontal" action="">
				<div class="form-group" id="g1">
					<label class="col-sm-2 control-label" style="font-size: 20px;">To : </label>
					<div class="col-sm-10">
						<select id="framework" name="framework[]" multiple="multiple">
							<?php
								$sql = mysql_query("SELECT * FROM friends WHERE user_one = '$my_id' OR user_two = '$my_id' ");
								while ($frnd_query = mysql_fetch_array($sql)) {
									if($frnd_query['user_one'] == $my_id){
										$frnd_id = $frnd_query['user_two'];
										$frnd_name = getUsername($frnd_id,'username'); ?>
										<option value="<?php echo $frnd_id?>"><?php echo $frnd_name ?></option>
									<?php }
									else{
										$frnd_id = $frnd_query['user_one'];
										$frnd_name = getUsername($frnd_id,'username'); ?>
										<option value="<?php echo $frnd_id ?>"><?php echo $frnd_name ?></option>
									<?php }
								}
							?>
						</select>
					</div>
				</div>

				<div class="form-group" id="g2">
					<label class="col-sm-2 control-label" style="font-size: 20px;">Text Input : </label>
					<div class="col-sm-9">
						<textarea type="text" name="text" class="form-control" rows="3" placeholder="Say something about this..."></textarea>
					</div>
				</div>
				
				<!--<div class="form-group" id="g3">
					<label class="col-sm-2 control-label" style="font-size: 20px;">Send by : </label>
					<div class="col-sm-10">
						<div class="radio">
                			<label style="font-size: 16px;">
                    			<input type="radio" name="radio" value="1" required><strong>E-mail</strong> 
                			</label>
           			 	</div>
            			<div class="radio">
                			<label style="font-size: 16px;">
                    			<input type="radio" name="radio" value="2" required><strong>Facebook</strong> 
                			</label>
            			</div>
					</div>
				</div>-->
				<hr>

				<div class="form-group" id="g4">
					<?php
						if(isset($search_user)){ ?>
							<div class="col-sm-6" style="padding-left: 8%;">
								<a href="searchUser.php?search_user=<?php echo $search_user ?>" name="cancel" class="btn btn-default" 
								role="button" style="width: 80px;">Back</a>
							</div>
						<?php }
						if(isset($album_id)){ ?>
							<div class="col-sm-6" style="padding-left: 8%;">
								<a href="view_gallery.php?album_id=<?php echo $album_id ?>" name="cancel" class="btn btn-default" 
								role="button" style="width: 80px;">Back</a>
							</div>
						<?php }
					?>
					<div class="col-sm-6">
						<button type="submit" name="send" class="btn btn-success" style="margin-left: 58%;">Send Images</button>
					</div>
				</div>

			</form>
		</div>
	</div>
	
	</div>
</body>
</html>

<script type="text/javascript">
   	$(document).ready(function() {
         $('#framework').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            enableCaseInsensitiveFiltering: true,
            selectAllJustVisible: false,
            buttonWidth:'300px'
        });
    });
</script>