<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hemila
 */

get_header();
?>
	<!-- Error 404 -->
	<section class="error-404 not-found">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-7 col-12">
					<header class="page-header">
						<h1 class="page-title"><span><?php esc_html_e( 'Oops!', 'hemila' ); ?></span><?php esc_html_e( 'That page can&rsquo;t be found.', 'hemila' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'hemila' ); ?></p>

						<?php
							get_search_form();
						?>
					</div><!-- .page-content -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Error 404 -->

<?php
get_footer();
