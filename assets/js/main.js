// assets/js/main.js

// Global Cart Update
window.updateCart = async function(productId, action) {
    const csrfToken = document.getElementById('cart_action_csrf').value;
    try {
        const response = await fetch('api/update_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId, action: action, csrf_token: csrfToken })
        });
        const result = await response.json();
        if (result.success) window.location.reload();
        else alert(result.message);
    } catch (error) { console.error('Error:', error); }
};

document.addEventListener('DOMContentLoaded', () => {
    // Navbar Scroll
    const navbar = document.getElementById('main-nav');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });
    }

    // Scroll Reveals
    const revealElements = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('active');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.15, rootMargin: "0px 0px -50px 0px" });
    revealElements.forEach(el => revealObserver.observe(el));

    // Typewriter
    const typewriterElement = document.getElementById('typewriter-text');
    if (typewriterElement) {
        const phrases = ["Premium Devotional Essentials.", "Elevate Your Spiritual Aura.", "Crafted with Divine Love."];
        let phraseIndex = 0, charIndex = 0, isDeleting = false;
        function type() {
            const currentPhrase = phrases[phraseIndex];
            if (isDeleting) {
                typewriterElement.textContent = currentPhrase.substring(0, charIndex - 1);
                charIndex--;
            } else {
                typewriterElement.textContent = currentPhrase.substring(0, charIndex + 1);
                charIndex++;
            }
            let typeSpeed = isDeleting ? 50 : 100;
            if (!isDeleting && charIndex === currentPhrase.length) { typeSpeed = 2000; isDeleting = true; } 
            else if (isDeleting && charIndex === 0) { isDeleting = false; phraseIndex = (phraseIndex + 1) % phrases.length; typeSpeed = 500; }
            setTimeout(type, typeSpeed);
        }
        setTimeout(type, 1000);
    }

    // AJAX Products Filtering
    const productsContainer = document.getElementById('products-container');
    const filterForm = document.getElementById('filter-form');
    const priceRange = document.getElementById('price-range');
    const priceDisplay = document.getElementById('price-display');

    if (productsContainer && filterForm) {
        priceRange.addEventListener('input', (e) => priceDisplay.textContent = '₹' + e.target.value);
        const escapeHTML = (str) => str.toString().replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        
        const fetchProducts = async () => {
            const maxPrice = priceRange.value;
            const checkedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(cb => cb.value).join(',');
            try {
                const response = await fetch(`/api/get_products.php?max_price=${maxPrice}&categories=${checkedCategories}`);
                const result = await response.json();
                if (result.success) renderProducts(result.data);
            } catch (error) { console.error("Fetch error:", error); }
        };

        const renderProducts = (products) => {
            productsContainer.innerHTML = '';
            if (products.length === 0) { productsContainer.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">No products match criteria.</p>'; return; }
            products.forEach(product => {
                const card = document.createElement('a');
                card.href = `product_details.php?id=${product.id}`;
                card.className = 'zen-card reveal active';
                card.innerHTML = `<img src="${escapeHTML(product.image_url)}" alt="${escapeHTML(product.name)}" class="zen-card-img" loading="lazy">
                                  <h3 class="zen-card-title">${escapeHTML(product.name)}</h3>
                                  <div class="zen-card-price">₹${product.price}</div>
                                  <button class="btn-add-cart" data-id="${product.id}">Add to Cart</button>`;
                productsContainer.appendChild(card);
            });
        };
        filterForm.addEventListener('change', fetchProducts);
        priceRange.addEventListener('change', fetchProducts); 
        productsContainer.addEventListener('click', (e) => {
            if(e.target.classList.contains('btn-add-cart')) { e.preventDefault(); /* Cart logic handled on details page for now */ }
        });
        fetchProducts();
    }

    // AJAX Add To Cart
    const addToCartLogic = async (productId, csrfToken, buttonEl) => {
        try {
            const originalText = buttonEl.innerText;
            buttonEl.innerText = "Adding..."; buttonEl.style.opacity = '0.7';
            const response = await fetch('/api/add_to_cart.php', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId, csrf_token: csrfToken })
            });
            const result = await response.json();
            if (result.success) {
                const cartBadge = document.getElementById('cart-count');
                if (cartBadge) { cartBadge.innerText = result.cart_count; cartBadge.style.transform = 'scale(1.3)'; setTimeout(() => cartBadge.style.transform = 'scale(1)', 200); }
                buttonEl.innerText = "Added!"; buttonEl.style.backgroundColor = "#10B981";
            } else { alert(result.message); buttonEl.innerText = originalText; }
            setTimeout(() => { buttonEl.innerText = originalText; buttonEl.style.opacity = '1'; buttonEl.style.backgroundColor = ""; }, 2000);
        } catch (error) { buttonEl.innerText = "Error"; }
    };

    const detailCartBtn = document.getElementById('add-to-cart-btn');
    if (detailCartBtn) {
        detailCartBtn.addEventListener('click', function() {
            addToCartLogic(this.getAttribute('data-id'), document.getElementById('cart_csrf').value, this);
        });
    }

    // AJAX Newsletter
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('newsletter-email').value, csrfToken = document.getElementById('csrf_token').value, btn = document.getElementById('newsletter-btn'), msgContainer = document.getElementById('newsletter-msg');
            btn.innerText = "Sending...";
            try {
                const response = await fetch('/api/subscribe.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ email: email, csrf_token: csrfToken }) });
                const result = await response.json();
                msgContainer.style.display = 'block'; msgContainer.innerText = result.message;
                if (result.success) { btn.innerText = "Subscribed!"; btn.classList.add('success'); msgContainer.style.color = "var(--color-aqua-mint)"; document.getElementById('newsletter-email').value = ''; } 
                else { btn.innerText = "Subscribe"; msgContainer.style.color = "#EF4444"; }
            } catch (error) { btn.innerText = "Subscribe"; }
        });
    }

    // Auth Form Toggle
    const btnLogin = document.getElementById('btn-show-login'), btnRegister = document.getElementById('btn-show-register'), formLogin = document.getElementById('form-login'), formRegister = document.getElementById('form-register');
    if (btnLogin && btnRegister) {
        btnLogin.addEventListener('click', () => { btnLogin.classList.add('active'); btnRegister.classList.remove('active'); formLogin.classList.add('active'); formRegister.classList.remove('active'); });
        btnRegister.addEventListener('click', () => { btnRegister.classList.add('active'); btnLogin.classList.remove('active'); formRegister.classList.add('active'); formLogin.classList.remove('active'); });
    }
});