<!DOCTYPE html>
<html>
<head>
<link href="/Sandwich/assets/css/search.css" rel="stylesheet" />
<link href="/Sandwich/assets/css/menu.css" rel="stylesheet" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="assets/css/menu.css" rel="stylesheet" />
<meta name="description" content="">
<!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet"> -->

	<!-- The main CSS file -->
<!-- /*<style type="text/css">.error {color:#FF0000;}</style>*/ -->

<?php 
include "includes/header.php"; 

require_once("includes/config.php");

?>
	<title>Sandwich Search</title>
</head>
<body>
<h1><center>Sanwich Search</center></h1>
<form id="Searchtable" action='searchresult.php' method='POST'>
<div class="CSSTableGenerator">
<table id="searchtable" align="center" border='2'>
	<tr>
	<td>Sanwich</td>
	<td>Descirption</td>
	<td>Size</td>
	<td>Price</td>
	</tr>

<?php

if(!isset($_SESSION['phoneNO'])){
	echo "You did not enter your phone number";
	echo "you will be returned to home page in 3 seconds";
	header("refresh:3, /Sandwich/index.php");
}else if($_SERVER['REQUEST_METHOD']=='GET'){
	$phoneNO = $_SESSION['phoneNO'];

	echo "<center> <span>Customer:<img src='/Sandwich/assets/img/Tomato.png'><img src='/Sandwich/assets/img/Tomato.png'><img src='/Sandwich/assets/img/Tomato.png'> $phoneNO</span></center>";
	$countArray = array();
		// the keyward has input, search the keyword 
	if($sandwichcount = $mysqli->prepare("select sname, count(*) from sandwich natural join menu group by sname order by sname")){
		$sandwichcount->execute();
		$sandwichcount->bind_result($sname, $count);

		if(isset($_GET['keyword'])){
			$keyword = htmlspecialchars($_GET['keyword']);
			$sandwichcount->close();
			$keyword = '%'.$keyword.'%';
			if($sandwichcount = $mysqli->prepare("select sname,count(*) from sandwich natural join menu where description like ? group by sname order by sname")){
				$sandwichcount->bind_param('s',$keyword);
				$sandwichcount->execute();
				$sandwichcount->bind_result($sname,$count);
			}
		//if the keyword has no input then return all pizza;
		}
		
		while($sandwichcount->fetch()){
			$countArray[$sname] = $count;
		}
		$sandwichcount->close();
	}
	if($sandwich = $mysqli->prepare("select * from sandwich natural join menu order by sname, size")){
		$sandwich->execute();
		$sandwich->bind_result($sname, $description,$msize,$mprice);

		if(isset($_GET['keyword'])){
			$keyword = htmlspecialchars($_GET['keyword']);
			$sandwich->close();
			$keyword = '%'.$keyword.'%';
			if($sandwich = $mysqli->prepare("select * from sandwich natural join menu where description like ? order by sname, size")){
				$sandwich->bind_param('s',$keyword);
				$sandwich->execute();
				$sandwich->bind_result($sname,$description,$msize,$mprice);
			}
		//if the keyword has no input then return all pizza;
		}
		// $rowspan=1;
		$previousname="";
// 		echo "<form action='searchresult.php' method='POST'>
// <table border='2'>
// <thead>
// 	<th>Sanwich</th>
// 	<th>Descirption</th>
// 	<th>Size</th>
// 	<th>Price</th>
// </thead>
// <tbody>";
		while($sandwich->fetch()){
		//one kind of sandwich iterate
			
			$sname = htmlspecialchars($sname);
			$description = htmlspecialchars($description);
			$msize = htmlspecialchars($msize);
			$mprice = htmlspecialchars($mprice);
			$sandwichItem = $sname."|".$msize;
			echo "<tr>";

			if($previousname == $sname){
				// $rowspan += 1;
				
				echo "<td class='left'><input type='checkbox' name='sandwichItem[]' value='$sandwichItem'>$msize</td><td>$mprice</td>";
				
			}else {
				$rowspan = $countArray[$sname];
				echo "<td rowspan=$rowspan>$sname</td><td rowspan=$rowspan>$description</td><td class='left'><input type='checkbox' name='sandwichItem[]' value='$sandwichItem'>$msize</td><td>$mprice</td>";
			}
			$previousname = $sname;

			// echo "<td rowspan=$rowspan>$sname</td><td>$description</td><td><input type='checkbox' name='sandwichItem' value=''>$msize</td><td>$mprice</td>";

			//fetch all menu item from menu table for each sandwich item.
			// if($menu = $mysqli->prepare("select * from menu where sname = ?")){
			// 	$menu->bind_param('s',$sname);
			// 	$menu->execute();
			// 	$menu->bind_result($msname,$msize,$mprice);
			// 	//msize iterate
			// 	echo "<td>";
			// 	while($menu->fetch()){
			// 		$sandwichItem = array('sname' =>$msname ,'size'=>$msize);
			// 		echo "<ul style='list-style-type: none;'>";
			// 		echo "<li><input type='checkbox' name='sandwichItem' value='$sandwichItem'> $msize".": $"."$price</li>";
			// 		echo "</ul>";
			// 	}
			// 	echo "</td>";


				//price iterate
				// echo "<td>";
				// while($menu->fetch()){

				// 	echo "<ul style='list-style-type: none;'>";
				// 	<li><checkbox> $mprice</li>
				// 	echo "</ul>";
				// }
				// echo "</td>";
			// }
			echo "</tr>";
		}
		$sandwich->close();
		$mysqli->close();
	}
}else if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST["sandwichItem"])){
		echo "123";
		//set those item in session it will destroy in order list page
		$_SESSION['sandwichItem'] = $_POST["sandwichItem"];
	}
	header('location:/Sandwich/userinfo.php');
}


?>
	<tr>
		<td></td>
	</tr>

</table>
</div>
<center><input type="submit" class="SubmitButton" name="submit" value="Order"></center>


</form>
</body>
</html>