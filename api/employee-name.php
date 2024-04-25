<?php

require_once '../includes/dbconn.php';

$employeeID = $_GET['employeeId'];

if (empty($employeeID)){
    http_response_code(400);
    echo "You must provide an employee_id.";
    exit();
}

$employeeID = intval($employeeID);

//this check works b/c employee_ids start at 1
if($employeeID == 0){
    http_response_code(400);
    echo "employee_id must be an integer.";
    exit();
}

$conn = getDBConnection();

$sql = "SELECT f_name, m_initial, l_name FROM Employee WHERE emp_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employeeID);
$stmt->bind_result($f_name, $m_initial, $l_name);
$stmt->execute();


if( $stmt->fetch() ){
    echo "$f_name $m_initial $l_name";
}else{
    http_response_code(404);
    echo "No employee found with that ID.";
}

$stmt->close();
$conn->close();

?>