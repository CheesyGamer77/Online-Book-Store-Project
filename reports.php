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
        $sql = "SELECT Genre, COUNT(*) AS total
            FROM Book
            GROUP BY Genre
            ORDER BY total DESC;";
        $res = mysqli_query($conn, $sql);

        echo "<table><tr><th>Genre</th><th>Total</th></tr>";
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr><td>" . $row["Genre"] . "</td><td>" . $row["total"] . "</td></tr>";
        }
        echo "</table>";
        mysqli_free_result($res);
		
        // Get average monthly sales for the year, ordered by month
        $sql = "SELECT Month, SUM(PurchaseTotal) AS MonthlySales
            FROM (
                SELECT MONTH(PurchasedAt) AS Month, Quantity * Price AS PurchaseTotal
                FROM PurchaseOf, InPurchase
                NATURAL JOIN Book
                WHERE YEAR(PurchasedAt) = YEAR(NOW())
            ) MonthlyTotal
            GROUP BY Month
            ORDER BY Month ASC";
        $res = mysqli_query($conn, $sql);
        
        echo "<table><tr><th>Month</th><th>Total Sales</th></tr>";
        $total = 0;
        $entries = 0;
        $average = 0;
        while ($row = mysqli_fetch_array($res)) {
            $entries += 1;
            $monthlySales = $row["MonthlySales"];
            echo "<tr><td>" . $row["Month"] . "</td><td>" . $row["MonthlySales"] . "</td></tr>";
            $total += $monthlySales;
        }
        echo "</table>";
        mysqli_free_result($res);

        if ($entries > 0) {
            $average = round($total / $entries, 2);
        }
        echo "Average Sales Per Month: \$$average";

        db_close($conn);
    ?></body>
</html>
