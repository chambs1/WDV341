<?php
// Include the database connection file
include('db-Connect.php');

// Set the character set
$conn->query("SET NAMES utf8mb4");

// Event class definition
class Event implements \JsonSerializable {
    private $events_id;
    private $events_name;
    private $events_description;
    private $events_presenter;
    private $events_date;
    private $events_time;

    // Constructor to initialize the properties
    public function __construct($events_id, $events_name, $events_description, $events_presenter, $events_date, $events_time) {
        $this->events_id = $events_id;
        $this->events_name = $events_name;
        $this->events_description = $events_description;
        $this->events_presenter = $events_presenter;
        $this->events_date = $events_date;
        $this->events_time = $events_time;
    }

    // Getters and Setters
    public function getEventsId() {
        return $this->events_id;
    }
    
    public function setEventsId($events_id) {
        $this->events_id = $events_id;
    }

    public function getEventsName() {
        return $this->events_name;
    }
    
    public function setEventsName($events_name) {
        $this->events_name = $events_name;
    }

    public function getEventsDescription() {
        return $this->events_description;
    }
    
    public function setEventsDescription($events_description) {
        $this->events_description = $events_description;
    }

    public function getEventsPresenter() {
        return $this->events_presenter;
    }
    
    public function setEventsPresenter($events_presenter) {
        $this->events_presenter = $events_presenter;
    }

    public function getEventsDate() {
        return $this->events_date;
    }
    
    public function setEventsDate($events_date) {
        $this->events_date = $events_date;
    }

    public function getEventsTime() {
        return $this->events_time;
    }
    
    public function setEventsTime($events_time) {
        $this->events_time = $events_time;
    }

    public function jsonSerialize(): mixed {
        return [
            'events_id' => $this->events_id,
            'events_name' => $this->events_name,
            'events_description' => $this->events_description,
            'events_presenter' => $this->events_presenter,
            'events_date' => $this->events_date,
            'events_time' => $this->events_time
        ];
    }
}

try {
    // Prepare and execute the SQL query to fetch one event
    $stmt = $conn->prepare("SELECT events_id, events_name, events_description, events_presenter, events_date, events_time FROM wdv341_events WHERE events_id = :event_id");
    
    // Example: Fetching the event with ID 1
    $eventId = 1;
    $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Set fetch style to associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetch();

    if ($result) {
        // Create an instance of the Event class and assign values
        $outputObj = new Event($result['events_id'], $result['events_name'], $result['events_description'], $result['events_presenter'], $result['events_date'], $result['events_time']);
        
        // Encode the object as JSON and echo it
        echo json_encode($outputObj);
    } else {
        echo "No event found with ID: $eventId";
    }
    
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// Close the database connection
$conn = null;

// End of the script
?>
