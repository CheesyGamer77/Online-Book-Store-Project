<?php
	require_once 'lib/common.php';
	$conn = db_connect();
	session_start();

	if (isset($_POST['search'])) {

		$keyword = "";
		$searchOn = "";
		$category = "";

		$keyword = $_GET["searchfor"];
		$searchOn = $_GET["searchon"];
		$category = $_GET["category"];

		$_SESSION["keyword"] = $keyword;
		$_SESSION["searchOn"] = $searchOn;
		$_SESSION["category"] = $category;
	}
?>

<!DOCTYPE HTML>
<!-- Figure 2: Search Screen by Alexander -->
<html>
<head>
	<title>SEARCH - 3-B.com</title>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td>Search for: </td>
			<!-- action="screen3.php" -->
			<form method="get" action="screen3.php">
				<td><input name="searchfor" id = "searchfor"/></td>
				<td><input type="submit" name="search" value="Search" /></td>
		</tr>
		<tr>
			<td>Search In: </td>
				<td>
					<select name="searchon" multiple>
						<option value="anywhere" selected='selected'>Keyword anywhere</option>
						<option value="title">Title</option>
						<option value="author">Author</option>
						<option value="publisher">Publisher</option>
						<option value="isbn">ISBN</option>				
					</select>
				</td>
				<td><a href="shopping_cart.php"><input type="button" name="manage" value="Manage Shopping Cart" /></a></td>
		</tr>
		<tr>
			<td>Category: </td>
				<td><select name="category">
						<option value='all' selected='selected'>All Categories</option>
							<?php
								//grab all distinct genres in the DB
								$genres = "SELECT DISTINCT Genre FROM Book";
								$result = mysqli_query($conn, $genres);
								//populate the dropdown with all genres in DB
								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
										echo "<option value='".$row['Genre']."'>".$row['Genre']."</option>";
									}
								}
							?>
				</form>
	<form action="index.php" method="post">	
				<td><input type="submit" name="exit" value="EXIT 3-B.com" /></td>
			</form>
		</tr>
	</table>
</body>
</html>
