<?php
session_start();
include "includes/db.php";

function validateEventInputs($post) {
    $errors = [];

    if (empty(trim($post['event_id'])))
        $errors[] = "Event ID is required.";

    if (empty($post['event_date']) || !strtotime($post['event_date']))
        $errors[] = "A valid Event Date is required.";

    if (empty($post['start_time']))
        $errors[] = "Start Time is required.";

    if (empty($post['end_time']))
        $errors[] = "End Time is required.";

    if (!empty($post['start_time']) && !empty($post['end_time']) &&
        $post['end_time'] <= $post['start_time'])
        $errors[] = "End Time must be after Start Time.";

    $allowed = ['Planned', 'Active', 'Completed', 'Cancelled'];
    if (!in_array($post['status'], $allowed))
        $errors[] = "Invalid status value.";

    if (!is_numeric($post['attendees']) || (int)$post['attendees'] < 0)
        $errors[] = "Expected Attendees must be a non-negative number.";

    if (empty(trim($post['venue'])))
        $errors[] = "Venue is required.";

    return $errors;
}

if(isset($_POST['add'])) {

    $errors = validateEventInputs($_POST);

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old']    = $_POST;
        header("Location: add.php");
        exit();
    }

    $event_id          = $_POST['event_id'];
    $event_date        = $_POST['event_date'];
    $start_time        = $_POST['start_time'];
    $end_time          = $_POST['end_time'];
    $status            = $_POST['status'];
    $expected_attendees = $_POST['attendees'];
    $venue             = $_POST['venue'];
    $description       = $_POST['description'];

    $stmt = mysqli_prepare($conn, "INSERT INTO events 
        (event_id, event_date, start_time, end_time, status, expected_attendees, venue, description) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt, "ssssssss",
        $event_id,
        $event_date,
        $start_time,
        $end_time,
        $status,
        $expected_attendees,
        $venue,
        $description
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit();
}


if(isset($_POST['update'])) {

    $errors = validateEventInputs($_POST);

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old']    = $_POST;
        header("Location: edit.php?id=" . (int)$_GET['id']);
        exit();
    }

    $id                = $_GET['id'];
    $event_id          = $_POST['event_id'];
    $event_date        = $_POST['event_date'];
    $start_time        = $_POST['start_time'];
    $end_time          = $_POST['end_time'];
    $status            = $_POST['status'];
    $expected_attendees = $_POST['attendees'];
    $venue             = $_POST['venue'];
    $description       = $_POST['description'];

    $stmt = mysqli_prepare($conn, "UPDATE events 
        SET event_id=?, 
            event_date=?, 
            start_time=?, 
            end_time=?, 
            status=?, 
            expected_attendees=?, 
            venue=?, 
            description=? 
        WHERE id=?");

    mysqli_stmt_bind_param($stmt, "ssssssssi",
        $event_id,
        $event_date,
        $start_time,
        $end_time,
        $status,
        $expected_attendees,
        $venue,
        $description,
        $id
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit();
}


if(isset($_POST['delete'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM events WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: index.php");
    exit();
}

