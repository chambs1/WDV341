<?php
require_once('db-Connect.php');

$confirmation = "";
$error = "";

// HoneyPot field name
$honeypotField = "website";

// Get event ID from query string
if (!isset($_GET['recid']) && !isset($_POST['recid'])) {
    die("No event ID specified.");
}

$eventId = isset($_GET['recid']) ? $_GET['recid'] : $_POST['recid'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // HoneyPot validation
    if (!empty($_POST[$honeypotField])) {
        $error = "Bot detected. Submission rejected.";
    } else {
        // Get form data
        $name = $_POST['events_name'];
        $description = $_POST['events_description'];
        $presenter = $_POST['events_presenter'];
        $date = $_POST['events_date'];
        $time = $_POST['events_time'];

        // Update query
        $sql = "UPDATE wdv341_events SET 
                    events_name = :name,
                    events_description = :description,
                    events_presenter = :presenter,
                    events_date = :date,
                    events_time = :time,
                    events_date_updated = NOW()
                WHERE events_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':presenter', $presenter);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':id', $eventId);

        if ($stmt->execute()) {
            $confirmation = "Event updated successfully!";
        } else {
            $error = "Error updating event.";
        }
    }
}

// Get event data to prefill form (after update or on first load)
$sql = "SELECT * FROM wdv341_events WHERE events_id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $eventId);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Event not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Event</title>
    <style>
        form { max-width: 500px; margin: 30px auto; background: #f9f9f9; padding: 20px; border-radius: 6px; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 8px; margin-top: 4px; }
        .confirmation { color: green; text-align: center; }
        .error { color: red; text-align: center; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Update Event</h2>
    <?php if ($confirmation): ?>
        <p class="confirmation"><?php echo $confirmation; ?></p>
        <p style="text-align:center;"><a href="selectEvents.php">Return to Events List</a></p>
    <?php else: ?>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="updateEvent.php">
            <input type="hidden" name="recid" value="<?php echo htmlspecialchars($event['events_id']); ?>">
            <!-- HoneyPot field (should be hidden from humans) -->
            <div class="hidden">
                <label>Website</label>
                <input type="text" name="<?php echo $honeypotField; ?>" value="">
            </div>
            <label>Event Name</label>
            <input type="text" name="events_name" value="<?php echo htmlspecialchars($event['events_name']); ?>" required>

            <label>Event Description</label>
            <textarea name="events_description" required><?php echo htmlspecialchars($event['events_description']); ?></textarea>

            <label>Event Presenter</label>
            <input type="text" name="events_presenter" value="<?php echo htmlspecialchars($event['events_presenter']); ?>" required>

            <label>Event Date</label>
            <input type="date" name="events_date" value="<?php echo htmlspecialchars($event['events_date']); ?>" required>

            <label>Event Time</label>
            <input type="time" name="events_time" value="<?php echo htmlspecialchars($event['events_time']); ?>" required>

            <input type="submit" value="Update Event">
        </form>
    <?php endif; ?>
</body>
</html>
