<?php 
// Hemila Header Option
$wp_customize->add_section( 'hemila_theme_settings', array(
	'capability'            => 'edit_theme_options',
	'priority'              => 1,
	'title'                 => __( 'Theme Default', 'hemila' ),
	'description'           => __( 'Theme default Settings', 'hemila' ),
	'panel'                 => 'hemila_front_option'
) );

$wp_customize->add_setting( 'hemila_topbar_enable',
  array(
    'default'           => 1,
    'sanitize_callback'     => 'hemila_sanitize_checkbox'
  )
);

$wp_customize->add_control( 'hemila_topbar_enable',
  array(
    'label'         => esc_html__( 'Enable topbar?', 'hemila' ),
    'section'       => 'hemila_theme_settings',
    'type'          => 'checkbox',
  )
);


$wp_customize->add_setting( 'hemila_post_top_enable',
  array(
    'default'           => 1,
    'sanitize_callback'     => 'hemila_sanitize_checkbox'
  )
);

$wp_customize->add_control( 'hemila_post_top_enable',
  array(
    'label'         => esc_html__( 'Enable post top title', 'hemila' ),
    'section'       => 'hemila_theme_settings',
    'type'          => 'checkbox',
  )
);

$wp_customize->add_setting( 'hemila_post_title', array(
    'capability'            => 'edit_theme_options',
    'default'               => 'Latest Articles',
    'sanitize_callback'     => 'sanitize_text_field'
) );

$wp_customize->add_control( 'hemila_post_title', array(
    'label'                 =>  __( 'Post Top title', 'hemila' ),
    'section'               => 'hemila_theme_settings',
    'type'                  => 'text',
    'settings'              => 'hemila_post_title',
) );

$wp_customize->add_setting( 'hemila_post_desc', array(
    'capability'            => 'edit_theme_options',
	'default'                  => 'Read the latest release articles and learn without limits.',
    'sanitize_callback'     => 'sanitize_text_field'
) );

$wp_customize->add_control( 'hemila_post_desc', array(
    'label'                 =>  __( 'Post Top title description', 'hemila' ),
    'section'               => 'hemila_theme_settings',
    'type'                  => 'text',
    'settings'              => 'hemila_post_desc',
) );

$wp_customize->add_setting( 'hemila_social_enable',
  array(
    'default'           => false,
    'sanitize_callback'     => 'hemila_sanitize_checkbox'
  )
);

$wp_customize->add_control( 'hemila_social_enable',
  array(
    'label'         => esc_html__( 'Enable Social Widget', 'hemila' ),
    'section'       => 'hemila_theme_settings',
    'type'          => 'checkbox',
  )
);

$hemila_social_arrays =  array('1'=>'fa-twitter', '2'=>'fa-facebook','3'=>'fa-linkedin','4'=>'fa-dribbble','5'=>'fa-youtube', );
foreach($hemila_social_arrays as $hemila_key => $hemila_socail){
	

$wp_customize->add_setting( 'hemila_sidebar_social_icon_'.$hemila_key, array(
	    'capability'            => 'edit_theme_options',
	    'default'               => '',
	    'sanitize_callback'     => 'sanitize_text_field'
	) );

$wp_customize->add_control( 'hemila_sidebar_social_icon_'.$hemila_key, array(
	/* translators: %s: Label */ 
    'label'                 =>   sprintf( __( 'Type social icon %s', 'hemila' ), $hemila_key ),
    /* translators: %s: Description */ 
	'description'           => sprintf( __( 'Use icon: Eg: %1$s. %2$s See more here %3$s', 'hemila' ), $hemila_socail,'<a href="'.esc_url('http://fontawesome.io/icons/').'" target="_blank">','</a>'),
    'section'               => 'hemila_theme_settings',
    'type'                  => 'text',
    'settings' => 'hemila_sidebar_social_icon_'.$hemila_key,
) );	

$wp_customize->add_setting( 'hemila_sidebar_social_link_'.$hemila_key, array(
	    'capability'            => 'edit_theme_options',
	    'default'               => '',
	    'sanitize_callback'     => 'esc_url_raw'
	) );

$wp_customize->add_control( 'hemila_sidebar_social_link_'.$hemila_key, array(
	/* translators: %s: Description */ 
    'label'                 =>   sprintf( __( 'Social icon link %s', 'hemila' ), $hemila_key ),
    'section'               => 'hemila_theme_settings',
    'type'                  => 'url',
    'settings' => 'hemila_sidebar_social_link_'.$hemila_key,
) );
}

$wp_customize->add_setting( 'hemila_post_excerpt', array(
    'capability'            => 'edit_theme_options',
    'default'               => 22,
    'sanitize_callback'     => 'absint'
) );

$wp_customize->add_control( 'hemila_post_excerpt', array(
    'label'                 =>  __( 'Post Excerpt Limit', 'hemila' ),
	'description'            => __( 'Customize post excerpt limit, global limit is : 22', 'hemila' ),
    'section'               => 'hemila_theme_settings',
    'settings'              => 'hemila_post_excerpt',
    'type'                  => 'text',
) );
