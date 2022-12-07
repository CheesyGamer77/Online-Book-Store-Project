<!DOCTYPE HTML>
<html>
    <head>
        <title>BBB Admin Reports</title>
    </head>

    <body><?php
        require_once 'lib/common.php';

        $conn = db_connect();
		session_start();

        $sql = "SELECT COUNT(*) AS customerCount FROM Customer;";
        $res = mysqli_query($conn, $sql);
        $customerCount = mysqli_fetch_assoc($res)['customerCount'];

        // Get total registered customers
        echo "Total registered customers: $customerCount";
    ?></body>
</html>
