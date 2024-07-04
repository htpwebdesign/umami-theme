document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.category-link');
    const allSections = document.querySelectorAll('.product-category');

    function showAllCategories() {
        allSections.forEach(section => {
            section.style.display = 'block';
        });
    }

    // Function to filter categories
    function filterCategories(category) {
        if (category === 'all') {
            showAllCategories();
        } else if (category === 'build-your-own-ramen') {
            // Redirect to the single product page for "Build Your Own Ramen"
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

    // Show all categories on initial load
    showAllCategories();

    // Event listener for category links
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const category = this.getAttribute('data-category');
            filterCategories(category);
        });
    });

    // Event listener for "All Products" link
    const allProductsLink = document.querySelector('.category-link[data-category="all"]');
    if (allProductsLink) {
        allProductsLink.addEventListener('click', function(event) {
            event.preventDefault();
            showAllCategories();
        });
    }
});
