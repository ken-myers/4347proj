<?php

require_once '../includes/dbconn.php';

// Get employee ID from HTML
$employeeID = $_GET['employeeId'];
$employeeID = intval($employeeID);

// Establish connection with DB
$conn = getDBConnection();

//Attempt to retrieve employee information with provided ID
$sql = "SELECT f_name, m_initial, l_name FROM Employee WHERE emp_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employeeID);
$stmt->bind_result($f_name, $m_initial, $l_name);
$stmt->execute();

//Return employee name to HTML to display in alert
if( $stmt->fetch() ){
    echo "$f_name $m_initial $l_name";
}
//Return error message which will be displayed in alert
else{
    http_response_code(404);
    echo "No employee found with that ID.";
}

$stmt->close();
$conn->close();

?>