<?php
function getDBConnection() {
    $host = 'localhost'; 
    $username = 'root'; 
    $password = 'your_new_password'; 
    $dbname = 'db_project';

    // Create connection
    $mysqli = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    return $mysqli;
}
