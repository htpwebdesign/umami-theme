<?php
defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
do_action('woocommerce_before_main_content');

/**
 * Hook: woocommerce_shop_loop_header.
 */
do_action('woocommerce_shop_loop_header');

get_template_part('category-menu');

if (woocommerce_product_loop()) {
    // Manually define the category order
    $category_order = array('appetizers', 'build-your-own-ramen', 'rice-noodles', 'sushi', 'combo', 'drinks', 'dessert');
    $ordered_categories = array();

    // Display products by category
    $product_categories = get_terms('product_cat', array(
        'hide_empty' => false,
        'parent'     => 0,
    ));

    // Order the categories according to the defined order
    foreach ($category_order as $slug) {
        foreach ($product_categories as $category) {
            if ($category->slug === $slug) {
                $ordered_categories[] = $category;
                break;
            }
        }
    }

    foreach ($ordered_categories as $category) {
        if ($category->slug !== 'uncategorized' && $category->slug !== 'gift-card') {
            echo '<section id="' . esc_attr($category->slug) . '" class="product-category">';
            echo '<h2>' . esc_html($category->name) . '</h2>';

            // Check if the current category is "Sushi" or "Rice-Noodles"
            if ($category->slug === 'sushi' || $category->slug === 'rice-noodles') {
                // Fetch sub-categories of "Sushi" or "Rice-Noodles"
                $subcategories = get_terms('product_cat', array(
                    'hide_empty' => false,
                    'parent'     => $category->term_id, // Get sub-categories of "Sushi" or "Rice-Noodles"
                ));

                foreach ($subcategories as $subcategory) {
                    echo '<section id="' . esc_attr($subcategory->slug) . '" class="product-subcategory">';
                    echo '<h3>' . esc_html($subcategory->name) . '</h3>';

                    // Fetch and display products in the current sub-category
                    $sub_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => $subcategory->slug,
                            ),
                        ),
                    );

                    $sub_products = new WP_Query($sub_args);

                    if ($sub_products->have_posts()) {
                        woocommerce_product_loop_start();

                        while ($sub_products->have_posts()) {
                            $sub_products->the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action('woocommerce_shop_loop');

                            wc_get_template_part('content', 'product');
                        }

                        woocommerce_product_loop_end();
                    }

                    wp_reset_postdata();
                    echo '</section>';
                }
            } else {
                // Fetch and display products in the current category
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

                $products = new WP_Query($args);

                if ($products->have_posts()) {
                    woocommerce_product_loop_start();

                    while ($products->have_posts()) {
                        $products->the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action('woocommerce_shop_loop');

                        wc_get_template_part('content', 'product');
                    }

                    woocommerce_product_loop_end();
                }

                wp_reset_postdata();
            }

            echo '</section>';
        }
    }

    /**
     * Hook: woocommerce_after_shop_loop.
     */
    do_action('woocommerce_after_shop_loop');
} else {
    /**
     * Hook: woocommerce_no_products_found.
     */
    do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
?>
