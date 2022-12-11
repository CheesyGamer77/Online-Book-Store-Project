<?php
    /**
     * Connects to the BBB database.
     * @return conn MySQL Connection object.
     */
    function db_connect() {
        $conn = @mysqli_connect('localhost', 'root', 'Karakeightpeaks88@', 'bookstore') or alert("Failed to connect to database: " . mysqli_connect_error());
        return $conn;
    }

    /**
     * Runs a query on the BBB database.
     * @param conn The open MySQL connection.
     * @param sql The SQL to run.
     */
    function db_query($conn, $sql) {
        return @mysqli_query($conn, $sql) or alert("Query failed: " . mysqli_error($conn));
    }

    /**
     * Closes the provided connection to the BBB database.
     */
    function db_close($connection) {
        @mysqli_close($connection);
    }

    function alert($message) {
        echo "<script>alert('$message');</script>";
        die($message);
    }

    function debug($message) {
        echo "<script>console.log('$message');</script>";
    }
?>
