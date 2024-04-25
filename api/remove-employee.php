<?php
require_once '../includes/dbconn.php';

$employeeId = $_GET['employeeId'];

if (empty($employeeId)) {
    http_response_code(400);
    echo "You must provide an employee ID";
    exit();
}

$employeeId = intval($employeeId);

//this check works b/c employee_ids start at 1
if($employeeId == 0){
    http_response_code(400);
    echo "employee_id must be an integer.";
    exit();
}


$mysqli = getDBConnection();


$stmt = $mysqli->prepare("DELETE FROM Employee WHERE emp_id = ?");
$stmt->bind_param("i", $employeeId);
$stmt->execute();


if ($stmt->affected_rows > 0) {
    echo "Employee with ID $employeeId has been removed.";
} else {
    echo "Could not find an employee with the matching ID.";
}

$stmt->close();
$conn->close();


?>