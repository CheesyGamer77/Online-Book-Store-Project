<?php
	require_once 'lib/common.php';
	session_start();

	// init shopping cart
    if(!isset($_SESSION['username']))
    {
		// TODO PH-4: Correct username
        $_SESSION['username'] = "user";
        $_SESSION['cart'] = array();
    }

	if (isset($_GET['delIsbn'])) {
		// removing a book from cart
		$isbn = $_GET['delIsbn'];
		$newCart = array();

		foreach($_SESSION['cart'] as $book) {
			if($book['isbn'] != $isbn) {
				array_push($newCart, $book);
				continue;
			}

			$quantity = $book['quantity'];
			debug($quantity);
			if($quantity != 1) {
				$book['quantity'] = $book['quantity'] - 1;
				array_push($newCart, $book);
			}
		}

		$_SESSION['cart'] = $newCart;
	}
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Shopping Cart</title>
	<script>
		//remove from cart
		function del(isbn) {
			window.location.href="shopping_cart.php?delIsbn="+ isbn;
		}
	</script>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td align="center">
				<form id="checkout" action="confirm_order.php" method="get">
					<input type="submit" name="checkout_submit" id="checkout_submit" value="Proceed to Checkout">
				</form>
			</td>
			<td align="center">
				<form id="new_search" action="screen2.php" method="post">
					<input type="submit" name="search" id="search" value="New Search">
				</form>								
			</td>
			<td align="center">
				<form id="exit" action="index.php" method="post">
					<input type="submit" name="exit" id="exit" value="EXIT 3-B.com">
				</form>					
			</td>
		</tr>
		<tr>
				<form id="recalculate" name="recalculate" action="" method="post">
			<td  colspan="3">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<th width='10%'>Remove</th><th width='60%'>Book Description</th><th width='10%'>Qty</th><th width='10%'>Price</th>
						<?php foreach ($_SESSION['cart'] as $book) {
							echo "<tr>";

							$isbn = $book['isbn'];
							$title = $book['title'];
							$author = $book['author'];
							$publisher = $book['publisher'];
							$price = $book['price'];
							$quantity = $book['quantity'];

							// delete button
							echo "<td><button name='delete' id='delete' onClick=\"del(" . "'$isbn'" . "); return false;\">Delete Item</button></td>";

							// book details
							echo "<td>$title</br><b>By</b> $author</br><b>Publisher:</b> $publisher</td>";

							echo "<td><input id='txt ". $isbn ."' name='txt123441' value='$quantity' size='1'/></td>";

							// price
							echo "<td>$price</td>";
							echo "</tr>";
						} ?>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">				
					<input type="submit" name="recalculate_payment" id="recalculate_payment" value="Recalculate Payment">
				</form>
			</td>
			<td align="center">
				&nbsp;
			</td>
			<td align="center">Subtotal:  $<?php
				$total = 0;
				foreach($_SESSION['cart'] as $book) {
					$total = round($total + ($book['price'] * $book['quantity']), 2);
				}
				echo $total;
			?></td>
		</tr>
	</table>
</body>
</html>
