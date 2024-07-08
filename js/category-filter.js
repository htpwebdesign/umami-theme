document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.category-link');
    const allSections = document.querySelectorAll('.product-category');
    const isSingleProductPage = document.body.classList.contains('single-product');
    const filterCategory = new URLSearchParams(window.location.search).get('filter');

    function showAllCategories() {
        allSections.forEach(section => {
            section.style.display = 'block';
        });
    }

    function filterCategories(category) {
        if (category === 'build-your-own-ramen') {
            window.location.href = document.querySelector('.category-link[data-category="build-your-own-ramen"]').href;
        } else if (isSingleProductPage) {
            const archiveUrl = `${window.location.origin}${window.location.pathname.replace(/\/product\/.*/, '/shop')}?filter=${category}`;
            window.location.href = archiveUrl;
        } else {
            if (category === 'all') {
                showAllCategories();
            } else {
                allSections.forEach(section => {
                    if (section.id === category) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }
        }
    }

    // On page load, filter categories if filter parameter exists
    if (!isSingleProductPage && filterCategory) {
        filterCategories(filterCategory);
    }

    // Add click event listeners to category links
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const category = this.getAttribute('data-category');
            filterCategories(category);
        });
    });

    // On archive page, show all categories initially
    if (!isSingleProductPage) {
        showAllCategories();
    }

    const allProductsLink = document.querySelector('.category-link[data-category="all"]');
    if (allProductsLink) {
        allProductsLink.addEventListener('click', function(event) {
            event.preventDefault();
            showAllCategories();
        });
    }
});
