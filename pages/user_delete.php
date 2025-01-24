<?php
require_once('../database/database.php');

// Check if the user ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete the user record from the database
    $deleteQuery = "DELETE FROM User WHERE user_id = $user_id";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        // Redirect to a success page or display a success message
        header('Location: user_list.php');
        exit;
    } else {
        // Handle query errors
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    // Handle missing user ID parameter
    echo "User ID not provided.";
}

mysqli_close($conn);
?>
