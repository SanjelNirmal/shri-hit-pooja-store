<!-- includes/navbar.php -->
<nav id="main-nav" class="navbar glass-panel">
    <div class="nav-container">
        <a href="index.php" class="nav-brand">SHRI HIT</a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Shop</a></li>
            <li><a href="index.php#about">About</a></li>
        </ul>
        <div class="nav-actions">
            <a href="cart.php" class="cart-icon">Cart <span id="cart-count" class="badge"
                    style="background:var(--color-royal-purple); padding:2px 8px; border-radius:10px; margin-left:5px;"><?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?></span></a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="login.php?action=logout" class="login-btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="login-btn">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>