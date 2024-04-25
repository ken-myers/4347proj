<?php

require_once '../includes/dbconn.php';

$itemID = $_GET['item_id'];

if (empty($itemID)){
    http_response_code(400);
    echo "You must provide an item_id.";
    exit();
}

$itemID = intval($itemID);

//this check works b/c item_ids start at 1
if($itemID == 0){
    http_response_code(400);
    echo "item_id must be an integer.";
    exit();
}

$conn = getDBConnection();

$sql = "SELECT name FROM Items WHERE item_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $itemID);
$stmt->bind_result($itemName);
$stmt->execute();

if( $stmt->fetch() ){
    echo $itemName;
}else{
    http_response_code(404);
    echo "No item found with that ID.";
}

?>