<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "ZIS");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST["student_id"];
    $password = $_POST["password"];

    // Simple validation
    if (empty($studentID) || empty($password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        // Check if the student ID is in the correct format
        if (!preg_match("/^[0-9-]+$/", $studentID)) {
            echo "<script>alert('Invalid student ID format. Please use only numbers and '-' character.');</script>";
        } else {
            // Check if the student ID and password match
            $query = "SELECT * FROM studusers WHERE student_id='$studentID' AND password='$password'";
            $result = $mysqli->query($query);

            if ($result->num_rows == 1) {
                // Fetch the user data
                $userData = $result->fetch_assoc();
                
                // Set session variables
                $_SESSION['student_id'] = $studentID;
                $_SESSION['first_name'] = $userData['first_name'];
                $_SESSION['middle_name'] = $userData['middle_name'];
                $_SESSION['last_name'] = $userData['last_name'];

                echo "<script>alert('Login successful.'); window.location='homepage.php';</script>";
                exit();
            } else {
                echo "<script>alert('Invalid student ID or password.'); window.location='index.html';</script>";
                exit();
            }
        }
    }

    $mysqli->close();
}
?>
