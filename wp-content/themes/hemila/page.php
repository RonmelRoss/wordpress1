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
 * @package hemila
 */

get_header();
?>
	
	<?php if(get_theme_mod('hemila_page_bc', true)) : ?>
		<!-- Hemila BC -->
		<div class="hemila-bc">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h2 class="bc-title"><?php the_title() ?></h2>
						<div class="bc-list">
							<?php if (function_exists('bcn_display')) bcn_display(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Hemila BC -->
	<?php endif; ?>
	
	<section class="blog-section site-page">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="page-top">
						<?php
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
get_footer();
