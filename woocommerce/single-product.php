<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

// Get the IDs of the "Uncategorized" and "Gift Card" categories
$uncategorized_id = get_option( 'default_product_cat' );
$gift_card_category = get_term_by( 'slug', 'gift-card', 'product_cat' );
$gift_card_id = $gift_card_category ? $gift_card_category->term_id : 0;

?>

<nav id="category-menu">
    <ul>
        <li><a href="#" class="category-link" data-category="all">All Products</a></li>
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
                echo '<li><a href="' . esc_url( get_term_link( $category ) ) . '" class="category-link" data-category="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</a></li>';
            }
        }
        ?>
    </ul>
</nav>

<?php
    /**
     * woocommerce_before_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
     * @hooked woocommerce_breadcrumb - 20
     */
    do_action( 'woocommerce_before_main_content' );
?>

<?php while ( have_posts() ) : ?>
    <?php the_post(); ?>

    <?php wc_get_template_part( 'content', 'single-product' ); ?>

<?php endwhile; // end of the loop. ?>

<?php
    /**
     * woocommerce_after_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
    do_action( 'woocommerce_after_main_content' );

    /**
     * woocommerce_sidebar hook.
     *
     * @hooked woocommerce_get_sidebar - 10
     */
    // do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
