<?php
session_start(); // Initialize sessions

// Check if the user is logged in
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    // Unset or destroy the session variables
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session

    // Redirect to a login page or any other page
    header("Location: login.php");
    exit;
} else {
    // If the user is not logged in, you can redirect them to a login page
    header("Location: login.php");
    exit;
}
?>