<?php 
function phoneNOValid($phoneNO){
	$phoneNO = cleanPhoneNo($phoneNO);
	return strlen($phoneNO) == 10;
}
function cleanInput($input){
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}
function cleanPhoneNo($input){
	return preg_replace('/\D+/', '', cleanInput($input));
	echo $input;
}
?>