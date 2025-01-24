<?php

$conn = mysqli_connect('localhost', 'root','','Projekat');

if (!$conn) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
} else{
    echo "Connection Established. ";
}

?>