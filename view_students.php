<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details by Class</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        .class-links {
            margin-bottom: 30px;
            padding: 10px;
            background-color: #f4f4f4;
            border-radius: 5px;
        }
        .class-links a {
            display: inline-block;
            margin: 5px;
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #e4e4e4;
            transition: background-color 0.3s ease;
        }
        .class-links a:hover {
            background-color: #ddd;
        }
        .class-section {
            margin-bottom: 30px;
            padding: 10px;
            background-color: #f4f4f4;
            border-radius: 5px;
        }
        .class-section h2 {
            background-color: #ccc;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .class-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .class-section table, .class-section th, .class-section td {
            border: 1px solid #ddd;
        }
        .class-section th, .class-section td {
            padding: 10px;
            text-align: left;
        }
        .class-section th {
            background-color: green;
        }
    </style>
</head>
<body>
    <header>
        <h1>Student Details by Class</h1>
    </header>

    <div class="container">
        <div class="class-links">
            <?php
            include 'includes/db.php';

            // Define specific classes including Underage
            $classes = [
                'Underage' => ['Underage'],
                '100L' => ['100L A', '100L B', '100L C', '100L D', '100L E', '100L F', '100L G', '100L H', '100L I', '100L J'],
                '200L' => ['200L A', '200L B', '200L C', '200L D', '200L E', '200L F', '200L G', '200L H', '200L I', '200L J'],
                '300L' => ['300L A', '300L B', '300L C', '300L D']
            ];

            // Display links for each class
            foreach ($classes as $group_key => $class_list) {
                echo "<div><strong>$group_key Classes:</strong></div>";
                foreach ($class_list as $class) {
                    echo "<a href='view_students.php?class=" . urlencode($class) . "'>$class</a> ";
                }
                echo "<br>";
            }
            ?>
        </div>

        <?php
        // Get the selected class from URL
        if (isset($_GET['class'])) {
            $selected_class = $_GET['class'];

            // Prepare SQL query for the selected class
            $query = "SELECT * FROM students WHERE class_level = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$selected_class]);
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display student details
            if ($students) {
                echo "<div class='class-section'>";
                echo "<h2>Details for Class: $selected_class</h2>";
                echo "<table>";
                echo "<thead><tr><th>ID</th><th>Surname</th><th>First Name</th><th>Other Name</th><th>Age</th><th>Class Level</th><th>Parent's Phone</th><th>Church Affiliation</th></tr></thead>";
                echo "<tbody>";
                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td>{$student['student_id']}</td>";
                    echo "<td>{$student['surname']}</td>";
                    echo "<td>{$student['firstname']}</td>"; // Verify column name
                    echo "<td>{$student['othername']}</td>"; // Verify column name
                    echo "<td>{$student['age']}</td>";
                    echo "<td>{$student['class_level']}</td>";
                    echo "<td>{$student['phone']}</td>"; // Verify column name
                    echo "<td>{$student['church']}</td>"; // Verify column name
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p>No students found in $selected_class.</p>";
            }
        }
        ?>
    </div>
    <a href="index.php" class="button">Back to Home</a>
</body>
</html>
