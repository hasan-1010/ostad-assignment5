<?php
session_start();

// Check if the user is an administrator; replace '1' with the actual admin role ID.
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ensure that a role ID is provided in the POST request.
        if (isset($_POST['roleID'])) {
            $roleIDToDelete = $_POST['roleID'];

            // Open the roles.txt file in read mode.
            $rolesFile = fopen("../roles.txt", "r");

            // Initialize an empty array to store roles temporarily.
            $updatedRoles = [];

            // Read the file line by line to find the role to delete.
            while (!feof($rolesFile)) {
                $line = fgets($rolesFile);
                if ($line !== false) {
                    list($roleID, $roleName) = explode('|', $line);

                    // Check if the role ID matches the one to delete.
                    if ((int)$roleID !== (int)$roleIDToDelete) {
                        // If not, add this role to the updated roles array.
                        $updatedRoles[] = $line;
                    }
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
        } else {
            // Handle cases where no role ID is provided.
            header('Location: ../error.php');
        }
    } else {
        header('Location: ../error.php');
    }
} else {
    header('Location: ../restricted.php');
}
