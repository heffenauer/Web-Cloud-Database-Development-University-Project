<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

$query = "SELECT m.measurement_id, l.location_name, p.parameter_name, s.source_name, u.username, m.measurement_value, m.measurement_datetime 
          FROM AirQualityMeasurement AS m
          INNER JOIN Location AS l ON m.location_id = l.location_id
          INNER JOIN AirQualityParameter AS p ON m.parameter_id = p.parameter_id
          INNER JOIN AirQualitySource AS s ON m.source_id = s.source_id
          INNER JOIN User AS u ON m.user_id = u.user_id";
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
                border-spacing: 0; /* makes sure to remove spacing between two cells */
                border-collapse: collapse; /* makes sure that two cells share a border line */
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
            <th>Measurement ID</th>
            <th>Location</th>
            <th>Parameter</th>
            <th>Source</th>
            <th>User</th>
            <th>Measurement Value</th>
            <th>Measurement Datetime</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['measurement_id']; ?></td>
                <td><?php echo $row['location_name']; ?></td>
                <td><?php echo $row['parameter_name']; ?></td>
                <td><?php echo $row['source_name']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['measurement_value']; ?></td>
                <td><?php echo $row['measurement_datetime']; ?></td>
                <td><a href="air_quality_measurement_edit.php?id=<?php echo $row['measurement_id']; ?>">Edit</a></td>
                <td><a href="air_quality_measurement_delete.php?id=<?php echo $row['measurement_id']; ?>">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <button onclick="location.href='air_quality_measurement_add.php'">Add Measurement</button>
    <a href="javascript:history.back()">Go Back</a>
    <a href="home.php">Direct to Home</a>



    </body>
    </html>

    <?php
    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle query errors
    echo "Error executing query: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
