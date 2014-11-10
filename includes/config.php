<?php 
// define('DB_HOST','localhost');
// define('DB_USER','root');
// define('DB_PASSWORD','admin');
// define('DATABASE','HW3Sandwich');




// $connect = mysql_connect(DB_HOST, DB_USER,DB_PASSWORD) or die("Fail to connect to MySQL".mysql_error());
// @mysql_select_db($database) or die("DB not found");
$mysqli = new mysqli('localhost','root','','Sandwich');
if(mysqli_connect_errno()){
	printf("connect failed: %s\n",mysqli_connect_error());
	exit();
}
session_start();

if(isset($SESSION["REMOTE_ADDR"]) && $SESSION["REMOTE_ADDR"] != $SERVER["REMOTE_ADDR"]) {
  session_destroy();
  session_start();
}

?>