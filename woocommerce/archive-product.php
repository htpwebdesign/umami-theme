<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action( 'woocommerce_shop_loop_header' );

// Get the IDs of the "Uncategorized" and "Gift Card" categories
$uncategorized_id = get_option( 'default_product_cat' );
$gift_card_category = get_term_by( 'slug', 'gift-card', 'product_cat' );
$gift_card_id = $gift_card_category ? $gift_card_category->term_id : 0;

// Add the category menu
?>
<nav id="category-menu">
    <ul>
        <li><a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="category-link" data-category="all">All Products</a></li>
        <?php
        $product_categories = get_terms( 'product_cat', array(
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false,
            'exclude'    =>  array( $uncategorized_id, $gift_card_id ), // Exclude "Uncategorized" and "Gift Card" categories
            'parent'     => 0, // Only get top-level categories
        ) );

        foreach ( $product_categories as $category ) {
            if ( $category->slug === 'build-your-own-ramen' ) {
                $single_product = get_posts( array(
                    'post_type' => 'product',
                    'posts_per_page' => 1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => 'build-your-own-ramen',
                        ),
                    ),
                ) );

                if ( $single_product ) {
                    $product_link = get_permalink( $single_product[0]->ID );
                    echo '<li><a href="' . esc_url( $product_link ) . '" class="category-link" data-category="build-your-own-ramen">' . esc_html( $category->name ) . '</a></li>';
                }
            } else {
                echo '<li><a href="' . esc_url(get_post_type_archive_link('product')) . '" class="category-link" data-category="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</a></li>';
            }
        }
        ?>
    </ul>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const filterCategory = urlParams.get('filter');

    if (filterCategory) {
        const categoryLink = document.querySelector(`.category-link[data-category="${filterCategory}"]`);
        if (categoryLink) {
            categoryLink.click();
        }
    }
});
</script>

<?php

if ( woocommerce_product_loop() ) {

    // Display products by category
    foreach ( $product_categories as $category ) {
        echo '<section id="' . esc_attr( $category->slug ) . '" class="product-category">';
        echo '<h2>' . esc_html( $category->name ) . '</h2>';

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category->slug,
                ),
            ),
        );

        $products = new WP_Query( $args );

        if ( $products->have_posts() ) {
            woocommerce_product_loop_start();

            while ( $products->have_posts() ) {
                $products->the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action( 'woocommerce_shop_loop' );

                wc_get_template_part( 'content', 'product' );
            }

            woocommerce_product_loop_end();
        }

        wp_reset_postdata();
        echo '</section>';
    }

    /**
     * Hook: woocommerce_after_shop_loop.
     *
     * @hooked woocommerce_pagination - 10
     */
    do_action( 'woocommerce_after_shop_loop' );
} else {
    /**
     * Hook: woocommerce_no_products_found.
     *
     * @hooked wc_no_products_found - 10
     */
    do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
