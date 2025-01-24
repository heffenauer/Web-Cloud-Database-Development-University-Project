<?php
require_once('../database/database.php');

// Check if the source ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $source_id = $_GET['id'];

    // Delete the source record from the AirQualitySource table
    $deleteQuery = "DELETE FROM AirQualitySource WHERE source_id = $source_id";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        // Redirect to a success page or display a success message
        header('Location: air_quality_source_list.php');
        exit;
    } else {
        // Handle query errors
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    // Handle missing source ID parameter
    echo "Source ID not provided.";
}

mysqli_close($conn);
?>
