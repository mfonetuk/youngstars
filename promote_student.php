<?php
include 'includes/db.php';

// Fetch all students
$query = "SELECT student_id, age, class_level FROM students";
$stmt = $conn->prepare($query);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($students as $student) {
    $student_id = $student['student_id'];
    $age = $student['age'] + 1; // Increment the student's age by 1
    $current_class_level = $student['class_level'];
    $newClassLevel = '';

    // Determine the new class level based on the updated age
    if ($age >= 1 && $age <= 10) {
        $newClassLevel = 'Underage';
    } elseif ($age >= 11 && $age <= 14) {
        $suffix = chr(65 + (intval($student_id) % 10)); // A-J for 100L
        $newClassLevel = "100L $suffix";
    } elseif ($age >= 15 && $age <= 16) {
        $suffix = chr(65 + (intval($student_id) % 10)); // A-J for 200L
        $newClassLevel = "200L $suffix";
    } elseif ($age >= 17 && $age <= 20) {
        $suffix = chr(65 + (intval($student_id) % 4)); // A-D for 300L
        $newClassLevel = "300L $suffix";
    } else {
        $newClassLevel = 'Unknown'; // Handle cases where age doesn't match expected ranges
    }

    // Update student class level and age in the database
    $updateQuery = "UPDATE students SET class_level = :class_level, age = :age WHERE student_id = :student_id";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->execute([
        'class_level' => $newClassLevel,
        'age' => $age,
        'student_id' => $student_id
    ]);
}




// Include the deletion script to remove students with class level 'Unknown'
include 'delete_unknown_students.php';
// Redirect to admin.php after operation
header('Location: admin.php');
exit;
?>
