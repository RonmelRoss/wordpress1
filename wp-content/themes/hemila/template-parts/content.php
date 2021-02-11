<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hemila
 */

?>
<div class="col-lg-6 col-md-6 col-12">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<!-- Single Post -->
		<div class="hemila-single-post margin-top-30">
			<div class="blog-head">
				<div class="comments"><i class="fa fa-comments"></i><?php echo esc_html(get_comments_number());?></div>
				<?php if(has_post_thumbnail()) : ?>	
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('hemila-blog-thumb'); ?></a>
				<?php endif; ?>
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
			</div>
			<div class="blog-body">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="entry-content"><?php the_excerpt();?></div>
				<div class="blog-meta">
					<?php $hemila_categories = get_the_category(get_the_ID());?>
					<div class="category"><a href="<?php echo esc_url(get_category_link($hemila_categories[0]->term_id));?>"><?php echo esc_html($hemila_categories[0]->name); ?></a></div>
					<ul class="list">
						<?php if ( empty (has_post_thumbnail())) : ?>
							<li><i class="fa fa-pencil"></i><?php hemila_posted_on(); ?></li>
						<?php endif; ?>
						<li><i class="fa fa-user"></i><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php 
						hemila_posted_by(); ?></a></li>
						<li><i class="fa fa-calendar"></i><?php echo esc_html(get_the_date());?></li>
						
					</ul>
				</div>
			</div>
		</div>
	</article> <!-- #post-<?php the_ID(); ?> -->
</div>