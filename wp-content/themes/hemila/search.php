<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package hemila
 */

get_header();

?>
	
	<?php if(get_theme_mod('hemila_search_bc', true)) : ?>
		<!-- Hemila BC -->
		<div class="hemila-bc">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h2 class="bc-title"><?php printf( esc_html__( 'Search Results: %s', 'hemila' ), '<span>' . get_search_query() . '</span>' );?></h2>
						<div class="bc-list">
							<?php if (function_exists('bcn_display')) bcn_display(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Hemila BC -->
	<?php endif; ?>
	
	<section class="blog-section search-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-12">
					<?php if ( have_posts() ) : ?>

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

						endwhile;

						the_posts_navigation();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>
				</div>
				<div class="col-lg-4 col-md-4 col-12">
					<div class="hemila-sidebar">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php
get_footer();
