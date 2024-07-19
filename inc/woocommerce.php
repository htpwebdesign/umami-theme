<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Urban_Umami
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function umami_theme_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'umami_theme_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function umami_theme_woocommerce_scripts() {
	wp_enqueue_style( 'umami-theme-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'umami-theme-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'umami_theme_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function umami_theme_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'umami_theme_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function umami_theme_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'umami_theme_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'umami_theme_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function umami_theme_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'umami_theme_woocommerce_wrapper_before' );

if ( ! function_exists( 'umami_theme_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function umami_theme_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'umami_theme_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'umami_theme_woocommerce_header_cart' ) ) {
			umami_theme_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'umami_theme_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function umami_theme_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		umami_theme_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'umami_theme_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'umami_theme_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function umami_theme_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'umami-theme' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'umami-theme' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'umami_theme_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function umami_theme_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php umami_theme_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}


add_action( 'woocommerce_init', 'remove_all_wc_add_to_cart' );
function remove_all_wc_add_to_cart() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// remove star rating under products in product archive
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

// add a view product details button to the product archives
add_action( 'woocommerce_after_shop_loop_item', 'urb_view_product_details_button', 9 );
function urb_view_product_details_button() {
	global $product;
	$product_id = $product->get_id();
	$product_permalink = get_permalink($product_id);
	echo '<a href="' . $product_permalink . '" class="button">View Details</a>';
}

// add a view details button to yith quick view if it exists
if ( function_exists( 'YITH_WCQV_Frontend' ) ) {
	add_action( 'yith_wcqv_product_summary', 'urb_view_product_details_button', 9 );
}

// remove gift card product (id is 358) from the shop page
add_action( 'woocommerce_product_query', 'urb_exclude_gift_card_from_shop' );

function urb_exclude_gift_card_from_shop( $q ) {
	if ( ! is_admin() && $q->is_main_query() && $q->is_post_type_archive( 'product' ) ) {
		$q->set( 'post__not_in', array( 358 ) );
	}
}

// remove woocommerce sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Remove the default store notice action
remove_action('wp_footer', 'woocommerce_demo_store');

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_images', 5 );


add_action('woocommerce_thankyou', 'custom_order_received_message', 10, 1);

function custom_order_received_message($order_id) {
    if (!$order_id) {
        return;
    }

    // Get the order object
    $order = wc_get_order($order_id);

    // Initialize shipping method variable
    $shipping_method = '';

    // Loop through the shipping items to get the shipping method ID
    foreach ($order->get_items('shipping') as $item_id => $shipping_item) {
        $shipping_method = $shipping_item->get_method_id();
    }

    // Customize the message based on the shipping method ID
    if ($shipping_method == 'local_pickup') {
        echo '<h2>Thank you for your order! Your order will be ready for pickup in approximately 15 minutes. However, during peak hours it can take up to 45 minutes. We thank you for your patience.</h2>';
    }
}

// Adds expiry time for happyumami coupon code for happy hour
function time_range_coupon_code( $coupon_code ) {
    // For specific coupon codes only, several could be added, separated by a comma
    $specific_coupons_codes = array('happyumami');
    
    // Coupon code in array, so check
    if ( in_array( $coupon_code, $specific_coupons_codes ) ) {
        // Set the correct time zone (http://php.net/manual/en/timezones.php)
        date_default_timezone_set( 'America/Vancouver' );

        // Set the start time and the end time to be valid
        $start_time = mktime( 15, 00, 00, date( 'm' ), date( 'd' ), date( 'Y' ) );
        $end_time   = mktime( 17, 00, 00, date( 'm' ), date( 'd' ), date( 'Y' ) );
        $time_now   = strtotime( 'now' );
        
        // Return true or false
        return $start_time <= $time_now && $end_time >= $time_now;
    }
    
    // Default
    return true;
}

// Is valid
function filter_woocommerce_coupon_is_valid( $valid, $coupon, $discount ) {
    // Get coupon code
    $coupon_code = $coupon->get_code();
    
    // Call function, return true or false
    $valid = time_range_coupon_code( $coupon_code );

    // NOT valid
    if ( ! $valid ) {
        throw new Exception( __( 'This coupon is only valid during Happy Hour (3 PM to 5 PM)', 'woocommerce' ), 109 );
    }

    return $valid;
}
add_filter( 'woocommerce_coupon_is_valid', 'filter_woocommerce_coupon_is_valid', 10, 3 );
