<?php

function elearning_register_feature_post_type() {
    $labels = array(
        'name'               => 'Features',
        'singular_name'      => 'Feature',
        'menu_name'          => 'Features',
        'name_admin_bar'     => 'Feature',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Feature',
        'new_item'           => 'New Feature',
        'edit_item'          => 'Edit Feature',
        'view_item'          => 'View Feature',
        'all_items'          => 'Features',
        'search_items'       => 'Search Features',
        'not_found'          => 'No features found.',
        'not_found_in_trash' => 'No features found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'learning-core',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'feature' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    );

    register_post_type( 'feature', $args );
}
add_action( 'init', 'elearning_register_feature_post_type' );


function elearning_feature_add_meta_box() {
    add_meta_box(
        'elearning_feature_icon',
        'Feature Icon',
        'elearning_feature_icon_meta_box_callback',
        'feature'
    );
}
add_action( 'add_meta_boxes', 'elearning_feature_add_meta_box' );

function elearning_feature_icon_meta_box_callback( $post ) {
    $value = get_post_meta( $post->ID, '_elearning_feature_icon', true );
    $icons = [
        'fa-address-book', 'fa-address-card', 'fa-adjust', 'fa-air-freshener', 'fa-align-center',
        'fa-align-justify', 'fa-align-left', 'fa-align-right', 'fa-allergies', 'fa-ambulance'
    ];

    echo '<div class="elearning-meta-box">';
    echo '<label for="elearning_feature_icon">Select Icon:</label>';
    echo '<select id="elearning_feature_icon" name="elearning_feature_icon">';
    foreach ( $icons as $icon ) {
        echo '<option value="' . esc_attr( $icon ) . '"' . selected( $value, $icon, false ) . '>' . esc_html( $icon ) . '</option>';
    }
    echo '</select>';
    echo '<p class="description">Select a FontAwesome icon for this feature.</p>';
    echo '</div>';
}


function elearning_save_feature_icon( $post_id ) {
    if ( ! isset( $_POST['elearning_feature_icon_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['elearning_feature_icon_nonce'], 'elearning_save_feature_icon' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( ! isset( $_POST['elearning_feature_icon'] ) ) {
        return;
    }

    $icon = sanitize_text_field( $_POST['elearning_feature_icon'] );

    update_post_meta( $post_id, '_elearning_feature_icon', $icon );
}
add_action( 'save_post', 'elearning_save_feature_icon' );


function elearning_set_custom_feature_columns($columns) {
    $columns['cb'] = '<input type="checkbox" />';
    $columns['title'] = __('Title');
    $columns['icon'] = __('Icon', 'elearning');
    $columns['date'] = __('Date');
    return $columns;
}
add_filter('manage_feature_posts_columns', 'elearning_set_custom_feature_columns');


function elearning_custom_feature_column($column, $post_id) {
    switch ($column) {
        case 'icon':
            $icon = get_post_meta($post_id, '_elearning_feature_icon', true);
            if ($icon) {
                echo '<i class="fas ' . esc_attr($icon) . '" style="font-size: 20px;"></i>';
            } else {
                echo 'No Icon';
            }
            break;
    }
}
add_action('manage_feature_posts_custom_column', 'elearning_custom_feature_column', 10, 2);
