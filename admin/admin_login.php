<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "ZIS");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["admin_username"];
    $password = $_POST["admin_password"];

    // Simple validation
    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        // Check if the admin username and password match
        $query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
        $result = $mysqli->query($query);

        if ($result->num_rows == 1) {
            // Admin authentication successful
            $_SESSION['admin_username'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid admin credentials.'); window.location='admin_login.html';</script>";
            exit();
        }
    }

    $mysqli->close();
}
?>
<!-- HTML for admin login form goes here -->
