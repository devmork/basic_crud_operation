<?php
include 'includes/db.php';

$sql = "SELECT * FROM attendance ORDER BY event_date DESC, start_time ASC";
$statement = mysqli_prepare($conn, $sql);
if ($statement) {
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement, $id, $event_id, $event_date, $start_time, $end_time, $status, $attendees, $description, $venue);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEAM — Event Attendance Management</title>
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
    <header class="page-header">
        <div class="brand">
            <div>
                <h1>Event Attendance Management</h1>
                <p class="subtitle">Track and manage event attendance.</p>
            </div>
        </div>
        <a class="btn primary" href="add.php">+ Add New Event</a>
    </header>

    <main class="container">
        <section class="card toolbar">
            <div class="left">
                <h2>Event Attendance Records</h2>
            </div>
        </section>

        <section class="card table-card">
            <table class="events-table" role="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Attendees</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($statement) {
                        while (mysqli_stmt_fetch($statement)) {
                            $dateFmt = $event_date ? date('M j, Y', strtotime($event_date)) : '';
                            $start = $start_time ? date('g:i A', strtotime($start_time)) : '';
                            $end = $end_time ? date('g:i A', strtotime($end_time)) : '';
                            $statusClass = strtolower($status);
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($id) . "</td>";
                            echo "<td><span class='chip'>" . htmlspecialchars($event_id) . "</span></td>";
                            echo "<td>" . htmlspecialchars($dateFmt) . "</td>";
                            echo "<td>" . htmlspecialchars($start) . " - " . htmlspecialchars($end) . "</td>";
                            echo "<td><span class='badge " . htmlspecialchars($statusClass) . "'>" . htmlspecialchars($status) . "</span></td>";
                            echo "<td>" . htmlspecialchars($attendees) . "</td>";
                            echo "<td>" . htmlspecialchars($venue) . "</td>";
                            echo "<td class='desc'>" . htmlspecialchars(mb_strimwidth($description, 0, 48, '...')) . "</td>";
                            echo "<td class='actions-td'>
                                    <a class='icon edit' href='edit.php?id=" . htmlspecialchars($id) . "' title='Edit'>✏️</a>
                                    <a class='icon del' href='delete.php?id=" . htmlspecialchars($id) . "' onclick='return confirm(\"Confirm deletion?\")' title='Delete'>🗑️</a>
                                  </td>";
                            echo "</tr>";
                        }
                        mysqli_stmt_close($statement);
                    } else {
                        echo "<tr><td colspan='9'>An error occurred while fetching records.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>