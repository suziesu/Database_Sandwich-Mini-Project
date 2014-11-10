<!DOCTYPE html>
<html>
<head>
<link href="assets/css/style.css" rel="stylesheet" />
<?php include "includes/head.php"; 
require_once("includes/config.php");
include "function.php";
include "includes/header.php"; 

$phoneNO = "";
$phoneERR="";
?>
	<title>SandWich</title>
</head>
<body>

<?php 
//check if the form is submiit as  POSt
if($_SERVER['REQUEST_METHOD']=='POST'){
	//if the user is already in the website, get the keyword and redirect to search result;
	if(isset($_SESSION['phoneNO'])){
		$keyword = $_POST['keyword'];
		header("location: searchresult.php/?keyword=$keyword");
	}else{
		//if the user is not visited before check the input phonenumber 
		if(isset($_POST['phoneNO']) && $_POST['phoneNO']!=""){
			// if user enter the phone number store them to show in input box for user friendly.
			$phoneNO = $_POST['phoneNO'];
			//if valid redirect to search phpwith keyword

			if(phoneNOValid($_POST['phoneNO'])){
				$phoneNO=cleanPhoneNo($_POST['phoneNO']);
				$_SESSION['phoneNO'] = $phoneNO;
				$keyword = $_POST['keyword'];
				header("location: searchresult.php/?keyword=$keyword");
			//if not valid stay in this page and retry
			}else{
				$phoneERR = "Phone Numner is wrong, please retry it with 10 digit";
			}
		// if the phone number is empty
		}else{
			$phoneERR = "*"."Please enter your phonenumber!";
		} 
	}
}


?>
<h1><center>Sanwich Order</center></h1>
<form id="login-register" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
	<center><h1>Search Sanwich</h1></center>
	<span class="error" ><?php echo $phoneERR; ?></span>
	
	<!-- <span>Phone Number</span> -->
	<?php
	
	if(isset($_SESSION['phoneNO'])){
		$phoneNO = $_SESSION['phoneNO'];
		echo "<center><span>Customer:<img src='assets/img/Tomato.png'><img src='assets/img/Tomato.png'><img src='assets/img/Tomato.png'>  $phoneNO</span></center>";
	}else{
		echo "<input type='text' name='phoneNO' value='". htmlentities($phoneNO)."' placeholder='Phone Number (10 Digit)'>";
	} 
	?>


	<h2><!-- KEY WORD  --><span>(no idea? just click "search")</span></h2>
	<input type='text' name='keyword' value='' placeholder='Search like delicious, turkey'>
	<center><input class='login_button' type='submit' value="Search"></center>


</form>
</body>
</html>