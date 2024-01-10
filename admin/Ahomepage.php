<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get the full name from the session
$firstName = $_SESSION['first_name'];
$middleName = $_SESSION['middle_name'];
$lastName = $_SESSION['last_name'];

// Generate the initial letter for the middle name
$middleInitial = !empty($middleName) ? $middleName[0] . '.' : '';

// Combine the names
$fullName = $firstName . ' ' . $middleInitial . ' ' . $lastName;

// Fetch additional information from the database (example: student list)
$mysqli = new mysqli("localhost", "root", "", "ZIS");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT student_id, first_name, middle_name, last_name FROM studusers";
$result = $mysqli->query($query);

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Homepage, <?php echo $fullName; ?></h1>

    <!-- Logout form -->
    <form method="post" action="admin\logout.php">
        <button type="submit" name="logout">Logout</button>
    </form>

    <h2>Student List</h2>
    <!-- Display student information in a table -->
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['student_id']}</td>";
                echo "<td>{$row['first_name']}</td>";
                echo "<td>{$row['middle_name']}</td>";
                echo "<td>{$row['last_name']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        // Disable back button after logout
        if (performance.navigation.type == 2) {
            location.reload(true);
        }
    </script>
</body>
</html>
