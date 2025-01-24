<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform validation on the input fields
    // ...

    // Check if the email already exists in the database
    $checkQuery = "SELECT * FROM User WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        echo "Email already exists.";
    } else {
        // Insert the new user into the database
        $insertQuery = "INSERT INTO User (username, city, email, password, is_admin) VALUES ('$username', '$city', '$email', '$password', 0)";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            mysqli_close($conn);
            // Display success message and redirect to login.php after a delay
            echo '<script>
                    setTimeout(function() {
                        alert("User account created successfully.");
                        window.location.href = "login.php";
                    }, 1000);
                </script>';
            exit;
        } else {
            echo "Error creating user account: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up @ Air Quality Monitor</title>
    <link rel="stylesheet" href="../styles/signup_style.css">
    <script src="../styles/global.js"></script>
</head>
<body>
<h1>Air Quality Monitor</h1>
<br>
<main>
    <div class="signup">
        <div class="inputs">
            <form method="POST" action="sign_up.php">
                <p>Username:</p>
                <input type="text" id="username" name="username" placeholder="Enter username" required>

                <p>City:</p>
                <input type="text" id="city" name="city" placeholder="Enter City" required>

                <p>Email:</p>
                <input type="email" id="email" name="email" placeholder="Enter email" required>

                <p>Password:</p>
                <div class="input-container">
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <button type="button" id="reveal-password" onclick="togglePassword()"> Reveal</button>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</main>
</body>
</html>
