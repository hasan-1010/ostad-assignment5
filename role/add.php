<?php
require_once '../functions.php';
session_start();

// Check if the user is an administrator; replace '1' with the actual admin role ID.
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $roleName = $_POST['roleName'];

        if (!empty($roleName)) {
            // Open the roles.txt file in append mode
            $rolesFile = fopen("../roles.txt", "a");

            // Generate a new role ID (you can use a function or increment the last role ID)
            $newRoleID = generateNewRoleID();

            // Create a new role entry
            $newRoleEntry = "$newRoleID|$roleName\n";

            // Append the new role entry to the roles.txt file
            fwrite($rolesFile, $newRoleEntry);

            // Close the file
            fclose($rolesFile);

            // Redirect to the role listing page
            header('Location: index.php');
        } else {
            // Handle validation errors or display an error message
            header('Location: ../error.php');
        }
    }
} else {
    header('Location: ../restricted.php');
}
?>
<?php

// Check if the user is an administrator; replace '1' with the actual admin role ID.
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    // User is an administrator, display the add role page.
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Add Role</title>
        <!-- Add Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="../dashboard.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Roles</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="add.php">New Role</a>
                    </li>
                </ul>
            </div>
            <form action="../logout.php" class="form-inline" method="post">
                <button class="btn btn-danger" type="submit" name="logout">Logout</button>
            </form>
        </nav>

        <div class="container mt-5">
            <h2>Add Role</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="roleName">Role Name</label>
                    <input type="text" class="form-control" id="roleName" name="roleName" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Role</button>
            </form>
        </div>

        <!-- Add Bootstrap JS and Popper.js for optional features -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>
<?php
} else {
    // User is not an administrator, redirect them to a restricted access page or display an error message.
    header('Location: ../restricted.php');
}
?>