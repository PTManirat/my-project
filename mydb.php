<?php
	$host = "localhost";
	$username = "root";
	$password = "4624631993";
	$db_name = "mydb";

	 	$conn = mysql_connect($host,$username,$password) or die ("Connection failed");
	 	mysql_select_db($db_name,$conn);
	 	mysql_query("SET NAMES UTF-8");

	/*$host = "localhost";
	$username = "root";
	$password = "4624631993";
	$db_name = "mydb";

	try{
   		$conn = new PDO ("mysql:host=$host;dbname=$db_name",$username,$password);
   		echo "Connected to Database";
	}
	catch (PDOException $e){
 		echo $e->getMessage();
	}*/
	
?>