<?php
// Database connection parameters
$servername = "localhost";
$username = "chambs1_wdv341";
$password = "Yohimbine83$";
$dbname = "chambs1_wdv341";

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optional: Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Message to confirm connection
//echo "Connected successfully!";
?>
