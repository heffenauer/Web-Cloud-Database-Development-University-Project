<?php
require_once('../database/database.php');

// Check if the location ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $location_id = $_GET['id'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $location_name = $_POST['location_name'];
        $city_id = $_POST['city_id'];

        // Update the location data in the database
        $query = "UPDATE Location SET location_name = '$location_name', city_id = $city_id WHERE location_id = $location_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Redirect to a success page or display a success message
            header('Location: location_list.php');
            exit;
        } else {
            // Handle query errors
            echo "Error executing query: " . mysqli_error($conn);
        }
    }

    // Fetch the existing location data from the database
    $query = "SELECT * FROM Location WHERE location_id = $location_id";
    $result = mysqli_query($conn, $query);
    $location = mysqli_fetch_assoc($result);

    // Check if the location exists
    if (!$location) {
        // Redirect to an error page or display an error message
        echo "Location not found.";
        exit;
    }

    // Fetch the list of cities for the dropdown
    $queryCities = "SELECT * FROM City";
    $resultCities = mysqli_query($conn, $queryCities);
    $cities = mysqli_fetch_all($resultCities, MYSQLI_ASSOC);
} else {
    // Handle missing location ID parameter
    echo "Location ID not provided.";
    exit;
}

// Close the database connection
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Location</title>
</head>
<body>
<h1>Edit Location</h1>
<form method="POST" action="location_edit.php?id=<?php echo $location_id; ?>">
    <label for="location_name">Location Name:</label>
    <input type="text" id="location_name" name="location_name" value="<?php echo $location['location_name']; ?>" required><br><br>

    <label for="city_id">City:</label>
    <select id="city_id" name="city_id" required>
        <?php foreach ($cities as $city): ?>
            <option value="<?php echo $city['city_id']; ?>" <?php echo ($city['city_id'] == $location['city_id']) ? 'selected' : ''; ?>><?php echo $city['city_name']; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="Save">
</form>
</body>
</html>
