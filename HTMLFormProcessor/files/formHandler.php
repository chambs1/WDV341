<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WDV101 Basic Form Handler Example</title>
</head>

<body>
    <h2>UNIT 3 Forms - Lesson 2 Server Side Processes</h2>
    
    <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Validate and sanitize input
                $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
                $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
                $schoolName = filter_input(INPUT_POST, 'school_name', FILTER_SANITIZE_STRING);
                $customerEmail = filter_input(INPUT_POST, 'customer_email', FILTER_SANITIZE_EMAIL);
                $academicStanding = filter_input(INPUT_POST, 'academic_standing', FILTER_SANITIZE_STRING);
                $selectedMajor = filter_input(INPUT_POST, 'program_choice', FILTER_SANITIZE_STRING); 
                
                // Updated checkbox names to match form data
                $checkBox1 = isset($_POST['contact_info']) ? 'Yes' : 'No';  
                $checkBox2 = isset($_POST['newsletter']) ? 'Yes' : 'No';    
                
                $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_STRING);
        
        // Display the confirmation
        ?>
        <h3>Confirmation Page</h3>
        <p>Dear <?php echo $firstName; ?>,</p>

        <p>Thank you for your interest in DMACC.</p>

        <p>We have you listed as a <?php echo $academicStanding; ?> starting this fall.</p>

        <p>You have declared <?php echo $selectedMajor; ?> as your major.</p>

        <p>Based upon your responses we will provide the following information in our confirmation email to you at <?php echo $customerEmail; ?>.</p>

        <ul>
            <li>Contact Information: <?php echo $checkBox1; ?></li>
            <li>Newsletter Signup: <?php echo $checkBox2; ?></li>
        </ul>

        <p>You have shared the following comments which we will review:</p>
        <blockquote><?php echo nl2br($comments); ?></blockquote>
        <?php
    } else {
        echo "<p>Error: This page should be accessed through a form submission.</p>";
    }
    ?>
</body>
</html>