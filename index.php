<?php
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEAM: Crud Activity</title>
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
    <h1>School Event Attendance Management</h1>
    <a href="add.php">Add New Attendance</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Event ID</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Expected Attendees</th>
                <th>Description</th>
                <th>Venue</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM attendance";
            $statement = mysqli_prepare($conn, $sql);
            if ($statement) {
                mysqli_stmt_execute($statement);
                mysqli_stmt_bind_result($statement, $id, $event_id, $date, $start_time, $end_time, $status, $attendees, $description, $venue);
                while (mysqli_stmt_fetch($statement)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($id) . "</td>";
                    echo "<td>" . htmlspecialchars($event_id) . "</td>";
                    echo "<td>" . htmlspecialchars($date) . "</td>";
                    echo "<td>" . htmlspecialchars($start_time) . "</td>";
                    echo "<td>" . htmlspecialchars($end_time) . "</td>";
                    echo "<td>" . htmlspecialchars($status) . "</td>";
                    echo "<td>" . htmlspecialchars($attendees) . "</td>";
                    echo "<td>" . htmlspecialchars($description) . "</td>";
                    echo "<td>" . htmlspecialchars($venue) . "</td>";
                    echo "<td>
                            <a href='edit.php?id=" . htmlspecialchars($id) . "'>Edit</a>
                            <a href='delete.php?id=" . htmlspecialchars($id) . "' onclick='return confirm(\"Confirm deletion?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<tr><td colspan='10'>An error occurred while fetching records.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>