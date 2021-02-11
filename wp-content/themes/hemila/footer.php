<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hemila
 */

?>
</div><!-- #content -->
	<footer id="colophon" class="site-footer">
		<?php if(is_active_sidebar('hemila_footer_1')) : ?>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<?php if(is_active_sidebar('hemila_footer_1')) : ?>
						<div class="col-lg-4 col-md-4 col-12">
							<?php dynamic_sidebar('hemila_footer_1'); ?>
						</div>
					<?php endif; ?>
					<?php if(is_active_sidebar('hemila_footer_2')) : ?>
						<div class="col-lg-4 col-md-4 col-12">
							<?php dynamic_sidebar('hemila_footer_2'); ?>
						</div>
					<?php endif; ?>
					<?php if(is_active_sidebar('hemila_footer_3')) : ?>
						<div class="col-lg-4 col-md-4 col-12">
							<?php dynamic_sidebar('hemila_footer_3'); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="footer-bottom">
			<div class="scroll-top"><a href="#masthead"><i class="fa fa-arrow-up"></i></a></div>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="site-info">
							<div class="single-line">
								<p><?php esc_html_e('&copy; All Right Reserved ','hemila'); bloginfo('title');?> <?php echo  esc_html(date_i18n( __( 'Y' , 'hemila' ) ));?></p>
							</div>
							<div class="single-line">
								<p><?php
								/* translators: 1: Theme name, 2: Theme author. */
								printf( esc_html__( 'Theme %2$s  By  %1$s', 'hemila' ), '<a href="https://sitebland.com/product/hemila" target="_blank" >sitebland</a>' , '<a href="#" target="_blank">Hemila</a>' );?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	
</div><!-- End Page -->

<?php wp_footer(); ?>

</body>
</html>
