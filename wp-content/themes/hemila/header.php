<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hemila
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Start Page -->
<div id="page" class="site">

	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'hemila' ); ?></a>

		<!-- Header -->
		<header id="masthead" class="header site-header">
			<?php if(get_theme_mod('hemila_topbar_enable', 1)) : ?>
			<div class="topbar">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-12">
							<!-- Date -->
							<div class="top-date"><i class="fa fa-calendar"></i> <?php echo esc_html(date_i18n(get_option('date_format'))); ?> <?php echo esc_html(date_i18n(get_option('time_format'))); ?></div>
							<!--/ End Date -->
						</div>
						<div class="col-lg-8 col-md-8 col-12">
							<div class="top-right">
								<?php
									wp_nav_menu( array(
									'theme_location' => 'menu-2',
										'menu_id'    => 'top-menu',
										'menu_class' => 'nav top-menu navbar-nav',
									) );
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif;?>
			<div class="header-inner">
			<?php if ( get_header_image() ) : ?>
				<div class="header-image">
					<img src="<?php header_image(); ?>" width="<?php echo absint( get_custom_header()->width ); ?>" height="<?php echo absint( get_custom_header()->height ); ?>">
				</div>
			<?php endif; ?>
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-9 col-12">
							<!-- Logo -->
							<div class="logo">
								<?php if( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
									the_custom_logo();
								}else { ?>
									<div class="normal-text">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html(get_bloginfo('name'));?></a>
										<?php $hemila_title_description = get_bloginfo( 'description', 'display' ); ?>
										<p class="site-description"><?php echo $hemila_title_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="col-lg-9 col-md-9 col-12">
							<?php if(is_active_sidebar('hemila-header-right')) : ?>
							<aside class="header-right"> 
								<?php dynamic_sidebar('hemila-header-right'); ?>
							</aside>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
			<div class="main-menu">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="main-menu-bar">
								<!-- Main Nav -->
								<nav id="site-navigation" class="main-navigation navbar navbar-expand-lg">
									<div class="navbar-collapse">
										<?php
										wp_nav_menu( array(
											'theme_location' => 'menu-1',
											'menu_id'        => 'primary-menu',
											'menu_class'        => 'nav hemila-menu navbar-nav',
										) );
										?>
									</div>
								</nav>
								<!--/ End Main Nav -->
								
								<!-- Hemila Mobile Menu -->
								<div class="hemila-mobile-menu">
									<div class="menu-click"><a href="#"class="fa fa-bars"><span><?php esc_html_e('Menu','hemila');?></span></a></div>
									<div class="menu-inner">
										<?php
											wp_nav_menu( array(
												'theme_location' => 'menu-1',
												'menu_id'        => 'side-menu',
												'menu_class'        => 'side-nav',
											) );
										?>
										<div class="close-menu"><a href="#"><i class="fa fa-remove"></i><?php esc_html_e('Close Menu','hemila');?></a></div>
									</div>
								</div>
								<!-- End Hemila Mobile Menu -->
								<?php if(get_theme_mod('hemila_social_enable')) : ?>
								<!-- Social Widget -->
								<div class="social-widget">
									<h4><?php esc_html_e('Follow Us','hemila');?></h4>
									<ul>
										<?php for($i=1;$i<=5;$i++):?>
										<li><a href="<?php echo esc_url( get_theme_mod( 'hemila_sidebar_social_link_'.$i ) )?>"><i class="fa <?php echo esc_attr( get_theme_mod( 'hemila_sidebar_social_icon_'.$i ) )?>"></i></a></li>
										<?php endfor;?>
									</ul>
								</div>
								<?php endif; ?>
							</div>
						</div>	
					</div>	
				</div>	
			</div>	
		</header>
		<!-- End Header -->
		
<div id="primary" class="hemila-section-main">