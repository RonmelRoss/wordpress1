<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hemila
 */

get_header();
?>
	<!-- Blog Layout -->
	<section class="blog-section site-main">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-12">
					<?php if(get_theme_mod('hemila_blog_enable')) : ?>
						<div class="post-main-slider">
							<div class="post-slider">
								<?php
									$hemila_post_count = esc_attr(get_theme_mod( 'hemila_post_count'));
									$hemila_blog_catId = esc_attr(get_theme_mod( 'hemila_blog_category_id'));
									$hemila_blog_catLink = get_category_link($hemila_blog_catId);
									$hemila_blog_CatName = get_category($hemila_blog_catId);
									$args = array(
										'post_type' => 'post',
										'posts_per_page' => $hemila_post_count,
										'post_status' => 'publish',
										'cat' => $hemila_blog_catId,
									);
									$hemila_blogloop = new WP_Query($args);
									while ($hemila_blogloop->have_posts()) : 
									$hemila_blogloop->the_post(); 
								?>
								<!-- Single Post Slider -->
								<div class="single-c-slider">
									<?php $categories = get_the_category(get_the_ID());?>
									<div class="image-head">
										<div class="post-cat"><a href="<?php echo esc_url(get_category_link($categories[0]->term_id));?>"><?php echo esc_html($categories[0]->name); ?></a></div>
										<a href="<?php the_permalink();?>">
											<?php the_post_thumbnail('hemila-slider-thumb'); ?>
										</a>
									</div>
									<!-- Hemila content -->
									<div class="hemila-content">
										<div class="post-formet">
										<?php if ( ! has_post_format( 'gallery') && ! has_post_format( 'video') ) :?>
											<span><i class="fa fa-pencil"></i></span>
										<?php endif; ?>
										<?php if ( has_post_format( 'gallery' )) :?>
											<span><i class="fa fa-photo"></i></span>
										<?php endif; ?>	
										<?php if ( has_post_format( 'video' )) :?>
											<span><i class="fa fa-youtube"></i></span>
										<?php endif; ?>	
										</div>
										<div class="news-meta">
											<ul class="list">
											<?php if ( empty (has_post_thumbnail())) : ?>
												<li><i class="fa fa-pencil"></i><?php hemila_posted_on(); ?></li>
											<?php endif; ?>
											<li><i class="fa fa-user"></i><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php 
											hemila_posted_by(); ?></a></li>
											<li><i class="fa fa-calendar-o"></i><?php echo esc_html(get_the_date());?> </li>
											<li><i class="fa fa-comments"></i><?php echo esc_html(get_comments_number());?> <?php esc_html_e('comments', 'hemila'); ?></li>
											</ul>
										</div>
									<h2 class="news-title medium"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
									<?php the_excerpt(); ?>
									<a href="<?php the_permalink() ;?>" class="hemila-btn"><?php esc_html_e('Read Article','hemila');?></a>
								</div>
							</div>
							<?php endwhile;
								wp_reset_postdata();
							?>			
						</div>
					</div>
					<?php endif; ?>
				</div>
				<?php if(get_theme_mod('hemila_top_grid_enable')) : ?>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="blog-top-grid">
						<div class="list-unstyled clearfix">
							<div class="row">
								<?php
									$hemila_top_grid_post_count = esc_attr(get_theme_mod( 'hemila_top_grid_post_count'));
									$hemila_top_grid_catId = esc_attr(get_theme_mod( 'hemila_top_grid_category_id'));
									$hemila_blog_catLink = get_category_link($hemila_top_grid_catId);
									$hemila_blog_CatName = get_category($hemila_top_grid_catId);
									$args = array(
										'post_type' => 'post',
										'posts_per_page' => $hemila_top_grid_post_count,
										'post_status' => 'publish',
										'cat' => $hemila_top_grid_catId,
									);
									$hemila_blogloop = new WP_Query($args);
									while ($hemila_blogloop->have_posts()) : 
									$hemila_blogloop->the_post(); 
								?>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="single-top-grid">
										<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
											<div class="post-thumb">
												<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" title="<?php the_title_attribute( 'echo=0' ); ?>"><?php the_post_thumbnail('hemila-top-grid-thumb'); ?>
												<div class="comment"><i class="fa fa-comments"></i><?php echo esc_html(get_comments_number());?></div>
											</div>
											<div class="post-text">
												<p class="post-meta"><time class="post-date" datetime="<?php echo esc_html(get_the_date()); ?>"><i class="fa fa-clock-o"></i><?php echo esc_html(get_the_date()); ?></time></p>
												<h4><a href="<?php echo esc_url( get_permalink()); ?>" rel="bookmark" title="<?php the_title_attribute( 'echo=0' ); ?>"><?php the_title(); ?></a></h4>
											</div>
										<?php } else{?>
											<div class="post-text">
												<p class="post-meta"><time class="post-date" datetime="<?php echo esc_html(get_the_date()); ?>"><i class="fa fa-clock-o"></i><?php echo esc_html(get_the_date()); ?></time></p>
												<h4><a href="<?php echo esc_url( get_permalink()); ?>" rel="bookmark" title="<?php the_title_attribute( 'echo=0' ); ?>"><?php the_title(); ?></a></h4>
											</div>
										<?php } ?>
										<div class="clearfix"></div>
									</div>
								</div>
								<?php endwhile;
								wp_reset_postdata();
								?>		
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="home-top-post">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-12">
								<div class="hemila-latest-post">
									<?php
										$hemila_post_title = get_theme_mod('hemila_post_title');
										$hemila_post_desc = get_theme_mod('hemila_post_desc');
									?>
									<?php if(get_theme_mod('hemila_post_top_enable', 1)) : ?>
									<div class="b-title">
										<?php if(!empty ($hemila_post_title)) :?>
											<h2><?php echo esc_html($hemila_post_title); ?></h2>
										<?php else : ?>
											<h2><?php esc_html_e('Latest Articles','hemila'); ?></h2>
										<?php endif;?>
										
										<?php if(!empty ($hemila_post_desc)) :?>
											<p><?php echo esc_html($hemila_post_desc); ?></p>
										<?php else : ?>
											<p><?php esc_html_e('Read the latest release articles and learn without limits.','hemila'); ?></p>
										<?php endif;?>
									</div>
									<?php endif; ?>
									<div class="row">
										<?php
										if ( have_posts() ) :
											if ( is_home() && ! is_front_page() ) :
												?>
												<header>
													<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
												</header>
												<?php
											endif;
											/* Start the Loop */
											while ( have_posts() ) :
												the_post();

												/*
												* Include the Post-Type-specific template for the content.
												* If you want to override this in a child theme, then include a file
												* called content-___.php (where ___ is the Post Type name) and that will be used instead.
												*/
												get_template_part( 'template-parts/content', get_post_type() );
											endwhile;
										else :
											get_template_part( 'template-parts/content', 'none' );
										endif;
										?>
									</div>
									<div class="row">
										<div class="col-12">
											<?php the_posts_navigation(); ?>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<!-- Start Pagination -->
											<div class="pagination-main">
												<?php if (function_exists("hemila_pagination"))
													{
														hemila_pagination();
													}  
												?>
											</div>
											<!-- End Pagination -->
										</div>
									</div>	
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-12">
								<div class="hemila-sidebar left-side">
									<?php get_sidebar(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Blog Layout -->
<?php get_footer();