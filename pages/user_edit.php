<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

// Check if the user ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $username = $_POST['username'];
        $city = $_POST['city'];
        $email = $_POST['email'];
        $is_admin = $_POST['is_admin'];

        // Update the user data in the database
        $query = "UPDATE User SET username = '$username', city = '$city',  email = '$email', is_admin = '$is_admin' WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirect to a success page or display a success message
            header('Location: user_list.php');
            exit;
        } else {
            // Handle query errors
            echo "Error executing query: " . mysqli_error($conn);
        }
    }

    // Fetch the existing user data from the database
    $query = "SELECT * FROM User WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // Check if the user exists
    if (!$user) {
        // Redirect to an error page or display an error message
        echo " User not found.";
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
        <title>Edit @ Air Quality Monitor</title>
    </head>
    <body>
    <h1>Edit User</h1>
    <form method="POST" action="user_edit.php?id=<?php echo $user_id; ?>">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>"><br><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo $user['city']; ?>"><br><br>

        <label for="is_admin">is_admin:</label>
        <input type="text" id="is_admin" name="is_admin" value="<?php echo $user['is_admin']; ?>"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br><br>

        <input type="submit" value="Save">
    </form>
    </body>
    </html>

    <?php
} else {
    // Handle missing user ID parameter
    echo " User ID not provided.";
}
?>
