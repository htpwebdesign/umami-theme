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
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

// Check if the current product is a gift card
$is_gift_card = false; // Replace with logic to determine if current product is a gift card
$product_categories = wp_get_post_terms( get_the_ID(), 'product_cat', array( 'fields' => 'names' ) );
// Get the IDs of the "Uncategorized" and "Gift Card" categories
$uncategorized_id = get_option( 'default_product_cat' );
$gift_card_category = get_term_by( 'slug', 'gift-card', 'product_cat' );
$gift_card_id = $gift_card_category ? $gift_card_category->term_id : 0;

foreach( $product_categories as $category ) {
	if ( $category === 'Gift Card' ) {
		$is_gift_card = true;
		break;
	}
}

?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

	<?php if ( ! $is_gift_card ) : ?>
		<div class="category-menu">
			<!-- Place your menu HTML structure here -->
			<ul class="category-links">
				<li><a href="#" class="category-link" data-category="all">All Products</a></li>
				<?php
				// Get product categories
				$product_categories = get_terms( array(
					'taxonomy'   => 'product_cat',
					'hide_empty' => true,
					'exclude'    =>  array( $uncategorized_id, $gift_card_id ), // Exclude "Uncategorized" and "Gift Card" categories
            		'parent'     => 0, // Only get top-level categories
				) );

				if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
					foreach ( $product_categories as $category ) {
						$category_link = get_term_link( $category );

						if ( is_wp_error( $category_link ) ) {
							continue;
						}

						echo '<li><a href="' . esc_url( $category_link ) . '" class="category-link">' . esc_html( $category->name ) . '</a></li>';
					}
				}
				?>
			</ul>
		</div>
	<?php endif; ?>

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
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		// do_action( 'woocommerce_sidebar' );
	?>

<?php
get_footer( 'shop' );

