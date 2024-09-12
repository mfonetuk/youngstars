<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <style>
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        .stats {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .stats div {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
        }
        .promote-section {
            text-align: center;
            margin-top: 30px;
        }
        .promote-section a {
            padding: 10px 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: #000;
        }
        .promote-section a:hover {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <div class="container">
        <h2>College Statistics</h2>

        <div class="stats">
            <div>
                <h3>Total Students in College</h3>
                <p>
                    <?php
                    include 'includes/db.php';
                    $query = "SELECT COUNT(*) AS total_students FROM students";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo $result['total_students'];
                    ?>
                </p>
            </div>
            <div>
                <h3>Total Boys</h3>
                <p>
                    <?php
                    $query = "SELECT COUNT(*) AS total_boys FROM students WHERE gender = 'Male'";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo $result['total_boys'];
                    ?>
                </p>
            </div>
            <div>
                <h3>Total Girls</h3>
                <p>
                    <?php
                    $query = "SELECT COUNT(*) AS total_girls FROM students WHERE gender = 'Female'";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo $result['total_girls'];
                    ?>
                </p>
            </div>
        </div>

        <h2>Students per Class</h2>
        <div class="stats">
            <?php
            // Individual classes
            $class_levels = [
                'Underage' => 'Underage',
                '100L A' => '100L A',
                '100L B' => '100L B',
                '100L C' => '100L C',
                '100L D' => '100L D',
                '100L E' => '100L E',
                '100L F' => '100L F',
                '100L G' => '100L G',
                '100L H' => '100L H',
                '100L I' => '100L I',
                '100L J' => '100L J',
                '200L A' => '200L A',
                '200L B' => '200L B',
                '200L C' => '200L C',
                '200L D' => '200L D',
                '200L E' => '200L E',
                '200L F' => '200L F',
                '200L G' => '200L G',
                '200L H' => '200L H',
                '200L I' => '200L I',
                '200L J' => '200L J',
                '300L A' => '300L A',
                '300L B' => '300L B',
                '300L C' => '300L C',
                '300L D' => '300L D',
            ];

            // Display total students for each individual class
            foreach ($class_levels as $class_name) {
                $query = "SELECT COUNT(*) AS total_students FROM students WHERE class_level = :class_level";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':class_level', $class_name);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<div>
                        <h3>$class_name</h3>
                        <p>{$result['total_students']}</p>
                      </div>";
            }
            ?>
        </div>

        <h2>Grouped Class Statistics</h2>
        <div class="stats">
            <?php
            // Grouped classes
            $grouped_classes = [
                'Underage' => ['Underage'],
                '100L' => ['100L A', '100L B', '100L C', '100L D', '100L E', '100L F', '100L G', '100L H', '100L I', '100L J'],
                '200L' => ['200L A', '200L B', '200L C', '200L D', '200L E', '200L F', '200L G', '200L H', '200L I', '200L J'],
                '300L' => ['300L A', '300L B', '300L C', '300L D'],
            ];

            // Display total students for each grouped class
            foreach ($grouped_classes as $group_key => $classes) {
                $placeholders = implode(',', array_fill(0, count($classes), '?'));
                $query = "SELECT COUNT(*) AS total_students FROM students WHERE class_level IN ($placeholders)";
                $stmt = $conn->prepare($query);
                
                // Bind the parameters
                $stmt->execute($classes);
                
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<div>
                        <h3>$group_key</h3>
                        <p>{$result['total_students']}</p>
                      </div>";
            }
            ?>
        </div>

        <div class="promote-section">
            <h2>Promote Students</h2>
            <a href="promote_student.php">Promote Students</a>
            <a href="index.php" class="button">Back to Home</a>
        </div>
    </div>
</body>
</html>
