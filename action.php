<?php
include "includes/db.php";

if(isset($_POST['add'])) {

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

    mysqli_stmt_bind_param($stmt, "sssssiss",
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

