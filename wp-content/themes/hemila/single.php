<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package hemila
 */

get_header();
?>

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

	<!-- Blog Sinlge -->
	<section class="blog-section blog-single">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-12">
					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'single' );

						the_post_navigation(
							array(
								'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'hemila' ) . '</span> <span class="nav-title">%title</span>',
								'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'hemila' ) . '</span> <span class="nav-title">%title</span>',
							)
						);

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
				</div>
				<div class="col-lg-4 col-md-4 col-12">
					<div class="hemila-sidebar">
						<?php get_sidebar();?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/ End Single -->
<?php
get_footer();
