<?php
	include("mydb.php");
	session_start();
	$Username = $_SESSION['user'];

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
	</style>
</head>
<body>
		<?php
		include("header.php");
		?>		
		<div id="number-of-album">
			<div class="col-lg-12">
				<h1 class="page-header" style="padding-left: 20px;">Album</h1>
			</div>
		
			<div class="col-lg-4">
				<div class="panel panel-info">
					<div class="panel-heading">
							<div class="row">
								<div class="col-lg-6">
									<center><i class="material-icons" style="font-size: 56px; color: black;">collections</i></center>
								</div>
								<div class="col-lg-6 text-center"  style="color: black;font-size: 25px;">
									<div class="numbers-of-album">
										<?php
											include "mydb.php";
											$result = mysql_query("SELECT COUNT(album_id) as total FROM album WHERE username = '$Username'");
											$data = mysql_fetch_assoc($result);
											echo $data['total'];
											mysql_close($conn);
										?>	
									</div>
									<div>Albums</div>
								</div>
							</div>
						</div>
						<a href="view_album.php">
							<div class="panel-footer" style="color: black;font-size: 16px;padding-left: 60px;">
								<span><strong>View Albums</strong></span>
								<div class="clearfix"></div>
							</div>
						</a>
					</div>
				</div>
		
		</div>
		</div>
</body>
</html>