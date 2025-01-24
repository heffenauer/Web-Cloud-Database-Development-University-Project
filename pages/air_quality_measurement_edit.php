<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

// Check if the measurement ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $measurement_id = $_GET['id'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $location_id = $_POST['location_id'];
        $parameter_id = $_POST['parameter_id'];
        $source_id = $_POST['source_id'];
        $user_id = $_POST['user_id'];
        $measurement_value = $_POST['measurement_value'];
        $measurement_datetime = $_POST['measurement_datetime'];

        // Update the measurement data in the database
        $query = "UPDATE AirQualityMeasurement 
                  SET location_id = '$location_id', 
                      parameter_id = '$parameter_id', 
                      source_id = '$source_id', 
                      user_id = '$user_id', 
                      measurement_value = '$measurement_value', 
                      measurement_datetime = '$measurement_datetime' 
                  WHERE measurement_id = $measurement_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirect to a success page or display a success message
            header('Location: air_quality_measurement_list.php');
            exit;
        } else {
            // Handle query errors
            echo "Error executing query: " . mysqli_error($conn);
        }
    }

    // Fetch the existing measurement data from the database
    $query = "SELECT * FROM AirQualityMeasurement WHERE measurement_id = $measurement_id";
    $result = mysqli_query($conn, $query);
    $measurement = mysqli_fetch_assoc($result);

    // Check if the measurement exists
    if (!$measurement) {
        // Redirect to an error page or display an error message
        echo "Measurement not found.";
        exit;
    }

    // Fetch the available locations, parameters, sources, and users for dropdowns
    $queryLocations = "SELECT * FROM Location";
    $resultLocations = mysqli_query($conn, $queryLocations);

    $queryParameters = "SELECT * FROM AirQualityParameter";
    $resultParameters = mysqli_query($conn, $queryParameters);

    $querySources = "SELECT * FROM AirQualitySource";
    $resultSources = mysqli_query($conn, $querySources);

    $queryUsers = "SELECT * FROM User";
    $resultUsers = mysqli_query($conn, $queryUsers);
    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Edit Air Quality Measurement</title>
    </head>
    <body>
    <h1>Edit Air Quality Measurement</h1>
    <form method="POST" action="air_quality_measurement_edit.php?id=<?php echo $measurement_id; ?>">

        <label for="location_id">Location:</label>
        <select id="location_id" name="location_id">
            <?php while ($location = mysqli_fetch_assoc($resultLocations)): ?>
                <option value="<?php echo $location['location_id']; ?>" <?php if ($location['location_id'] === $measurement['location_id']) echo 'selected'; ?>>
                    <?php echo $location['location_name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="parameter_id">Parameter:</label>
        <select id="parameter_id" name="parameter_id">
            <?php while ($parameter = mysqli_fetch_assoc($resultParameters)): ?>
                <option value="<?php echo $parameter['parameter_id']; ?>" <?php if ($parameter['parameter_id'] === $measurement['parameter_id']) echo 'selected'; ?>>
                    <?php echo $parameter['parameter_name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="source_id">Source:</label>
        <select id="source_id" name="source_id">
            <?php while ($source = mysqli_fetch_assoc($resultSources)): ?>
                <option value="<?php echo $source['source_id']; ?>" <?php if ($source['source_id'] === $measurement['source_id']) echo 'selected'; ?>>
                    <?php echo $source['source_name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="user_id">User:</label>
        <select id="user_id" name="user_id">
            <?php while ($user = mysqli_fetch_assoc($resultUsers)): ?>
                <option value="<?php echo $user['user_id']; ?>" <?php if ($user['user_id'] === $measurement['user_id']) echo 'selected'; ?>>
                    <?php echo $user['username']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="measurement_value">Measurement Value:</label>
        <input type="text" id="measurement_value" name="measurement_value" value="<?php echo $measurement['measurement_value']; ?>"><br><br>

        <label for="measurement_datetime">Measurement Datetime:</label>
        <input type="datetime-local" id="measurement_datetime" name="measurement_datetime" value="<?php echo date('Y-m-d\TH:i', strtotime($measurement['measurement_datetime'])); ?>"><br><br>

        <input type="submit" value="Save">
    </form>
    </body>
    </html>

    <?php
} else {
    // Handle missing measurement ID parameter
    echo "Measurement ID not provided.";
}
?>
