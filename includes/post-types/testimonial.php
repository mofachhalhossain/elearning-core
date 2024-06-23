<?php

function elearning_register_testimonial_post_type() {
    $labels = array(
        'name'               => 'Testimonials',
        'singular_name'      => 'Testimonial',
        'menu_name'          => 'Testimonials',
        'name_admin_bar'     => 'Testimonial',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Testimonial',
        'new_item'           => 'New Testimonial',
        'edit_item'          => 'Edit Testimonial',
        'view_item'          => 'View Testimonial',
        'all_items'          => 'Testimonials',
        'search_items'       => 'Search Testimonials',
        'not_found'          => 'No testimonials found.',
        'not_found_in_trash' => 'No testimonials found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'learning-core',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'testimonial' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
    );

    register_post_type( 'testimonial', $args );
}
add_action( 'init', 'elearning_register_testimonial_post_type' );

function elearning_add_testimonial_metaboxes() {
    add_meta_box(
        'elearning_testimonial_quote',
        'Client Quote',
        'elearning_render_testimonial_quote_meta_box',
        'testimonial',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'elearning_add_testimonial_metaboxes' );

function elearning_render_testimonial_quote_meta_box( $post ) {
    $stored_meta = get_post_meta( $post->ID );
    ?>
    <p>
        <label for="quote" class="elearning-row-title"><?php _e( 'Client Quote', 'text_domain' ) ?></label>
        <textarea name="quote" id="quote" rows="4" style="width:100%;"><?php if ( isset ( $stored_meta['quote'] ) ) echo $stored_meta['quote'][0]; ?></textarea>
    </p>
    <?php
}

function elearning_save_testimonial_meta( $post_id ) {
    if ( ! isset( $_POST['elearning_nonce'] ) ) {
        return $post_id;
    }
    $nonce = $_POST['elearning_nonce'];

    if ( ! wp_verify_nonce( $nonce, basename( __FILE__ ) ) ) {
        return $post_id;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( 'testimonial' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
    }

    $new_meta_value = ( isset( $_POST['quote'] ) ? sanitize_textarea_field( $_POST['quote'] ) : '' );

    update_post_meta( $post_id, 'quote', $new_meta_value );
}
add_action( 'save_post', 'elearning_save_testimonial_meta' );