<?php
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['csrf_token']) || $data['csrf_token'] !== $_SESSION['csrf_token'])
    exit;

$productId = (int) $data['product_id'];
$action = $data['action'];

if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
    if ($action === 'remove')
        unset($_SESSION['cart'][$productId]);
    else {
        $_SESSION['cart'][$productId] += (int) $action;
        if ($_SESSION['cart'][$productId] <= 0)
            unset($_SESSION['cart'][$productId]);
    }
    echo json_encode(['success' => true]);
}
?>