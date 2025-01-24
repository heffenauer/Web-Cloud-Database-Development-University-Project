<?php
require_once('../database/database.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $location_name = $_POST['location_name'];
    $city_id = $_POST['city_id'];

    // Insert the new location into the database
    $query = "INSERT INTO Location (location_name, city_id) VALUES ('$location_name', $city_id)";
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

// Fetch the list of cities for the dropdown
$queryCities = "SELECT * FROM City";
$resultCities = mysqli_query($conn, $queryCities);
$cities = mysqli_fetch_all($resultCities, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Location</title>
</head>
<body>
<h1>Add Location</h1>
<form method="POST" action="location_add.php">
    <label for="location_name">Location Name:</label>
    <input type="text" id="location_name" name="location_name" required><br><br>

    <label for="city_id">City:</label>
    <select id="city_id" name="city_id" required>
        <?php foreach ($cities as $city): ?>
            <option value="<?php echo $city['city_id']; ?>"><?php echo $city['city_name']; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="Add Location">
</form>
</body>
</html>
