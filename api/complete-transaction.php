<?php

require_once '../includes/dbconn.php';

//can't represent items subarray in form format, so must parse JSON directly
$transactionJSON = file_get_contents('php://input');
$transaction = json_decode($transactionJSON, true);

$customerEmail  = $transaction['customerEmail'];
$cashierID = $transaction['cashierId'];
$items = $transaction['items'];

if(empty($customerEmail) || empty($cashierID) || empty($items)) {
    http_response_code(400);
    echo "You must provide a customer email, cashier ID, and items.";
    exit();
}


$conn = getDBConnection();
$currentDate = date("Y-m-d");

# do all queries in one transaction
$conn->autocommit(FALSE);

try{

    #create new transaction entity
    $sqlTrans = "INSERT INTO Transaction (customer_email, cash_id, date) VALUES (?, ?, ?)";
    $stmtTrans = $conn->prepare($sqlTrans);
    $stmtTrans->bind_param("sis", $customerEmail, $cashierID, $currentDate);
    if (!$stmtTrans->execute()){
        $stmtTrans->close();
        throw new Exception($stmtTrans->error);
    }
    $transactionID = $stmtTrans->insert_id;
    $stmtTrans->close();

    #update quantities of each item in stock
    $sqlQty = "UPDATE Items SET stock = stock - ? WHERE item_id = ?";
    for($i = 0; $i < count($items); $i++){
        $stmtQty = $conn->prepare($sqlQty);
        $stmtQty->bind_param("ii", $items[$i]['quantity'], $items[$i]['itemId']);
        if (!$stmtQty->execute()){
            $stmtQty->close();
            throw new Exception($stmtQty->error);
        }
        $stmtQty->close();
    }

    #create new transaction_item entities
    $sqlTransQty = 'INSERT INTO Transaction_Items (tran_id, item_id, quantity) VALUES (?, ?, ?)';
    for($i = 0; $i < count($items); $i++){
        $stmtTransItem = $conn->prepare($sqlTransQty);
        $stmtTransItem->bind_param('iii', $transactionID, $items[$i]['itemId'], $items[$i]['quantity']);
        if (!$stmtTransItem->execute()){
            $stmtTransItem->close();
            throw new Exception($stmtTransItem->error);
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