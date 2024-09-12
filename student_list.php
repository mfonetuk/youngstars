<?php
include 'includes/db.php';
include 'classes/Student.php';

$student = new Student($conn);
$students = $student->searchStudent(""); // Fetch all students
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Student List</h1>
    </header>

    <section>
        <table border="1">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Other Name</th>
                    <th>Class Level</th>
                    <th>Hostel</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($students) > 0) { ?>
                    <?php foreach ($students as $student) { ?>
                        <tr>
                            <td><?php echo $student['student_id']; ?></td>
                            <td><?php echo $student['surname']; ?></td>
                            <td><?php echo $student['firstname']; ?></td>
                            <td><?php echo $student['othername']; ?></td>
                            <td><?php echo $student['class_level']; ?></td>
                            <td><?php echo $student['hostel']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6">No students found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.php" class="button">Back to Home</a>
    </section>
</body>
</html>
