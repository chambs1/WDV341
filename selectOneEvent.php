<?php
    // Include the database connection
    require_once('dbConnect.php');

    // Set the character set
    $conn->query("SET NAMES utf8mb4");

    // Hard code the event ID for testing purposes
    $eventId = 2; // Change this to test different events

    try {
        // Prepare SQL statement with WHERE clause to select one event
        $sql = "SELECT * FROM wdv341_events WHERE events_id = :eventId";
        $stmt = $conn->prepare($sql);
        
        // Bind the parameter
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        
        // Execute the prepared statement
        $stmt->execute();
        
        // Get the result
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if we found an event
        $eventFound = $event !== false;
        
    } catch(PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WDV341 - Select One Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        
        h1 {
            color: #333;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        
        .event-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        
        .event-details {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 10px;
        }
        
        .event-label {
            font-weight: bold;
            color: #555;
        }
        
        .event-value {
            color: #333;
        }
        
        .no-event {
            padding: 20px;
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            color: #666;
        }
        
        .event-description {
            margin-top: 15px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #eee;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <h1>Event Details</h1>
    
    <?php if($eventFound): ?>
        <div class="event-container">
            <div class="event-details">
                <div class="event-label">Event ID:</div>
                <div class="event-value"><?php echo $event['events_id']; ?></div>
                
                <div class="event-label">Event Name:</div>
                <div class="event-value"><?php echo $event['events_name']; ?></div>
                
                <div class="event-label">Presenter:</div>
                <div class="event-value"><?php echo $event['events_presenter']; ?></div>
                
                <div class="event-label">Date:</div>
                <div class="event-value"><?php echo $event['events_date']; ?></div>
                
                <div class="event-label">Time:</div>
                <div class="event-value"><?php echo $event['events_time']; ?></div>
                
                <div class="event-label">Date Inserted:</div>
                <div class="event-value"><?php echo $event['events_date_inserted']; ?></div>
                
                <div class="event-label">Last Updated:</div>
                <div class="event-value"><?php echo $event['events_date_updated']; ?></div>
            </div>
            
            <div class="event-description">
                <div class="event-label">Description:</div>
                <p><?php echo $event['events_description']; ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="no-event">
            <p>No event found with ID: <?php echo $eventId; ?></p>
        </div>
    <?php endif; ?>
</body>
</html>
