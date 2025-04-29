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
    body {
        font-family: Arial, sans-serif;
        background: #f9f9f9;
    }
    table {
        border-collapse: collapse;
        width: 80%;
        margin: 30px auto;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }
    th {
        background: #f1f1f1;
    }
    .delete-btn {
        background: #c00;
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }
    /* Add form styling for updateEvent.php */
    form {
        max-width: 500px;
        margin: 40px auto;
        background: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    label {
        display: block;
        margin-top: 15px;
        color: #333;
        font-weight: bold;
    }
    input[type="text"],
    input[type="date"],
    input[type="time"],
    textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 1em;
    }
    textarea {
        resize: vertical;
        min-height: 60px;
    }
    input[type="submit"] {
        margin-top: 20px;
        padding: 10px 20px;
        background: #0077cc;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 1em;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background: #005fa3;
    }
    .confirmation {
        color: green;
        text-align: center;
    }
    .error {
        color: red;
        text-align: center;
    }
    .hidden {
        display: none;
    }
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
                    <th>Action</th>
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
                        <td>
                            <a href="updateEvent.php?recid=<?php echo $row['events_id']; ?>">Edit</a>
                        </td>
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
