<?php
    /**
     * Connects to the BBB database.
     * @return conn MySQL Connection object.
     */
    function db_connect() {
        $conn = @mysqli_connect('localhost', 'frontend', '8sDAe2+2$pX2-+s', 'BBB') or die("Failed to connect to database: " . mysqli_connect_error());
        return $conn;
    }

    /**
     * Runs a query on the BBB database.
     * @param conn The open MySQL connection.
     * @param sql The SQL to run.
     */
    function db_query($conn, $sql) {
        @mysqli_query($conn, $sql) or die("Query failed: " . mysqli_error($conn));
    }

    /**
     * Closes the provided connection to the BBB database.
     */
    function db_close($connection) {
        @mysqli_close($connection);
    }
?>