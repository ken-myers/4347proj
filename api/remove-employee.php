<?php
require_once '../includes/dbconn.php';

// Get employee ID from HTML
$employeeId = $_GET['employeeId'];
$employeeId = intval($employeeId);

// Establish connection with DB
$mysqli = getDBConnection();

//Prepare and execute query
$stmt = $mysqli->prepare("DELETE FROM Employee WHERE emp_id = ?");
$stmt->bind_param("i", $employeeId);
$stmt->execute();

//Execute query
if ($stmt->affected_rows > 0) {
    echo "Employee with ID $employeeId has been removed.";
} else {
    echo "Could not find an employee with the matching ID.";
}

$stmt->close();

?>