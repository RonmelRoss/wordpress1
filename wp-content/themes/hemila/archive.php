<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hemila
 */

get_header();
?>

	<?php if(get_theme_mod('hemila_archive_bc', true)) : ?>
		<!-- Hemila BC -->
		<div class="hemila-bc">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php $hemila_bc_archive_title = get_theme_mod('hemila_bc_archive_title'); ?>
						<?php if(!empty ($hemila_bc_archive_title)) :?>
						<h2 class="bc-title"><?php echo esc_html($hemila_bc_archive_title)?></h2>
						<?php else :?>
						<h2 class="bc-title"><?php esc_html_e('Blog Archive','hemila')?></h2>
						<?php endif ;?>
						<div class="bc-list">
							<?php if (function_exists('bcn_display')) bcn_display(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Hemila BC -->
	<?php endif; ?>
	
	<section class="blog-section site-archive">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-12">
					<div class="archive-post">
						<div class="row">
							<?php if ( have_posts() ) : ?>
								<?php
									/* Start the Loop */
									while ( have_posts() ) :
									the_post();

									/*
									 * Include the Post-Type-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
									 */
									get_template_part( 'template-parts/content', 'archive' );

								endwhile;

								else :
								get_template_part( 'template-parts/content', 'none' );

								endif;
							?>
						</div>
						<div class="row">
							<div class="col-12">
								<!-- Hemila Pagination -->
								<div class="pagination-main">
									<?php if (function_exists("hemila_pagination"))
										{
											hemila_pagination();
										}  
									?>
								</div>
								<!--/ End Hemila Pagination -->
							</div>
						</div>	
					</div>
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
