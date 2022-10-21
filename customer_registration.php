<?php
	if (isset($_POST['register_submit'])) {
		// FIXME: Don't ever do this with passwords. Ever.
		$conn = mysqli_connect('localhost', 'frontend', '8sDAe2+2$pX2-+s', 'BBB');
		if (!$conn) {
			echo "<script>alert('Failed to connect to database: " . mysqli_connect_error() . "');</script>";
			die();
		}

		// use escape strings for inserting data
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$pin = mysqli_real_escape_string($conn, $_POST['pin']);
		$retypePin = mysqli_real_escape_string($conn, $_POST['retype_pin']);
		$firstName = mysqli_real_escape_string($conn, $_POST['firstname']);
		$lastName = mysqli_real_escape_string($conn, $_POST['firstname']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);
		$city = mysqli_real_escape_string($conn, $_POST['city']);
		$state = mysqli_real_escape_string($conn, $_POST['state']);
		$zip = mysqli_real_escape_string($conn, $_POST['zip']);
		$ccType = mysqli_real_escape_string($conn, $_POST['credit_card']);
		$ccNumber = mysqli_real_escape_string($conn, $_POST['card_number']);
		$ccExpiration = mysqli_real_escape_string($conn, $_POST['expiration']);

		// FIXME: No validation for PIN		

		// insert credit card data
		// FIXME: Violates GDPR regulations on encrypting PII
		$sql = "INSERT INTO CreditCard(cardNumber, type, expiration) VALUES ('$ccNumber', '$ccType', '$ccExpiration');";
		if (!mysqli_query($conn, $sql)) {
			echo "Failed to insert credit card data " . mysqli_error($conn);
			die();
		}

		// insert the rest of the user data
		// FIXME: Violates GDPR regulations on encrypting PII
		$sql = "INSERT INTO Customer(userName, pin, fName, lName, address, city, state, zip, creditCardNumber) VALUES ('$username', '$pin', '$firstName', '$lastName', '$address', '$city', '$state', '$zip', '$ccNumber');";
		if (!mysqli_query($conn, $sql)) {
			echo "Failed to insert user data " . mysqli_error($conn);
			die();
		}
	}
?>

<!DOCTYPE HTML>
<html>
<script>alert('Please enter all values')</script><!-- UI: Prithviraj Narahari, php code: Alexander Martens -->
<head>
	<title> CUSTOMER REGISTRATION </title>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<tr>
			<form id="register" action="" method="post">
			<td align="right">
				Username<span style="color:red">*</span>:
			</td>
			<td align="left" colspan="3">
				<input type="text" id="username" name="username" placeholder="Enter your username">
			</td>
		</tr>
		<tr>
			<td align="right">
				PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" id="pin" name="pin">
			</td>
			<td align="right">
				Re-type PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" id="retype_pin" name="retype_pin">
			</td>
		</tr>
		<tr>
			<td align="right">
				Firstname<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="firstname" name="firstname" placeholder="Enter your firstname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Lastname<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="lastname" name="lastname" placeholder="Enter your lastname">
			</td>
		</tr>
		<tr>
			<td align="right">
				Address<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="address" name="address">
			</td>
		</tr>
		<tr>
			<td align="right">
				City<span style="color:red">*</span>:
			</td>
			<td colspan="3" align="left">
				<input type="text" id="city" name="city">
			</td>
		</tr>
		<tr>
			<td align="right">
				State<span style="color:red">*</span>:
			</td>
			<td align="left">
				<select id="state" name="state">
				<option selected disabled>select a state</option>
				<option>Michigan</option>
				<option>California</option>
				<option>Tennessee</option>
				</select>
			</td>
			<td align="right">
				Zip<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" id="zip" name="zip">
			</td>
		</tr>
		<tr>
			<td align="right">
				Credit Card<span style="color:red">*</span>
			</td>
			<td align="left">
				<select id="credit_card" name="credit_card">
				<option selected disabled>select a card type</option>
				<option>VISA</option>
				<option>MASTER</option>
				<option>DISCOVER</option>
				</select>
			</td>
			<td colspan="2" align="left">
				<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				Expiration Date<span style="color:red">*</span>:
			</td>
			<td colspan="2" align="left">
				<input type="text" id="expiration" name="expiration" placeholder="MM/YY">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"> 
				<input type="submit" id="register_submit" name="register_submit" value="Register">
			</td>
			</form>
			<form id="no_registration" action="index.php" method="post">
			<td colspan="2" align="center">
				<input type="submit" id="donotregister" name="donotregister" value="Don't Register">
			</td>
			</form>
		</tr>
	</table>
</body>
</html>
