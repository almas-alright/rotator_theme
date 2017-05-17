<?php
get_header();

         echo do_shortcode('[step-img step="2" class="saas"]');         
         echo do_shortcode('[step-img step="1" class="saas"]');         
         echo do_shortcode('[step-a step="2" class="sdsds"]');         
         echo '<h4>'.do_shortcode('[step-title step="2"]').'</h4>';         
?>

        <script>
//            (function (window, location) {
//                history.replaceState(null, document.title, location.pathname + "<?= $step1["redirect_link"]; ?>!/history");
//                history.pushState(null, document.title, location.pathname);
//
//                window.addEventListener("popstate", function () {
//                    if (location.hash === "<?= $step1["redirect_link"]; ?>!/history") {
//                        history.replaceState(null, document.title, location.pathname);
//                        setTimeout(function () {
//                            location.replace("<?= $step1["redirect_link"]; ?>");
//                        }, 0);
//                    }
//                }, false);
//            }(window, location));
        </script>
<?php
get_footer();