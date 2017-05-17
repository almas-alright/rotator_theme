<?php

add_action('init', 'cmedia_testimonials');

function cmedia_testimonials() {
    $labels = array(
        'name' => _x('Testimonials', 'post type general name', 'cmedia'),
        'singular_name' => _x('Testimonial', 'post type singular name', 'cmedia'),
        'menu_name' => _x('Testimonial', 'admin menu', 'cmedia'),
        'name_admin_bar' => _x('Testimonial', 'add new on admin bar', 'cmedia'),
        'add_new' => _x('Add New', 'Testimonial', 'cmedia'),
        'add_new_item' => __('Add New Testimonial', 'cmedia'),
        'new_item' => __('New Testimonial', 'cmedia'),
        'edit_item' => __('Edit Testimonial', 'cmedia'),
        'view_item' => __('View Testimonial', 'cmedia'),
        'all_items' => __('All Testimonials', 'cmedia'),
        'search_items' => __('Search Testimonial', 'cmedia'),
        'parent_item_colon' => __('Parent Testimonial:', 'cmedia'),
        'not_found' => __('No Testimonial found.', 'cmedia'),
        'not_found_in_trash' => __('No Testimonials found in Trash.', 'cmedia')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'testimonial'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'menu_icon' => 'dashicons-welcome-widgets-menus'
    );

    register_post_type('testimonial', $args);

    $t_labels = array(
        'name' => _x('Testimonial Types', 'taxonomy general name'),
        'singular_name' => _x('Testimonial Type', 'taxonomy singular name'),
        'search_items' => __('Search Testimonial Types'),
        'popular_items' => __('Popular Testimonial Types'),
        'all_items' => __('All Testimonial Types'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Testimonial Type'),
        'update_item' => __('Update Testimonial Type'),
        'add_new_item' => __('Add New Testimonial Type'),
        'new_item_name' => __('New Testimonial Type Name'),
        'separate_items_with_commas' => __('Separate writers with commas'),
        'add_or_remove_items' => __('Add or remove writers'),
        'choose_from_most_used' => __('Choose from the most used writers'),
        'not_found' => __('No writers found.'),
        'menu_name' => __('Testimonials Category'),
    );

    $t_args = array(
        'hierarchical' => true,
        'labels' => $t_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array('slug' => 'testimonial-category'),
    );

    register_taxonomy('testimonial-category', 'testimonial', $t_args);
    
}

// =========================================================//
add_action('restrict_manage_posts', 'my_filter_list_cat');

function my_filter_list_cat() {
    $screen = get_current_screen();
    global $wp_query;
    if ($screen->post_type == 'testimonial') {
        wp_dropdown_categories(array(
            'show_option_all' => 'Show All Category',
            'taxonomy' => 'testimonial-category',
            'name' => 'testimonial-category',
            'orderby' => 'name',
            'selected' => ( isset($wp_query->query['testimonial-category']) ? $wp_query->query['testimonial-category'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ));
    }
}

add_filter('parse_query', 'perform_filtering_cat');

function perform_filtering_cat($query) {
    $qv = &$query->query_vars;
    if (( $qv['testimonial-category'] ) && is_numeric($qv['testimonial-category'])) {
        $term = get_term_by('id', $qv['testimonial-category'], 'testimonial-category');
        $qv['testimonial-category'] = $term->slug;
    }
}

add_action('restrict_manage_posts', 'my_filter_list');

function my_filter_list() {
    $screen = get_current_screen();
    global $wp_query;
    if ($screen->post_type == 'testimonial') {
        wp_dropdown_categories(array(
            'show_option_all' => 'Show All Brands',
            'taxonomy' => 'testimonials-tag',
            'name' => 'testimonials-tag',
            'orderby' => 'name',
            'selected' => ( isset($wp_query->query['testimonials-tag']) ? $wp_query->query['testimonials-tag'] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ));
    }
}

add_filter('parse_query', 'perform_filtering');

function perform_filtering($query) {
    $qv = &$query->query_vars;
    if (( $qv['testimonials-tag'] ) && is_numeric($qv['testimonials-tag'])) {
        $term = get_term_by('id', $qv['testimonials-tag'], 'testimonials-tag');
        $qv['testimonials-tag'] = $term->slug;
    }
}

add_filter('manage_testimonial_posts_columns', 'ST4_columns_head');
add_action('manage_testimonial_posts_custom_column', 'ST4_columns_content', 10, 2);

function ST4_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');
        return $post_thumbnail_img[0];
    }
}

// ADD NEW COLUMN
function ST4_columns_head($defaults) {
    $defaults['featured_image'] = 'Featured Image';
    return $defaults;
}

// SHOW THE FEATURED IMAGE
function ST4_columns_content($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
        $post_featured_image = ST4_get_featured_image($post_ID);
        if ($post_featured_image) {
            echo '<img style="width:100px; height:100px;" src="' . $post_featured_image . '" />';
        } else {
            // NO FEATURED IMAGE, SHOW THE DEFAULT ONE
            echo '<img style="width:100px; height:100px;" src="' . get_bloginfo('template_url') . '/testimonials/images/default.svg" />';
        }
    }
}

//=================================================//

add_filter('rwmb_meta_boxes', 'cmidia_testimonial_tl');

function cmidia_testimonial_tl($meta_boxes) {
    $prefix = 'cm_';

    $meta_boxes[] = array(
        'id' => 'page_ls',
        'title' => 'Author Info',
        'pages' => array('testimonial'), //'post',
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => 'Author',
                'desc' => '',
                'id' => $prefix . '_author_name',
                'type' => 'text',
                'class' => 'no-class',
            ),            
            array(
                'name' => 'Author Email',
                'desc' => '',
                'id' => $prefix . '_author_email',
                'type' => 'email',
                'class' => 'no-class',
            ),            
            array(
                'name' => 'Author Location',
                'desc' => '',
                'id' => $prefix . '_author_location',
                'type' => 'text',
                'class' => 'no-class',
            ),            
        )
    );
    return $meta_boxes;
}