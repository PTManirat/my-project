<?php
  require 'phpmailer/PHPMailerAutoload.php'; 
  include("mydb.php");
  session_start();
  $Username =  $_SESSION['user'];

  if(!isset($_SESSION['user'])){
    header("location:page1.php");
    exit();
  }

  $check_frnd_qurey = mysql_query("SELECT * FROM register WHERE username = '$Username' ");
  $result = mysql_fetch_array($check_frnd_qurey);

  if(isset($_POST['submit'])){
    $cur_pass = md5($_POST['cur_pass']);
    $new_pass = md5($_POST['new_pass']);
    $con_pass = md5($_POST['con_pass']);
    if($cur_pass != $result['password']){
      $errorMsg = "The current password you've entered is incorrect.";
    }
    else{
        if($new_pass != $con_pass){
          $errorMsg = "Your new password must be confirmed correctly.";
        }
        else{
          $old_pass = $result['password'];
          $query_sql = mysql_query("UPDATE register SET password = '$new_pass' WHERE password = '$old_pass' AND username = '$Username'");
          if($query_sql){
            $successMsg = "Your password has been changed.";
          }
          else{
            $errorMsg = "Could not change password.";
          }
        }
    }
  }

  if(isset($_POST['new_login'])){
    $old_pass = $result['password'];
    $email_target = $result['email'];
    $new_password = rand(72891,92729);
    $encode_newpass = md5($new_password);
    //$new_password = md5($new_password);
    $subject = "Login Information";
    $message = "Your password has been changed to $new_password";
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
    $mail->addAddress($email_target); //TO  
             
      if($mail->send()){
        $update_pass = mysql_query("UPDATE register SET password = '$encode_newpass' WHERE password = '$old_pass' 
          AND username = '$Username' ");
        echo "<script language=\"JavaScript\">";
        echo "alert('Send E-mail success.');";
        echo "window.open(\"logout.php\",\"_self\");";
        echo "</script>";
      }
      else{
        echo 'Mailer Error: ' . $mail->ErrorInfo;
      }
  }

 ?>
<!DOCTYPE html>
<html>
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

<style>
  html,body,h1,h2,h3,h4,h5,h6 {
    font-family: "Roboto", sans-serif
  }
  #forgot{
    cursor: pointer;
  }
</style>

<body>
<?php
  include("header.php");
?>
  <div class="w3-content w3-margin-top" style="max-width:1400px;">
    <div class="w3-row-padding">   <!-- The Grid -->
      
      <div class="w3-third">     <!-- Left Column -->
        <div class="w3-white w3-text-grey w3-card-4">
          
          <div class="w3-display-container w3-padding-32">
              <center>
                <img src="pic/user.png" style="width:45%" alt="Avatar">
                <h3> <?php echo $Username ?></h3>
              </center>
          </div>
          
          <div class="w3-container">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="profilesetting.php"><h5><strong>Edit Profile
                <span class="glyphicon glyphicon-chevron-right" style="float: right;"></span></strong></h5></a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#"><h5><strong>Password
                <span class="glyphicon glyphicon-chevron-right" style="float: right;"></span></strong></h5></a>
              </li>
            </ul>
          </div>
          
          <div class="w3-container">
            <hr>
            <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Personal Information</b></p>
            <div class="w3-row-padding">
              <p>Name : <?php  echo $result['firstName'].' '.$result['lastName'] ?></p>
            </div>
            <div class="w3-row-padding">
              <p>Email :  <?php  echo $result['email'] ?></p>
            </div>
            <br>
          </div>

        </div><br>
      </div>

      <div class="w3-twothird">
        <div class="w3-container w3-card-2 w3-white w3-margin-bottom">
          <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>My Account</h2>
          <hr>

          <form class="form-horizontal" id="change_pass" action="" method="POST">
         
                <?php
                  if(isset($errorMsg)){ ?>
                    <div class="row col-sm-12">
                      <div class="alert alert-danger">
                        <span><?php echo $errorMsg ?></span>
                      </div>
                    </div>
                  <?php } 
                  if(isset($successMsg)){ ?>
                    <div class="row col-sm-12">
                      <div class="alert alert-success">
                        <span><?php echo $successMsg ?></span>
                      </div>
                    </div>
                  <?php }
                ?>
          
             <div class="form-group">
                <label class="control-label col-sm-3" for="cur_pass">Current password :</label>
                <div class="col-sm-5">
                  <input type="password" class="form-control" name="cur_pass" maxlength="8" required>
                  <a data-toggle="modal" data-target="#myModal" id="forgot">Forgot your password?</a>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-3" for="new_pass">New password :</label>
                <div class="col-sm-5">
                  <input type="password" class="form-control" name="new_pass" maxlength="8" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="con_pass">Verify password:</label>
                <div class="col-sm-5">
                  <input type="password" class="form-control" name="con_pass" maxlength="8" required>
                </div>
              </div>
              <div class="form-group">        
                <div class="col-sm-offset-3 col-sm-10">
                  <button type="submit" name="submit" class="btn btn-default">Save changes</button>
                </div>
              </div>
              <br>
          </form> 
        
        </div>
      </div>

    </div>
  </div>
  
  <!--Model-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
  
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Do you want to reset your password?</h4>
        </div>
        <div class="modal-body">
          <p>We found email : <?php echo $result['email'] ?> was associated with your account.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalx" data-dismiss="modal">Reset password</button>
        </div>
      </div>
      
    </div>
  </div>

  <!--Model-->
  <div class="modal fade" id="myModalx" role="dialog">
    <div class="modal-dialog">
  
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Check your email.</h4>
        </div>
        <div class="modal-body">
          <p>We've sent new password to '<?php echo $result['email'] ?>' , Please try to login with new password again.</p>
        </div>
        <div class="modal-footer">
          <form id="new_login" action="" method="POST">
            <button type="submit" name="new_login" class="btn btn-success">New Login</button>
          </form>
        </div>
      </div>
      
    </div>
  </div>


</div>
</body>
</html>
