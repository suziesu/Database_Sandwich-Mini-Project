<!DOCTYPE html>
<html>
<head>
<link href="/Sandwich/assets/css/style.css" rel="stylesheet" />
<?php include "includes/head.php"; 
require_once("includes/config.php");
include "function.php";
include "includes/header.php"; 
?>
</head>
<body>
<!-- <div id="Searchtable" class="CSSTableGenerator"> -->
<form id="login-register" action='editstatus.php' method='POST'>
<input type="text" name="status" placeholder="Pending, Delivering, Complete">
<center><input class='login_button' type='submit' value="Change Status"></center>


<?php
$phone=$sname=$size=$o_time="";
if($_SERVER['REQUEST_METHOD']=='GET'){
	if($_GET['phone'] && $_GET['sname'] && $_GET['size'] && $_GET['o_time']){
		$phone=$_GET['phone'];
		$sname=$_GET['sname'];
		$size=$_GET['size'];
		$o_time=$_GET['o_time'];
		$statusinfo = $phone.'|'.$sname."|".$size."|".$o_time;
		echo "<input style='display:none' name='statusinfo' value='$statusinfo'>";
	}

}else{
	if(isset($_POST['status']) && isset($_POST['statusinfo'])){
		$status = cleanInput($_POST['status']);
		$status = strtolower($status);
		$statusinfo = explode("|", $_POST['statusinfo']);
		if($updatestatus= $mysqli->prepare("update orders set status=? where phone=? and sname=? and size=? and o_time=? ")){
			$updatestatus->bind_param('sssss',$status, $statusinfo[0],$statusinfo[1],$statusinfo[2],$statusinfo[3]);
			$updatestatus->execute();
			if($updatestatus->errno){
				echo "Update Address Fail, Please try again!";
			}
			else{
				echo "Update successfull";
				header("refresh:3; /Sandwich/admin.php");
			}
			$updatestatus->close();
		}
		$mysqli->close();
	}else{
		echo "no status input";
	}
	
}




 ?>
 </form>
 </div>
</body>
</html>