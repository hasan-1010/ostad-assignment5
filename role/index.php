<?php
require_once '../functions.php';
session_start();

// Check if the user is an administrator; replace '1' with the actual admin role ID.
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    // User is an administrator, display the role listing page.
    // Fetch roles from your roles.txt file or database and display them.
    $roles = getRoles(); // Implement this function to get roles.

    // Display the roles in a table.
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Role Listing</title>
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
            <h2>Role Listing</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Role ID</th>
                        <th>Role Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $roleid => $role) : ?>
                        <tr>
                            <td><?= $roleid ?></td>
                            <td><?= $role ?></td>
                            <td>
                                <a href="edit.php?id=<?= $roleid ?>" class="btn btn-primary">Edit</a>
                                <form action="delete.php" method="post" onsubmit="confirm('Are you sure you want to delete this Role?')" style="display: contents;">
                                    <input type="hidden" name="roleID" value="<?= $roleid ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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