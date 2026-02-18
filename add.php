<?php
include "action.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Event</title>
    <link rel="stylesheet" href="styles/add.css">
</head>
<body>
    <div class="modal-wrap">
        <div class="modal">
            <header class="modal-header">
                <h2>Add New Event</h2>
            </header>

            <form method="POST" action="action.php" class="form-grid" >
                <label>
                    <span class="label-text">Event ID *</span>
                    <input type="text" name="event_id" placeholder="e.g., EVT-2026-001" required>
                </label>

                <label>
                    <span class="label-text">Event Date *</span>
                    <input type="date" name="event_date" required>
                </label>

                <label>
                    <span class="label-text">Start Time *</span>
                    <input type="time" name="start_time" required>
                </label>

                <label>
                    <span class="label-text">End Time *</span>
                    <input type="time" name="end_time" required>
                </label>

                <label>
                    <span class="label-text">Status *</span>
                    <select name="status" required>
                        <option value="Planned">Planned</option>
                        <option value="Active">Active</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </label>

                <label>
                    <span class="label-text">Expected Attendees *</span>
                    <input type="number" name="attendees" min="0" placeholder="e.g., 50" required>
                </label>

                <label class="full">
                    <span class="label-text">Venue *</span>
                    <input type="text" name="venue" placeholder="e.g., Main Auditorium, Building A" required>
                </label>

                <label class="full">
                    <span class="label-text">Description *</span>
                    <textarea name="description" rows="5" placeholder="Enter a detailed description of the event phase..."></textarea>
                </label>

                <div class="form-actions full">
                    <button class="btn-primary" type="submit" name="add">Add Event</button>
                    <a href="index.php" class="btn-cancel" role="button">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>