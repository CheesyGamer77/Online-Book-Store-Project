<?php
	session_start();

	if(!isset($_SESSION["username"]) || !isset($_SESSION["cart"])) {
		header("Location: user_login.php");
		exit;
	}

	$username = $_SESSION["username"];

	require_once 'lib/common.php';
	
	$conn = db_connect();

	$sql = "SELECT * FROM Customer
		NATURAL JOIN (
			SELECT CardNo, CardType, MONTH(ExpDate) AS ExpMonth, YEAR(ExpDate) as ExpYear
			FROM CreditCard
		)CardData
		WHERE Username='$username'";
	$res = $conn->query($sql);

	$customer = mysqli_fetch_assoc($res);
	mysqli_free_result($res);

	db_close($conn);

	// compute subtotal
	$subtotal = 0;
	foreach ($_SESSION["cart"] as $book) {
		$subtotal += $book["price"] * $book["quantity"];
	}
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>CONFIRM ORDER</title>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<form id="buy" action="proof_purchase.php" method="post">
		<tr>
			<td>Shipping Address:</td>
		</tr>
		
		<!-- My guess is that this is for the customer name :shrug: -->
		<td colspan="2"><?php echo $customer["FName"] . " " . $customer["LName"] ?></td>

		<!-- Credit Card Deets -->
		<!-- For some odd reason this is placed right after the start of the shipping address display :shrug: -->
		<td rowspan="3" colspan="2">
			<!-- You can choose to use the credit card already stored -->
			<input type="radio" name="cardgroup" value="profile_card" checked>Use Credit card on file<br /><?php echo $customer["CardType"] . " - " . $customer["CardNo"] . " - " . $customer["ExpMonth"] . "/" . $customer["ExpYear"] ?><br />
			
			<!-- Or use a new one instead -->
			<input type="radio" name="cardgroup" value="new_card">New Credit Card<br />
			<select id="credit_card" name="credit_card">
				<option selected disabled>select a card type</option>
				<option>VISA</option>
				<option>MASTER</option>
				<option>DISCOVER</option>
			</select>
			<input type="text" id="card_number" name="card_number" placeholder="Credit card number">
			<br />
			Exp date
			<input type="text" id="card_expiration" name="card_expiration" placeholder="mm/yyyy">
		</td>
		
		<!-- Here's the rest of the address stuff -->
		<tr><td colspan="2"><?php echo $customer["Address"] ?></td></tr> <!-- Street -->
		<tr><td colspan="2"><?php echo $customer["City"] ?></td></tr> <!-- City -->
		<tr><td colspan="2"><?php echo $customer["State"] . ", " . $customer["Zip"] ?></td></tr> <!-- State, ZIP -->
	
		<tr>
			<td colspan="3" align="center">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:520px;border:1px solid black;">
					<table border='1'>
						<th>Book Description</th>
						<th>Qty</th>
						<th>Price</th>

						<?php foreach ($_SESSION["cart"] as $book) {
							echo "<tr>";
							echo "<td>" . $book["title"] . "</br><b>By</b> " . $book["author"] . "</br><b>Publisher:</b> " . $book["publisher"] . "</td>";
							echo "<td>" . $book["quantity"] . "</td>";
							echo "<td>$" . $book["price"] . "</td>";
							echo "</tr>";
						}?>
					</table>
				</div>
			</td>
		</tr>
		
		<tr>
			<td align="left" colspan="2">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:260px;border:1px solid black;background-color:LightBlue">
					<b>Shipping Note:</b> The book will be </br>delivered within 5</br>business days.
				</div>
			</td>

			<td align="right">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:260px;border:1px solid black;">
					SubTotal:$<?php echo $subtotal?></br>Shipping_Handling:$2</br>_______</br>Total:$<?php echo $subtotal + 2 ?>
				</div>
			</td>
		</tr>
		
		<tr>
			<td align="right">
				<input type="submit" id="buyit" name="btnbuyit" value="BUY IT!">
			</td>
			
			</form> <!-- No idea why the form is closed *right here* :shrug: -->

			<!-- Redirect to update customer profile-->
			<td align="right">
				<form id="update" action="update_customerprofile.php" method="post">
					<input type="submit" id="update_customerprofile" name="update_customerprofile" value="Update Customer Profile">
				</form>
			</td>

			<!-- Redirect to home page -->
			<td align="left">
				<form id="cancel" action="index.php" method="post">
					<input type="submit" id="cancel" name="cancel" value="Cancel">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>
