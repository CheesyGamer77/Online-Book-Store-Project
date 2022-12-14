<?php
	require_once 'lib/common.php';
	session_start();

	if(!isset($_POST["btnbuyit"]) || !isset($_SESSION["username"]) || !isset($_SESSION["cart"])) {
		//header("Location: user_login.php");

		if(!isset($_POST["btnbuyit"])) {
			echo "buyit not set";
		}

		if(!isset($_SESSION["username"])) {
			echo "username not set";
		}

		if(!isset($_SESSION["cart"])) {
			echo "cart not set";
		}

		exit;
	}

	$conn = db_connect();

	$username = mysqli_real_escape_string($conn, $_SESSION["username"]);

	// insert our initial purchase data and get our receipt id
	// 
	// this is not a great way of doing this. in an ideal world,
	// we'd authenticate a server dedicated to assigning receipt IDs, and
	// use that for our queries

	// first insert the initial purchase data
	$sql = "INSERT INTO PurchaseOf(Username) VALUES ('$username');";
	db_query($conn, $sql);

	// now get the receipt id from what we literally just inserted
	$sql = "SELECT ReceiptID, DATE_FORMAT(PurchasedAt, '%Y-%m-%d') AS Date, DATE_FORMAT(PurchasedAt, '%T') AS Time, FName, LName, Address, City, State, Zip, CardNo, CardType, DATE_FORMAT(ExpDate, '%m/%Y') ExpDate
		FROM PurchaseOf
		NATURAL JOIN Customer
		NATURAL JOIN CreditCard
		WHERE Username='$username'
		ORDER BY PurchasedAt DESC
		LIMIT 1;";

	$res = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($res);

	$receiptId = $data["ReceiptID"];
	$date = $data["Date"];
	$time = $data["Time"];
	$name = $data["FName"] .  " " . $data["LName"];
	$cardNumber = $data["CardNo"];
	$cardType = $data["CardType"];
	$cardDate = $data["ExpDate"];
	$address = $data["Address"];
	$city = $data["City"];
	$state = $data["State"];
	$zip = $data["Zip"];

		//if the user changed their card on the last page, update it here.
	if($_POST["cardgroup"] == "new_card")
		{
			$oldccNum = $cardNumber;
			$cardType = $_POST["credit_card"];
			$cardNumber = $_POST["card_number"];
			$cardDate = $_POST["card_expiration"];
			$sql =
			"UPDATE CreditCard
			 SET CardNo = '$cardNumber',
			 CardType = '$cardType',
			 ExpDate = '$cardDate'
			 WHERE CardNo = '$oldccNum'";
			db_query($conn, $sql);
		}

	mysqli_free_result($res);

	// now insert the rest of the books into the purchase
	foreach ($_SESSION["cart"] as $book) {
		$isbn = $book["isbn"];
		$quantity = $book["quantity"];

		$sql = "INSERT INTO InPurchase VALUES ($quantity, '$isbn', $receiptId);";
		db_query($conn, $sql);
	}
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Proof purchase</title>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<form id="buy" action="" method="post">
		
		<tr><td>Shipping Address:</td></tr>
		
		<td colspan="2"><?php echo $name ?></td>
		<td rowspan="3" colspan="2">
		
		<b>UserID:</b><?php echo $username ?><br />
		<b>Date:</b><?php echo $date ?><br />
		<b>Time:</b><?php echo $time ?><br />
		<b>Card Info:</b><?php echo $cardType ?><br /><?php echo $cardDate . " - " . $cardNumber ?></td>
		
		<tr>
			<td colspan="2"><?php echo $address ?></td>		
		</tr>
		
		<tr>
			<td colspan="2"><?php echo $city ?></td>
		</tr>
		
		<tr>
			<td colspan="2"><?php echo $state . ", " . $zip ?></td>
		</tr>
		
		<tr>
			<td colspan="3" align="center">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:520px;border:1px solid black;">
					<table border='1'>
						<th>Book Description</th>
						<th>Qty</th>
						<th>Price</th>

						<?php
							$subtotal = 0;
							foreach ($_SESSION["cart"] as $book) {
								echo "<tr>";
								echo "<td>" . $book["title"] . "</br><b>By</b> " . $book["author"] . "</br><b>Publisher:</b> " . $book["publisher"] . "</td>";
								echo "<td>" . $book["quantity"] . "</td>";
								echo "<td>$" . $book["price"] . "</td>";
								echo "</tr>";

								$subtotal += $book["price"] * $book["quantity"];
							}
							
							$_SESSION["cart"] = array();
						?>
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
					SubTotal:$<?php echo $subtotal ?></br>Shipping_Handling:$2</br>_______</br>Total:$<?php echo $subtotal + 2 ?></div>
			</td>
		</tr>
		
		<tr>
		
		</form>
		
			<td align="right">
				<form id="update" action="screen2.php" method="post">
					<input type="submit" id="update_customerprofile" name="update_customerprofile" value="New Search">
				</form>
			</td>
			
			<td align="left">
				<form id="cancel" action="index.php" method="post">
					<input type="submit" id="exit" name="exit" value="EXIT 3-B.com">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>
