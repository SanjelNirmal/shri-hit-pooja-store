<?php
require_once __DIR__ . '/includes/header.php';
$cart = $_SESSION['cart'] ?? [];
$cartItems = [];
$total = 0;

if (!empty($cart)) {
    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, name, price, image_url FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();
    foreach ($products as $product) {
        $qty = $cart[$product['id']];
        $subtotal = $product['price'] * $qty;
        $total += $subtotal;
        $product['qty'] = $qty;
        $product['subtotal'] = $subtotal;
        $cartItems[] = $product;
    }
}
?>

<div class="cart-layout reveal active">
    <div class="cart-items">
        <h1 style="margin-bottom: 20px;">Your Divine Cart</h1>
        <?php if (empty($cartItems)): ?>
            <div class="glass-panel" style="padding: 40px; text-align: center;">
                <p>Your cart is empty.</p>
            </div>
        <?php else: ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item glass-panel">
                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="" class="cart-item-img">
                    <div class="cart-item-info">
                        <h3>
                            <?php echo htmlspecialchars($item['name']); ?>
                        </h3>
                        <div class="qty-control">
                            <button class="qty-btn" onclick="updateCart(<?php echo $item['id']; ?>, -1)">-</button>
                            <span>
                                <?php echo $item['qty']; ?>
                            </span>
                            <button class="qty-btn" onclick="updateCart(<?php echo $item['id']; ?>, 1)">+</button>
                        </div>
                        <button class="remove-btn" onclick="updateCart(<?php echo $item['id']; ?>, 'remove')">Remove</button>
                    </div>
                    <div class="cart-item-action">
                        <div style="font-size: 1.2rem; font-weight: bold;">₹
                            <?php echo number_format($item['subtotal'], 2); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($cartItems)): ?>
        <aside class="cart-summary glass-panel">
            <h2>Order Summary</h2>
            <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <div class="summary-row"><span>Subtotal</span><span>₹
                    <?php echo number_format($total, 2); ?>
                </span></div>
            <div class="summary-row summary-total"><span>Total</span><span>₹
                    <?php echo number_format($total, 2); ?>
                </span></div>
            <a href="checkout.php" class="btn-large"
                style="display: block; text-align: center; text-decoration: none; margin-top: 30px;">Proceed to Checkout</a>
        </aside>
    <?php endif; ?>
</div>
<input type="hidden" id="cart_action_csrf" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
<?php require_once __DIR__ . '/includes/footer.php'; ?>