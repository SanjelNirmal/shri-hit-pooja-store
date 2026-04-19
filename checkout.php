<?php
require_once __DIR__ . '/includes/header.php';
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}
?>
<div class="checkout-layout reveal active">
    <div class="glass-panel" style="padding: 40px;">
        <h1 style="margin-bottom: 30px; text-align: center; color: var(--color-aqua-mint);">Secure Checkout</h1>
        <form action="api/process_order.php" method="POST" class="checkout-form">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group"><label>Address</label><textarea name="address" class="form-control" rows="3"
                    required></textarea></div>
            <button type="submit" class="btn-large">Place Order</button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>