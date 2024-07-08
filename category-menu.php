<?php
// Check if the current post is a single product
if (!is_singular('product')) {
    // Get the IDs of the "Uncategorized" and "Gift Card" categories
    $uncategorized_id = get_option('default_product_cat');
    $gift_card_category = get_term_by('slug', 'gift-card', 'product_cat');
    $gift_card_id = $gift_card_category ? $gift_card_category->term_id : 0;

    // Fetch product categories excluding "Uncategorized" and "Gift Card"
    $product_categories = get_terms('product_cat', array(
        'orderby'    => 'name',
        // 'order'      => 'ASC',
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
                <li><a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-link" data-category="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
<?php
}
?>
