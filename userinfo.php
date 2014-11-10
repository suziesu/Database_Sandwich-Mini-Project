<!DOCTYPE html>
<html>
<head>

<?php include "includes/head.php"; 
require_once("includes/config.php");
include "includes/header.php"; 
?>
<link href="assets/css/userinfo.css" rel="stylesheet" />
	<title>Customer Info</title>
</head>
<body>
<h1><center>Customer Shipping Address</center></h1>
<form id="userinfo" action='userinfo.php' method='POST'>


<?php 
$ERR="";

$userPhoneNO = $building_num=$street=$apartment=$userInfo=""; 
//no user phone num info go to index
if(!isset($_SESSION['phoneNO'])){
	$userInfo = "You did not enter your phone number <br>You will be returned to home page in 3 seconds";
	header("refresh:3, index.php");
}else{
	
	$userPhoneNO = $_SESSION['phoneNO'];
	echo "<center><h1><span>Customer:<img src='assets/img/Tomato.png'><img src='assets/img/Tomato.png'><img src='assets/img/Tomato.png'>  $userPhoneNO</span></h1></center>";
	//check if the user is in DB, if it is them set those address info in inputbox.
	if($userPhone = $mysqli->prepare("select * from customer where phone = ? ")){
		$userPhone->bind_param('s',$userPhoneNO);
		$userPhone->execute();
		$userPhone->bind_result($phone,$building_num,$street,$apartment);
		if($userPhone->fetch()){
			$userInfo = "Is The Address Correct?<br> If not, change a new one";
			$_SESSION['userInDB'] = true;
		}else{
			//the user has not in DB
			// $userInfo = "You are not in our System. Type a address";
			$_SESSION['userInDB'] = false;
		}
		$userPhone->close();
	}
	// get the order item from searchresult page which user selected
	if(isset($_SESSION['sandwichItem'])){
		if($_SERVER['REQUEST_METHOD']=='POST'){
			if(!isset($_POST['building']) || !isset($_POST['street']) ||!isset($_POST['apartment'])){
				$ERR = "* Required Filed need to be entered;";
			}else{
				$building_num = (int)$_POST['building'];
				$street = $_POST['street'];
				$apartment = $_POST['apartment'];
				//if user is in DB just update the post address info
				if ($_SESSION['userInDB']){
					if($existUser = $mysqli->prepare("update customer set building_num=?,street=?,apartment=? where phone=? ")){
						$existUser->bind_param('isss',$building_num,$street,$apartment,$userPhoneNO);
						$existUser->execute();
						if($existUser->errno){
							$userInfo= "Update Address Fail, Please try again!";
						}
						else{
							$userInfo= "Update successfull";
							header("refresh:3, order.php");
						}
						$existUser->close();
					}
				// if user is not in DB , insert phonenumber and address info
				}else{
					if($insertUser = $mysqli->prepare("insert into customer(phone,building_num,street,apartment) values (?,?,?,?)")){
						$insertUser->bind_param("siss",$userPhoneNO,$building_num,$street,$apartment);
						$insertUser->execute();
						$insertUser->close();
						$userInfo= "Update successfull";
						$_SESSION['userInDB'] = true;
						header("location: order.php");
					}

				}
				$mysqli->close();
			}
		
		}
	}else{
		$userInfo= "you have not ordered, below are the history order! ";
		header('location:order.php');
	}
}
	
?>

<div><center><span id="userAddress"><?php echo $userInfo; ?></span></center>

<p id="userinfomsg"><?php echo $ERR; ?><br>* Required Field</p><br>

<h3>Building Number *</h3>
<input type="text" name="building" value='<?php echo $building_num; ?>' >

<h3>Street * </h3>
<input type="text" name="street" value='<?php echo $street; ?>'>

<h3>Apartment * </h3>
<input type="text" name="apartment" value='<?php echo $apartment; ?>' >
</div>
<center><input class="submitbutton" type="submit" name="submit" value="Submit Shipping Address" ></center>
</form>
</body>
</html>