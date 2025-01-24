<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

$query = "SELECT * FROM AirQualityParameter";
$result = mysqli_query($conn, $query);

// Process the query result
if ($result) {
    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>List @ Air Quality Monitor</title>
        <style>
            table {
                border: 1px solid black;
                border-spacing: 0;
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid black;
                padding: 0px 5px;
            }
        </style>
    </head>
    <body>

    <table>
        <tr>
            <th>Parameter Name</th>
            <th>Parameter Description</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['parameter_name']; ?></td>
                <td><?php echo $row['parameter_description']; ?></td>
                <td><a href="air_quality_parameter_edit.php?id=<?php echo $row['parameter_id']; ?>">Edit</a></td>
                <td><?php
                    // Check if the city has associated locations
                    $parameter_id = $row['parameter_id'];
                    $checkQuery = "SELECT COUNT(*) AS parameter_count FROM AirQualityMeasurement WHERE parameter_id = $parameter_id";
                    $checkResult = mysqli_query($conn, $checkQuery);
                    $parameterCount = mysqli_fetch_assoc($checkResult)['parameter_count'];

                    if ($parameterCount > 0) {
                        echo "Cannot Delete";
                    } else {
                        echo "<a href='air_quality_parameter_delete.php?id=$parameter_id'>Delete</a>";
                    }
                    ?>
            </tr>
        <?php endwhile; ?>
    </table>

    <button onclick="location.href='air_quality_parameter_add.php'">Add Parameter</button>
    <a href="javascript:history.back()">Go Back</a>
    <a href="home.php">Direct to Home</a>


    </body>
    </html>

    <?php
    mysqli_free_result($result);
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
