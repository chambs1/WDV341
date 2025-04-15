<?php
// eventsForm.php - Self-posting form with honeypot protection

// Initialize variables
$formSubmitted = false;
$errorMessage = "";
$successMessage = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot check - if this field is filled, it's likely a bot
    if (!empty($_POST["website_url"])) {
        // Bot detected, but we'll pretend everything is fine
        $formSubmitted = true;
        $successMessage = "Event successfully added to the database!";
    } else {
        // Process legitimate form submission
        $formSubmitted = true;
        
        // Include database connection
        require_once('db-connect.php');
        
        // Get form data and sanitize
        $events_name = trim(filter_var($_POST['events_name'], FILTER_SANITIZE_STRING));
        $events_description = trim(filter_var($_POST['events_description'], FILTER_SANITIZE_STRING));
        $events_presenter = trim(filter_var($_POST['events_presenter'], FILTER_SANITIZE_STRING));
        $events_date = $_POST['events_date'];
        $events_time = $_POST['events_time'];
        
        // Current date for inserted and updated fields
        $current_date = date('Y-m-d');
        
        try {
            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO wdv341_events 
                                   (events_name, events_description, events_presenter, 
                                    events_date, events_time, events_date_inserted, events_date_updated) 
                                   VALUES 
                                   (:name, :description, :presenter, 
                                    :date, :time, :date_inserted, :date_updated)");
            
            // Bind parameters
            $stmt->bindParam(':name', $events_name);
            $stmt->bindParam(':description', $events_description);
            $stmt->bindParam(':presenter', $events_presenter);
            $stmt->bindParam(':date', $events_date);
            $stmt->bindParam(':time', $events_time);
            $stmt->bindParam(':date_inserted', $current_date);
            $stmt->bindParam(':date_updated', $current_date);
            
            // Execute the statement
            $stmt->execute();
            
            $successMessage = "Event successfully added to the database!";
        } catch(PDOException $e) {
            $errorMessage = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WDV341 - Event Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        textarea {
            height: 120px;
            resize: vertical;
        }
        
        /* Honeypot field - hidden from users but visible to bots */
        .honeypot {
            display: none;
        }
        
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            border-left: 5px solid #3c763d;
        }
        
        .error-message {
            background-color: #f2dede;
            color: #a94442;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            border-left: 5px solid #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>WDV341 - Add New Event</h1>
        
        <?php if ($formSubmitted && !empty($successMessage)): ?>
            <div class="success-message">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errorMessage)): ?>
            <div class="error-message">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Honeypot field to catch bots -->
            <div class="honeypot">
                <label for="website_url">Website URL</label>
                <input type="text" id="website_url" name="website_url">
            </div>
            
            <div class="form-group">
                <label for="events_name">Event Name:</label>
                <input type="text" id="events_name" name="events_name" required>
            </div>
            
            <div class="form-group">
                <label for="events_description">Event Description:</label>
                <textarea id="events_description" name="events_description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="events_presenter">Event Presenter:</label>
                <input type="text" id="events_presenter" name="events_presenter" required>
            </div>
            
            <div class="form-group">
                <label for="events_date">Event Date:</label>
                <input type="date" id="events_date" name="events_date" required>
            </div>
            
            <div class="form-group">
                <label for="events_time">Event Time:</label>
                <input type="time" id="events_time" name="events_time" required>
            </div>
            
            <button type="submit">Submit Event</button>
        </form>
    </div>
</body>
</html>
