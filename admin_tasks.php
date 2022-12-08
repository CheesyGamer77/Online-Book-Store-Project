<?php
	if (isset($_POST['login'])) {
		require_once 'lib/common.php';

		$conn = db_connect();
		session_start();

		//grab and set variables
		$username = mysqli_real_escape_string($conn, $_POST["adminname"]);
		$pin = mysqli_real_escape_string($conn, $_POST["pin"]);

		// query for any customer with the given username
		$sql = "SELECT * FROM Admin WHERE Username='$username' AND PIN='$pin';"; 
		$result = $conn->query($sql);

		// grabbing the result from the DB
		echo "Getting result";
		if(mysqli_num_rows($result) > 0 ){
			$_SESSION["admin"] = $username;
			echo "Admin Username: $username";
			echo "Admin Variable: " . $_SESSION['admin'];
			//header("Location: admin_tasks.php");
			exit;
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>ADMIN TASKS</title>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<!---
		<tr>
			<form action="manage_bookstorecatalog.php" method="post" id="catalog">
			<td align="center">
				<input type="submit" name="bookstore_catalog" id="bookstore_catalog" value="Manage Bookstore Catalog" style="width:200px;">
			</td>
			</form>
		</tr>
		<tr>
			<form action=" " method="post" id="orders">
			<td align="center">
				<input type="submit" name="place_orders" id="place_orders" value="Place Orders" style="width:200px;">
			</td>
			</form>
		</tr>
		--->
		<tr>
			<form action="reports.php" method="post" id="reports">
			<td align="center">
				<input type="submit" name="gen_reports" id="gen_reports" value="Generate Reports" style="width:200px;">
			</td>
			</form>
		</tr>
		<!---
		<tr>
			<form action="update_adminprofile.php" method="post" id="update">
			<td align="center">
				<input type="submit" name="update_profile" id="update_profile" value="Update Admin Profile" style="width:200px;">
			</td>
			</form>
		</tr>
		--->
		<tr>
		<td>&nbsp</td>
		</tr>
		<tr>
			<form action="index.php" method="post" id="exit">
			<td align="center">
				<input type="submit" name="cancel" id="cancel" value="EXIT 3-B.com[Admin]" style="width:200px;">
			</td>
			</form>
		</tr>
	</table>
</body>
</html>
