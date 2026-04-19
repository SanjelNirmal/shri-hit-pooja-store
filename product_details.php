<?php
require_once __DIR__ . '/includes/header.php';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product && $id > 0) {
    $product = ['id' => $id, 'name' => 'Divine Radha Krishna Idol', 'price' => 3500, 'description' => 'A handcrafted masterpiece.', 'image_url' => 'https://via.placeholder.com/500x600.png?text=Product'];
}
?>

<div class="product-details-container reveal active">
    <div class="product-image-wrapper glass-panel">
        <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
            alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    <div class="product-info">
        <h1>
            <?php echo htmlspecialchars($product['name']); ?>
        </h1>
        <div class="product-price">₹
            <?php echo number_format($product['price'], 2); ?>
        </div>
        <p class="product-description">
            <?php echo nl2br(htmlspecialchars($product['description'])); ?>
        </p>
        <input type="hidden" id="cart_csrf" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
        <button class="btn-large" id="add-to-cart-btn" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>