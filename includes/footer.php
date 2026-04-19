<!-- includes/footer.php -->
</main>
<footer>
    <div class="footer-content">
        <div class="footer-brand">
            <h2 style="color: var(--color-aqua-mint);">SHRI HIT</h2>
            <p style="color: var(--color-soft-gray); margin-top: 15px;">Premium Radhavallav Pooja Store.<br>Elevating
                your devotion.</p>
        </div>
        <div class="footer-newsletter glass-panel" style="padding: 25px;">
            <h3>Join our Divine Community</h3>
            <p style="color: var(--color-soft-gray); font-size: 0.9rem; margin-top: 10px;">Subscribe for updates.</p>
            <form id="newsletter-form" class="newsletter-form">
                <input type="hidden" name="csrf_token" id="csrf_token"
                    value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                <input type="email" id="newsletter-email" class="newsletter-input" placeholder="Enter your email"
                    required>
                <button type="submit" id="newsletter-btn" class="btn-newsletter">Subscribe</button>
            </form>
            <p id="newsletter-msg" style="margin-top: 10px; font-size: 0.85rem; display: none;"></p>
        </div>
    </div>
    <div style="text-align: center; margin-top: 50px; color: var(--color-soft-gray); font-size: 0.9rem;">
        &copy; <?php echo date('Y'); ?> Shri Hit Radhavallav Pooja Store. All Rights Reserved.
    </div>
</footer>
<script src="/assets/js/main.js"></script>
</body>

</html>