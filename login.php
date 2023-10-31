<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user data from users.txt and validate login
    $users = file("users.txt");
    $loggedIn = false;

    foreach ($users as $user) {
        list($savedUsername, $savedEmail, $hashedPassword, $savedRole) = explode("|", $user);

        if ($savedUsername === $username && password_verify($password, $hashedPassword)) {
            $loggedIn = true;
            break;
        }
    }

    if ($loggedIn) {
        // User is logged in, perform actions (e.g., set a session)
        // You can add additional logic, such as setting a session to authenticate the user
        session_start();
        $role = getRoleById($savedRole);

        $_SESSION['username'] = $username;
        $_SESSION['role'] = trim(strtolower($role['name']));

        if ($_SESSION['role'] == 'admin') {
            header('Location: dashboard.php'); // Redirect to a protected dashboard page
            die();
        } else {
            header('Location: user-account.php');
            die();
        }
    } else {
        // Login failed, redirect to an error page or display an error message
        header('Location: login.php?error=Login Failed.');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Login</title>
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
                <h2>User Login</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="register.php" class="btn btn-info">Register</a>
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