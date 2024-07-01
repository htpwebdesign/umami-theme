<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Urban_Umami
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
            if (function_exists("get_field")) {
                if (have_rows("contact_repeater")) {
                    while (have_rows("contact_repeater")) {

                        the_row();

                        if (get_sub_field("location_name")) {
                            $location_name = sanitize_text_field(get_sub_field("location_name"));
                            echo "<p>" . esc_html($location_name) . "</p>";
                        }

                        if (get_sub_field("address")) {
                            $address = sanitize_text_field(get_sub_field("address"));
                            echo "<p>" . esc_html($address) . "</p>";
                        }

                        if (get_sub_field("map")) {
                            $location = get_sub_field("map");
                            if (isset($location['lat']) && isset($location['lng'])) {
                                $lat = sanitize_text_field($location['lat']);
                                $lng = sanitize_text_field($location['lng']);
                                ?>
                                <div class="acf-map" data-zoom="16">
                                    <div class="marker" data-lat="<?php echo esc_attr($lat); ?>" data-lng="<?php echo esc_attr($lng); ?>"></div>
                                </div>
                                <?php
                            }
                        }

                        if (get_sub_field("phone")) {
                            $phone = sanitize_text_field(get_sub_field("phone"));
                            echo "<p>" . esc_html($phone) . "</p>";
                        }

                        if (get_sub_field("email")) {
                            $email = sanitize_email(get_sub_field("email"));
                            if ($email) {
                                echo "<p><a href='mailto:" . esc_attr($email) . "'>" . esc_html($email) . "</a></p>";
                            }
                        }
                    }
                }
            }
		?>

	</main><!-- #main -->

<?php
get_footer();
