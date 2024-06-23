<?php

function elearning_register_instructor_post_type() {
    $labels = array(
        'name'               => 'Instructors',
        'singular_name'      => 'Instructor',
        'menu_name'          => 'Instructors',
        'name_admin_bar'     => 'Instructor',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Instructor',
        'new_item'           => 'New Instructor',
        'edit_item'          => 'Edit Instructor',
        'view_item'          => 'View Instructor',
        'all_items'          => 'Instructors',
        'search_items'       => 'Search Instructors',
        'not_found'          => 'No instructors found.',
        'not_found_in_trash' => 'No instructors found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'learning-core',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'instructor' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    );


    register_post_type( 'instructor', $args );
}
add_action( 'init', 'elearning_register_instructor_post_type' );


function elearning_instructor_social_urls_meta_box() {
    add_meta_box(
        'elearning_instructor_social_urls_meta_box',
        'Social URLs',
        'elearning_render_instructor_social_urls_meta_box',
        'instructor',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'elearning_instructor_social_urls_meta_box' );

function elearning_render_instructor_social_urls_meta_box( $post ) {
    $facebook_url = get_post_meta( $post->ID, '_instructor_facebook_url', true );
    $twitter_url = get_post_meta( $post->ID, '_instructor_twitter_url', true );
    $instagram_url = get_post_meta( $post->ID, '_instructor_instagram_url', true );


    echo '<p><label for="instructor_facebook_url">Facebook URL:</label><br>';
    echo '<input type="text" id="instructor_facebook_url" name="instructor_facebook_url" value="' . esc_attr( $facebook_url ) . '" size="50"></p>';

    echo '<p><label for="instructor_twitter_url">Twitter URL:</label><br>';
    echo '<input type="text" id="instructor_twitter_url" name="instructor_twitter_url" value="' . esc_attr( $twitter_url ) . '" size="50"></p>';

    echo '<p><label for="instructor_instagram_url">Instagram URL:</label><br>';
    echo '<input type="text" id="instructor_instagram_url" name="instructor_instagram_url" value="' . esc_attr( $instagram_url ) . '" size="50"></p>';
}


function elearning_save_instructor_social_urls_meta_box( $post_id ) {
    if ( ! isset( $_POST['elearning_instructor_social_urls_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['elearning_instructor_social_urls_nonce'], 'elearning_instructor_social_urls_meta_box_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['instructor_facebook_url'] ) ) {
        update_post_meta( $post_id, '_instructor_facebook_url', esc_url( $_POST['instructor_facebook_url'] ) );
    }

    if ( isset( $_POST['instructor_twitter_url'] ) ) {
        update_post_meta( $post_id, '_instructor_twitter_url', esc_url( $_POST['instructor_twitter_url'] ) );
    }

    if ( isset( $_POST['instructor_instagram_url'] ) ) {
        update_post_meta( $post_id, '_instructor_instagram_url', esc_url( $_POST['instructor_instagram_url'] ) );
    }
}
add_action( 'save_post', 'elearning_save_instructor_social_urls_meta_box' );