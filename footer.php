<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Urban_Umami
 */

?>

	<footer id="colophon" class="site-footer">
		<?php the_custom_logo(); ?>
		<nav class="social-navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'social-menu',
					'menu_id'        => 'social-menu',
				)
			);
			?>
		</nav>
		<div class="contact-locations">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'contact-menu',
					'menu_id'        => 'contact-menu',
				)
			);
			?>
		</div><!-- .footer-contact -->
		<div class="footer-menu">
			<nav class="footer-navigation">
				<h2>Company</h2>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'menu_id'        => 'footer-menu',
					)
				);
				?>
			</nav>
		</div><!-- .footer-menus -->
		<div class="site-info">
			<p>&copy;2024 Urban Umami. All rights reserved |
				<?php the_privacy_policy_link(); ?> |
				<?php esc_html_e( 'Created by ', 'umami-theme' ); ?>
				<a href="<?php echo esc_url( __( 'https://wp.bcitwebdeveloper.ca/', 'umami-theme' ) ); ?>">
					<?php esc_html_e( 'CMNN', 'umami-theme' ); ?>
				</a>
			</p>
			<!---->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
