<?php

function elearning_register_course_post_type() {
    $labels = array(
        'name'               => 'Courses',
        'singular_name'      => 'Course',
        'menu_name'          => 'Courses',
        'name_admin_bar'     => 'Course',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Course',
        'new_item'           => 'New Course',
        'edit_item'          => 'Edit Course',
        'view_item'          => 'View Course',
        'all_items'          => 'Courses',
        'search_items'       => 'Search Courses',
        'not_found'          => 'No courses found.',
        'not_found_in_trash' => 'No courses found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'learning-core',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'course' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'taxonomies'         => array( 'post_tag', 'course_category' ),
    );

    register_post_type( 'course', $args );
}
add_action( 'init', 'elearning_register_course_post_type' );

function elearning_register_course_category_taxonomy() {
    $labels = array(
        'name'              => 'Course Categories',
        'singular_name'     => 'Course Category',
        'search_items'      => 'Search Course Categories',
        'all_items'         => 'All Course Categories',
        'parent_item'       => 'Parent Course Category',
        'parent_item_colon' => 'Parent Course Category:',
        'edit_item'         => 'Edit Course Category',
        'update_item'       => 'Update Course Category',
        'add_new_item'      => 'Add New Course Category',
        'new_item_name'     => 'New Course Category Name',
        'menu_name'         => 'Course Categories',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'course-category' ),
    );

    register_taxonomy( 'course_category', array( 'course' ), $args );
}
add_action( 'init', 'elearning_register_course_category_taxonomy' );
