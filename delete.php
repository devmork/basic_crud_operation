<?php
include 'includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = $_GET['id'];

$sql = "DELETE FROM attendance WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        echo "An error occurred while deleting the record.";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "An error occurred while preparing the statement.";
}
?>