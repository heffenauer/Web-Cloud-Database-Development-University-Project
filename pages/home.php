<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../database/database.php');

session_start(); // Start the session

// Check if the user is logged in
$loggedIn = isset($_SESSION['user_id']);

// Check if the user is an admin
$isAdmin = false;
if ($loggedIn) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT is_admin FROM User WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    $isAdmin = ($user['is_admin'] == 1);
}

// Fun Facts array
$funFacts = [
    "Air pollution is responsible for over 7 million premature deaths worldwide every year.",
    "Indoor air pollution can be 2 to 5 times higher than outdoor pollution levels.",
    "Breathing in polluted air can lead to various health problems, including respiratory diseases and heart conditions.",
    "Poor air quality can affect cognitive function and may contribute to neurological disorders.",
    "Air pollution can also harm the environment, leading to climate change and ecological imbalances.",
    "The World Health Organization (WHO) considers air pollution as the single biggest environmental health risk.",
];

shuffle($funFacts); // Shuffle the fun facts array

// Fetch data for the data grid
$queryGrid = "SELECT City.city_name, AirQualityParameter.parameter_name, AirQualityMeasurement.measurement_value, AirQualityMeasurement.measurement_datetime 
              FROM AirQualityMeasurement
              JOIN City ON AirQualityMeasurement.location_id = City.city_id
              JOIN AirQualityParameter ON AirQualityMeasurement.parameter_id = AirQualityParameter.parameter_id
              ORDER BY AirQualityMeasurement.measurement_datetime DESC";
$resultGrid = mysqli_query($conn, $queryGrid);
$dataGrid = mysqli_fetch_all($resultGrid, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home @ Air Quality Monitor</title>
    <link rel="stylesheet" href="../styles/home_style.css">
    <script>
        // Function to rotate through facts
        function rotateFacts() {
            const funFacts = <?php echo json_encode($funFacts); ?>;
            const factContainer = document.getElementById('fact-container');
            let currentFact = 0;

            setInterval(() => {
                factContainer.style.opacity = '0';
                setTimeout(() => {
                    factContainer.textContent = funFacts[currentFact];
                    factContainer.style.opacity = '1';
                }, 500); // Delay before updating the fact (in milliseconds)
                currentFact = (currentFact + 1) % funFacts.length;
            }, 8000); // Interval in milliseconds (e.g., 8000 = 8 seconds)
        }

        // Call the rotateFacts function when the page is loaded
        window.addEventListener('load', rotateFacts);

        // Function to toggle visibility of data grid rows
        function toggleDataGridRows() {
            const rows = document.querySelectorAll('#data-table tbody tr');
            let index = 0;

            setInterval(() => {
                rows[index].classList.add('hidden');
                index = (index + 1) % rows.length;
                rows[index].classList.remove('hidden');
            }, 5000); // Interval in milliseconds (e.g., 5000 = 5 seconds)
        }

        // Call the toggleDataGridRows function when the page is loaded
        window.addEventListener('load', toggleDataGridRows);
    </script>
</head>
<body>
<header>
    <h1>Air Quality Monitor</h1>
</header>
<div class="searchbar">
    <div class="search-container">
        <form action="input">
            <input type="text" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="button-container">
        <?php if ($loggedIn): ?>
            <button class="logout-button" onclick="location.href='logout.php'">Logout</button>
        <?php else: ?>
            <button class="login-button" onclick="location.href='login.php'">Login</button>
        <?php endif; ?>
        <?php if ($loggedIn): ?>
            <?php if ($isAdmin): ?>
                <button class="admin-button" onclick="location.href='admin.php'">Administration</button>
            <?php endif; ?>
            <button class="edit-account-button" onclick="location.href='user_account_edit.php?id=<?php echo $_SESSION['user_id']; ?>'">Edit Account</button>
        <?php endif; ?>
        <button class="extra-info-button" onclick="location.href='extra_info.php'">Extra Info</button>
    </div>
</div>
<main id="bigmain">
    <aside id="left">
        <!-- Side panel content -->
        <h2>About Air Quality</h2>
        <div id="fact-container"></div>
    </aside>
    <main id="littlemain">
        <!-- Main content -->
        <h2>Welcome to Air Quality Monitor</h2>
        <p>Explore the latest air quality measurements and learn more about the importance of clean air.</p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d23029.59320726015!2d18.31444225!3d43.820599400000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sba!4v1684484735344!5m2!1sen!2sba" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

    </main>
    <aside id="right">
        <div id="datagrid">
            <!-- Data grid content -->
            <h2>Data Grid</h2>
            <table id="data-table">
                <thead>
                <tr>
                    <th>City</th>
                    <th>Parameter</th>
                    <th>Measurement Value</th>
                    <th>Date and Time</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($dataGrid as $index => $row): ?>
                    <tr class="<?php echo $index === 0 ? '' : 'hidden'; ?>">
                        <td><?php echo $row['city_name']; ?></td>
                        <td><?php echo $row['parameter_name']; ?></td>
                        <td><?php echo $row['measurement_value']; ?></td>
                        <td><?php echo $row['measurement_datetime']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </aside>
</main>
<footer>All rights reserved by Din Becirbasic, Dzani Eterle & Darin Anic &copy</footer>
</body>
</html>
