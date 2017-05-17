<div class="col-xs-12 col-sm-4 col-md-4">
    <div class="right-content">
        <aside class="right-sidebar right-xs-top-t-20">
            <div class="right-title">BREAKING NEWS</div>
            <img class="img-responsive img-center" src="<?php print(IMG); ?>ads2.jpg" alt="ads"> 
        </aside>
        <aside>
            <div class="re-post mt30">

                <?php
                $testimonials = new WP_Query(
                        array(
                    'post_type' => 'testimonial',
                    'posts_per_page' => 3,
                    'order' => 'asc',
                        )
                );
                if ($testimonials->have_posts()) : while ($testimonials->have_posts()) : $testimonials->the_post();
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

                        $line = '<div class="re-post-con">
                                    <figure>' . $thumb . '</figure>
                                    <div class="well">' . $content . '<h4>' . $name . ' - ' . $location . '</h4></div>
                                </div>';
                        echo $line;

                    endwhile;
                endif;
                wp_reset_query();
                ?>
            </div>
        </aside>

        <aside class="mt30">
            <div class="free-box scroll-to-fixed-fixed" id="sidebar" style="z-index: 1000;">
                <h2 class="text-center">Try it Free</h2>
                <?php echo do_shortcode('[step-img step="1" class="img-responsive center-block"]'); ?>
                <div class="inner-text">
                    <h3>Use our <span class="text-uppercase">Exlusive</span> link to receive a <span class="color-pink text-uppercase">risk free trial today!</span> </h3>
                    <a class="btn btn-secondary btn-offer btn-free" href="#">Rush My Trial</a>
                </div>
            </div>
        </aside>

    </div>
</div>