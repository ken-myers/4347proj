<?php

require_once '../includes/dbconn.php';

$empId = $_POST['emp_id'];
$passcode = $_POST['passcode'];
$newPasscode = $_POST['new_passcode'];

if(empty($empId) || empty($passcode) || empty($newPasscode)){
    http_response_code(400);
    echo "You must provide an emp_id, passcode, and new_passcode.";
    exit();
}

$conn = getDBConnection();

// Safe code for assignment 6

$stmt = $conn->prepare("UPDATE Employee SET passcode = ? WHERE emp_id = ? AND passcode = ?");
$stmt->bind_param("sis", $newPasscode, $empId, $passcode);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Passcode successfully changed.";
} else {
    echo "No match found for that employee ID or passcode";
}

$stmt->close();

$conn->close();

?>