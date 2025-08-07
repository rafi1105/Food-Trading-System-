<?php
require_once 'config.php';
require_once 'vendor/autoload.php'; // Ensure you have the Dompdf library installed

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['order_id'])) {
    die('Order ID is required.');
}

$order_id = $_GET['order_id'];

// Fetch order details from the database
$select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
$select_order->execute([$order_id]);

if ($select_order->rowCount() == 0) {
    die('Order not found.');
}

$order = $select_order->fetch(PDO::FETCH_ASSOC);

// Generate the bill content
$html = '<h1 style="text-align: center;">Order Bill</h1>';
$html .= '<p><strong>Order ID:</strong> ' . $order['id'] . '</p>';
$html .= '<p><strong>Placed On:</strong> ' . $order['placed_on'] . '</p>';
$html .= '<p><strong>Name:</strong> ' . $order['name'] . '</p>';
$html .= '<p><strong>Email:</strong> ' . $order['email'] . '</p>';
$html .= '<p><strong>Number:</strong> ' . $order['number'] . '</p>';
$html .= '<p><strong>Address:</strong> ' . $order['address'] . '</p>';
$html .= '<p><strong>Payment Method:</strong> ' . $order['method'] . '</p>';
$html .= '<p><strong>Total Products:</strong> ' . $order['total_products'] . '</p>';
$html .= '<p><strong>Total Price:</strong> $' . $order['total_price'] . '</p>';
$html .= '<p><strong>Payment Status:</strong> ' . $order['payment_status'] . '</p>';

// Initialize Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output the generated PDF
$dompdf->stream('Order_Bill_' . $order['id'] . '.pdf', ["Attachment" => true]);
exit;
?>