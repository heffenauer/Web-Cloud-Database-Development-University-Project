<?php
require_once('../database/database.php');

$query = "SELECT * FROM User";
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
            <th>ID</th>
            <th>Name</th>
            <th>City</th>
            <th>Email</th>
            <th>Admin Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['city']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['is_admin']; ?></td>
                <td><a href="user_edit.php?id=<?php echo $row['user_id']; ?>">Edit</a></td>
                <td><?php
                    // Check if the city has associated locations
                    $user_id = $row['user_id'];
                    $checkQuery = "SELECT COUNT(*) AS user_count FROM AirQualityMeasurement WHERE user_id = $user_id";
                    $checkResult = mysqli_query($conn, $checkQuery);
                    $userCount = mysqli_fetch_assoc($checkResult)['user_count'];

                    if ($userCount > 0) {
                        echo "Cannot Delete";
                    } else {
                        echo "<a href='user_delete.php?id=$user_id'>Delete</a>";
                    }
                    ?>
            </tr>
        <?php endwhile; ?>
    </table>

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
