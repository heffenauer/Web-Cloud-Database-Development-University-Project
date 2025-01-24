<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

if (isset($_GET['id'])) {
    $parameterId = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $parameterName = $_POST['parameter_name'];
        $parameterDescription = $_POST['parameter_description'];

        $updateQuery = "UPDATE AirQualityParameter SET parameter_name = '$parameterName', parameter_description = '$parameterDescription' WHERE parameter_id = $parameterId";
        $result = mysqli_query($conn, $updateQuery);

        if ($result) {
            header('Location: air_quality_parameter_list.php');
            exit;
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }
    }

    $query = "SELECT * FROM AirQualityParameter WHERE parameter_id = $parameterId";
    $result = mysqli_query($conn, $query);
    $parameter = mysqli_fetch_assoc($result);

    if (!$parameter) {
        echo "Parameter not found.";
        exit;
    }
    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Edit Parameter @ Air Quality Monitor</title>
    </head>
    <body>
    <h1>Edit Parameter</h1>
    <form method="POST" action="air_quality_parameter_edit.php?id=<?php echo $parameterId; ?>">
        <label for="parameter_name">Parameter Name:</label>
        <input type="text" id="parameter_name" name="parameter_name" value="<?php echo $parameter['parameter_name']; ?>"><br><br>
        <label for="parameter_description">Parameter Description:</label>
        <input type="text" id="parameter_description" name="parameter_description"
               value="<?php echo $parameter['parameter_description']; ?>"><br><br>
        <input type="submit" value="Save">
    </form>
    </body>
    </html>

    <?php
} else {
    echo "Parameter ID not provided.";
}
?>

