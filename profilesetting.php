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

  $check_frnd_qurey = mysql_query("SELECT * FROM register WHERE username = '$Username' ");
  $result = mysql_fetch_array($check_frnd_qurey);

  if(isset($_POST['submit'])){
    $user = $_POST['username'];
    $f_name = $_POST['firstname'];
    $l_name = $_POST['lastname'];
    $e_mail = $_POST['email'];
    
    if(empty($user) || $user == $result['username']){
      $new_user = $result['username'];
    }
    else{
      $checkUser = mysql_query("SELECT username FROM register WHERE username = '$user' ");
      if(mysql_num_rows($checkUser) > 0){
        $new_user = $result['username'];
        echo "<script language=\"JavaScript\">";
        echo "alert('Username is already exists.');";
        echo "</script>";
      }
      else{
        $new_user = $user;
      }
    }

    if(empty($f_name) || $f_name == $result['firstName']){
      $newf_name = $result['firstName'];
    }
    else{
      $newf_name = $f_name;
    }

    if(empty($l_name) || $l_name == $result['lastName']){
      $newl_name = $result['lastName'];
    }
    else{
      $newl_name = $l_name;
    }

    if(empty($e_mail) || $e_mail == $result['email']){
      $newe_mail = $result['email'];
    }
    else{
      $checkEmail = mysql_query("SELECT email FROM register WHERE email = '$e_mail' ");
      if(mysql_num_rows($checkEmail) > 0){
        $newe_mail = $result['email'];
        echo "<script language=\"JavaScript\">";
        echo "alert('E-mail is already exists.');";
        echo "</script>";
        
      }
      else{
        $newe_mail = $e_mail;
      }
    }

    $update_profile = mysql_query("UPDATE register SET username='$new_user',firstName='$newf_name',lastName='$newl_name',email='$newe_mail' WHERE Id = '$my_id' ");
    unset($_SESSION['user']);
    unset($_SESSION['my_id']);
    $_SESSION['user'] = $new_user;
    $my_id = getId($new_user,'Id');
    $_SESSION['my_id'] = $my_id;
    //header('location: profilesetting.php');
    echo "<script language=\"JavaScript\">";
    echo "window.open(\"profilesetting.php\",\"_self\");";
    echo "</script>";
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
                <a class="nav-link active" href="#"><h5><strong>Edit Profile
                <span class="glyphicon glyphicon-chevron-right" style="float: right;"></span></strong></h5></a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="passwordsetting.php"><h5><strong>Password
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
 
            <form class="form-horizontal" id="edit_from" action="" method="POST" enctype="multipart/form-data">
             <?php
                if(isset($errorMsg)){ ?>
                  <div class="row col-sm-12">
                    <div class="alert alert-danger">
                      <span><?php echo $errorMsg ?></span>
                    </div>
                  </div>
                <?php }
              ?>
              <div class="form-group">
                <label class="control-label col-sm-2" for="username">Username :</label>
                <div class="col-sm-5">
                  <input type="hidden" name="username" value="<?php  echo $Username ?>">
                  <input type="text" class="form-control" name="name" maxlength="10" value="<?php  echo $Username ?>" disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="firstname">First Name :</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="firstname" maxlength="64" value="<?php echo $result['firstName'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="lastname">Last Name :</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="lastname" maxlength="64" value="<?php echo $result['lastName'] ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="email">E-mail :</label>
                <div class="col-sm-5">
                  <input type="email" class="form-control" name="email" value="<?php echo $result['email'] ?>">
                </div>
              </div>
              <!--<div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Password:</label>
                <div class="col-sm-5">          
                  <input type="password" class="form-control" name="pwd">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="confirmpwd">Re-Password:</label>
                <div class="col-sm-5">          
                  <input type="password" class="form-control" name="confirmpwd">
                </div>
              </div>-->

              <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" name="submit" class="btn btn-default">Save changes</button>
                </div>
              </div>
              <br>
            </form>

        </div>
      </div>

    </div>
  </div>

</div>
</body>
</html>
