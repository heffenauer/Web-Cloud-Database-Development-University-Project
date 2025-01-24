<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

session_start(); // Start the session

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform user authentication and admin verification logic here
    // Example:
    $query = "SELECT * FROM User WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Store the user ID in the session
        $_SESSION['user_id'] = $user['user_id'];
        // Redirect to home page or perform user-specific actions
        header('Location: home.php');
        exit;
    } else {
        // Handle authentication failure
        echo "Invalid email or password.";
    }
}

mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login @ Air Quality Monitor</title>
    <link rel="stylesheet" href="../styles/login_style.css">
</head>
<body>
<h1>Air Quality Monitor</h1>
<br>
<main>
    <div class="login">
        <img class="loginimage" src="../images/bestweather.svg" alt="">
        <div class="inputs">
            <form method="POST" action="login.php">
                <p id="email_text">Email:</p>
                <input type="email" id="email" name="email" placeholder="Enter email" required>
                <p>Password:</p>
                <div class="input-container">
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <button type="button" id="reveal-password" onclick="togglePassword()">Reveal</button>
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="sign_up.php">Sign up</a></p>
        </div>
    </div>
</main>
</body>
</html>
