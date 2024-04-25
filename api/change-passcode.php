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

//Unsafe, for injection demo
$sql = "UPDATE Employee SET passcode = '$newPasscode' WHERE emp_id = $empId AND passcode = '$passcode';";
if($conn->query($sql) == TRUE){
    $rows = $conn->affected_rows;
    if($rows > 0){
        echo "Password successfully changed.";
    }else{
        http_response_code(404);
        echo "No match found for that employee ID and passcode.";
    }
}else{
    http_response_code(500);
}

$conn->close();

?>
