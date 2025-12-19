<?php

$conn = new mysqli(
    'localhost',    // Database host
    'root',         // Database username
    '',             // Database password
    'hotel'         // Database name
);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
