<?php
	session_start();
	session_destroy();
	header("location:page1.php");
	exit();
	mysql_close($conn);
?>