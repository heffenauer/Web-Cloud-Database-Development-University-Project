<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../database/database.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $location_id = $_POST['location_id'];
    $parameter_id = $_POST['parameter_id'];
    $source_id = $_POST['source_id'];
    $user_id = $_POST['user_id'];
    $measurement_value = $_POST['measurement_value'];
    $measurement_datetime = $_POST['measurement_datetime'];

    // Insert the measurement data into the database
    $insertQuery = "INSERT INTO AirQualityMeasurement (location_id, parameter_id, source_id, user_id, measurement_value, measurement_datetime)
                    VALUES ('$location_id', '$parameter_id', '$source_id', '$user_id', '$measurement_value', '$measurement_datetime')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        // Redirect to a success page or display a success message
        header('Location: air_quality_measurement_list.php');
        exit;
    } else {
        // Handle query errors
        echo "Error executing query: " . mysqli_error($conn);
    }
}

// Retrieve data from related tables
$locationQuery = "SELECT * FROM Location";
$locationResult = mysqli_query($conn, $locationQuery);

$parameterQuery = "SELECT * FROM AirQualityParameter";
$parameterResult = mysqli_query($conn, $parameterQuery);

$sourceQuery = "SELECT * FROM AirQualitySource";
$sourceResult = mysqli_query($conn, $sourceQuery);

$userQuery = "SELECT * FROM User";
$userResult = mysqli_query($conn, $userQuery);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Measurement @ Air Quality Monitor</title>
</head>
<body>
<h1>Add Measurement</h1>
<form method="POST" action="air_quality_measurement_add.php">
    <label for="location_id">Location:</label>
    <select id="location_id" name="location_id">
        <?php while ($locationRow = mysqli_fetch_assoc($locationResult)): ?>
            <option value="<?php echo $locationRow['location_id']; ?>"><?php echo $locationRow['location_name']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label for="parameter_id">Parameter:</label>
    <select id="parameter_id" name="parameter_id">
        <?php while ($parameterRow = mysqli_fetch_assoc($parameterResult)): ?>
            <option value="<?php echo $parameterRow['parameter_id']; ?>"><?php echo $parameterRow['parameter_name']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label for="source_id">Source:</label>
    <select id="source_id" name="source_id">
        <?php while ($sourceRow = mysqli_fetch_assoc($sourceResult)): ?>
            <option value="<?php echo $sourceRow['source_id']; ?>"><?php echo $sourceRow['source_name']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label for="user_id">User:</label>
    <select id="user_id" name="user_id">
        <?php while ($userRow = mysqli_fetch_assoc($userResult)): ?>
            <option value="<?php echo $userRow['user_id']; ?>"><?php echo $userRow['username']; ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label for="measurement_value">Measurement Value (ug/m3):</label>
    <input type="number" step="0.01" id="measurement_value" name="measurement_value"><br><br>


    <label for="measurement_datetime">Measurement Datetime:</label>
    <input type="datetime-local" id="measurement_datetime" name="measurement_datetime"><br><br>

    <input type="submit" value="Add">
</form>
</body>
</html>

<?php
// Free the result sets
mysqli_free_result($locationResult);
mysqli_free_result($parameterResult);
mysqli_free_result($sourceResult);
mysqli_free_result($userResult);

// Close the database connection
mysqli_close($conn);
?>
