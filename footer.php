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
		<div class="footer-contact">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'contact-menu',
					'menu_id'        => 'contact-menu',
				)
			);
			?>
		</div><!-- .footer-contact -->
		<div class="footer-menus">
			<nav class="footer-navigation">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'menu_id'        => 'footer-menu',
					)
				);
				?>
			</nav>
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
		</div><!-- .footer-menus -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
