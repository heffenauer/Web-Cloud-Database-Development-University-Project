<?php
require_once('../database/database.php');

// Check if the location ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $location_id = $_GET['id'];

    // Delete the location record from the database
    $deleteQuery = "DELETE FROM Location WHERE location_id = $location_id";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        // Redirect to a success page or display a success message
        header('Location: location_list.php');
        exit;
    } else {
        // Handle query errors
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    // Handle missing location ID parameter
    echo "Location ID not provided.";
}

mysqli_close($conn);
?>
