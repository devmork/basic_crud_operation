<?php
include "includes/db.php";

if(isset($_POST['add'])) {
    $event_id = $_POST['event_id'];
    $event_date = $_POST['event_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = $_POST['status'];
    $expected_attendees = $_POST['attendees'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];

    mysqli_query($conn, "INSERT INTO events (event_id, event_date, start_time, end_time, status, expected_attendees, venue, description) 
                         VALUES ('$event_id', '$event_date', '$start_time', '$end_time', '$status', '$expected_attendees', '$venue', '$description')");
    
    header("Location: index.php");
    exit();
}