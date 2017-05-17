jQuery(document).ready(function ($) {
    console.log('test');

    $('body').on('click', function () {
        $('#ouibounce-modal').hide();
    });

    $('#ouibounce-modal .modal-footer').on('click', function () {
        $('#ouibounce-modal').hide();
    });

    $('#ouibounce-modal .modal').on('click', function (e) {
        e.stopPropagation();
    });


    $("#close").click(function () {
        $("#popup").hide();

    });


// ***************************
// sidebar news slider
    $('#sidebar').scrollToFixed();


    $('.panel-heading a').click(function () {
        $('.panel-heading').removeClass('actives');
        $(this).parents('.panel-heading').addClass('actives');
    });

    $(window).scroll(function () {
        if (!($('body > main').hasClass('non-sticky'))) {
            if ($(window).scrollTop()) {
                $(".main-menu").addClass("slideDownScaleReversedIn").removeClass("slideDownScaleReversedOut");
            } else {
                $(".main-menu").addClass("slideDownScaleReversedOut").removeClass("slideDownScaleReversedIn");
            }
        } else {
            console.log('sticky');
        }
    });

    var _ouibounce = ouibounce($('#ouibounce-modal')[0], {
        aggressive: true,
        timer: 0,
        callback: function () {
        }
    });

});





