<?php

    require_once '../includes/dbconn.php';

    $conn = getDBConnection();
    
    // Select all tuples from Items
    $sql = $conn->prepare("select * from Items");
    $sql->execute();
    $result = $sql->get_result();
    
    // Put all tuples into inventory array
    $inventory[] = $result->fetch_object();
    while($row = $result->fetch_object()){
        $inventory[] = $row;
    }

    // JSON encode inventory array for manager-inventory-screen.html
    echo json_encode($inventory);

    // Close connections
    $result->close();
    $conn->close();

?>