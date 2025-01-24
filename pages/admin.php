<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin @ Air Quality Monitor</title>
    <link rel="stylesheet" href="../styles/admin_style.css">
</head>
<body>
<div class="container">
    <h1>Admin Page</h1>
    <div class="admin-panel">
        <div class="welcome">
            <h2>Welcome!</h2>
            <p>You have administrative privileges.</p>
            <p>Here are some admin tasks you can perform:</p>
        </div>
        <div class="actions">
            <button onclick="location.href='user_list.php'">List Users</button>
            <button onclick="location.href='city_list.php'">List Cities</button>
            <button onclick="location.href='location_list.php'">List Locations</button>
            <button onclick="location.href='air_quality_source_list.php'">List Sources</button>
            <button onclick="location.href='air_quality_parameter_list.php'">List Parameters</button>
            <button onclick="location.href='air_quality_measurement_list.php'">List Measurements</button>
        </div>
    </div>
</div>
</body>
</html>
