<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hemila
 */
?>
	<div class="blog-content-main">
		<div class="blog-head">
			<?php the_post_thumbnail('hemila-blog-single-thumb'); ?>
		</div>
		<div class="blog-body">
			<h1 class="blog-heading"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h1>
			<div class="blog-meta">
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
			<?php the_content(); ?>
		</div>
	</div>