<?php
require_once('../database/database.php');

if (isset($_GET['id'])) {
    $parameterId = $_GET['id'];

    $deleteQuery = "DELETE FROM AirQualityParameter WHERE parameter_id = $parameterId";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        header('Location: air_quality_parameter_list.php');
        exit;
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    echo "Parameter ID not provided.";
}

mysqli_close($conn);
?>
