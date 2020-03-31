<?php

add_action( 'add_meta_boxes', 'stag_metabox_layout' );

function stag_metabox_layout() {
	$meta_box = array(
		'id'          => 'stag-metabox-layout',
		'title'       => __( 'Layout Settings', 'crux' ),
		'description' => __( 'Configure page layout.', 'crux' ),
		'page'        => 'page',
		'context'     => 'side',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name'    => __( 'Page Layout', 'crux' ),
				'desc'    => __( 'Select the desired page layout.', 'crux' ),
				'id'      => '_stag_page_layout',
				'type'    => 'select',
				'std'     => 'default',
				'options' => array(
					'default'       => __( 'Default - Set in Crux > Sidebar', 'crux' ),
					'no-sidebar'    => __( 'No Sidebar', 'crux' ),
					'left-sidebar'  => __( 'Left Sidebar', 'crux' ),
					'right-sidebar' => __( 'Right Sidebar', 'crux' ),
				),
			),
			array(
				'name'    => __( 'Sidebar Setting', 'crux' ),
				'desc'    => __( 'Choose which sidebar to display.', 'crux' ),
				'id'      => '_stag_page_sidebar',
				'type'    => 'select',
				'std'     => 'default',
				'options' => stag_registered_sidebars( array( '' => __( 'Default Sidebar', 'crux' ) ) ),
			),
		),
	);

	stag_add_meta_box( $meta_box );

	$meta_box['page'] = 'post';
	stag_add_meta_box( $meta_box );
}
