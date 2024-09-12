<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Hostel Students</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <style>
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        .toggle-buttons {
            margin-bottom: 20px;
            text-align: center;
        }
        .toggle-buttons button {
            padding: 10px 20px;
            font-size: 16px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
        .toggle-buttons button:hover {
            background-color: #f0f0f0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Students Hostel Status</h1>
    </header>

    <div class="container">
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
            <button id="showMaleHostel">Show Male Hostel Students</button>
            <button id="showFemaleHostel">Show Female Hostel Students</button>
            <button id="showNoHostel">Show Non-Hostel Students</button>
        </div>

        <!-- Table to Display Students -->
        <table id="studentsTable">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Other Name</th>
                    <th>Class Level</th>
                    <th>Gender</th>
                    <th>Hostel</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'includes/db.php';

                // Fetch all students
                $query = "SELECT * FROM students";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($students as $s) {
                    $hostelStatus = ($s['hostel'] && $s['hostel'] != 'None') ? '1' : '0';
                    $gender = htmlspecialchars($s['gender']);
                    echo "<tr class='student-row' data-hostel='$hostelStatus' data-gender='$gender'>
                            <td>{$s['student_id']}</td>
                            <td>{$s['surname']}</td>
                            <td>{$s['firstname']}</td>
                            <td>{$s['othername']}</td>
                            <td>{$s['class_level']}</td>
                            <td>{$s['gender']}</td>
                            <td>{$s['hostel']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showMaleHostelButton = document.getElementById('showMaleHostel');
            const showFemaleHostelButton = document.getElementById('showFemaleHostel');
            const showNoHostelButton = document.getElementById('showNoHostel');
            const rows = document.querySelectorAll('#studentsTable .student-row');

            function showMaleHostelStudents() {
                rows.forEach(row => {
                    if (row.dataset.hostel === '1' && row.dataset.gender === 'Male') {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            }

            function showFemaleHostelStudents() {
                rows.forEach(row => {
                    if (row.dataset.hostel === '1' && row.dataset.gender === 'Female') {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            }

            function showNoHostelStudents() {
                rows.forEach(row => {
                    if (row.dataset.hostel === '0') {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            }

            showMaleHostelButton.addEventListener('click', showMaleHostelStudents);
            showFemaleHostelButton.addEventListener('click', showFemaleHostelStudents);
            showNoHostelButton.addEventListener('click', showNoHostelStudents);
        });
    </script>
</body>
</html>
