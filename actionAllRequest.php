<?php
	include("mydb.php");
	session_start();
	

	include("function.php");

	$action = $_GET['action'];
	$user_id = $_GET['user_id'];
	$my_id = $_SESSION['my_id'];
	
	if($action == 'send'){
		mysql_query("INSERT INTO friend_request VALUES('','$my_id','$user_id')");
		header('location: sendFriendRequest.php?user_id='.$user_id);
	}

	if($action == 'cancel'){
		mysql_query("DELETE FROM friend_request WHERE fromID = '$my_id' AND toID = '$user_id' ");
		header('location: sendFriendRequest.php?user_id='.$user_id);
	}

	if($action == 'accept1'){
		mysql_query("DELETE FROM friend_request WHERE fromID = '$user_id' AND toID = '$my_id' ");
		mysql_query("INSERT INTO friends VALUES ('','$user_id','$my_id') ");
		header('location: friends.php');
	}

	if($action == 'unfrnd'){
		mysql_query("DELETE FROM friends WHERE (user_one='$my_id' AND user_two='$user_id') OR (user_one='$user_id' AND user_two='$my_id')");
		header('location: friends.php');
	}

	if($action == 'ignore1'){
		mysql_query("DELETE FROM friend_request WHERE fromID = '$user_id' AND toID = '$my_id' ");
		header('location: sendFriendRequest.php?user_id='.$user_id);
	}

	if($action == 'ignore2'){
		mysql_query("DELETE FROM friend_request WHERE fromID = '$user_id' AND toID = '$my_id' ");
		header('location: friendRequest.php');
	}

	if($action == 'accept2'){
		mysql_query("DELETE FROM friend_request WHERE fromID = '$user_id' AND toID = '$my_id' ");
		mysql_query("INSERT INTO friends VALUES ('','$user_id','$my_id') ");
		header('location: friendRequest.php');
	}

?>