<!DOCTYPE HTML>
<html>
    <head>
        <title>BBB Admin Reports</title>
    </head>

    <body><?php
        require_once 'lib/common.php';

        $conn = db_connect();
		session_start();

        // Get total registered customers
        $sql = "SELECT COUNT(*) AS customerCount FROM Customer;";
        $res = mysqli_query($conn, $sql);
        $customerCount = mysqli_fetch_assoc($res)['customerCount'];
        mysqli_free_result($res);
        echo "Total registered customers: $customerCount";

        // Get total books in each category
        $sql = "SELECT Genre, COUNT(*) AS total FROM Book GROUP BY Genre;";
        $res = mysqli_query($conn, $sql);
        $totals = mysqli_fetch_assoc($res);
        mysqli_free_result($res);

        echo "<table><tr><th>Genre</th><th>Total</th></tr>";
        foreach ($totals as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo "</table>";
        

		db_close($conn);
    ?></body>
</html>
