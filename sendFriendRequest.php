<?php
	include("mydb.php");
	session_start();
	$Username = $_SESSION['user'];
	$my_id = $_SESSION['my_id'];
	
	if(!isset($_SESSION['user'])){
		header("location:page1.php");
		exit();
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
		.addFriendBox{
			background-color: #f7f4f4;
			width: 40%;
			margin: 30px auto; /*top,bottom and right,left*/
			padding-bottom: 20px;
			border-radius: 5px;
		}
		h2.page-header,form{
			padding-top: 15px;
			padding-left: 20px;
		}
		h3{
			margin-bottom: 15px;
		}
		.frame{
			padding: 30px;
			display: none;
		}
		.box{
			padding: 8px 20px;
			border-radius: 5px;
			margin: 10px 0px;
			text-decoration: none;
		}
		#blue{
			background: #7EA7D8;
			color: #fff;
		}
		#green{
			background: #82CA9D;
			color: #fff;
		}
		#white{
			background: #fff;
			color: #000;
			border-style: ridge;
			border-width: 1px;
			border-color: #b9b9b9;
		}
		#red{
			background: #F9777A;
			color: #fff;
		}
		img{
			width: 20%;
			height: 20%;	
		}
		button.btn-primary{
			width: 80px;
		}
	</style>

</head>
<body>
	<?php
	include("header.php");
	?>

	<div class="addFriendBox">
		<h2 class="page-header">Add Friend</h2>
		<form name="searchNameFriend" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
			<div class="input-group col-lg-10">
				<input type="text" name="name_friend" class="form-control" placeholder="Please enter username" autocomplete="off" required>
				<div class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
				</div>
			</div>
		</form>
		
	<?php
	include("mydb.php");
	include("function.php");

		if(isset($_POST['name_friend']) || isset($_GET['name_friend']) || isset($_GET['user_id'])){

			if(isset($_POST['name_friend'])){
				$frn_name = $_POST['name_friend'];
				$user_id = getID($frn_name,'Id');
			}

			if(isset($_GET['name_friend'])){
				$user_id = $_GET['name_friend'];
				$frn_name = getUsername($user_id,'username');
			}

			if(isset($_GET['user_id'])){
				$user_id = $_GET['user_id'];
				$frn_name = getUsername($user_id,'username');
			}

			if($my_id != $user_id){
				if($user_id != 0){
					$check_frnd_qurey = mysql_query("SELECT Id FROM friends WHERE (user_one='$my_id' AND user_two='$user_id') OR (user_one='$user_id' AND user_two='$my_id') ");
					if(mysql_num_rows($check_frnd_qurey) == 1){ ?>
						<div class="frame" style="display: block;">
							<center><img src="pic/user-512.png">
							<h3><?php echo $frn_name ?></h3>
							<a href="sendFriendRequest.php" class="box" id="blue">Already Friend</a>
							</center>
						</div>
					<?php }
					else{
						$from_query = mysql_query("SELECT Id FROM friend_request WHERE fromID = '$user_id' AND toID = '$my_id' ");
						$to_query = mysql_query("SELECT Id FROM friend_request WHERE fromID = '$my_id' AND toID = '$user_id' ");
						if(mysql_num_rows($from_query) == 1){ ?>
							<div class="frame" style="display: block;">
								<center><img src="pic/user-512.png">
								<h3><?php echo $frn_name ?></h3>
								<a href="actionAllRequest.php?action=accept1&user_id=<?php echo $user_id ?>" class="box" id="green">Accept</a>
								<a href="actionAllRequest.php?action=ignore1&user_id=<?php echo $user_id ?>" class="box" id="white">Ignore</a>
							</center>
						</div>
						<?php }
						else if(mysql_num_rows($to_query) == 1){ ?>
							<div class="frame" style="display: block;">
								<center><img src="pic/user-512.png">
								<h3><?php echo $frn_name ?></h3>
								<a href="actionAllRequest.php?action=cancel&user_id=<?php echo $user_id ?>" class="box" id="red">Cancel Request</a> 
								</center>
							</div>
						<?php }
						else{ ?>
							<div class="frame" style="display: block;">
								<center><img src="pic/user-512.png">
								<h3><?php echo $frn_name ?></h3>
								<a href="actionAllRequest.php?action=send&user_id=<?php echo $user_id ?>" class="box" id="green">Send Friend Request</a> 
								</center>
							</div>
						<?php }
					}
				}
				else{ ?>
					<div class="frame" style="display: block;">
						<center><img src="pic/user-512.png">
						<h3>User not found.</h3>
						<a href="sendFriendRequest.php" class="box" id="blue">OK</a>
						</center>
					</div>
				<?php }
			}
			else{ ?>
				<div class="frame" style="display: block;">
					<center><img src="pic/user-512.png">
					<h3><?php echo $frn_name ?></h3>
					<h5 style="margin-bottom: 20px;">You cannot add yourself as a friend.</h5>
					<a href="sendFriendRequest.php" class="box" id="blue">OK</a>
					</center>
				</div>
			<?php }
		}

	?>
	</div>

	</div>
</body>
</html>