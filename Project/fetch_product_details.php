<?php

@include 'config.php';

header('Content-Type: application/json');

if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $fetch_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $fetch_product->execute([$product_id]);

    if($fetch_product->rowCount() > 0) {
        $product = $fetch_product->fetch(PDO::FETCH_ASSOC);
        echo json_encode($product);
    } else {
        echo json_encode(["error" => "Product not found"]);
    }
} else {
    echo json_encode(["error" => "Product ID not provided"]);
}

?>