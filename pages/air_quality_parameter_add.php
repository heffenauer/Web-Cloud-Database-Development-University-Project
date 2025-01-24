<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parameterName = $_POST['parameter_name'];
    $parameterDescription = $_POST['parameter_description'];

    $insertQuery = "INSERT INTO AirQualityParameter (parameter_name, parameter_description) VALUES ('$parameterName', '$parameterDescription')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        header('Location: air_quality_parameter_list.php');
        exit;
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Parameter @ Air Quality Monitor</title>
</head>
<body>
<h1>Add Parameter</h1>
<form method="POST" action="air_quality_parameter_add.php">
    <label for="parameter_name">Parameter Name:</label>
    <input type="text" id="parameter_name" name="parameter_name"><br><br>
    <label for="parameter_description">Parameter Description:</label>
    <input type="text" id="parameter_description" name="parameter_description"><br><br>
    <input type="submit" value="Add">
</form>
</body>
</html>
