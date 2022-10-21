<?php
	if (isset($_GET)) {
		require_once 'lib/common.php';

		debug("Got here");

		$title = $_GET['title'];

		debug("Title: " . $title);

		$conn = db_connect();

		debug("Connected to DB");
		$isbn = mysqli_real_escape_string($conn, $_GET('isbn'));
		debug("ISBN: " . $isbn);

		// fetch book author
		$sql = "SELECT author FROM Book WHERE isbn = '$isbn';";
		if (!($res = mysqli_query($conn, $sql))) {
			debug("Error: " . mysqli_error($conn));
		}

		$book = mysqli_fetch_assoc($res);
		mysqli_free_result($res);

		echo "Author: " . $book['author'];

		// fetch reviews ordered by time submitted (newer reviews first)
		$sql = "SELECT content FROM Review WHERE isbn = '$isbn' ORDER BY submittedAt DESC;";
		$res = mysqli_query($conn, $sql);
		$reviewTexts = mysqli_fetch_all($res);
		mysqli_free_result($res);

		echo "Fetched reviews";
		
		db_close($conn);
	}
?>

<!-- screen 4: Book Reviews by Prithviraj Narahari, php coding: Alexander Martens-->
<!DOCTYPE html>
<html>
<head>
	<title>Book Reviews - 3-B.com</title>
	<style>
	.field_set
	{
		border-style: inset;
		border-width:4px;
	}
	</style>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="center">
				<h5>Reviews For:</h5>
			</td>
			<td align="left">
				<h5><?php echo $title?></h5>
			</td>
		</tr>
			
		<tr>
			<td colspan="2">
			<div id="bookdetails" style="overflow:scroll;height:200px;width:300px;border:1px solid black;">
			<table>
						</table>
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<form action="screen2.php" method="post">
					<input type="submit" value="Done">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>
