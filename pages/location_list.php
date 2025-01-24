<?php
require_once('../database/database.php');

$query = "SELECT Location.location_id, Location.location_name, City.city_name 
          FROM Location 
          INNER JOIN City ON Location.city_id = City.city_id";
$result = mysqli_query($conn, $query);

// Process the query result
if ($result) {
    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>List Locations</title>
        <style>
            table {
                border: 1px solid black;
                border-spacing: 0;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid black;
                padding: 5px;
            }
        </style>
    </head>
    <body>

    <h1>List Locations</h1>
    <table>
        <tr>
            <th>Location ID</th>
            <th>Location Name</th>
            <th>City Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['location_id']; ?></td>
                <td><?php echo $row['location_name']; ?></td>
                <td><?php echo $row['city_name']; ?></td>
                <td><a href="location_edit.php?id=<?php echo $row['location_id']; ?>">Edit</a></td>
                <td><?php
                    // Check if the city has associated locations
                    $location_id = $row['location_id'];
                    $checkQuery = "SELECT COUNT(*) AS location_count FROM AirQualityMeasurement WHERE location_id = $location_id";
                    $checkResult = mysqli_query($conn, $checkQuery);
                    $locationCount = mysqli_fetch_assoc($checkResult)['location_count'];

                    if ($locationCount > 0) {
                        echo "Cannot Delete";
                    } else {
                        echo "<a href='location_delete.php?id=$location_id'>Delete</a>";
                    }
                    ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <button onclick="location.href='location_add.php'">Add Location</button>

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
