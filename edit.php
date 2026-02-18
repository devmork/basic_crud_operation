<?php
include 'includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int)$_GET['id'];

$sql = "SELECT id, event_id, event_date, start_time, end_time, status, attendees, description, venue
        FROM attendance WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $rid, $event_id, $event_date, $start_time, $end_time, $status, $attendees, $description, $venue);
    if (!mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "An error occurred.";
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = trim($_POST['event_id'] ?? '');
    $event_date = trim($_POST['event_date'] ?? '');
    $start_time = trim($_POST['start_time'] ?? '');
    $end_time = trim($_POST['end_time'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $attendees = trim($_POST['attendees'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $venue = trim($_POST['venue'] ?? '');

    if (empty($event_id)) $errors[] = "Event ID is required.";
    if (empty($event_date) || !DateTime::createFromFormat('Y-m-d', $event_date)) $errors[] = "Valid event date is required.";
    // accept H:i or H:i:s or empty
    if ($start_time !== '' && !DateTime::createFromFormat('H:i', $start_time) && !DateTime::createFromFormat('H:i:s', $start_time)) {
        $errors[] = "Valid start time is required.";
    }
    if ($end_time !== '' && !DateTime::createFromFormat('H:i', $end_time) && !DateTime::createFromFormat('H:i:s', $end_time)) {
        $errors[] = "Valid end time is required.";
    }
    if (empty($status) || !in_array($status, ['Planned', 'Active', 'Completed', 'Cancelled'])) $errors[] = "Valid status is required.";
    if ($attendees === '' || !is_numeric($attendees) || $attendees < 0) $errors[] = "Expected attendees must be a non-negative number.";
    if (empty($venue)) $errors[] = "Venue is required.";

    if (empty($errors)) {
        $sql = "UPDATE attendance SET event_id = ?, event_date = ?, start_time = ?, end_time = ?, status = ?, attendees = ?, description = ?, venue = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            $ai = (int)$attendees;
            mysqli_stmt_bind_param($stmt, "sssssissi", $event_id, $event_date, $start_time, $end_time, $status, $ai, $description, $venue, $id);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                header("Location: index.php");
                exit;
            } else {
                $errors[] = "An error occurred while updating the record.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = "An error occurred while preparing the statement.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event Attendance</title>
    <link rel="stylesheet" href="styles/add.css">
</head>
<body>
    <div class="modal-wrap">
        <div class="modal">
            <header class="modal-header">
                <h2>Edit Event Attendance</h2>
                <a href="index.php" class="close">✕</a>
            </header>

            <?php if (!empty($errors)): ?>
                <div class="errors">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" class="form-grid" novalidate>
                <label>
                    <span class="label-text">Event ID *</span>
                    <input type="text" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>" placeholder="e.g., EVT-2026-001" required>
                </label>

                <label>
                    <span class="label-text">Event Date *</span>
                    <input type="date" name="event_date" value="<?php echo htmlspecialchars($event_date); ?>" required>
                </label>

                <label>
                    <span class="label-text">Start Time *</span>
                    <input type="time" name="start_time" value="<?php echo htmlspecialchars($start_time); ?>">
                </label>

                <label>
                    <span class="label-text">End Time *</span>
                    <input type="time" name="end_time" value="<?php echo htmlspecialchars($end_time); ?>">
                </label>

                <label>
                    <span class="label-text">Status *</span>
                    <select name="status" required>
                        <option value="Planned" <?php echo ($status === 'Planned') ? 'selected' : ''; ?>>Planned</option>
                        <option value="Active" <?php echo ($status === 'Active') ? 'selected' : ''; ?>>Active</option>
                        <option value="Completed" <?php echo ($status === 'Completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="Cancelled" <?php echo ($status === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </label>

                <label>
                    <span class="label-text">Expected Attendees *</span>
                    <input type="number" name="attendees" min="0" value="<?php echo htmlspecialchars($attendees); ?>" placeholder="e.g., 50" required>
                </label>

                <label class="full">
                    <span class="label-text">Venue *</span>
                    <input type="text" name="venue" value="<?php echo htmlspecialchars($venue); ?>" placeholder="e.g., Main Auditorium, Building A" required>
                </label>

                <label class="full">
                    <span class="label-text">Description *</span>
                    <textarea name="description" rows="5" placeholder="Enter a detailed description of the event phase..."><?php echo htmlspecialchars($description); ?></textarea>
                </label>

                <div class="form-actions full">
                    <button class="btn-primary" type="submit">Update Event Attendance</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>