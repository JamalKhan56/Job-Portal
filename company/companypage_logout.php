<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['id_company'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header("Location: ../company_signin.php");
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: ../company_signin.php");
    exit();
}
?>
