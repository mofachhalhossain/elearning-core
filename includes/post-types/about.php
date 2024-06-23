<?php
add_theme_support('post-thumbnails');

function elearning_register_about_post_type() {
    $labels = array(
        'name'               => 'About Sections',
        'singular_name'      => 'About Section',
        'menu_name'          => 'About',
        'name_admin_bar'     => 'About',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New About Section',
        'new_item'           => 'New About Section',
        'edit_item'          => 'Edit About Section',
        'view_item'          => 'View About Section',
        'all_items'          => 'About',
        'search_items'       => 'Search About Sections',
        'not_found'          => 'No about sections found.',
        'not_found_in_trash' => 'No about sections found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'learning-core',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'about-section' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
    );

    register_post_type( 'about', $args );
}
add_action( 'init', 'elearning_register_about_post_type' );


function elearning_about_add_meta_boxes() {
    add_meta_box(
        'elearning_about_list',
        'About List Items',
        'elearning_about_list_meta_box_callback',
        'about'
    );
    add_meta_box(
        'elearning_about_button',
        'About Button',
        'elearning_about_button_meta_box_callback',
        'about'
    );
}
add_action( 'add_meta_boxes', 'elearning_about_add_meta_boxes' );


function elearning_about_list_meta_box_callback( $post ) {
    $value = get_post_meta( $post->ID, '_elearning_about_list', true );
    echo '<label for="elearning_about_list">List Items (separated by commas): </label>';
    echo '<textarea id="elearning_about_list" name="elearning_about_list" rows="4" cols="50">' . esc_textarea( $value ) . '</textarea>';
}

function elearning_about_button_meta_box_callback( $post ) {
    $text = get_post_meta( $post->ID, '_elearning_about_button_text', true );
    $url = get_post_meta( $post->ID, '_elearning_about_button_url', true );
    echo '<label for="elearning_about_button_text">Button Text: </label>';
    echo '<input type="text" id="elearning_about_button_text" name="elearning_about_button_text" value="' . esc_attr( $text ) . '" size="50" />';
    echo '<br/><br/>';
    echo '<label for="elearning_about_button_url">Button URL: </label>';
    echo '<input type="text" id="elearning_about_button_url" name="elearning_about_button_url" value="' . esc_attr( $url ) . '" size="50" />';
}


function elearning_save_about_meta_boxes( $post_id ) {
    if ( isset( $_POST['elearning_about_list_nonce'] ) && wp_verify_nonce( $_POST['elearning_about_list_nonce'], 'elearning_save_about_list' ) ) {
        update_post_meta( $post_id, '_elearning_about_list', sanitize_textarea_field( $_POST['elearning_about_list'] ) );
    }

    if ( isset( $_POST['elearning_about_button_nonce'] ) && wp_verify_nonce( $_POST['elearning_about_button_nonce'], 'elearning_save_about_button' ) ) {
        update_post_meta( $post_id, '_elearning_about_button_text', sanitize_text_field( $_POST['elearning_about_button_text'] ) );
        update_post_meta( $post_id, '_elearning_about_button_url', sanitize_text_field( $_POST['elearning_about_button_url'] ) );
    }
}
add_action( 'save_post', 'elearning_save_about_meta_boxes' );
