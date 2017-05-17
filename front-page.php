<?php
get_header();
get_template_part('template-part/nav', 'main');
?>

<!-- Main Content -->
<section class="main-content-holder">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8">
                <?php
                get_template_part('template-part/featured', 'post');
                get_template_part('template-part/featured', 'flow');

                while (have_posts()) : the_post();
                    $id = get_the_ID();
                    $title = get_the_title();
                    $content = get_the_content();
                endwhile;
                
                echo do_shortcode($content);
                get_template_part('template-part/comment');
                
                ?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>
<!-- /Main Content -->
<?php
get_footer();
