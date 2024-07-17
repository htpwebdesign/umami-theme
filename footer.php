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
				<a href="<?php echo esc_url( __( 'https://cgtwebdesigns.com/', 'umami-theme' ) ); ?>" target="_blank">
					<?php esc_html_e( 'Catharina', 'umami-theme' ); ?>
				</a>,
				<a href="<?php echo esc_url( __( 'https://mlewebs.ca/', 'umami-theme' ) ); ?>" target="_blank">
					<?php esc_html_e( 'Matthew', 'umami-theme' ); ?>
				</a>,
				<a href="<?php echo esc_url( __( 'https://ninaweng.com/', 'umami-theme' ) ); ?>" target="_blank">
					<?php esc_html_e( 'Nina', 'umami-theme' ); ?>
				</a>, and
				<a href="<?php echo esc_url( __( 'https://natcreates.com/', 'umami-theme' ) ); ?>" target="_blank">
					<?php esc_html_e( 'Natalia', 'umami-theme' ); ?>
				</a>.
			</p>
			<!---->
		</div><!-- .site-info -->
		<button id="back-to-top" class="back-to-top">
			<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
				<path d="m11.998 21.995c5.517 0 9.997-4.48 9.997-9.997 0-5.518-4.48-9.998-9.997-9.998-5.518 0-9.998 4.48-9.998 9.998 0 5.517 4.48 9.997 9.998 9.997zm4.843-8.211c.108.141.157.3.157.456 0 .389-.306.755-.749.755h-8.501c-.445 0-.75-.367-.75-.755 0-.157.05-.316.159-.457 1.203-1.554 3.252-4.199 4.258-5.498.142-.184.36-.29.592-.29.23 0 .449.107.591.291z"/>
			</svg>
			<span class="screen-reader-text">Scroll To Top</span>
		</button>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
