<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$host = 'localhost';
$dbname = 'chambs1_wdv341'; // Replace with your database name
$username = "root";
$password = ""; // Replace with your database password

// Create a new MySQLi connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check for connection errors
if (mysqli_connect_errno()) {
    echo "<p style='color: red;'>Failed to connect to MySQL: " . mysqli_connect_error() . "</p>";
    exit;
}

// Initialize variables
$events_name = '';
$events_description = '';
$events_presenter = '';
$events_date = '';
$events_time = '';
$honeypot = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user inputs
    $events_name = isset($_POST['events_name']) ? htmlspecialchars(trim($_POST['events_name'])) : '';
    $events_description = isset($_POST['events_description']) ? htmlspecialchars(trim($_POST['events_description'])) : '';
    $events_presenter = isset($_POST['events_presenter']) ? htmlspecialchars(trim($_POST['events_presenter'])) : '';
    $events_date = isset($_POST['events_date']) ? $_POST['events_date'] : '';
    $events_time = isset($_POST['events_time']) ? $_POST['events_time'] : '';
    $honeypot = isset($_POST['honeypot_field']) ? $_POST['honeypot_field'] : '';

    // Validate honeypot field
    if (!empty($honeypot)) {
        echo "<p style='color: red;'>This form has been marked as spam.</p>";
        exit;
    }

    // Server-side validations
    $errors = [];

    if (empty($events_name)) {
        $errors[] = "Event Name is required.";
    }

    if (empty($events_presenter)) {
        $errors[] = "Presenter is required.";
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $events_date)) {
        $errors[] = "Date must be in the format YYYY-MM-DD.";
    }

    if (!preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $events_time)) {
        $errors[] = "Time must be in the format HH:MM (24-hour format).";
    }

    // If no errors, insert data into the database
    if (empty($errors)) {
        $sql = "INSERT INTO wdv341_events (events_name, events_description, events_presenter, events_date, events_time) VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "<p style='color: red;'>SQL statement failed: " . mysqli_error($conn) . "</p>";
            exit;
        }

        mysqli_stmt_bind_param($stmt, "sssss", $events_name, $events_description, $events_presenter, $events_date, $events_time);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p style='color: green;'>Event inserted successfully.</p>";
            // Redirect to the same page or another page with empty fields
            header("Location: add_event_form.php");
            exit;
        } else {
            echo "<p style='color: red;'>Error inserting record: " . mysqli_error($conn) . "</p>";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<ul style='color: red;'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}

// Close the connection
mysqli_close($conn);
?>
