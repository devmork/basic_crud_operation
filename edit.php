<?php
include "action.php";

$id = $_GET["id"];
$query = mysqli_query($conn, "SELECT * FROM events WHERE id = '$id'");
$event = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <link rel="stylesheet" href="styles/form.css">
</head>
<body>
    <div class="modal-wrap">
        <div class="modal">
            <header class="modal-header">
                <h2>Edit Event</h2>
            </header>

            <form method="POST" action="action.php" class="form-grid" >
                <label>
                    <span class="label-text">Event ID *</span>
                    <input type="text" name="event_id" placeholder="e.g., EVT-2026-001" required value="<?= htmlspecialchars($event['event_id']); ?>">
                </label>

                <label>
                    <span class="label-text">Event Date *</span>
                    <input type="date" name="event_date" required value="<?= htmlspecialchars($event['event_date']); ?>">
                </label>

                <label>
                    <span class="label-text">Start Time *</span>
                    <input type="time" name="start_time" required value="<?= htmlspecialchars($event['start_time']); ?>">
                </label>

                <label>
                    <span class="label-text">End Time *</span>
                    <input type="time" name="end_time" required value="<?= htmlspecialchars($event['end_time']); ?>">
                </label>

                <label>
                    <span class="label-text">Status *</span>
                    <select name="status" required>
                        <option value="Planned" <?= $event['status'] == 'Planned' ? 'selected' : ''; ?>>Planned</option>
                        <option value="Active" <?= $event['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                        <option value="Completed" <?= $event['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="Cancelled" <?= $event['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </label>

                <label>
                    <span class="label-text">Expected Attendees *</span>
                    <input type="number" name="attendees" min="0" placeholder="e.g., 50" required value="<?= htmlspecialchars($event['expected_attendees']); ?>">
                </label>

                <label class="full">
                    <span class="label-text">Venue *</span>
                    <input type="text" name="venue" placeholder="e.g., Main Auditorium, Building A" required value="<?= htmlspecialchars($event['venue']); ?>">
                </label>

                <label class="full">
                    <span class="label-text">Description *</span>
                    <textarea name="description" rows="5" placeholder="Enter a detailed description of the event phase..."><?= htmlspecialchars($event['description']); ?></textarea>
                </label>

                <div class="form-actions full">
                    <button class="btn-primary" type="submit" name="update">Update Event</button>
                    <a href="index.php" class="btn-cancel" role="button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>