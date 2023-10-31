<?php
// Read users from the file
function getUsers()
{
    $users = file("users.txt", FILE_IGNORE_NEW_LINES);
    $userList = [];

    foreach ($users as $user) {
        $userData = explode("|", $user);
        $userList[] = [
            'id' => $userData[0],
            'username' => $userData[1],
            'email' => $userData[2],
            'roleId' => $userData[4],
        ];
    }

    return $userList;
}
function getUserByUsername($username)
{
    $usersFile = fopen("users.txt", "r");

    while (!feof($usersFile)) {
        $line = fgets($usersFile);
        if ($line !== false) {
            list($userName, $userEmail) = explode('|', $line);

            if ($userName === $username) {
                fclose($usersFile);
                return ['username' => $userName, 'email' => $userEmail];
            }
        }
    }

    fclose($usersFile);
    return null; // User not found
}

// Add a new user
function addUser($firstName, $lastName, $roleId)
{
    $users = file_get_contents("users.txt");
    $userCount = count(explode("\n", $users));
    $newUserId = $userCount + 1;
    $newUser = "$newUserId|$firstName|$lastName|$roleId\n";
    file_put_contents("users.txt", $newUser, FILE_APPEND);
}

// Read roles from the file
function getRoles()
{
    $roles = file($_SERVER['DOCUMENT_ROOT'] . "/ostad-assignment5/roles.txt", FILE_IGNORE_NEW_LINES);
    $roleList = [];

    foreach ($roles as $role) {
        list($id, $name) = explode("|", $role);
        $roleList[$id] = $name;
    }

    return $roleList;
}

function generateNewRoleID()
{
    // Open the roles.txt file in read mode
    $rolesFile = fopen($_SERVER['DOCUMENT_ROOT'] . "/ostad-assignment5/roles.txt", "r");

    // Initialize the new ID
    $newRoleID = 1; // Default ID if there are no existing roles

    // Read the file line by line to find the last role ID
    while (!feof($rolesFile)) {
        $line = fgets($rolesFile);
        if ($line !== false) {
            list($roleID, $roleName) = explode('|', $line);
            $newRoleID = max($newRoleID, (int)$roleID + 1);
        }
    }

    // Close the file
    fclose($rolesFile);

    return $newRoleID;
}

function getRoleById($roleID)
{
    // Open the roles.txt file in read mode
    $rolesFile = fopen("roles.txt", "r");

    // Initialize a variable to store the role
    $role = null;

    // Read the file line by line to find the role by ID
    while (!feof($rolesFile)) {
        $line = fgets($rolesFile);
        if ($line !== false) {
            list($existingRoleID, $roleName) = explode('|', $line);

            // Check if the role ID matches the one we are looking for
            if ((int)$existingRoleID === (int)$roleID) {
                // Role found, store it and break out of the loop
                $role = ['id' => $existingRoleID, 'name' => $roleName];
                break;
            }
        }
    }

    // Close the file
    fclose($rolesFile);

    return $role;
}
