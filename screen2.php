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
					<option value='Science Fiction'>Science Fiction</option>
					<option value='Classics'>Classics</option>
					<option value='Historical Fiction'>Historical Fiction</option>
					<option value='Fantasy'>Fantasy</option>
				</form>

			<button onclick="location.href = 'index.php';">EXIT 3-B.com</button>
		</tr>
	</table>
</body>
</html>
