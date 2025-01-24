<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $sourceName = $_POST['source_name'];
    $sourceType = $_POST['source_type'];

    // Insert the new record into the AirQualitySource table
    $query = "INSERT INTO AirQualitySource (source_name, source_type) VALUES ('$sourceName', '$sourceType')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect to a success page or display a success message
        header('Location: air_quality_source_list.php');
        exit;
    } else {
        // Handle query errors
        echo "Error executing query: " . mysqli_error($conn);
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Source @ Air Quality Monitor</title>
</head>
<body>
<h1>Add Source</h1>
<form method="POST" action="air_quality_source_add.php">
    <label for="source_name">Source Name:</label>
    <input type="text" id="source_name" name="source_name" required><br><br>

    <label for="source_type">Source Type:</label>
    <input type="text" id="source_type" name="source_type" required><br><br>

    <input type="submit" value="Add">
</form>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
