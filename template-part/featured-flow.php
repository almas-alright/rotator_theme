<?php

$fp = new WP_Query(
        array(
    'post_type' => 'post',
    'meta_key' => '_is_ns_featured_post',
    'meta_value' => 'yes',
    'posts_per_page' => 1,
        )
);
if ($fp->have_posts()) : while ($fp->have_posts()) : $fp->the_post();
        $title = get_the_title();
        $content = get_the_content();
        $name = get_post_meta(get_the_ID(), 'cm__author_name', TRUE);
        $email = get_post_meta(get_the_ID(), 'cm__author_email', TRUE);
        $location = get_post_meta(get_the_ID(), 'cm__author_location', TRUE);
        $href = get_permalink(get_the_ID());
        $thumb = get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'img-responsive'));
        $attachment_id = get_post_thumbnail_id(get_the_ID());
        $img_big = wp_get_attachment_image_src($attachment_id, 'full', FALSE);
        $excerpt2 = cut_limit(get_the_content(), 12);

        echo '<h2>'.$title.'</h2>';
        if (has_post_thumbnail()) {
            echo '<figure class="mb30">' . $thumb . '</figure>';
        }
        echo $content;
    endwhile;
endif;
wp_reset_query();
