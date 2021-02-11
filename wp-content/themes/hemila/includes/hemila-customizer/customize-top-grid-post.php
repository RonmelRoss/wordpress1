<?php 
// Hemila Top Grid Post
$wp_customize->add_section( 'hemila_top_grid_section', array(
	'capability'            => 'edit_theme_options',
	'priority'              => 2,
	'title'                 => __( 'Top Grid Post', 'hemila' ),
	'description'           => __( 'Post Slider Settings.', 'hemila' ),
	'panel'                 => 'hemila_front_option'
) );

$wp_customize->add_setting( 'hemila_top_grid_enable',
  array(
    'default'           => '',
    'sanitize_callback'     => 'hemila_sanitize_checkbox'
  )
);

$wp_customize->add_control( 'hemila_top_grid_enable',
  array(
    'label'         => esc_html__( 'Enable Top Grid Post?', 'hemila' ),
    'section'       => 'hemila_top_grid_section',
    'type'          => 'checkbox',
    'priority'      => 1,
  )
);

$wp_customize->add_setting( 'hemila_top_grid_post_count', array(
    'capability'            => 'edit_theme_options',
    'default'               => '1',
    'sanitize_callback'     => 'wp_filter_nohtml_kses'
) );

$wp_customize->add_control( 'hemila_top_grid_post_count', array(
    'label'                 =>  __( 'Type post count', 'hemila' ),
    'section'               => 'hemila_top_grid_section',
    'type'                  => 'text',
    'settings'              => 'hemila_top_grid_post_count',
) );

$wp_customize->add_setting('hemila_top_grid_category_id',array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'hemila_sanitize_category',
	'default' =>  '1',
   )
);
    
$wp_customize->add_control(new hemila_Customize_Dropdown_Taxonomies_Control($wp_customize,'hemila_top_grid_category_id',
    array(
        'label' => __('Select category for Blog','hemila'),
        'section' => 'hemila_top_grid_section',
        'settings' => 'hemila_top_grid_category_id',
        'type'=> 'dropdown-taxonomies',
    )
));