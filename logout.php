<?php
if (!isset($_SESSION['username'])) {
    // The user is not logged in, so redirect to the login page.
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // If the "Logout" button is clicked, destroy the session and redirect to the login page.
    session_destroy();
    header('Location: login.php');
    exit();
}
