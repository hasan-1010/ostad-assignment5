<?php
session_start();

// Check if the user is an administrator; replace '1' with the actual admin role ID.
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ensure that a role ID and new role name are provided in the form data.
        if (isset($_POST['roleID']) && isset($_POST['roleName'])) {

            $roleIDToEdit = $_POST['roleID'];
            $newRoleName = $_POST['roleName'];
            // Open the roles.txt file in read mode.
            $rolesFile = fopen("../roles.txt", "r");

            // Initialize an array to store updated roles.
            $updatedRoles = [];

            // Read the file line by line, updating the role name if the role ID matches.
            while (!feof($rolesFile)) {
                $line = fgets($rolesFile);
                if ($line !== false) {
                    list($roleID, $roleName) = explode('|', $line);

                    // Check if the role ID matches the one to edit.
                    if ((int)$roleID === (int)$roleIDToEdit) {
                        // Update the role name.
                        $line = "$roleID|$newRoleName\n";
                    }

                    // Add this role to the updated roles array.
                    $updatedRoles[] = $line;
                }
            }

            // Close the file.
            fclose($rolesFile);

            // Reopen the roles.txt file in write mode to overwrite it.
            $rolesFile = fopen("../roles.txt", "w");

            // Write the updated roles back to the file.
            foreach ($updatedRoles as $updatedRole) {
                fwrite($rolesFile, $updatedRole);
            }

            // Close the file again.
            fclose($rolesFile);

            // Redirect to the role listing page.
            header('Location: index.php');
            die();
        } else {
            // Handle cases where the role ID or role name is not provided.
            header('Location: ../error.php');
        }
    }
} else {
    header('Location: ../restricted.php');
}


// Check if the user is an administrator; replace '1' with the actual admin role ID.
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Ensure that a role ID is provided in the URL.
        if (isset($_GET['id'])) {
            $roleIDToEdit = $_GET['id'];

            // Open the roles.txt file in read mode.
            $rolesFile = fopen("../roles.txt", "r");

            // Initialize a variable to store the role to edit.
            $roleToEdit = null;

            // Read the file line by line to find the role to edit.
            while (!feof($rolesFile)) {
                $line = fgets($rolesFile);
                if ($line !== false) {
                    list($roleID, $roleName) = explode('|', $line);

                    // Check if the role ID matches the one to edit.
                    if ((int)$roleID === (int)$roleIDToEdit) {
                        // Store the role to edit.
                        $roleToEdit = $line;
                        break; // Role found, no need to continue searching.
                    }
                }
            }

            // Close the file.
            fclose($rolesFile);

            // Check if the role was found.
            if ($roleToEdit !== null) {
                list($roleID, $roleName) = explode('|', $roleToEdit);
                // Display the "Edit Role" form with the existing role name.
?>
                <!DOCTYPE html>
                <html>

                <head>
                    <title>Edit Role</title>
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
                        <h2>Edit Role</h2>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="roleName">Role Name</label>
                                <input type="text" class="form-control" id="roleName" name="roleName" value="<?= $roleName ?>" required>
                            </div>
                            <input type="hidden" name="roleID" value="<?= $roleIDToEdit ?>">
                            <button type="submit" class="btn btn-primary">Update</button>
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
                // Handle cases where the role to edit was not found.
                header('Location: ../error.php');
            }
        } else {
            // Handle cases where no role ID is provided in the URL.
            header('Location: ../error.php');
        }
    } else {
        header('Location: ../error.php');
    }
} else {
    // User is not an administrator, redirect them to a restricted access page or display an error message.
    header('Location: ../restricted.php');
}
