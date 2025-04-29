<?php
session_start();
if (!isset($_SESSION['validUser']) || $_SESSION['validUser'] !== "yes") {
    header("Location: login.php");
    exit();
}
require_once "db-Connect.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $eventId = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM wdv341_events WHERE events_id = :id");
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        header("Location: events.php?msg=Event+deleted+successfully");
        exit();
    } else {
        header("Location: events.php?error=Failed+to+delete+event");
        exit();
    }
} else {
    header("Location: events.php?error=Invalid+event+ID");
    exit();
}
