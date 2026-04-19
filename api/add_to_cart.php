<?php
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['csrf_token']) || $data['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false]);
    exit;
}

$productId = isset($data['product_id']) ? (int) $data['product_id'] : 0;
if ($productId > 0) {
    if (!isset($_SESSION['cart']))
        $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$productId]))
        $_SESSION['cart'][$productId]++;
    else
        $_SESSION['cart'][$productId] = 1;
    echo json_encode(['success' => true, 'cart_count' => array_sum($_SESSION['cart'])]);
}
?>