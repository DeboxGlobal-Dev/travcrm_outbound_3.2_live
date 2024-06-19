<?php if($page=='home') {  ?>
    <!-- <script src="<?php echo $fullurl; ?>/elegant/js/jquery.min.js"></script> -->
    <!-- <script src="<?php echo $fullurl; ?>/elegant/js/modernizr.js"></script>  -->
    <!-- Load the plugin -->
    <!-- <script src="<?php echo $fullurl; ?>/elegant/js/jquery.animateSlider.js"></script> -->
    <script>
        // $(".anim-slider").animateSlider({
        //     autoplay    :true,
        //     interval    :5500,
        //     animations  : 
        //     {
        //         0   : //Slide No2
        //         {   
        //             li          :
        //             {
        //                 show        : "fadeInLeft",
        //                 hide        : "fadeOutLeftBig",
        //                 delayShow   : "delay0-2s"
        //             },
        //             "#img1"     :
        //             {
        //                 show        : "fadeInLeft",
        //                 delayShow   : "delay2s"
                        
        //             }
        //         },
        //         1   : //Slide No2
        //         {   
        //             li              :
        //             {
        //                 show        : "fadeInLeft",
        //                 hide        : "fadeOutLeftBig",
        //                 delayShow   : "delay0-2s"
        //             },
        //             "#img2"         :
        //             {
        //                 show        : "fadeInLeft",
        //                 delayShow   : "delay2s"
                        
        //             }
        //         },
        //         2:{
        //             li          :
        //             {
        //                 show        : "fadeInUp",
        //                 hide        : "fadeOutDownBig",
        //                 delayShow   : "delay0s"
        //             },
        //             "#img3"            :
        //             {
        //                 show        : "slideInLeft",
        //                 delayShow   : "delay0s"
        //             } 
        //         }
        //     }
        // });
         
    </script>
<?php }else{ ?>
    </div>
   <div id="footer" class="custom_footer" style="visibility: visible; margin-top: -27px; display: none;">
        <div class="inner" id="footer-id" style="">
            <div class="logos">
            </div>
            <div id="footer-contact">
                <p class="inverted elegclass">
                    <?php echo $companyName; ?>
                </p>
                <p class="phone"><i class="icon-icon_telephone custom_icon invert"></i>
                <?php echo $clientPhone; ?>
            </p>
            </div>
        </div>
    </div>   
    <script type="text/javascript">
        $(function () {
            // if page is greater than x of scrollable window allow back to top link
            var shouldScroll = ($(document).height() / $(window).height()) > 1.25;
            // previous scroll position
            var lastScrollTop = 0;
            var timeout;
                    
            $(window).scroll(function () {
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    if (shouldScroll) {
                        var footerWidth = $("#footer").width();
                        var myID = $("div#backToTop");
                        // current scroll position
                        var st = $(window).scrollTop();
                        // start showing when close to bottom
                        var showbottom = ($(document).height() - $(window).height()) * 90 / 100;
                        //hide if close to top
                        var hideTop = $(document).height() * 10 / 100;
                        // if current scroll position is smaller than last (scrolling up) and
                        // current position is greater than the minimum scrolled hieght or
                        // current position is greater the show becasue we are closeto the bottom
                        if (st > hideTop) {
                            if (st < lastScrollTop || st >= showbottom) {
                                myID.removeClass("hide");
                                myID.addClass("show");
                            }
                            else {
                                myID.removeClass("show");
                                myID.addClass("hide");
                            }
                        }
                        else {
                            myID.removeClass("show");
                            myID.addClass("hide");
                        }

                        //Move up if screen is smaller and the button could cover social media icons

                        if (footerWidth <= "1680") {
                            var bottom = st + $(window).height() == $(document).height();
                            if (bottom) {
                                myID.addClass('move');
                            } else {
                                myID.removeClass('move');
                            }
                        } else {
                            myID.removeClass('move');
                        }

                    }
                    lastScrollTop = st;
                }, 50);
            });
        });
    </script>
    <!--Back to top--> 
    <div id="backToTop" class="btt hide">
        <a href="#page-wrapper">
            <div class="btt_icon"></div>
            back to top
        </a>
    </div>
<?php } ?>

</body>
</html>

