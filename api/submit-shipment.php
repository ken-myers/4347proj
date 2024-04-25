<?php

require_once '../includes/dbconn.php';

//can't represent items subarray in form format, so must parse JSON directly
$transactionJSON = file_get_contents('php://input');
$transaction = json_decode($transactionJSON, true);

$managerID  = $transaction['managerID'];
$supplierID = $transaction['supplierID'];
$items = $transaction['items'];

if(empty($managerID) || empty($supplierID) || empty($items)) {
    http_response_code(400);
    echo "You must provide a manager id, supplier id, and items.";
    exit();
}


$conn = getDBConnection();
$currentDate = date("Y-m-d");

# do all queries in one transaction
$conn->autocommit(FALSE);

try{

    #create new shipment entity
    $sqlShipment = "INSERT INTO Shipment (mgr_id, sup_id, date_placed) VALUES (?, ?, ?)";
    $stmtShipment = $conn->prepare($sqlShipment);
    $stmtShipment->bind_param("iis", $managerID, $supplierID, $currentDate);
    if (!$stmtShipment->execute()){
        $stmtShipment->close();
        throw new Exception($stmtShipment->error);
    }
    $shipmentID = $stmtShipment->insert_id;
    $stmtShipment->close();

    #create new shipment_item entities
    $sqlShipmentQty = 'INSERT INTO Shipment_Items (ship_id, item_id, quantity) VALUES (?, ?, ?)';
    for($i = 0; $i < count($items); $i++){
        $stmtShipmentItem = $conn->prepare($sqlShipmentQty);
        $stmtShipmentItem->bind_param('iii', $shipmentID, $items[$i]['itemId'], $items[$i]['quantity']);
        if (!$stmtShipmentItem->execute()){
            $stmtShipmentItem->close();
            throw new Exception($stmtShipmentItem->error);
        }
    }

    $conn->commit();
    $conn->close();
}catch(Exception $e){
    $conn->rollback();
    $conn->close();
    http_response_code(500);
    echo "Failed to complete transaction: " . $e->getMessage();
    exit();
}

?>