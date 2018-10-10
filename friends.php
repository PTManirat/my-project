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
		.friendBox{
			background-color: #f7f4f4;
			width: 45%;
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
			margin-right: 40px;
		}
		#red{
			background: #F9777A;
			color: #fff;
		}
	</style>

</head>
<body>
	<?php
	include("header.php");
	include("mydb.php");
	include("function.php");

		$frnd_query = mysql_query("SELECT * FROM friends WHERE user_one = '$my_id' OR user_two = '$my_id' ");
	?>
	
	<div class="friendBox">
		<h2>Friends</h2>
		<div class="frnd_list">
			<table>
				<?php
					while ($result = mysql_fetch_array($frnd_query)) {
						if($result['user_one'] == $my_id){ 
							$x = $result['user_two'];
							$frnd_user = getUsername($x,'username'); ?>
							<tr>
								<td><img src="pic/user-512.png"></td>
								<td><p><?php echo $frnd_user ?></p></td>
								<td><a href="actionAllRequest.php?action=unfrnd&user_id=<?php echo $x ?>" class="box" id="red" onclick="return confirm('Are you sure to delete this select?');">Unfriend</a></td>
							</tr>
						<?php }
						else{ 
							$x = $result['user_one'];
							$frnd_user = getUsername($x,'username'); ?>
							<tr>
								<td><img src="pic/user-512.png"></td>
								<td><p><?php echo $frnd_user ?></p></td>
								<td><a href="actionAllRequest.php?action=unfrnd&user_id=<?php echo $x ?>" class="box" id="red">Unfriend</a></td>
							</tr>
						<?php }
					}
				?>
				
			</table>
		</div>
	</div>

	</div>
</body>
</html>