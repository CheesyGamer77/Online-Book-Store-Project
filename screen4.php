<?php
	if (isset($_GET)) {
		require_once 'lib/common.php';

		$isbn = $_GET['isbn'];

		$conn = db_connect();

		// fetch book author
		$sql = "SELECT LName, Title
				FROM Book
				JOIN Author ON Book.AuthorID = Author.AuthorID
				WHERE isbn = '$isbn';";
		$res = mysqli_query($conn, $sql);
		$book = mysqli_fetch_assoc($res);
		$author = $book['LName'];
		$title = $book["Title"];
		mysqli_free_result($res);

		$sql = "SELECT ReviewText 
				FROM Review
				JOIN Book ON Review.ISBN = Book.ISBN
		 		WHERE Book.ISBN = '$isbn';";
		$res = mysqli_query($conn, $sql);
		$reviewTexts = mysqli_fetch_all($res, MYSQLI_ASSOC);
		mysqli_free_result($res);

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
				<h5><?php echo $title . "<br>By: " . $author?></h5>
			</td>
		</tr>

		<tr>
			<td colspan="2">
			<div id="bookdetails" style="overflow:scroll;height:200px;width:300px;border:1px solid black;">
			<table><?php foreach ($reviewTexts as $review) { ?>
				<tr><td> <?php echo htmlspecialchars($review['ReviewText']) ?></td></tr>
			<?php }?></table>
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
