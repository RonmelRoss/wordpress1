<?php 
// Hemila Breadcrumb
$wp_customize->add_section( 'hemila_breadcrumb', array(
	'capability'            => 'edit_theme_options',
	'priority'              => 3,
	'title'                 => esc_html__( 'Page Breadcrumb', 'hemila' ),
	'description'           => esc_html__( 'Page Breadcrumb Settings.', 'hemila' ),
	'panel'                 => 'hemila_front_option'
) );

$wp_customize->add_setting( 'hemila_page_bc',
  array(
    'default'           => true,
    'sanitize_callback'     => 'hemila_sanitize_checkbox'
  )
);

$wp_customize->add_control( 'hemila_page_bc',
  array(
    'label'         => esc_html__( 'Show page breadcrumb', 'hemila' ),
    'section'       => 'hemila_breadcrumb',
    'type'          => 'checkbox',
  )
);

$wp_customize->add_setting( 'hemila_archive_bc',
  array(
    'default'           => true,
    'sanitize_callback'     => 'hemila_sanitize_checkbox'
  )
);

$wp_customize->add_control( 'hemila_archive_bc',
  array(
    'label'         => esc_html__( 'Show archive breadcrumb', 'hemila' ),
    'section'       => 'hemila_breadcrumb',
    'type'          => 'checkbox',
  )
);
$wp_customize->add_setting( 'hemila_bc_archive_title', array(
    'capability'            => 'edit_theme_options',
    'sanitize_callback'     => 'sanitize_text_field'
) );

$wp_customize->add_control( 'hemila_bc_archive_title', array(
    'label'                 =>  __( 'Type Archive Title', 'hemila' ),
    'section'               => 'hemila_breadcrumb',
    'type'                  => 'text',
    'settings'              => 'hemila_bc_archive_title',
) );

$wp_customize->add_setting( 'hemila_search_bc',
  array(
    'default'           => true,
    'sanitize_callback'     => 'hemila_sanitize_checkbox'
  )
);

$wp_customize->add_control( 'hemila_search_bc',
  array(
    'label'         => esc_html__( 'Show search breadcrumb', 'hemila' ),
    'section'       => 'hemila_breadcrumb',
    'type'          => 'checkbox',
  )
);