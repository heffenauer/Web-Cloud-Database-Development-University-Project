<?php
require_once('../database/database.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $cityName = $_POST['city_name'];

    // Insert the city record into the database
    $query = "INSERT INTO City (city_name) VALUES ('$cityName')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect to a success page or display a success message
        header('Location: city_list.php');
        exit;
    } else {
        // Handle query errors
        echo "Error executing query: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add City</title>
</head>
<body>
<h1>Add City</h1>
<form method="POST" action="city_add.php">
    <label for="city_name">City Name:</label>
    <input type="text" id="city_name" name="city_name" required>
    <br><br>
    <input type="submit" value="Add">
</form>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
