<?php
include 'includes/db.php';

$errors = [];
$event_id = $phase_date = $start_time = $end_time = $phase_status = $expected_attendees = $description = $venue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = trim($_POST['event_id'] ?? '');
    $phase_date = trim($_POST['phase_date'] ?? '');
    $start_time = trim($_POST['start_time'] ?? '');
    $end_time = trim($_POST['end_time'] ?? '');
    $phase_status = trim($_POST['phase_status'] ?? '');
    $expected_attendees = trim($_POST['expected_attendees'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $venue = trim($_POST['venue'] ?? '');

    // Validation (unchanged)
    if (empty($event_id)) $errors[] = "Event ID is required.";
    if (empty($phase_date) || !DateTime::createFromFormat('Y-m-d', $phase_date)) $errors[] = "Valid phase date is required.";
    //if (empty($start_time) || !DateTime::createFromFormat('H:i:s', $start_time)) $errors[] = "Valid start time is required.";
    //if (empty($end_time) || !DateTime::createFromFormat('H:i:s', $end_time)) $errors[] = "Valid end time is required.";
    if (empty($phase_status) || !in_array($phase_status, ['Planned', 'Active', 'Completed', 'Cancelled'])) $errors[] = "Valid status is required.";
    if (empty($expected_attendees) || !is_numeric($expected_attendees) || $expected_attendees < 0) $errors[] = "Expected attendees must be a non-negative number.";
    if (empty($venue)) $errors[] = "Venue is required.";

    if (empty($errors)) {
        $sql = "INSERT INTO attendance (event_id, phase_date, start_time, end_time, phase_status, expected_attendees, description, venue) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssiss", $event_id, $phase_date, $start_time, $end_time, $phase_status, $expected_attendees, $description, $venue);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php");
                exit;
            } else {
                $errors[] = "An error occurred while adding the record.";
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
    <title>Add Attendance Phase</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Add New Attendance Phase</h1>
    <?php if (!empty($errors)): ?>
        <ul class="error">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="POST">
        <!-- Form fields remain unchanged from previous version -->
        <label>Event ID: <input type="text" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>"></label><br>
        <label>Phase Date: <input type="date" name="phase_date" value="<?php echo htmlspecialchars($phase_date); ?>"></label><br>
        <label>Start Time: <input type="time" name="start_time" value="<?php echo htmlspecialchars($start_time); ?>"></label><br>
        <label>End Time: <input type="time" name="end_time" value="<?php echo htmlspecialchars($end_time); ?>"></label><br>
        <label>Status: 
            <select name="phase_status">
                <option value="Planned" <?php echo $phase_status === 'Planned' ? 'selected' : ''; ?>>Planned</option>
                <option value="Active" <?php echo $phase_status === 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="Completed" <?php echo $phase_status === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="Cancelled" <?php echo $phase_status === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </label><br>
        <label>Expected Attendees: <input type="number" name="expected_attendees" value="<?php echo htmlspecialchars($expected_attendees); ?>"></label><br>
        <label>Description: <textarea name="description"><?php echo htmlspecialchars($description); ?></textarea></label><br>
        <label>Venue: <input type="text" name="venue" value="<?php echo htmlspecialchars($venue); ?>"></label><br>
        <button type="submit">Add Phase</button>
    </form>
    <a href="index.php">Back to List</a>
</body>
</html>