<?php
session_start();

// Logout functionality
if (isset($_POST['logout'])) {
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
    }
    
    header("Location: index.html");
    exit();
}
?>
