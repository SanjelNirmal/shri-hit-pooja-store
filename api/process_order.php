<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_POST['csrf_token'] !== $_SESSION['csrf_token'])
    die("Invalid Request");
$_SESSION['cart'] = []; // Clear Cart
require_once __DIR__ . '/../includes/header.php';
?>
<div class="checkout-layout reveal active" style="text-align: center; padding: 100px 20px;">
    <div class="glass-panel" style="padding: 60px;">
        <h1 style="color: #10B981; margin-bottom: 20px;">Order Placed Successfully!</h1>
        <p style="margin-bottom: 40px;">Order Reference:
            <strong>#
                <?php echo strtoupper(bin2hex(random_bytes(4))); ?>
            </strong>
        </p>
        <a href="../products.php" class="btn-large" style="text-decoration: none;">Return to Shop</a>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>