<?php
require_once('../database/database.php');

// Check if the measurement ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $measurement_id = $_GET['id'];

    // Delete the measurement record from the database
    $deleteQuery = "DELETE FROM AirQualityMeasurement WHERE measurement_id = $measurement_id";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        // Redirect to a success page or display a success message
        header('Location: air_quality_measurement_list.php');
        exit;
    } else {
        // Handle query errors
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    // Handle missing measurement ID parameter
    echo "Measurement ID not provided.";
}

mysqli_close($conn);
?>
