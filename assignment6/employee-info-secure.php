<?php
require_once '../includes/dbconn.php';

$empId = $_POST['emp_id'];
$passcode = $_POST['passcode'];

if(empty($empId) || empty($passcode)) {
    http_response_code(400);
    echo "You must provide an emp_id and passcode.";
    exit();
}

$conn = getDBConnection();

// Not a prepared statement, for injection demo purposes
//$res = $conn->query("SELECT emp_id, f_name, m_initial, l_name, salary FROM Employee WHERE emp_id = $empId AND passcode = '$passcode'");

$stmt = $conn->prepare("SELECT emp_id, f_name, m_initial, l_name, salary FROM Employee WHERE emp_id = ? AND passcode = ?");
$stmt->bind_param("is", $empId, $passcode);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 1) {

    $row = $res->fetch_assoc();
    $fName = $row['f_name'];
    $mInitial = $row['m_initial'];
    $salary = $row['salary'];
    $employeeID = $row['emp_id'];

    // Format name
    $fullName = $fName . (empty($mInitial) ? ' ' : " $mInitial ") . $lName;
    $salaryText = is_null($salary) ? "Not listed" : $salary;

    //Format final output
    echo <<<EOF
    <p> Employee ID: $employeeID </p>
    <p> Name: $fullName </p>
    <p> Salary: $salaryText </p>
    EOF;
} else {
    echo "No match found for that ID and passcode.";
}

// Close statement
$stmt->close();

// Close connection
$conn->close();

?>