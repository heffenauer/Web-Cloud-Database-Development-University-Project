<?php
require_once('../database/database.php');

// Insert placeholder users
$insertQuery = "INSERT INTO User (user_id ,username, password, email, is_admin) VALUES
(NULL, 'JohnDoe', 'password1', 'johndoe@example.com', 0),
(NULL, 'JaneSmith', 'password2', 'janesmith@example.com', 0),
(NULL, 'AdminUser', 'adminpassword', 'admin@example.com', 1)";

$result = mysqli_query($conn, $insertQuery);

if ($result) {
    echo "Placeholder users added successfully.";
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
