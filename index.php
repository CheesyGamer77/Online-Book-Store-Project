<?php
	session_start();
	
	if(isset($_SESSION['username'])) {
		unset($_SESSION['username']);
	}

	if(isset($_SESSION['cart'])) {
		unset($_SESSION['cart']);
	}

	if(isset($_SESSION['admin'])) {
		unset($_SESSION['admin']);
	}
?>

<!DOCTYPE HTML>
<html>
<head>
	<!-- Figure 1: Welcome Screen by Alexander -->
	<title>Welcome to Best Book Buy Online Bookstore!</title>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
	<tr><td><h2>Best Book Buy (3-B.com)</h2></td></tr>
	<tr><td><h4>Online Bookstore</h4></td></tr>
	<tr><td><form action="" method="post">
		<input type="radio" name="group1" value="SearchCat.php" onclick="document.location.href='screen2.php'">Search Online<br/>
		<input type="radio" name="group1" value="customer_registration.php" onclick="document.location.href='customer_registration.php'">New Customer<br/>
		<input type="radio" name="group1" value="user_login.php" onclick="document.location.href='user_login.php'">Returning Customer<br/>
		<input type="radio" name="group1" value="admin_login.php" onclick="document.location.href='admin_login.php'">Administrator<br/>
		<input type="submit" name="submit" value="ENTER">
	</form></td></tr>
	</table>
</body>
</html>
