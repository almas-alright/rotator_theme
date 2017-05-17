<?php
//error_reporting(E_ERROR | E_PARSE);
//res paths//

define("TROOT", get_stylesheet_directory_uri());
define("ASS", TROOT . "/assets/");
define("IMG", TROOT . "/images/");
define("CSS", TROOT . "/css/");
define("JS", TROOT . "/js/");

//scripts and required styles//

function tea_scripts() {

    wp_enqueue_style('gfont-1', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i');
    wp_enqueue_style('gfont-2', 'https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i');    
    wp_enqueue_style('style-css', TROOT . '/style.css');
    wp_enqueue_style('custom-css', CSS . 'custom.css');
    
//    wp_enqueue_style('bootstrap', CSS . 'bootstrap.min.css');
//    wp_enqueue_style('fa', CSS . 'font-awesome.min.css');
    wp_enqueue_style('ob', CSS . 'ouibounce.min.css');    
//    wp_enqueue_style('ob', CSS . 'responsive.css');

    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap_js', JS . 'bootstrap.min.js', array('jquery'));    
    wp_enqueue_script('hot-dela', 'http://hot-deals.creativecore.netdna-cdn.com/TMT/UsW/jquery-scrolltofixed.js', array('jquery'));
    wp_enqueue_script('ob-js', JS . 'ouibounce.js', array('jquery'));
    wp_enqueue_script('custom-js', JS . 'custom.js', array('jquery'));
}

add_action('wp_enqueue_scripts', 'tea_scripts');

//Register Required menus//

function ch_menu() {
    register_nav_menus(array('primary-nav' => "Primary Nav"));
}

add_action('init', 'ch_menu');



//Sidebars
//if (function_exists("register_sidebar")) {
//
//    
//}



add_theme_support('post-thumbnails');
add_image_size('portfolio-thumb', 300, 250, true);

//for wp title//

function cmedia_wp_title($title, $sep) {
    global $paged, $page;

    if (is_feed())
        return $title;

    // Add the site name.
    $title .= get_bloginfo('name', 'display');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() ))
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if (( $paged >= 2 || $page >= 2 ) && !is_404())
        $title = "$title $sep " . sprintf(__('Page %s', 'cmedia'), max($paged, $page));

    return $title;
}

add_filter('wp_title', 'cmedia_wp_title', 10, 2);

function get_one_page($name, $image_size) {
    $data = array();
//    $args_r = array('pagename' => $name);
    $args_r = array('page_id' => $name);
    $target_post = new WP_Query($args_r);
    if ($target_post->have_posts()) :
        while ($target_post->have_posts()) : $target_post->the_post();
            $data['title'] = get_the_title();
            $data['content'] = get_the_content(true);
            $data['link'] = get_permalink(get_the_ID());
            $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $image_size, true);
            $data['thumbnail'] = $img[0];
        //wp_get_attachment_link( $id, 'medium' );
        endwhile;
    endif;
    wp_reset_query();
    return $data;
}

function cut_limit($string, $words = 1) {
    $string = strip_tags($string);
    $string = strip_shortcodes($string);
    return implode(' ', array_slice(explode(' ', $string), 0, $words));
}

require_once('includes/class-tgm-plugin-activation.php');
require_once('includes/install-plugins.php');

require_once('includes/roater.php');
require_once('includes/testimonials.php');
require_once('includes/wp_bootstrap_navwalker.php');
	
require_once (dirname(__FILE__) . '/redux/reduxcore/framework.php');
require_once (dirname(__FILE__) . '/redux/sample/sample-config.php');

