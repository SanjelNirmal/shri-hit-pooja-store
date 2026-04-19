<?php
require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');

$maxPrice = isset($_GET['max_price']) ? (float) $_GET['max_price'] : 10000;
$categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : [];

try {
    $sql = "SELECT id, name, price, image_url, category FROM products WHERE price <= ?";
    $params = [$maxPrice];
    if (!empty($categories) && $categories[0] !== '') {
        $inQuery = implode(',', array_fill(0, count($categories), '?'));
        $sql .= " AND category IN ($inQuery)";
        $params = array_merge($params, $categories);
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();

    if (empty($products)) { // Mock data
        $products = [['id' => 1, 'name' => 'Idol', 'price' => 3500, 'image_url' => 'https://via.placeholder.com/300.png', 'category' => 'Idols']];
    }
    echo json_encode(['success' => true, 'data' => $products]);
} catch (PDOException $e) {
    echo json_encode(['success' => false]);
}
?>