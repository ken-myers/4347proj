<?php
require_once '../includes/dbconn.php';

$shipmentId = $_GET['shipmentId'];
$managerId = $_GET['managerId'];

if (empty($shipmentId)) {
    http_response_code(400);
    echo "You must provide a shipment ID";
    exit();
}

if (empty($managerId)) {
    http_response_code(400);
    echo "You must provide a manager ID";
    exit();
}

$shipmentId = intval($shipmentId);
$managerId = intval($managerId);

//this check works b/c shipment_ids start at 1
if($shipmentId == 0) {
    http_response_code(400);
    echo "shipment ID must be an integer.";
    exit();
}

//this check works b/c manager_ids start at 1
if($managerId == 0){
    http_response_code(400);
    echo "manager ID must be an integer.";
    exit();
}


$mysqli = getDBConnection();


$stmt = $mysqli->prepare("UPDATE Shipment SET status = 'Confirmed' WHERE ship_id = ? AND mgr_id = ? AND NOT status = 'Confirmed'");
$stmt->bind_param("ii", $shipmentId, $managerId);
$stmt->execute();


if ($stmt->affected_rows > 0) {
    echo "Shipment with ID $shipmentId has been confirmed by manager with ID $managerId.";
} else {
    echo "Shipment has either already been confirmed or does not exist.";
}

$stmt->close();


$stmt = $mysqli->prepare("UPDATE Items JOIN Shipment_Items ON Items.item_id = Shipment_Items.item_id SET stock = stock + quantity WHERE ship_id = ?");
$stmt->bind_param("i", $shipmentId);
$stmt->execute();
$stmt->close();

$conn->close();


?>