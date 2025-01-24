<?php
require_once('../database/database.php');

// Check if the city ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $city_id = $_GET['id'];

    // Delete the city record from the database
    $deleteQuery = "DELETE FROM City WHERE city_id = $city_id";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        // Redirect to a success page or display a success message
        header('Location: city_list.php');
        exit;
    } else {
        // Handle query errors
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    // Handle missing city ID parameter
    echo "City ID not provided.";
}

mysqli_close($conn);
?>
