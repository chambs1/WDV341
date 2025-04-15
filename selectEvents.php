<?php
    // Include the database connection
    require_once('db-Connect.php');

    // Set the character set
    $conn->query("SET NAMES utf8mb4");

    try {
        // First, let's verify the table exists and has data
        $checkQuery = "SELECT COUNT(*) FROM wdv341_events";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->execute();
        $rowCount = $checkStmt->fetchColumn();
        
        // Now prepare the main query
        $sql = "SELECT * FROM wdv341_events";
        $stmt = $conn->prepare($sql);
        
        // Execute the prepared statement
        $stmt->execute();
        
        // Get the results - use fetch in a loop instead of fetchAll
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
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
    <title>WDV341 - Select Events</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <h1>Events List</h1>
    <p>Total events in database: <?php echo $rowCount; ?></p>
    
    <?php if($rowCount > 0): ?>
        <table class="event-table">
            <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Event Description</th>
                    <th>Event Presenter</th>
                    <th>Event Date</th>
                    <th>Event Time</th>
                    <th>Event Date Inserted</th>
                    <th>Event Date Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($results as $row): ?>
                    <tr>
                        <td><?php echo $row['events_id']; ?></td>
                        <td><?php echo $row['events_name']; ?></td>
                        <td><?php echo $row['events_description']; ?></td>
                        <td><?php echo $row['events_presenter']; ?></td>
                        <td><?php echo $row['events_date']; ?></td>
                        <td><?php echo $row['events_time']; ?></td>
                        <td><?php echo $row['events_date_inserted']; ?></td>
                        <td><?php echo $row['events_date_updated']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-events">
            <p>There are currently no events in the database.</p>
        </div>
    <?php endif; ?>
</body>
</html>
