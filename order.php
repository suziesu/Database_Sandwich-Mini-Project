
<!DOCTYPE html>
<html>
<head>
<link href="/Sandwich/assets/css/search.css" rel="stylesheet" />
<?php include "includes/head.php"; 
require_once("includes/config.php");
$userInfo=$msg="";
include "includes/header.php"; 
?>
	<title>Sandwich Order List</title>
</head>
<body>
<h1><center>Sandwich Order List</center></h1>
<span><?php echo $userInfo; ?></span>
<span class='error'><?php echo $msg; ?></span>

<form id='Searchtable'>
<div class="CSSTableGenerator">
<table border='1' id="searchtable">
<tr>
		<td>Sandwich</td>
		<td>Size</td>
		<td>Order_Time</td>
		<td>Quantity</td>
		<td>Status</td>
</tr>
	<!-- <tbody> -->
		
	
<?php  
//cannot get user phoneNO return to index page

if(!isset($_SESSION['phoneNO'])){
	$userInfo = "You did not enter your phone number <br>You will be returned to home page in 3 seconds";
	header("refresh:3, index.php");
// user is not insert into the db. return to set address page
}else if(!$_SESSION['userInDB']){
	$userInfo = "You still are not in DB enter your address to try again";
	header("refresh:3, userinfo.php");
}else{
	$phoneNO = $_SESSION['phoneNO'];
	echo "<center><span>Customer:<img src='assets/img/Tomato.png'><img src='assets/img/Tomato.png'><img src='assets/img/Tomato.png'>  $phoneNO</span></center>";
	//user is already in DB with address info.
	
	$userInfo = "User:".$phoneNO;
	if(isset($_SESSION['sandwichItem'])){
		$orderItems = $_SESSION['sandwichItem'];//array [ss|ss,ss|ss]

		$date = date("Y-m-d h:i:sa");
		$statusPending = "pending";
		$one = 1;
		//inser order into order table one by one:
		foreach($orderItems as $item ){
			$item = explode('|', $item);
			// echo $item[0];
			// echo $item[1];
			//first search if the item in order with pending
			if($searchPendingOrder = $mysqli->prepare("select * from orders where phone=? and sname=? and size=? and status=?")){
				
				$searchPendingOrder->bind_param('ssss',$phoneNO,$item[0],$item[1],$statusPending);
				$searchPendingOrder->execute();
				$searchPendingOrder->bind_result($phone,$sname,$size,$o_time,$quantity,$status);
				if($searchPendingOrder->fetch()){
					$searchPendingOrder->close();

					// if the item is in order with pending update
					if($orderPending= $mysqli->prepare("update orders set quantity=?, o_time=? where phone=? and sname=? and size=? and status=? ")){
						$quantity = $quantity +1;
						$orderPending->bind_param('isssss', $quantity, $date, $phoneNO,$item[0],$item[1],$statusPending);
						$orderPending->execute();
						if($orderPending->errno){
							echo $orderPending->errno;
							echo $orderPending->error;
						}
						else{
							echo "Update successfull";
						}
						$orderPending->close();
					}
				}else{
					
					//if there is no such order insert
					if($insertItem = $mysqli->prepare("insert into orders(phone,sname,size,o_time,quantity,status) values(?,?,?,?,?,?)")){
						$insertItem->bind_param('ssssis', $phoneNO,$item[0],$item[1],$date,$one,$statusPending);
						$insertItem->execute();
						// if($insertItem->errno){
						// 	echo $insertItem->errno;
						// 	echo $insertItem->error;
						// 	echo "Update Address Fail, Please try again!";
						// }
						// else{
						// 	echo "Update successfull";
						// 	header("refresh:3, order.php");
						// }
						$insertItem->close();

					}
				}
				// $searchPendingOrder->close();
				// check if there is order item has same size,kind pending update the order and plus one quantity
				
			}
		}	
		//after insert order item seesion will destroy.
		unset($_SESSION['sandwichItem']);
		//select the pending order item if size or others equal change quantity and o_date;

	}else{
		$msg = "you have not ordered, below are the history order!<br>click <button><a href='index.php'>return to search</a></button> ";
		
	}
	//show all order
	if($allorder = $mysqli->prepare("select * from orders where phone = ? ")){
		$allorder->bind_param('s',$phoneNO);
		$allorder->execute();
		$allorder->bind_result($a_phone,$a_sname,$a_size,$a_o_time,$a_quantity,$a_status);

		while($allorder->fetch()){
			echo "<tr>";
			echo "<td>$a_sname</td><td>$a_size</td><td>$a_o_time</td><td>$a_quantity</td><td>$a_status</td>";
			echo "</tr>";
		}
		$allorder->close();
	}
	$mysqli->close();


}	


?>
<!-- </tbody> -->
</table>
</div>
</form>
</body>
</html>
