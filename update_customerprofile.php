<?php
	require_once 'lib/common.php';
	$conn = db_connect();
	//if a user that isn't logged in has somehow gotten here, send them to the login page
	session_start();
	if(!isset($_SESSION['username'])) {
		header("Location: user_login.php");
		exit;			
	}
	else
		$username = $_SESSION["username"];


	//grab all customer data, throw it into an assoc array
	$sql = "
	SELECT * 
	FROM Customer 
	NATURAL JOIN CreditCard 
	WHERE Username='$username'";
	$res = $conn->query($sql);
	$customer = mysqli_fetch_assoc($res);
	mysqli_free_result($res);

	if (isset($_POST['update_submit'])) {
		// use escape strings for inserting data
		$pin = mysqli_real_escape_string($conn, $_POST['new_pin']);
		$retypePin = mysqli_real_escape_string($conn, $_POST['retypenew_pin']);
		$firstName = mysqli_real_escape_string($conn, $_POST['firstname']);
		$lastName = mysqli_real_escape_string($conn, $_POST['lastname']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);
		$city = mysqli_real_escape_string($conn, $_POST['city']);
		$state = mysqli_real_escape_string($conn, $_POST['state']);
		$zip = mysqli_real_escape_string($conn, $_POST['zip']);
		$ccType = mysqli_real_escape_string($conn, $_POST['credit_card']);
		$ccNumber = mysqli_real_escape_string($conn, $_POST['card_number']);
		$ccExpiration = mysqli_real_escape_string($conn, $_POST['expiration_date']);

		if ($pin != $retypePin) {
			die("Failed to verify PIN");
		}

		//update the customer first
		$sql = "
		UPDATE Customer
		SET 
		PIN = '$pin',
		FName = '$firstName',
		LName = '$lastName',
		Address = '$address',
		City = '$city',
		State = '$state',
		Zip = '$zip',
		CardNo = '$ccNumber'
		WHERE Username='$username'"; 
		db_query($conn, $sql);

		//then update the card
		$sql = "
		UPDATE CreditCard
		SET
		CardNo = '$ccNumber',
		CardType = '$ccType',
		ExpDate = '$ccExpiration'
		WHERE CardNo = '$ccNumber'";
		db_query($conn, $sql);
	}


	db_close($conn);

?>

<!DOCTYPE HTML>
<html>
<script>alert('Please enter all values')</script><!DOCTYPE HTML>
<head>
	<title>UPDATE CUSTOMER PROFILE</title>
</head>
<body>
	<form id="update_profile" action="confirm_order.php" method="post">
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td align="right">
				Username: <?php echo($username) ?>
			</td>
			<td colspan="3" align="center">
							</td>
		</tr>
		<tr>
			<td align="right">
				PIN<span style="color:red"></span>:
			</td>
			<td>
				<input type="text" id="new_pin" name="new_pin" value = <?php echo $customer["PIN"]?>>
			</td>
			<td align="right">
				Re-type PIN<span style="color:red"></span>:
			</td>
			<td>
				<input type="text" id="retypenew_pin" name="retypenew_pin">
			</td>
		</tr>
		<tr>
			<td align="right">
				First Name<span style="color:red"></span>:
			</td>
			<td colspan="3">
				<input type="text" id="firstname" name="firstname" value = <?php echo $customer["FName"]?>>
			</td>
		</tr>
		<tr>
			<td align="right"> 
				Last Name<span style="color:red"></span>:
			</td>
			<td colspan="3">
				<input type="text" id="lastname" name="lastname" value = <?php echo $customer["LName"]?>>
			</td>
		</tr>
		<tr>
			<td align="right">
				Address<span style="color:red"></span>:
			</td>
			<td colspan="3">
				<input type="text" id="address" name="address" value = <?php echo $customer["Address"]?>>
			</td>
		</tr>
		<tr>
			<td align="right">
				City<span style="color:red"></span>:
			</td>
			<td colspan="3">
				<input type="text" id="city" name="city" value = <?php echo $customer["City"]?>>
			</td>
		</tr>
		<tr>
			<td align="right">
				State<span style="color:red"></span>:
			</td>
			<td>
				<select id="state" name="state">
				<option selected><?php echo $customer["State"]?></option>
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District Of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select>
				</select>
			</td>
			<td align="right">
				Zip<span style="color:red"></span>:
			</td>
			<td>
				<input type="text" id="zip" name="zip" value = <?php echo $customer["Zip"]?>>
			</td>
		</tr>
		<tr>
			<td align="right">
				Credit Card<span style="color:red"></span>:
			</td>
			<td>
				<select id="credit_card" name="credit_card">
				<option selected><?php echo $customer["CardType"]?></option>
				<option>VISA</option>
				<option>MASTER</option>
				<option>DISCOVER</option>
				</select>
			</td>
			<td align="left" colspan="2">
				<input type="text" id="card_number" name="card_number" value = <?php echo $customer["CardNo"]?>>
			</td>
		</tr>
		<tr>
			<td align="right" colspan="2">
				Expiration Date<span style="color:red"></span>:
			</td>
			<td colspan="2" align="left">
				<input type="text" id="expiration_date" name="expiration_date" value = <?php echo $customer["ExpDate"]?>>
			</td>
		</tr>
		<tr>
			<td align="right" colspan="2">
				<input type="submit" id="update_submit" name="update_submit" value="Update">
			</td>
			</form>
				<form id="cancel" action="confirm_order.php" method="post">	
					<td align="left" colspan="2">
						<input type="submit" id="cancel_submit" name="cancel_submit" value="Cancel">
					</td>
		</tr>
	</table>
	</form>
</body>
</html>
