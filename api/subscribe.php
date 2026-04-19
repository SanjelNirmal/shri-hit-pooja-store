<?php
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['csrf_token']) || $data['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false]);
    exit;
}

$email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => true, 'message' => 'Subscribed successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
}
?>