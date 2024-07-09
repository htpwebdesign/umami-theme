<?php
// Check if the current post is not a single product or is a single product excluding "gift-card"
if (!is_singular('product') || (is_singular('product') && !has_term('gift-card', 'product_cat'))) {
    // Get the IDs of the "Uncategorized" and "Gift Card" categories
    $uncategorized_id = get_option('default_product_cat');
    $gift_card_category = get_term_by('slug', 'gift-card', 'product_cat');
    $gift_card_id = $gift_card_category ? $gift_card_category->term_id : 0;

    // Fetch product categories excluding "Uncategorized" and "Gift Card"
    $product_categories = get_terms('product_cat', array(
        'orderby'    => 'name',
        'hide_empty' => false,
        'exclude'    => array($uncategorized_id, $gift_card_id), // Exclude "Uncategorized" and "Gift Card" categories
        'parent'     => 0,
    ));

    // Output the category menu
    ?>
    <nav id="category-menu">
        <ul>
            <li><a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="category-link" data-category="all">All Products</a></li>
            <?php foreach ($product_categories as $category) : ?>
                <?php
                // Determine the link URL based on whether it's a single product or not
                if ($category->slug === 'build-your-own-ramen' && !is_singular('product')) {
                    // Link directly to the single product page for "Build Your Own Ramen"
                    $single_product = get_posts(array(
                        'post_type' => 'product',
                        'posts_per_page' => 1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => 'build-your-own-ramen',
                            ),
                        ),
                    ));
                    if ($single_product) {
                        $category_link = esc_url(get_permalink($single_product[0]->ID));
                    } else {
                        continue; // Skip this category if no single product found
                    }
                } else {
                    // Link to product category archive
                    $category_link = esc_url(get_term_link($category));
                // } else {
                //     // Link to shop page with filter parameter
                //     $shop_page_url = get_permalink(wc_get_page_id('shop')); // Get the shop page URL
                //     $category_link = esc_url(add_query_arg('filter', $category->slug, $shop_page_url));
                }
                ?>
                <li><a href="<?php echo $category_link; ?>" class="category-link" data-category="<?php echo esc_attr($category->slug); ?>" id="category-<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
<?php
}
?>