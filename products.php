<?php require_once __DIR__ . '/includes/header.php'; ?>

<div class="products-layout">
    <aside class="filters-sidebar glass-panel">
        <h2 style="margin-bottom: 20px;">Filters</h2>
        <form id="filter-form">
            <div class="filter-group">
                <h3>Price Range</h3>
                <span id="price-display">₹5000</span>
                <input type="range" id="price-range" name="max_price" min="0" max="10000" value="5000" step="100">
            </div>
            <div class="filter-group">
                <h3>Categories</h3>
                <label class="filter-label"><input type="checkbox" name="categories[]" value="Idols"
                        class="category-checkbox"> Deities & Idols</label>
                <label class="filter-label"><input type="checkbox" name="categories[]" value="Incense"
                        class="category-checkbox"> Incense & Dhoop</label>
                <label class="filter-label"><input type="checkbox" name="categories[]" value="Attire"
                        class="category-checkbox"> Deity Attire</label>
                <label class="filter-label"><input type="checkbox" name="categories[]" value="Utensils"
                        class="category-checkbox"> Pooja Utensils</label>
            </div>
        </form>
    </aside>
    <section>
        <div id="products-container" class="products-grid"></div>
    </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>