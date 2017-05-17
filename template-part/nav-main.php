<header class="header-holder" id="home">
    <div class="logo-area">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2">
                    <a href="#"><img class="img-responsive logo" src="<?php print(IMG); ?>logo.png" alt="logo"></a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-7 top-left-con hidden-xs">
                    <span>Trending Now :</span>
                    <ul class="list-inline">
                        <li><a href="#">#Miranda's Thanksgiving</a></li>
                        <li><a href="#">#KylienadTyga</a></li>
                        <li><a href="#">#GigiHadid</a></li>
                        <li><a href="#">#JenniferLawrence</a></li>
                    </ul>
                    <p><a href="#" class="redcar">RedCarpetDaily</a></p>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 hidden-xs">
                    <a href="#" class="btn btn-header btn1">Subscribe</a>
                    <a href="#" class="btn btn-header btn2">Sign In</a>         
                    <ul class="list-inline top-social-icon hidden-xs">
                        <li><a href="#" target="blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" target="blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" target="blank"><i class="fa fa-pinterest-p"></i></a></li>
                        <li><a href="#" target="blank"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" target="blank"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="main-menu">
        <div class="container">
            <div class="row">
                <nav class="navbar">
                    <div class="container-fluid"> 
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false"> <i class="fa fa-bars" style="color:#ffffff; font-size:22px;"></i> </button>
                            <a class="navbar-brand" href="#"><img class="img-responsive logo" src="<?php print(IMG); ?>logo.png" alt="logo"></a></div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">                            
                            <?php
                            wp_nav_menu(array(
                                'menu' => 'primary-nav',
                                'theme_location' => 'primary-nav',
                                'depth' => 2,
                                'container' => false,
                                'menu_class' => 'nav navbar-nav',
                                'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                                'walker' => new wp_bootstrap_navwalker())
                            );
                            ?>
                        </div>
                        <!-- /.navbar-collapse -->

                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>