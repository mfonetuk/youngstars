<?php
include 'includes/db.php';

// Delete students where class_level is 'Unknown'
$deleteQuery = "DELETE FROM students WHERE class_level = 'Unknown'";
$deleteStmt = $conn->prepare($deleteQuery);
$deleteStmt->execute();

// Redirect to admin.php after operation
header('Location: admin.php');
exit;
?>
