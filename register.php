<?php
require_once 'functions.php';
$roles = $roles = getRoles();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $exist = getUserByUsername($username);
    if (!empty($exist)) {
        header('Location: register.php?error=User name already taken.');
        die();
    }
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $roleId = $_POST['roleId'];

    $userData = "$username|$email|$password|$roleId\n";

    file_put_contents("users.txt", $userData, FILE_APPEND);

    // Redirect
    header('Location: login.php?success=Registration has been completed.');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Registration</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <?php if (isset($_REQUEST['success'])) : ?>
                    <div class="alert alert-success"><?= $_REQUEST['success'] ?></div>
                <?php endif; ?>
                <?php if (isset($_REQUEST['error'])) : ?>
                    <div class="alert alert-danger"><?= $_REQUEST['error'] ?></div>
                <?php endif; ?>
                <h2>User Registration</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="roleId">Role</label>
                        <select class="form-control" id="roleId" name="roleId">
                            <?php foreach ($roles as $roleid => $role) : ?>
                                <option value="<?= $roleid ?>"><?= $role ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                    <a href="login.php" class="btn btn-info">Login</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js for optional features -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>