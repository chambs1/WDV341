<?php
// Define PHP variables
$yourName = "Chris Ambs"; // Replace with your name
$assignmentName = "PHP Basics Assignment";

// Variables for arithmetic operations
$number1 = 5;
$number2 = 3;
$total = $number1 + $number2;

// PHP array
$languages = array("PHP", "HTML", "JavaScript");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Assignment</title>
</head>
<body>
    <!-- Display assignment name -->
    <h1><?php echo $assignmentName; ?></h1>

    <!-- Display name inside an h2 element -->
    <h2><?php echo $yourName; ?></h2>

    <!-- Display numbers and their total -->
    <p>Number 1: <?php echo $number1; ?></p>
    <p>Number 2: <?php echo $number2; ?></p>
    <p>Total: <?php echo $total; ?></p>

    <!-- Pass PHP array to JavaScript -->
    <script>
        // Convert PHP array to JavaScript array
        var languages = <?php echo json_encode($languages); ?>;

        // Display the values of the JavaScript array on the page
        document.write("<h3>Programming Languages:</h3>");
        document.write("<ul>");
        for (var i = 0; i < languages.length; i++) {
            document.write("<li>" + languages[i] + "</li>");
        }
        document.write("</ul>");
    </script>
</body>
</html>

