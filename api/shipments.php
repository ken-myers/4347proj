<?php

    require_once '../includes/dbconn.php';

    $conn = getDBConnection();
    
    // Select all tuples from Items
    $sql = $conn->prepare("select * from Shipment");
    $sql->execute();
    $result = $sql->get_result();
    
    // Put all tuples into inventory array
    $shipments[] = $result->fetch_object();
    while($row = $result->fetch_object()){
        $shipments[] = $row;
    }

    // JSON encode inventory array for manager-inventory-screen.html
    echo json_encode($shipments);

    // Close connections
    $result->close();
    $conn->close();

?>