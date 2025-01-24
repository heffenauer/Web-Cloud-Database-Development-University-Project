<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

$query = "SELECT * FROM AirQualitySource";
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
                border-collapse: collapse; /*makes sure that two cells share a border line */
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
            <th>Source Name</th>
            <th>Source Type</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['source_name']; ?></td>
                <td><?php echo $row['source_type']; ?></td>
                <td><a href="air_quality_source_edit.php?id=<?php echo $row['source_id']; ?>">Edit</a></td>
                <td><?php
                // Check if the city has associated locations
                $source_id = $row['source_id'];
                $checkQuery = "SELECT COUNT(*) AS source_count FROM AirQualityMeasurement WHERE source_id = $source_id";
                $checkResult = mysqli_query($conn, $checkQuery);
                $sourceCount = mysqli_fetch_assoc($checkResult)['source_count'];

                if ($sourceCount > 0) {
                    echo "Cannot Delete";
                } else {
                    echo "<a href='air_quality_source_delete.php?id=$source_id'>Delete</a>";
                }
                ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <button onclick="location.href='air_quality_source_add.php'">Add Source</button>
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
