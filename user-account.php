<?php
session_start();

if (!isset($_SESSION['username'])) {
    // The user is not logged in, so redirect to the login page.
    header('Location: login.php');
    exit(); // Make sure to exit to prevent further execution.
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <!-- Create the Bootstrap navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <form action="logout.php" class="form-inline" method="post">
            <button class="btn btn-danger" type="submit" name="logout">Logout</button>
        </form>
    </nav>

    <div class="container mt-5">
        <!-- Dashboard content goes here -->
        General User Dashboard
    </div>

    <!-- Add Bootstrap JS and Popper.js for optional features -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>