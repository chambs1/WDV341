<?php
session_start();
if (!isset($_SESSION['validUser']) || $_SESSION['validUser'] !== "yes") {
    header("Location: login.php");
    exit();
}
require_once "db-Connect.php";

// Fetch all events
$stmt = $conn->query("SELECT events_id, events_name, events_presenter, events_date FROM wdv341_events");
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Events</title>
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

    <script>
    function confirmDelete(eventId) {
        if (confirm("Are you sure you want to delete this event?")) {
            window.location.href = "delete-event.php?id=" + eventId;
        }
    }
    </script>
</head>
<body>
    <h2 style="text-align:center;">All Events</h2>
    <?php
    // Show success/error messages from delete-event.php
    if (isset($_GET['msg'])) {
        echo "<p style='text-align:center;color:green;'>" . htmlspecialchars($_GET['msg']) . "</p>";
    }
    if (isset($_GET['error'])) {
        echo "<p style='text-align:center;color:red;'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>
    <table>
        <tr>
            <th>Event Name</th>
            <th>Presenter</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?php echo htmlspecialchars($event['events_name']); ?></td>
            <td><?php echo htmlspecialchars($event['events_presenter']); ?></td>
            <td><?php echo htmlspecialchars($event['events_date']); ?></td>
            <td>
                <button class="delete-btn" onclick="confirmDelete(<?php echo $event['events_id']; ?>)">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
