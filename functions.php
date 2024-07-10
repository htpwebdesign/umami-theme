<?php
/**
 * Urban Umami functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Urban_Umami
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function umami_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Urban Umami, use a find and replace
		* to change 'umami-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'umami-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'umami-theme' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'umami-theme' ),
			'social-menu' => esc_html__( 'Footer Menu - Social', 'umami-theme' ),
			'contact-menu' => esc_html__( 'Footer Menu - Contact', 'umami-theme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'umami_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function umami_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'umami_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'umami_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

/**
 * Enqueue scripts and styles.
 */
function umami_theme_scripts() {
	wp_enqueue_style( 'umami-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'umami-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'umami-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script('jquery');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style(
		'google-fonts', 
		'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@100..900&display=swap', 
		array(),
		null
	);
	// Enqueue custom script
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), '1.0', true);

    // Enqueue category filter script conditionally for product archive and single product pages
    if (is_post_type_archive('product') || is_singular('product')) {
        wp_enqueue_script('category-filter', get_template_directory_uri() . '/js/category-filter.js', array('jquery'), '1.0', true);
    }
}
add_action( 'wp_enqueue_scripts', 'umami_theme_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load CPT and Taxonomy files.
 */
require get_template_directory() . '/inc/cpt-taxonomy.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// create shortcode for displaying testimonials
add_shortcode('testimonial', 'urb_testimonial_shortcode');

function urb_testimonial_shortcode() {
	$args = array(
		'post_type' => 'urb-testimonial',
		'posts_per_page' => 1,
		'orderby' => 'rand'
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			
			$output = "<div class='testimonial'>";
				$output .= "<h2>" . get_the_title() . "</h2>";
				$output .= get_the_content();
			$output .= "</div>";
		}

		wp_reset_postdata();
	}

	return $output;
}

function urb_contact_footer_menu($items, $args) {
	if ( $args->theme_location == 'contact-menu' ) {
		if ( function_exists( 'get_field' ) ) {
			$menu_object = wp_get_nav_menu_object( $args->menu );
            if ( $menu_object && have_rows( 'contact_repeater_footer', $menu_object ) ) {
                while ( have_rows( 'contact_repeater_footer', $menu_object ) ) {
                    the_row();

					$location_name = get_sub_field( 'location_name' );
					$address = get_sub_field( 'address' );
					$phone = get_sub_field( 'phone' );
					$email = get_sub_field( 'email' );
					$hours_of_operation = get_sub_field( 'hours_of_operation' );

					$items .= "<li>";
					$items .= "<h3>" . esc_html($location_name) . "</h3>";
					$items .= "<p>" . esc_html($address) . "</p>";
					$items .= "<p>" . esc_html($phone) . "</p>";
					$items .= "<a href='mailto:" . esc_attr($email) . "'>" . esc_html($email) . "</a>";
					$items .= "<p>" . esc_html($hours_of_operation) . "</p>";
					$items .= "</li>";
				}
			} 
		}
	}

	return $items;
}

add_filter('wp_nav_menu_items', 'urb_contact_footer_menu', 10, 2);

/**
 * Lower Yoast SEO Metabox location
 */
function yoast_to_bottom(){
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoast_to_bottom' );
