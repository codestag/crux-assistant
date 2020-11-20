<?php

add_action( 'add_meta_boxes', 'stag_metabox_layout' );

function stag_metabox_layout() {
	$meta_box = array(
		'id'          => 'stag-metabox-layout',
		'title'       => __( 'Layout Settings', 'crux-assistant' ),
		'description' => __( 'Configure page layout.', 'crux-assistant' ),
		'page'        => 'page',
		'context'     => 'side',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name'    => __( 'Page Layout', 'crux-assistant' ),
				'desc'    => __( 'Select the desired page layout.', 'crux-assistant' ),
				'id'      => '_stag_page_layout',
				'type'    => 'select',
				'std'     => 'default',
				'options' => array(
					'default'       => __( 'Default - Set in Crux > Sidebar', 'crux-assistant' ),
					'no-sidebar'    => __( 'No Sidebar', 'crux-assistant' ),
					'left-sidebar'  => __( 'Left Sidebar', 'crux-assistant' ),
					'right-sidebar' => __( 'Right Sidebar', 'crux-assistant' ),
				),
			),
			array(
				'name'    => __( 'Sidebar Setting', 'crux-assistant' ),
				'desc'    => __( 'Choose which sidebar to display.', 'crux-assistant' ),
				'id'      => '_stag_page_sidebar',
				'type'    => 'select',
				'std'     => 'default',
				'options' => stag_registered_sidebars( array( '' => __( 'Default Sidebar', 'crux-assistant' ) ) ),
			),
		),
	);

	stag_add_meta_box( $meta_box );

	$meta_box['page'] = 'post';
	stag_add_meta_box( $meta_box );
}
