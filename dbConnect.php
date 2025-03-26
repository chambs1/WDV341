<?php
    // Database connection parameters for local XAMPP
    $servername = "localhost";
    $username = "root";     // Default XAMPP username
    $password = "Yohimbine83$";         // Default XAMPP password (blank)
    $dbname = "wdv341";     // Your database name
    
    try {
        // Create connection using PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Display success message
        echo "<h2>Connection Successful!</h2>";
        echo "<p>You are now connected to the database: $dbname</p>";
    }
    catch(PDOException $e) {
        // Display error message if connection fails
        echo "<h2>Connection Failed</h2>";
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
?>
