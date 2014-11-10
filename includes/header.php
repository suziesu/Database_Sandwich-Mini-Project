<header> 
<ul id='menu'>
<li><a href='/Sandwich/index.php'>Search Home</a></li>
<li><a href='/Sandwich/searchresult.php'>Sandwich List</a></li>
<li><a href='/Sandwich/order.php'>Order List</a></li>
<li><a href='/Sandwich/admin.php'>Admin</a></li>


<?php 

require_once("includes/config.php");
if(isset($_SESSION['phoneNO']) ){
	echo "<li><a href='order.php'>".$_SESSION['phoneNO']."</a></li>";
}
?> 
</ul>
