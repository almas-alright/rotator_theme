<!DOCTYPE html>
<html <?php language_attributes(); ?>>

    <head>

        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>        
        <title><?php wp_title('|', true, 'right'); ?></title>

        <link rel="icon" type="image/png" href="<?php print IMG; ?>fab4.png"/>
        <link rel="icon" type="image/x-icon" href="<?php print IMG; ?>favicon.ico">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>> 