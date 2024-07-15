<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Urban_Umami
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'umami-theme' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Visit our menu page if you want to order some delicious Japanese food!', 'umami-theme' ); ?></p>

				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="sad-face"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3.5 8c.828 0 1.5.671 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.671-1.5-1.5.672-1.5 1.5-1.5zm-7 0c.828 0 1.5.671 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.671-1.5-1.5.672-1.5 1.5-1.5zm8.122 9.377c-1.286-.819-2.732-1.308-4.622-1.308s-3.336.489-4.622 1.308l-.471-.58c.948-1.161 2.761-2.797 5.093-2.797s4.145 1.636 5.093 2.797l-.471.58z"/></svg>
				<a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>" class="menu-link-404"><?php esc_html_e( 'Menu', 'umami-theme' ); ?></a>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
