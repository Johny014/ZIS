<?php
$mysqli = new mysqli("localhost", "root", "", "ZIS");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["first_name"];
    $middleName = $_POST["middle_name"];
    $lastName = $_POST["last_name"];
    $studentID = $_POST["student_id"];
    $password = $_POST["password"];

    // Simple validation
    if (empty($firstName) || empty($lastName) || empty($studentID) || empty($password)) {
        echo "<script>alert('Please fill in all required fields.');window.location='index.html';</script>";
    } else {
        // Check if the student ID is in the correct format
        if (!preg_match("/^[0-9-]+$/", $studentID)) {
            echo "<script>alert('Invalid student ID format. Please use only numbers and '-' character.');window.location='index.html';</script>";
        } else {
            // Check if the student ID is already taken
            $checkQuery = "SELECT student_id FROM studusers WHERE student_id='$studentID'";
            $result = $mysqli->query($checkQuery);

            if ($result->num_rows > 0) {
                echo "<script>alert('Student ID is already taken. Please choose another one.');window.location='index.html';</script>";
            } else {
                // Insert new user into the database
                $query = "INSERT INTO studusers (first_name, middle_name, last_name, student_id, password) VALUES ('$firstName', '$middleName', '$lastName', '$studentID', '$password')";

                if ($mysqli->query($query) === TRUE) {
                    echo "<script>alert('Registration successful.'); window.location='homepage.php';</script>";
                 exit();
            } else {
                echo "<script>alert('Error: " . $query . "<br>" . $mysqli->error . "'); window.location='index.html';</script>";
                exit();
            }
            }
        }
    }

    $mysqli->close();
}
?>
