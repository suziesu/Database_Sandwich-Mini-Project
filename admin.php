
<!DOCTYPE html>
<html>
<head>
<link href="/Sandwich/assets/css/search.css" rel="stylesheet" />
<?php include "includes/head.php"; 
require_once("includes/config.php");
include "includes/header.php"; 
?>
	<title>Amin Sandwich Order List</title>
</head>
<body>
<h1><center>Admin Sandwich Order List</center></h1>

<div id="Searchtable" class="CSSTableGenerator">

<!-- <form action="editstatus.php" method='POST'> -->

<table border='1'>
<tr>
		<td>Phone</td>
		<td>Sandwich</td>
		<td>Size</td>
		<td>Order_Time</td>
		<td>Quantity</td>
		<td>Status</td>
		<td>Edit</td>
	<!-- <tbody> -->
		
	</tr>
<?php  
if($_SERVER['REQUEST_METHOD']=='GET'){

	
	if(isset($_GET['pendingorder'])){
		$status="pending";
		if($pending = $mysqli->prepare("select * from orders where status=? order by o_time")){
			$pending->bind_param('s', $status);
			$pending->execute();
			$pending->bind_result($a_phone,$a_sname,$a_size,$a_o_time,$a_quantity,$a_status);

			while($pending->fetch()){
				echo "<tr>";
				echo "<td>$a_phone</td><td>$a_sname</td><td>$a_size</td><td>$a_o_time</td><td>$a_quantity</td><td>$a_status</td><td><a href='editstatus.php/?phone=$a_phone&sname=$a_sname&size=$a_size&o_time=$a_o_time'>Edit</a></td>";
				echo "</tr>";
			}
			$pending->close();
		}
		$mysqli->close();

	}else{
		if($allorder = $mysqli->prepare("select * from orders order by o_time ")){
			$allorder->execute();
			$allorder->bind_result($a_phone,$a_sname,$a_size,$a_o_time,$a_quantity,$a_status);

			while($allorder->fetch()){
				echo "<tr>";
				echo "<td>$a_phone</td><td>$a_sname</td><td>$a_size</td><td>$a_o_time</td><td>$a_quantity</td><td>$a_status</td><td><a href='editstatus.php/?phone=$a_phone&sname=$a_sname&size=$a_size&o_time=$a_o_time'>Edit</a></td>";
				echo "</tr>";
			}
			$allorder->close();
		}
	}
}
//show all order

?>

<!-- </tbody> -->
</table>
<center>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='GET'>
<input class="SubmitButton" type="submit" name='pendingorder' value="Pending Order">
</form>
<input type='button' class="SubmitButton" name='changestatus' value='Change Status'>
<!-- </form> -->
</center>
</div>
</body>
</html>
