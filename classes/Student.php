<?php
class Student {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function generateStudentID() {
        $currentYear = date('y'); // Get the last two digits of the current year (e.g., 24 for 2024)
        
        // Query to get the last student ID registered this year
        $query = "SELECT student_id FROM students WHERE student_id LIKE 'YBC/$currentYear/%' ORDER BY student_id DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastID = $result->fetch(PDO::FETCH_ASSOC);

        if ($lastID) {
            // Extract the number part and increment it
            $lastNumber = (int)substr($lastID['student_id'], -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Start with 001 if no student has been registered this year
            $newNumber = '001';
        }

        // Return the new student ID
        return "YBC/$currentYear/$newNumber";
    }

    public function registerStudent($surname, $firstname, $othername, $gender, $age, $phone, $church, $class_level, $hostel, $student_id) {
        $query = "INSERT INTO students (student_id, surname, firstname, othername, gender, age, phone, church, class_level, hostel)
                  VALUES (:student_id, :surname, :firstname, :othername, :gender, :age, :phone, :church, :class_level, :hostel)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            'student_id' => $student_id,
            'surname' => $surname,
            'firstname' => $firstname,
            'othername' => $othername,
            'gender' => $gender,
            'age' => $age,
            'phone' => $phone,
            'church' => $church,
            'class_level' => $class_level,
            'hostel' => $hostel,
        ]);
    }

    private function determineClassLevel($age) {
        if ($age >= 1 && $age <= 10) {
            return 'Underage';
        } elseif ($age >= 11 && $age <= 14) {
            return '100L';
        } elseif ($age >= 15 && $age <= 16) {
            return '200L';
        } elseif ($age >= 17 && $age <= 20) {
            return '300L';
        } else {
            return 'Unknown';
        }
    }

    public function searchStudent($searchTerm) {
        $query = "SELECT * FROM students WHERE surname LIKE :searchTerm OR firstname LIKE :searchTerm OR student_id LIKE :searchTerm";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['searchTerm' => "%$searchTerm%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
