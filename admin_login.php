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
	<title>Admin Login</title>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<form action="admin_tasks.php" method="post" id="adminlogin_screen">
		<tr>
			<td align="right">
				Adminname<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="adminname" id="adminname">
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
