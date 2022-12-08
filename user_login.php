<?php
	session_start();

	if (isset($_POST['login'])) {
		require_once 'lib/common.php';

		$conn = db_connect();

		// grab and set variables
		$username = mysqli_real_escape_string($conn, $_POST["username"]);
		$pin = mysqli_real_escape_string($conn, $_POST["pin"]);

		// query for any customer with the given username
		$sql_query = "SELECT * FROM Customer WHERE Username='$username' AND PIN='$pin';"; 
		$result = $conn->query($sql_query);


		// grabbing the result from the DB
		if(mysqli_num_rows($result) > 0 ){
			$_SESSION["username"] = $_POST["username"];
			$_SESSION['cart'] = array();
			header("Location: screen2.php");
			exit;
		}
	}
?>

<!DOCTYPE HTML>
<head>
	<title>User Login</title>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<form method="post" id="login_screen">
		<tr>
			<td align="right">
				Username<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="username" id="username">
			</td>
			<td align="right">
				<input type="submit" name="login" id="login" value="Login">
			</td>
		</tr>
		<tr>
			<td align="right">
				PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" name="pin" id="pin">
			</td>
			</form>
			<form action="index.php" method="post" id="login_screen">
			<td align="right">
				<input type="submit" name="cancel" id="cancel" value="Cancel">
			</td>
			</form>
		</tr>
	</table>
</body>
</html>
