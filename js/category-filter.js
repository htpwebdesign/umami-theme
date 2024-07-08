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
        if (isSingleProductPage) {
            // Navigate to the archive page with the selected category filter
            const archiveUrl = `${window.location.origin}${window.location.pathname}?filter=${category}`;
            window.location.href = archiveUrl;
        } else {
            if (category === 'all') {
                showAllCategories();
            } else if (category === 'build-your-own-ramen') {
                window.location.href = document.querySelector('.category-link[data-category="build-your-own-ramen"]').href;
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

    showAllCategories();

    if (filterCategory) {
        filterCategories(filterCategory);
    }

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const category = this.getAttribute('data-category');
            filterCategories(category);
        });
    });

    const allProductsLink = document.querySelector('.category-link[data-category="all"]');
    if (allProductsLink) {
        allProductsLink.addEventListener('click', function(event) {
            event.preventDefault();
            showAllCategories();
        });
    }
});
