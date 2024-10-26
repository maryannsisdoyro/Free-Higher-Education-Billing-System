<?php
session_start();
include('db_connect.php');

// If form is submitted, handle the login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a statement to select the user by username
    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables for successful login
            $_SESSION['login_id'] = $user['id'];
            $_SESSION['login_username'] = $user['username'];
            $_SESSION['login_type'] = $user['type'];

            // Redirect to the home page after login
            header('Location: index.php?page=home');
            exit();
        } else {
            $error = "Username or password is incorrect.";  // Wrong password
        }
    } else {
        $error = "Username or password is incorrect.";  // Username not found
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <link rel="stylesheet" href="path/to/bootstrap.min.css"> <!-- Include Bootstrap -->
</head>
<style>
    body {
        background: linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.3)), url('./assets/bg-img.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
    main#main {
        width: 100%;
        height: 100vh;
        display: flex;
    }
</style>
<body class="bg-dark">

<main class="container" id="main">
    <div class="align-self-center w-100">
        <h4 class="text-white text-center"><b><?php echo htmlspecialchars($_SESSION['system']['name'] ?? 'System Name'); ?></b></h4>
        <div id="login-center" class="row justify-content-center">
            <div class="card col-md-4">
                <div class="card-body">
                    <!-- Display any errors if login fails -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form id="login-form" method="POST" action="login.php">
                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <div style="position: relative;">
                                <input type="password" id="password" name="password" class="form-control my-2" required>
                                <i class="bx bx-show fs-4" style="cursor: pointer; position: absolute; top: 0; right: 0; margin: 12px 10px 0 0;" id="show-pass1"></i>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="forgot-password.php">Forgot Password</a>
                            <button type="submit" class="btn-sm btn-block btn-wave col-md-4 btn-danger">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Show/hide password functionality
    let showPass1 = document.getElementById('show-pass1');
    showPass1.onclick = () => {
        let passwordInp = document.getElementById('password');
        if (passwordInp.getAttribute('type') === 'password') {
            showPass1.classList.replace('bx-show', 'bx-low-vision');
            passwordInp.setAttribute('type', 'text');
        } else {
            showPass1.classList.replace('bx-low-vision', 'bx-show');
            passwordInp.setAttribute('type', 'password');
        }
    };
</script>

<!-- Include necessary JS (e.g., jQuery, Bootstrap) -->
<script src="path/to/jquery.min.js"></script>
<script src="path/to/bootstrap.bundle.min.js"></script>
</body>
</html>
