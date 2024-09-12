<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Register a New Student</h1>
    </header>

    <section>
        <!-- Search Section -->
        <form action="register.php" method="GET" class="search-form">
            <label for="searchTerm">Search Student:</label>
            <input type="text" id="searchTerm" name="searchTerm" placeholder="Enter surname, firstname, or ID">
            <button type="submit">Search</button>
        </form>

        <?php
        include 'includes/db.php';
        include 'classes/Student.php';

        $student = new Student($conn);

        // If search is performed
        if (isset($_GET['searchTerm'])) {
            $searchTerm = $_GET['searchTerm'];
            $students = $student->searchStudent($searchTerm);

            if (count($students) > 0) {
                echo "<h3>Search Results:</h3>";
                echo "<table border='1'>
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
                        <tbody>";
                foreach ($students as $s) {
                    echo "<tr>
                            <td>{$s['student_id']}</td>
                            <td>{$s['surname']}</td>
                            <td>{$s['firstname']}</td>
                            <td>{$s['othername']}</td>
                            <td>{$s['class_level']}</td>
                            <td>{$s['hostel']}</td>
                          </tr>";
                }
                echo "</tbody>
                      </table>";
            } else {
                echo "<p>No students found.</p>";
            }
        }
        ?>

        <!-- Registration Form -->
        <form action="register.php" method="POST" class="registration-form">
            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" required>

            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="othername">Other Name:</label>
            <input type="text" id="othername" name="othername">

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required min="1">

            <label for="phone">Parent's Phone Number:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="church">Church Affiliation:</label>
            <input type="text" id="church" name="church">

            <label for="hostel_preference">Do you want to stay in the hostel?</label>
            <select id="hostel_preference" name="hostel_preference" required>
                <option value="">Select Preference</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>

            <button type="submit">Register</button>
            <a href="index.php" class="button">Back to Home</a>
        </form>

        <?php
        // Registration Process
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $surname = $_POST['surname'];
            $firstname = $_POST['firstname'];
            $othername = $_POST['othername'];
            $gender = $_POST['gender'];
            $age = $_POST['age'];
            $phone = $_POST['phone'];
            $church = $_POST['church'];
            $hostel_preference = $_POST['hostel_preference'];

            // Determine class level based on age
            if ($age >= 11 && $age <= 14) {
                $class_level = '100L';
                $class = chr(rand(65, 74)); // A-J
            } elseif ($age >= 15 && $age <= 16) {
                $class_level = '200L';
                $class = chr(rand(65, 74)); // A-J
            } elseif ($age >= 17 && $age <= 20) {
                $class_level = '300L';
                $class = chr(rand(65, 68)); // A-D
            } else {
                $class_level = 'Underage';
                $class = '';
            }

            // Generate Student ID
            $student_id = $student->generateStudentID();

            // Determine hostel allocation
            if ($hostel_preference == 'Yes') {
                if ($gender == 'Male') {
                    $hostel = 'Male:Hostel A';
                } else {
                    // Randomly assign to one of the female hostels (A, B, C, or D)
                    $female_hostels = ['Hostel A', 'Hostel B', 'Hostel C', 'Hostel D'];
                    $random_hostel = $female_hostels[array_rand($female_hostels)];
                    $hostel = 'Female:' . $random_hostel;
                }
            } else {
                $hostel = 'None';
            }

            // Register the student
            $success = $student->registerStudent($surname, $firstname, $othername, $gender, $age, $phone, $church, "$class_level $class", $hostel, $student_id);

            if ($success) {
                echo "<p>Registration successful. Student ID: $student_id</p>";
            } else {
                echo "<p>Registration failed. Please try again.</p>";
            }
        }
        ?>
    </section>
</body>
</html>
