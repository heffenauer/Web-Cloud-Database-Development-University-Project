<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database/database.php');

$query = "SELECT * FROM City";
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
            <th>City Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['city_name']; ?></td>
                <td><a href="city_edit.php?id=<?php echo $row['city_id']; ?>">Edit</a></td>
                <td>
                    <?php
                    // Check if the city has associated locations
                    $city_id = $row['city_id'];
                    $checkQuery = "SELECT COUNT(*) AS location_count FROM Location WHERE city_id = $city_id";
                    $checkResult = mysqli_query($conn, $checkQuery);
                    $locationCount = mysqli_fetch_assoc($checkResult)['location_count'];

                    if ($locationCount > 0) {
                        echo "Cannot Delete";
                    } else {
                        echo "<a href='city_delete.php?id=$city_id'>Delete</a>";
                    }
                    ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <button onclick="location.href='city_add.php'">Add City</button>
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
