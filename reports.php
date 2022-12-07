<?php
    require_once 'lib/common.php';

    $conn = db_connect();
    session_start();

    // Get total registered customers
    $sql = "SELECT COUNT(*) AS customerCount FROM Customer;";
    $res = mysqli_query($conn, $sql);
    $customerCount = mysqli_fetch_assoc($res)['customerCount'];
    mysqli_free_result($res);

    // Get total books in each category
    $sql = "SELECT Genre, COUNT(*) AS total
        FROM Book
        GROUP BY Genre
        ORDER BY total DESC;";
    $res = mysqli_query($conn, $sql);

    $genreCounts = array();
    while ($row = mysqli_fetch_array($res)) {
        array_push($genreCounts, $row);
    }
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
    
    $total = 0;
    $entries = 0;
    $average = 0;
    $yearlySales = array();
    while ($row = mysqli_fetch_array($res)) {
        array_push($yearlySales, $row);
        $entries += 1;
        $total += $row["MonthlySales"];
    }
    mysqli_free_result($res);

    if ($entries > 0) {
        $average = round($total / $entries, 2);
    }

    // Get all titles and number of reviews for each
    $sql = "SELECT Title, COUNT(*) AS ReviewCount
        FROM Book
        NATURAL JOIN Review
        GROUP BY ISBN;";
    $res = mysqli_query($conn, $sql);

    $reviewData = array();
    while ($row = mysqli_fetch_array($res)) {
        array_push($reviewData, $row);
    }
    mysqli_free_result($res);
    db_close($conn);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>BBB Admin Reports</title>
    </head>

    <body>
        <h1>Admin Reports</h1>
        <h2>Total Registered Customers</h2>
        <p><?php
            echo $customerCount
        ?></p>

        <h2>Books In Each Category</h2>
        <table>
            <tr>
                <th>Genre</th>
                <th>Total</th>
            </tr>
            <?php
                foreach ($genreCounts as $row) {
                    echo "<tr><td>" . $row["Genre"] . "</td><td>" . $row["total"] . "</td></tr>";
                }
            ?>
        </table>

        <h2>Yearly Sales</h2>
        <h3>Totals By Month</h3>
        <table>
            <tr>
                <th>Month</th>
                <th>Total Sales</th>
            </tr>
            <?php
                foreach ($yearlySales as $row) {
                    echo "<tr><td>" . $row["Month"] . "</td><td>" . $row["MonthlySales"] . "</td></tr>";
                }
            ?>
        </table>

        <h3>Average Monthly Sales</h3>
        <p><?php
            echo "$" . $average;
        ?></p>

        <h2>Total Book Reviews By Title</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Total Reviews</th>
            </tr>
            <?php
                foreach ($reviewData as $row) {
                    echo "<tr><td>" . $row["Title"] . "</td><td>" . $row["ReviewCount"] . "</td></tr>";
                }
            ?>
        </table>
    </body>
</html>
