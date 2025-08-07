<?php

@include 'config.php';

header('Content-Type: application/json');

if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $fetch_history = $conn->prepare("SELECT price, timestamp FROM `product_price_history` WHERE product_id = ? ORDER BY timestamp ASC");
    $fetch_history->execute([$product_id]);

    $price_history = $fetch_history->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($price_history);
} else {
    echo json_encode(["error" => "Product ID not provided"]);
}

?>