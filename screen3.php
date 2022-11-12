<?php
	require_once 'lib/common.php';
	$conn = db_connect();
	session_start();

	$keyword = $_GET["searchfor"];
	$searchOn = $_GET["searchon"];
	$category = $_GET["category"];

	//print_r($_SESSION);
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
				
					<h6> <fieldset>Your Shopping Cart has 0 items</fieldset> </h6>
				
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
					$query = 
					"SELECT Book.ISBN, Price, Genre, Title, PublisherName, FName, LName
					FROM Book
					JOIN Author ON Book.AuthorID = Author.AuthorID
					JOIN PublishedBy ON Book.ISBN = PublishedBy.ISBN
					JOIN Publisher ON Publisher.PublisherID = PublishedBy.PublisherID";
					$queryAddition = " WHERE";

					//if we have a criteria we wish to search on, specify that.
					if ($searchOn == "anywhere")
					{
						$queryAddition = $queryAddition . (" FName LIKE '%".$keyword."%' OR LName LIKE '%".$keyword."%' OR Title LIKE '%".$keyword."%' OR Book.ISBN LIKE '%".$keyword."%' OR PublisherName LIKE '%".$keyword."%'");
					}
					else
					{
						$queryAddition = $queryAddition . (" ".$searchOn." LIKE '%".$keyword."%'");
					}
					
					//if the user has specified a category, search only for those books.
					//we check for searchon here again because we want the formatting to be correct with AND.
					//TODO: make this not terrible.
					if($category != "all" && isset($searchOn))
					{
						$queryAddition = $queryAddition . (" AND Genre = ".$category."");
					}

					//adding everything together. we check to see if anything was acutally added as a specific search first.
					if($queryAddition!=" WHERE")
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
						//echo "<button name='btnCart' id='btnCart' onClick='cart(" . $current_sale_id ." , 1, \"". date("F") . "\", \"". date("Y") . "\", 0, \"" . $_SESSION["user"] . "\", \"" . $row['ISBN']. "\")'>Add to Cart</button></td>";
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
