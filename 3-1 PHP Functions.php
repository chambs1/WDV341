<?php

// Function that will accept a Unix Timestamp and format it into mm/dd/yyyy format
function format_date_mm_dd_yyyy($timestamp) {
    return date("m/d/Y", $timestamp);
}

// Function that will accept a Unix Timestamp and format it into dd/mm/yyyy format
function format_date_dd_mm_yyyy($timestamp) {
    return date("d/m/Y", $timestamp);
}

// Function that will accept a string, display the number of characters in the string, 
// trim any leading or trailing whitespace, convert to lowercase, and check for "DMACC".
function process_string($string) {
    // Display the number of characters in the string
    $length = strlen($string);
    echo "Number of characters: $length<br>";

    // Trim any leading or trailing whitespace
    $trimmed_string = trim($string);
    echo "Trimmed string: \"$trimmed_string\"<br>";

    // Convert to all lowercase characters
    $lowercase_string = strtolower($trimmed_string);
    echo "Lowercase string: \"$lowercase_string\"<br>";

    // Check for the word "DMACC"
    if (stripos($lowercase_string, "dmacc") !== false) {
        echo "The string contains 'DMACC'.<br>";
    } else {
        echo "The string does not contain 'DMACC'.<br>";
    }

    return $lowercase_string;
}

// Format a number as phone number: e.g., (123) 456-7890
function formatPhoneNumber($number) {
    // Assuming the number is always 10 digits long (e.g., 1234567890)
    return preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $number);
}

// Format a number as US currency with a dollar sign: e.g., $123,456.00
function formatCurrency($amount) {
    return '$' . number_format($amount, 2);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Functions</title>
</head>
<body>
    <h1>3-1 PHP Functions</h1>

    <!-- Demonstrating date formatting functions -->
    <h2>Date Formatting</h2>
    <?php
        $current_timestamp = time();
        echo "<p>Current Unix Timestamp: $current_timestamp</p>";
        echo "<p>Formatted as mm/dd/yyyy: " . format_date_mm_dd_yyyy($current_timestamp) . "</p>";
        echo "<p>Formatted as dd/mm/yyyy: " . format_date_dd_mm_yyyy($current_timestamp) . "</p>";
    ?>

    <!-- Demonstrating string processing function -->
    <h2>String Processing</h2>
    <?php
        $test_string = "  I attend DMACC. ";
        echo "<p>Original String: \"$test_string\"</p>";
        process_string($test_string);

        // Example of a string not containing "DMACC"
        $no_dmacc_string = "  Hello World! ";
        echo "<p>Original String: \"$no_dmacc_string\"</p>";
        process_string($no_dmacc_string);
    ?>
    <!-- Demonstrating phone number formatting function -->
    <h2>Phone Number Formatting</h2>
    <?php
        $phone_number = "1234567890";
        echo "<p>Original Phone Number: $phone_number</p>";
        echo "<p>Formatted Phone Number: " . formatPhoneNumber($phone_number) . "</p>";
    ?>

    <!-- Demonstrating currency formatting function -->
    <h2>Currency Formatting</h2>
    <?php
        $amount = 123456.789;
        echo "<p>Original Amount: $amount</p>";
        echo "<p>Formatted Currency: " . formatCurrency($amount) . "</p>";
    ?>

</body>
</html>