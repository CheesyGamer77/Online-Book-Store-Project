<?php
	require_once 'lib/common.php';
	$conn = db_connect();
	session_start();

	$keyword = mysqli_real_escape_string($conn, $_GET["searchfor"]);
	$searchOn = mysqli_real_escape_string($conn, $_GET["searchon"]);
	$category = mysqli_real_escape_string($conn, $_GET["category"]);

	if(isset($_GET["cartisbn"])) {
		if(!isset($_SESSION['cart'])) {
			// default to empty cart
			$_SESSION['cart'] = array();
		}

		// find book with said ISBN
		$isbn = $_GET["cartisbn"];
		$sql = "SELECT Book.ISBN, Title, FName, LName, PublisherName, Price
				FROM Book
				NATURAL JOIN Author
				NATURAL JOIN PublishedBy
				NATURAL JOIN Publisher
				WHERE Book.ISBN = '$isbn'";
		$res = mysqli_query($conn, $sql);
		$book = mysqli_fetch_assoc($res);

		// check if the book already exists in the cart
		// if so, just increment and update the quantity
		$quantity = 1;
		$found = false;
		$index = 0;
		foreach($_SESSION['cart'] as $b) {
			if($b['isbn'] == $isbn) {
				$found = true;
				$b['quantity'] += 1;
				$_SESSION['cart'][$index] = $b;
				break;
			}
			$index += 1;
		}

		// add book data to cart if it wasn't already there
		if(!$found) {
			array_push($_SESSION['cart'], array(
				"isbn" => $isbn,
				"title" => $book['Title'],
				"author" => $book['FName'] . " " . $book['LName'],
				"publisher" => $book['PublisherName'],
				"price" => $book['Price'],
				"quantity" => $quantity
			));
		}
	}

	// count the items in our cart
	$itemCount = 0;
	if(isset($_SESSION["cart"])) {
		foreach ($_SESSION["cart"] as $book) {
			$itemCount += $book["quantity"];
		}
	}
?>


<!DOCTYPE HTML>
<!-- Figure 3: Search Result Screen by Prithviraj Narahari, php coding: Alexander Martens -->
<html>
<head>
	<title> Search Result - 3-B.com </title>
	<script>
	//redirect to reviews page
	function review(isbn, title){
		window.location.href="screen4.php?isbn="+ isbn;
	}
	//add to cart
	function cart(isbn, searchfor, searchon, category){
		window.location.href="screen3.php?cartisbn="+ isbn + "&searchfor=" + searchfor + "&searchon=" + searchon + "&category=" + category;
	}
	</script>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="left">
				<h6><fieldset><?php echo "Your Shopping Cart has $itemCount items"; ?></fieldset></h6>
			</td>
			<td>
				&nbsp
			</td>
			<td align="right">
				<form action="shopping_cart.php" method="post">
					<input type="submit" value="Manage Shopping Cart">
				</form>
			</td>
		</tr>	
		<tr>
		<td style="width: 350px" colspan="3" align="center">
			<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;background-color:LightBlue">
			<table>
				<?php
					//initalizing the query. we will be updating this as we parse through inputs
					$query = "SELECT Book.ISBN, Price, Genre, Title, PublisherName, FName, LName
					FROM Book
					NATURAL JOIN Author
					NATURAL JOIN PublishedBy
					NATURAL JOIN Publisher";
					$queryAddition = " WHERE";

					//if we have a criteria we wish to search on, specify that.
					if ($keyword != "") {
						if ($searchOn == "anywhere")
						{
							$queryAddition = $queryAddition . (" FName LIKE '%".$keyword."%' OR LName LIKE '%".$keyword."%' OR Title LIKE '%".$keyword."%' OR Book.ISBN LIKE '%".$keyword."%' OR PublisherName LIKE '%".$keyword."%'");
						}
						else
						{
							$queryAddition = $queryAddition . (" ".$searchOn." LIKE '%".$keyword."%'");
						}
					}
					
					//if the user has specified a category, search only for those books.
					//we check for searchon here again because we want the formatting to be correct with AND.
					//TODO: make this not terrible.
					if($category != "all" && isset($searchOn))
					{
						$queryAddition = $queryAddition . (" AND Genre = ".$category."");
					}

					//adding everything together. we check to see if anything was actually added as a specific search first.
					if($queryAddition != " WHERE")
					{
						$query = $query . $queryAddition;
					}
					$query = $query . ";";

					//querying and displaying stuff
					$result = mysqli_query($conn, $query);
					while($row = mysqli_fetch_array($result))
					{
						//these unholy buttons are what was provided. may god have mercy on our souls.	
						echo "<tr><td align='left'>";
						echo "<button name='btnCart' id='btnCart' onClick='cart(\"" . $row['ISBN'] . "\"," . "\"$keyword\"," . "\"$searchOn\"," . "\"$category\")'>Add to Cart</button></td>";
						echo "<td rowspan='2' align='left'>" . $row['Title'].  "</br>" .$row['FName'] . " " . $row['LName']. "</br>";
						echo "<b>Publisher:</b> " . $row['PublisherName']. "</br>";
						echo "<b>ISBN:</b> " . $row['ISBN']. "</t> <b>Price:</b> $" . $row['Price']. "</td></tr>";
						echo "<tr><td align='left'><button name='review' id='review' onClick='review(\"" . $row['ISBN']. "\")'>Reviews</button></td></tr>";
						echo "<tr><td colspan='2'><p>_______________________________________________</p></td></tr>";
					} 

				?>
			</table>
			</div>
			
			</td>
		</tr>
		<tr>
			<td align= "center">
				<form action="confirm_order.php" method="get">
					<input type="submit" value="Proceed To Checkout" id="checkout" name="checkout">
				</form>
			</td>
			<td align="center">
				<form action="screen2.php" method="post">
					<input type="submit" value="New Search">
				</form>
			</td>
			<td align="center">
				<form action="index.php" method="post">
					<input type="submit" name="exit" value="EXIT 3-B.com">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>

<?php
db_close($conn);
?>