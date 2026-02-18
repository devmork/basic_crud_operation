<?php
include 'includes/db.php';

$query = mysqli_query($conn, "SELECT * FROM attendance");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="styles/index.css"> 
</head>
<body>
    <header class="page-header">
        <div class="brand">
            <div>
                <h1>Event Management</h1>
                <p class="subtitle">Track and manage events.</p>
            </div>
        </div>
        <a class="btn primary" href="add.php">+ Add New Event</a>
    </header>

    <main class="container">
        <section class="card toolbar">
            <div class="toolbar-inner">
                <div class="left">
                    <h2>Event Records</h2>
                </div>

                <div class="controls">
                    <select id="statusFilter" class="filter-select" aria-label="Filter status">
                        <option value="">All Status</option>
                        <option value="Planned">Planned</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
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
                        <th>Expected Attendees</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                
                <tbody> 
                    <?php 
                     while ($events = mysqli_fetch_assoc($query)) :
                    ?>
                    <tr>
                        <td><?= $events['id'] ?></td>
                        <td><?= $events['event_id'] ?></td>
                        <td><?= $events['event_date'] ?></td>
                        <td><?= $events['start_time'] ?> - <?= $events['end_time'] ?></td>
                        <td><span class='badge <?= strtolower($events['status']) ?>'><?= $events['status'] ?></span></td>
                        <td><?= $events['expected_attendees'] ?></td>
                        <td><?= $events['venue'] ?></td>
                        <td><?= $events['description'] ?></td>
                        <td class='actions-td'>
                            <a class='icon edit' href='edit.php?id=<?= htmlspecialchars($events['id']) ?>' title='Edit'>✏️</a>
                            <a class='icon del' href='delete.php?id=<?= htmlspecialchars($events['id']) ?>' onclick='return confirm("Confirm deletion?")' title='Delete'>🗑️</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>