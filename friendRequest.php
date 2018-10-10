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
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<style>
		html,body,h1,h2,h3,h4,h5,h6 {
		    font-family: "Roboto", sans-serif
		}
		body{
			background-color: /*#FDC167*/#FFBE7D;
		}
		.friendRequestBox{
			background-color: #f7f4f4;
			width: 40%;
			margin: 30px auto; /*top,bottom and right,left*/
			border-radius: 5px;
		}
		h2{
			padding-top: 15px;
			padding-left: 20px;
		}
		table{
			width: 100%;
		}
		tr{
			height: 80px;
			border: 1px solid #dddddd;
		}
		img{
			width: 20px;
			height: 20px;
			float: right;
		}
		p{
			font-size: 20px;
			padding-top: 15px;
			padding-left: 10px;
		}
		.box{
			padding: 8px 20px;
			border-radius: 5px;
			text-decoration: none;
			float: right;
			margin-right: 15px;
		}
		#white{
			background: #fff;
			color: #000;
			border-style: ridge;
			border-width: 1px;
			border-color: #b9b9b9;
		}
		#green{
			background: #82CA9D;
			color: #fff;
		}
	</style>

</head>
<body>
	<?php
	include("header.php");
	include("mydb.php");
	include("function.php");

		$from_query = mysql_query("SELECT * FROM friend_request WHERE toID = '$my_id' ");

	?>

	<div class="friendRequestBox">
		<h2>Friend Requests</h2>
		<div class="frnd_request">
			<table>
				<?php
 					while ($result = mysql_fetch_array($from_query)) {
 						$temp = $result['fromID'];
 						$frnd_user = getUsername($temp,'username'); ?>
 							<tr>
								<td><img src="pic/user-512.png"></td>
								<td><p><?php echo $frnd_user ?></p></td>
								<td><a href="actionAllRequest.php?action=ignore2&user_id=<?php echo $temp ?>" class="box" id="white">Ignore</a>
								<a href="actionAllRequest.php?action=accept2&user_id=<?php echo $temp ?>" class="box" id="green">Accept</a></td>
							</tr>
 					<?php }
				?>
			</table>
		</div>
	</div>

	</div>
</body>
</html>