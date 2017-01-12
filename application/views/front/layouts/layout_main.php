<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->

<?php $this->load->view('front/layouts/layout_header'); ?>
<!--
    AVAILABLE BODY CLASSES:
    
    smoothscroll            = create a browser smooth scroll
    enable-animation        = enable WOW animations

    bg-grey                 = grey background
    grain-grey              = grey grain background
    grain-blue              = blue grain background
    grain-green             = green grain background
    grain-blue              = blue grain background
    grain-orange            = orange grain background
    grain-yellow            = yellow grain background
    
    boxed                   = boxed layout
    pattern1 ... patern11   = pattern background
    menu-vertical-hide      = hidden, open on click
    
    BACKGROUND IMAGE [together with .boxed class]
    data-background="<?= DEFAULT_IMAGE_PATH ?>boxed_background/1.jpg"
-->
<body class="smoothscroll enable-animation">

    <!-- SLIDE TOP -->
    <div id="slidetop">

        <div class="container">

            <div class="row">

                <div class="col-md-4">
                    <h6><i class="icon-heart"></i> WHY SMARTY?</h6>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas metus nulla, commodo a sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa. </p>
                </div>

                <div class="col-md-4">
                    <h6><i class="icon-attachment"></i> RECENTLY VISITED</h6>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fa fa-angle-right"></i> Consectetur adipiscing elit amet</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i> This is a very long text, very very very very very very very very very very very very </a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i> Lorem ipsum dolor sit amet</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i> Dolor sit amet,consectetur adipiscing elit amet</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i> Consectetur adipiscing elit amet,consectetur adipiscing elit</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h6><i class="icon-envelope"></i> CONTACT INFO</h6>
                    <ul class="list-unstyled">
                        <li><b>Address:</b> PO Box 21132, Here Weare St, <br /> Melbourne, Vivas 2355 Australia</li>
                        <li><b>Phone:</b> 1-800-565-2390</li>
                        <li><b>Email:</b> <a href="mailto:support@yourname.com">support@yourname.com</a></li>
                    </ul>
                </div>

            </div>

        </div>

        <a class="slidetop-toggle" href="#"><!-- toggle button --></a>

    </div>
    <!-- /SLIDE TOP -->


    <!-- wrapper -->
    <div id="wrapper">

        <!-- Top Bar -->
        <div id="topBar">
            <div class="container">

                <!-- right -->
                <div class="pull-right margin-top-10 size-14">
                    <b class="hidden-xs">Contact:</b> +1-800-654-3210
                </div>

                <!-- left -->
                <ul class="top-links list-inline">
                    <li>
                        <a class="dropdown-toggle no-text-underline" data-toggle="dropdown" href="#"><img class="flag-lang" src="<?= DEFAULT_IMAGE_PATH ?>flags/us.png" width="16" height="11" alt="lang" /> ENGLISH</a>
                        <ul class="dropdown-langs dropdown-menu pull-right">
                            <li><a tabindex="-1" href="#"><img class="flag-lang" src="<?= DEFAULT_IMAGE_PATH ?>flags/us.png" width="16" height="11" alt="lang" /> ENGLISH</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="#"><img class="flag-lang" src="<?= DEFAULT_IMAGE_PATH ?>flags/de.png" width="16" height="11" alt="lang" /> GERMAN</a></li>
                            <li><a tabindex="-1" href="#"><img class="flag-lang" src="<?= DEFAULT_IMAGE_PATH ?>flags/ru.png" width="16" height="11" alt="lang" /> RUSSIAN</a></li>
                            <li><a tabindex="-1" href="#"><img class="flag-lang" src="<?= DEFAULT_IMAGE_PATH ?>flags/it.png" width="16" height="11" alt="lang" /> ITALIAN</a></li>
                        </ul>

                    </li>
                </ul>

            </div>
        </div>
        <!-- /Top Bar -->

        <!-- 
            AVAILABLE HEADER CLASSES

            Default nav height: 96px
            .header-md      = 70px nav height
            .header-sm      = 60px nav height

            .noborder       = remove bottom border (only with transparent use)
            .transparent    = transparent header
            .translucent    = translucent header
            .sticky         = sticky header
            .static         = static header
            .dark           = dark header
            .bottom         = header on bottom
            
            shadow-before-1 = shadow 1 header top
            shadow-after-1  = shadow 1 header bottom
            shadow-before-2 = shadow 2 header top
            shadow-after-2  = shadow 2 header bottom
            shadow-before-3 = shadow 3 header top
            shadow-after-3  = shadow 3 header bottom

            .clearfix       = required for mobile menu, do not remove!

            Example Usage:  class="clearfix sticky header-sm transparent noborder"
        -->
        <div id="header" class="sticky clearfix">

            <!-- SEARCH HEADER -->
            <div class="search-box over-header">
                <a id="closeSearch" href="#" class="glyphicon glyphicon-remove"></a>

                <form action="page-search-result-1.html" method="get">
                    <input type="text" class="form-control" placeholder="SEARCH" />
                </form>
            </div> 
            <!-- /SEARCH HEADER -->

            <!-- TOP NAV -->
            <header id="topNav">
                <div class="container">

                    <!-- Mobile Menu Button -->
                    <button class="btn btn-mobile" data-toggle="collapse" data-target=".nav-main-collapse">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- BUTTONS -->
                    <ul class="pull-right nav nav-pills nav-second-main">

                        <!-- SEARCH -->
                        <li class="search">
                            <a href="javascript:;">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                        <!-- /SEARCH -->

                    </ul>
                    <!-- /BUTTONS -->


                    <!-- Logo -->
                    <a class="logo pull-left" href="index.html">
                        <img src="<?= DEFAULT_IMAGE_PATH ?>logo_dark.png" alt="" />
                    </a>

                    <!-- 
                        Top Nav 
                        
                        AVAILABLE CLASSES:
                        submenu-dark = dark sub menu
                    -->
                    <div class="navbar-collapse pull-right nav-main-collapse collapse">
                        <nav class="nav-main">

                            <!--
                                NOTE
                                
                                For a regular link, remove "dropdown" class from LI tag and "dropdown-toggle" class from the href.
                                Direct Link Example: 

                                <li>
                                    <a href="#">HOME</a>
                                </li>
                            -->
                            <ul id="topMain" class="nav nav-pills nav-main">
                                <li class="dropdown active"><!-- HOME -->
                                    <a href="<?=base_url()?>">HOME</a>
                                </li>
                                <li class="dropdown"><!-- PAGES -->
                                    <a class="dropdown-toggle" href="#">
                                        PAGES
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                ABOUT
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-about-us-1.html">ABOUT US - LAYOUT 1</a></li>
                                                <li><a href="page-about-us-2.html">ABOUT US - LAYOUT 2</a></li>
                                                <li><a href="page-about-us-3.html">ABOUT US - LAYOUT 3</a></li>
                                                <li><a href="page-about-us-4.html">ABOUT US - LAYOUT 4</a></li>
                                                <li><a href="page-about-us-5.html">ABOUT US - LAYOUT 5</a></li>
                                                <li><a href="page-about-me-1.html">ABOUT ME - LAYOUT 1</a></li>
                                                <li><a href="page-about-me-2.html">ABOUT ME - LAYOUT 2</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                TEAM
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-team-1.html">TEAM - LAYOUT 1</a></li>
                                                <li><a href="page-team-2.html">TEAM - LAYOUT 2</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                SERVICES
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-services-1.html">SERVICES - LAYOUT 1</a></li>
                                                <li><a href="page-services-2.html">SERVICES - LAYOUT 2</a></li>
                                                <li><a href="page-services-3.html">SERVICES - LAYOUT 3</a></li>
                                                <li><a href="page-services-4.html">SERVICES - LAYOUT 4</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                FAQ
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-faq-1.html">FAQ - LAYOUT 1</a></li>
                                                <li><a href="page-faq-2.html">FAQ - LAYOUT 2</a></li>
                                                <li><a href="page-faq-3.html">FAQ - LAYOUT 3</a></li>
                                                <li><a href="page-faq-4.html">FAQ - LAYOUT 4</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                CONTACT
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-contact-1.html">CONTACT - LAYOUT 1</a></li>
                                                <li><a href="page-contact-2.html">CONTACT - LAYOUT 2</a></li>
                                                <li><a href="page-contact-3.html">CONTACT - LAYOUT 3</a></li>
                                                <li><a href="page-contact-4.html">CONTACT - LAYOUT 4</a></li>
                                                <li><a href="page-contact-5.html">CONTACT - LAYOUT 5</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                ERROR
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-404-1.html">ERROR 404 - LAYOUT 1</a></li>
                                                <li><a href="page-404-2.html">ERROR 404 - LAYOUT 2</a></li>
                                                <li><a href="page-404-3.html">ERROR 404 - LAYOUT 3</a></li>
                                                <li><a href="page-404-4.html">ERROR 404 - LAYOUT 4</a></li>
                                                <li><a href="page-404-5.html">ERROR 404 - LAYOUT 5</a></li>
                                                <li><a href="page-404-6.html">ERROR 404 - LAYOUT 6</a></li>
                                                <li><a href="page-404-7.html">ERROR 404 - LAYOUT 7</a></li>
                                                <li><a href="page-404-8.html">ERROR 404 - LAYOUT 8</a></li>
                                                <li class="divider"></li>
                                                <li><a href="page-500-1.html">ERROR 500 - LAYOUT 1</a></li>
                                                <li><a href="page-500-2.html">ERROR 500 - LAYOUT 2</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                SIDEBAR
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-sidebar-left.html">SIDEBAR LEFT</a></li>
                                                <li><a href="page-sidebar-right.html">SIDEBAR RIGHT</a></li>
                                                <li><a href="page-sidebar-both.html">SIDEBAR BOTH</a></li>
                                                <li><a href="page-sidebar-no.html">NO SIDEBAR</a></li>
                                                <li class="divider"></li>
                                                <li><a href="page-sidebar-dark-left.html">SIDEBAR LEFT - DARK</a></li>
                                                <li><a href="page-sidebar-dark-right.html">SIDEBAR RIGHT - DARK</a></li>
                                                <li><a href="page-sidebar-dark-both.html">SIDEBAR BOTH - DARK</a></li>
                                                <li><a href="page-sidebar-dark-no.html">NO SIDEBAR - DARK</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                LOGIN/REGISTER
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-login-1.html">LOGIN - LAYOUT 1</a></li>
                                                <li><a href="page-login-2.html">LOGIN - LAYOUT 2</a></li>
                                                <li><a href="page-login-3.html">LOGIN - LAYOUT 3</a></li>
                                                <li><a href="page-login-4.html">LOGIN - LAYOUT 4</a></li>
                                                <li><a href="page-login-5.html">LOGIN - LAYOUT 5</a></li>
                                                <li><a href="page-login-register-1.html">LOGIN + REGISTER 1</a></li>
                                                <li><a href="page-login-register-2.html">LOGIN + REGISTER 2</a></li>
                                                <li><a href="page-login-register-3.html">LOGIN + REGISTER 3</a></li>
                                                <li><a href="page-register-1.html">REGISTER - LAYOUT 1</a></li>
                                                <li><a href="page-register-2.html">REGISTER - LAYOUT 2</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                CLIENTS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-clients-1.html">CLIENTS 1 - SIDEBAR RIGHT</a></li>
                                                <li><a href="page-clients-2.html">CLIENTS 1 - SIDEBAR LEFT</a></li>
                                                <li><a href="page-clients-3.html">CLIENTS 1 - FULLWIDTH</a></li>
                                                <li class="divider"></li>
                                                <li><a href="page-clients-4.html">CLIENTS 2 - SIDEBAR RIGHT</a></li>
                                                <li><a href="page-clients-5.html">CLIENTS 2 - SIDEBAR LEFT</a></li>
                                                <li><a href="page-clients-6.html">CLIENTS 2 - FULLWIDTH</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                SEARCH RESULT
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-search-result-1.html">LAYOUT 1 - LEFT SIDEBAR</a></li>
                                                <li><a href="page-search-result-2.html">LAYOUT 1 - RIGHT SIDEBAR</a></li>
                                                <li><a href="page-search-result-3.html">LAYOUT 1 - FULLWIDTH</a></li>
                                                <li class="divider"></li>
                                                <li><a href="page-search-result-4.html">LAYOUT 2 - LEFT SIDEBAR</a></li>
                                                <li><a href="page-search-result-5.html">LAYOUT 2 - RIGHT SIDEBAR</a></li>
                                                <li class="divider"></li>
                                                <li><a href="page-search-result-6.html">LAYOUT 3 - TABLE SEARCH</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                PROFILE
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-profile.html">USER PROFILE</a></li>
                                                <li><a href="page-profile-projects.html">USER PROJECTS</a></li>
                                                <li><a href="page-profile-comments.html">USER COMMENTS</a></li>
                                                <li><a href="page-profile-history.html">USER HISTORY</a></li>
                                                <li><a href="page-profile-settings.html">USER SETTINGS</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                MAINTENANCE
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-maintenance-1.html">MAINTENANCE - LAYOUT 1</a></li>
                                                <li><a href="page-maintenance-2.html">MAINTENANCE - LAYOUT 2</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                COMING SOON
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-coming-soon-1.html">COMING SOON - LAYOUT 1</a></li>
                                                <li><a href="page-coming-soon-2.html">COMING SOON - LAYOUT 2</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                FORUM
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="page-forum-home.html">FORUM - HOME</a></li>
                                                <li><a href="page-forum-topic.html">FORUM - TOPIC</a></li>
                                                <li><a href="page-forum-post.html">FORUM - POST</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="page-careers.html">CAREERS</a></li>
                                        <li><a href="page-sitemap.html">SITEMAP</a></li>
                                        <li><a href="page-blank.html">BLANK PAGE</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><!-- FEATURES -->
                                    <a class="dropdown-toggle" href="#">
                                        FEATURES
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-browser"></i> SLIDERS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-toggle" href="#">REVOLUTION SLIDER 4.x</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-slider-revolution-fullscreen.html">FULLSCREEN</a></li>
                                                        <li><a href="feature-slider-revolution-fullwidth.html">FULL WIDTH</a></li>
                                                        <li><a href="feature-slider-revolution-fixedwidth.html">FIXED WIDTH</a></li>
                                                        <li><a href="feature-slider-revolution-kenburns.html">KENBURNS EFFECT</a></li>
                                                        <li><a href="feature-slider-revolution-videobg.html">HTML5 VIDEO</a></li>
                                                        <li><a href="feature-slider-revolution-captions.html">CAPTIONS</a></li>
                                                        <li><a href="feature-slider-revolution-smthumb.html">THUMB SMALL</a></li>
                                                        <li><a href="feature-slider-revolution-lgthumb.html">THUMB LARGE</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="feature-slider-revolution-prev1.html">NAV PREVIEW 1</a></li>
                                                        <li><a href="feature-slider-revolution-prev2.html">NAV PREVIEW 2</a></li>
                                                        <li><a href="feature-slider-revolution-prev3.html">NAV PREVIEW 3</a></li>
                                                        <li><a href="feature-slider-revolution-prev4.html">NAV PREVIEW 4</a></li>
                                                        <li><a href="feature-slider-revolution-prev0.html">NAV THEME DEFAULT</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">LAYER SLIDER</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-slider-layer-fullwidth.html">FULLWIDTH</a></li>
                                                        <li><a href="feature-slider-layer-fixed.html">FIXED WIDTH</a></li>
                                                        <li><a href="feature-slider-layer-captions.html">CAPTIONS</a></li>
                                                        <li><a href="feature-slider-layer-carousel.html">CAROUSEL</a></li>
                                                        <li><a href="feature-slider-layer-2d3d.html">2D &amp; 3D TRANSITIONS</a></li>
                                                        <li><a href="feature-slider-layer-thumb.html">THUMB NAV</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">FLEX SLIDER</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-slider-flexslider-fullwidth.html">FULL WIDTH</a></li>
                                                        <li><a href="feature-slider-flexslider-content.html">CONTENT</a></li>
                                                        <li><a href="feature-slider-flexslider-thumbs.html">WITH THUMBS</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">OWL SLIDER</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-slider-owl-fullwidth.html">FULL WIDTH</a></li>
                                                        <li><a href="feature-slider-owl-fixed.html">FIXED WIDTH</a></li>
                                                        <li><a href="feature-slider-owl-fixed+progress.html">FIXED + PROGRESS</a></li>
                                                        <li><a href="feature-slider-owl-carousel.html">BASIC CAROUSEL</a></li>
                                                        <li><a href="feature-slider-owl-fade.html">EFFECT - FADE</a></li>
                                                        <li><a href="feature-slider-owl-backslide.html">EFFECT - BACKSLIDE</a></li>
                                                        <li><a href="feature-slider-owl-godown.html">EFFECT - GODOWN</a></li>
                                                        <li><a href="feature-slider-owl-fadeup.html">EFFECT - FADE UP</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">SWIPE SLIDER</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-slider-swipe-full.html">FULLSCREEN</a></li>
                                                        <li><a href="feature-slider-swipe-fixed-height.html">FIXED HEIGHT</a></li>
                                                        <li><a href="feature-slider-swipe-autoplay.html">AUTOPLAY</a></li>
                                                        <li><a href="feature-slider-swipe-fade.html">FADE TRANSITION</a></li>
                                                        <li><a href="feature-slider-swipe-slide.html">SLIDE TRANSITION</a></li>
                                                        <li><a href="feature-slider-swipe-coverflow.html">COVERFLOW TRANSITION</a></li>
                                                        <li><a href="feature-slider-swipe-html5-video.html">HTML5 VIDEO</a></li>
                                                        <li><a href="feature-slider-swipe-3columns.html">3 COLUMNS</a></li>
                                                        <li><a href="feature-slider-swipe-4columns.html">4 COLUMNS</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="feature-slider-nivo.html">NIVO SLIDER</a></li>
                                                <li><a href="feature-slider-camera.html">CAMERA SLIDER</a></li>
                                                <li><a href="feature-slider-elastic.html">ELASTIC SLIDER</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-hotairballoon"></i> HEADERS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-header-light.html">HEADER - LIGHT</a></li>
                                                <li><a href="feature-header-dark.html">HEADER - DARK</a></li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">HEADER - HEIGHT</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-header-large.html">LARGE (96px)</a></li>
                                                        <li><a href="feature-header-medium.html">MEDIUM (70px)</a></li>
                                                        <li><a href="feature-header-small.html">SMALL (60px)</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">HEADER - SHADOW</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-header-shadow-after-1.html">SHADOW 1 - AFTER</a></li>
                                                        <li><a href="feature-header-shadow-before-1.html">SHADOW 1 - BEFORE</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="feature-header-shadow-after-2.html">SHADOW 2 - AFTER</a></li>
                                                        <li><a href="feature-header-shadow-before-2.html">SHADOW 2 - BEFORE</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="feature-header-shadow-after-3.html">SHADOW 3 - AFTER</a></li>
                                                        <li><a href="feature-header-shadow-before-3.html">SHADOW 3 - BEFORE</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="feature-header-shadow-dark-1.html">SHADOW - DARK PAGE EXAMPLE</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="feature-header-transparent.html">HEADER - TRANSPARENT</a></li>
                                                <li><a href="feature-header-transparent-line.html">HEADER - TRANSP+LINE</a></li>
                                                <li><a href="feature-header-translucent.html">HEADER - TRANSLUCENT</a></li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">HEADER - BOTTOM</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-header-bottom-light.html">BOTTOM LIGHT</a></li>
                                                        <li><a href="feature-header-bottom-dark.html">BOTTOM DARK</a></li>
                                                        <li><a href="feature-header-bottom-transp.html">BOTTOM TRANSPARENT</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">HEADER - LEFT SIDE</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-header-side-left-1.html">FIXED</a></li>
                                                        <li><a href="feature-header-side-left-2.html">OPEN ON CLICK</a></li>
                                                        <li><a href="feature-header-side-left-3.html">DARK</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">HEADER - RIGHT SIDE</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-header-side-right-1.html">FIXED</a></li>
                                                        <li><a href="feature-header-side-right-2.html">OPEN ON CLICK</a></li>
                                                        <li><a href="feature-header-side-right-3.html">DARK</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">HEADER - STATIC</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-header-static-top-light.html">STATIC TOP - LIGHT</a></li>
                                                        <li><a href="feature-header-static-top-dark.html">STATIC TOP - DARK</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="feature-header-static-bottom-light.html">STATIC BOTTOM - LIGHT</a></li>
                                                        <li><a href="feature-header-static-bottom-dark.html">STATIC BOTTOM - DARK</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="feature-header-nosticky.html">HEADER - NO STICKY</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-anchor"></i> FOOTERS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-footer-1.html#footer">FOOTER - LAYOUT 1</a></li>
                                                <li><a href="feature-footer-2.html#footer">FOOTER - LAYOUT 2</a></li>
                                                <li><a href="feature-footer-3.html#footer">FOOTER - LAYOUT 3</a></li>
                                                <li><a href="feature-footer-4.html#footer">FOOTER - LAYOUT 4</a></li>
                                                <li><a href="feature-footer-5.html#footer">FOOTER - LAYOUT 5</a></li>
                                                <li><a href="feature-footer-6.html#footer">FOOTER - LAYOUT 6</a></li>
                                                <li><a href="feature-footer-7.html#footer">FOOTER - LAYOUT 7</a></li>
                                                <li><a href="feature-footer-8.html#footer">FOOTER - LAYOUT 8 (light)</a></li>
                                                <li><a href="feature-footer-0.html#footer">FOOTER - STICKY</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-circle-compass"></i> MENU STYLES
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-menu-0.html">MENU - OVERLAY</a></li>
                                                <li><a href="feature-menu-1.html">MENU - STYLE 1</a></li>
                                                <li><a href="feature-menu-2.html">MENU - STYLE 2</a></li>
                                                <li><a href="feature-menu-3.html">MENU - STYLE 3</a></li>
                                                <li><a href="feature-menu-4.html">MENU - STYLE 4</a></li>
                                                <li><a href="feature-menu-5.html">MENU - STYLE 5</a></li>
                                                <li><a href="feature-menu-6.html">MENU - STYLE 6</a></li>
                                                <li><a href="feature-menu-7.html">MENU - STYLE 7</a></li>
                                                <li><a href="feature-menu-8.html">MENU - STYLE 8</a></li>
                                                <li><a href="feature-menu-9.html">MENU - STYLE 9</a></li>
                                                <li><a href="feature-menu-10.html">MENU - STYLE 10</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-genius"></i> MENU DROPDOWN
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-menu-dd-light.html">DROPDOWN - LIGHT</a></li>
                                                <li><a href="feature-menu-dd-dark.html">DROPDOWN - DARK</a></li>
                                                <li><a href="feature-menu-dd-color.html">DROPDOWN - COLOR</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-beaker"></i> PAGE TITLES
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-title-left.html">ALIGN LEFT</a></li>
                                                <li><a href="feature-title-right.html">ALIGN RIGHT</a></li>
                                                <li><a href="feature-title-center.html">ALIGN CENTER</a></li>
                                                <li><a href="feature-title-light.html">LIGHT</a></li>
                                                <li><a href="feature-title-dark.html">DARK</a></li>
                                                <li><a href="feature-title-tabs.html">WITH TABS</a></li>
                                                <li><a href="feature-title-breadcrumbs.html">BREADCRUMBS ONLY</a></li>
                                                <li>
                                                    <a class="dropdown-toggle" href="#">PARALLAX</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="feature-title-parallax-small.html">PARALLAX SMALL</a></li>
                                                        <li><a href="feature-title-parallax-medium.html">PARALLAX MEDIUM</a></li>
                                                        <li><a href="feature-title-parallax-large.html">PARALLAX LARGE</a></li>
                                                        <li><a href="feature-title-parallax-2xlarge.html">PARALLAX 2x LARGE</a></li>
                                                        <li><a href="feature-title-parallax-transp.html">TRANSPARENT HEADER</a></li>
                                                        <li><a href="feature-title-parallax-transp-large.html">TRANSPARENT HEADER - LARGE</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="feature-title-short-height.html">SHORT HEIGHT</a></li>
                                                <li><a href="feature-title-rotative-text.html">ROTATIVE TEXT</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-layers"></i> PAGE SUBMENU
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-page-submenu-light.html">PAGE SUBMENU - LIGHT</a></li>
                                                <li><a href="feature-page-submenu-dark.html">PAGE SUBMENU - DARK</a></li>
                                                <li><a href="feature-page-submenu-color.html">PAGE SUBMENU - COLOR</a></li>
                                                <li><a href="feature-page-submenu-transparent.html">PAGE SUBMENU - TRANSPARENT</a></li>
                                                <li><a href="feature-page-submenu-below-title.html">PAGE SUBMENU - BELOW PAGE TITLE</a></li>
                                                <li><a href="feature-page-submenu-scrollTo.html">PAGE SUBMENU - scrollTo</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-trophy"></i> ICONS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-icons-fontawesome.html">FONTAWESOME</a></li>
                                                <li><a href="feature-icons-glyphicons.html">GLYPHICONS</a></li>
                                                <li><a href="feature-icons-etline.html">ET LINE</a></li>
                                                <li><a href="feature-icons-flags.html">FLAGS</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-flag"></i> BACKGROUNDS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-content-bg-grey.html">CONTENT - SIMPLE GREY</a></li>
                                                <li><a href="feature-content-bg-ggrey.html">CONTENT - GRAIN GREY</a></li>
                                                <li><a href="feature-content-bg-gblue.html">CONTENT - GRAIN BLUE</a></li>
                                                <li><a href="feature-content-bg-ggreen.html">CONTENT - GRAIN GREEN</a></li>
                                                <li><a href="feature-content-bg-gorange.html">CONTENT - GRAIN ORANGE</a></li>
                                                <li><a href="feature-content-bg-gyellow.html">CONTENT - GRAIN YELLOW</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-magnifying-glass"></i> SEARCH LAYOUTS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-search-default.html">SEARCH - DEFAULT</a></li>
                                                <li><a href="feature-search-fullscreen-light.html">SEARCH - FULLSCREEN LIGHT</a></li>
                                                <li><a href="feature-search-fullscreen-dark.html">SEARCH - FULLSCREEN DARK</a></li>
                                                <li><a href="feature-search-header-light.html">SEARCH - HEADER LIGHT</a></li>
                                                <li><a href="feature-search-header-dark.html">SEARCH - HEADER DARK</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="shortcode-animations.html"><i class="et-expand"></i> ANIMATIONS</a></li>
                                        <li><a href="feature-grid.html"><i class="et-grid"></i> GRID</a></li>
                                        <li><a href="feature-essentials.html"><i class="et-heart"></i> ESSENTIALS</a></li>
                                        <li><a href="page-changelog.html"><i class="et-alarmclock"></i> CHANGELOG</a></li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                <i class="et-newspaper"></i> SIDE PANEL
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="feature-sidepanel-dark-right.html">SIDE PANEL - DARK - RIGHT</a></li>
                                                <li><a href="feature-sidepanel-dark-left.html">SIDE PANEL - DARK - LEFT</a></li>
                                                <li class="divider"></li>
                                                <li><a href="feature-sidepanel-light-right.html">SIDE PANEL - LIGHT - RIGHT</a></li>
                                                <li><a href="feature-sidepanel-light-left.html">SIDE PANEL - LIGHT - LEFT</a></li>
                                                <li class="divider"></li>
                                                <li><a href="feature-sidepanel-color-right.html">SIDE PANEL - COLOR - RIGHT</a></li>
                                                <li><a href="feature-sidepanel-color-left.html">SIDE PANEL - COLOR - LEFT</a></li>
                                            </ul>
                                        </li>
                                        <li><a target="_blank" href="../Admin/HTML/"><span class="label label-success pull-right">BONUS</span><i class="et-gears"></i> ADMIN PANEL</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown mega-menu"><!-- PORTFOLIO -->
                                    <a class="dropdown-toggle" href="#">
                                        PORTFOLIO
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="row">

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><span>GRID</span></li>
                                                        <li><a href="portfolio-grid-1-columns.html">1 COLUMN</a></li>
                                                        <li><a href="portfolio-grid-2-columns.html">2 COLUMNS</a></li>
                                                        <li><a href="portfolio-grid-3-columns.html">3 COLUMNS</a></li>
                                                        <li><a href="portfolio-grid-4-columns.html">4 COLUMNS</a></li>
                                                        <li><a href="portfolio-grid-5-columns.html">5 COLUMNS</a></li>
                                                        <li><a href="portfolio-grid-6-columns.html">6 COLUMNS</a></li>
                                                    </ul>
                                                </div>

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><span>MASONRY</span></li>
                                                        <li><a href="portfolio-masonry-2-columns.html">2 COLUMNS</a></li>
                                                        <li><a href="portfolio-masonry-3-columns.html">3 COLUMNS</a></li>
                                                        <li><a href="portfolio-masonry-4-columns.html">4 COLUMNS</a></li>
                                                        <li><a href="portfolio-masonry-5-columns.html">5 COLUMNS</a></li>
                                                        <li><a href="portfolio-masonry-6-columns.html">6 COLUMNS</a></li>

                                                    </ul>
                                                </div>

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><span>SINGLE</span></li>
                                                        <li><a href="portfolio-single-extended.html">EXTENDED ITEM</a></li>
                                                        <li><a href="portfolio-single-parallax.html">PARALLAX IMAGE</a></li>
                                                        <li><a href="portfolio-single-slider.html">SLIDER GALLERY</a></li>
                                                        <li><a href="portfolio-single-html5-video.html">HTML5 VIDEO</a></li>
                                                        <li><a href="portfolio-single-masonry-thumbs.html">MASONRY THUMBS</a></li>
                                                        <li><a href="portfolio-single-embed-video.html">EMBED VIDEO</a></li>
                                                    </ul>
                                                </div>

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><span>LAYOUT</span></li>
                                                        <li><a href="portfolio-layout-default.html">DEFAULT</a></li>
                                                        <li><a href="portfolio-layout-aside-left.html">LEFT SIDEBAR</a></li>
                                                        <li><a href="portfolio-layout-aside-right.html">RIGHT SIDEBAR</a></li>
                                                        <li><a href="portfolio-layout-aside-both.html">BOTH SIDEBAR</a></li>
                                                        <li><a href="portfolio-layout-fullwidth.html">FULL WIDTH (100%)</a></li>
                                                        <li><a href="portfolio-layout-tabfilter.html">TAB FILTER &amp; PAGINATION</a></li>

                                                    </ul>
                                                </div>

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><span>LOADING</span></li>
                                                        <li><a href="portfolio-loading-pagination.html">PAGINATION</a></li>
                                                        <li><a href="portfolio-loading-jpagination.html">JQUERY PAGINATION</a></li>
                                                        <li><a href="portfolio-loading-infinite-scroll.html">INFINITE SCROLL</a></li>
                                                        <li><a href="portfolio-loading-ajax-page.html">AJAX IN PAGE</a></li>
                                                        <li><a href="portfolio-loading-ajax-modal.html">AJAX IN MODAL</a></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown"><!-- BLOG -->
                                    <a class="dropdown-toggle" href="#">
                                        BLOG
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                DEFAULT
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="blog-default-aside-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="blog-default-aside-right.html">RIGHT SIDEBAR</a></li>
                                                <li><a href="blog-default-aside-both.html">BOTH SIDEBAR</a></li>
                                                <li><a href="blog-default-fullwidth.html">FULL WIDTH</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                GRID
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="blog-column-2colums.html">2 COLUMNS</a></li>
                                                <li><a href="blog-column-3colums.html">3 COLUMNS</a></li>
                                                <li><a href="blog-column-4colums.html">4 COLUMNS</a></li>
                                                <li class="divider"></li>
                                                <li><a href="blog-column-aside-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="blog-column-aside-right.html">RIGHT SIDEBAR</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                MASONRY
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="blog-masonry-2colums.html">2 COLUMNS</a></li>
                                                <li><a href="blog-masonry-3colums.html">3 COLUMNS</a></li>
                                                <li><a href="blog-masonry-4colums.html">4 COLUMNS</a></li>
                                                <li><a href="blog-masonry-fullwidth.html">FULLWIDTH</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                TIMELINE
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="blog-timeline-aside-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="blog-timeline-aside-right.html">RIGHT SIDEBAR</a></li>
                                                <li><a href="blog-timeline-right-aside-right.html">RIGHT + TIMELINE RIGHT</a></li>
                                                <li><a href="blog-timeline-right-aside-left.html">LEFT + TIMELINE RIGHT</a></li>
                                                <li><a href="blog-timeline-fullwidth-left.html">FULL WIDTH - LEFT</a></li>
                                                <li><a href="blog-timeline-fullwidth-right.html">FULL WIDTH - RIGHT</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                SMALL IMAGE
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="blog-smallimg-aside-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="blog-smallimg-aside-right.html">RIGHT SIDEBAR</a></li>
                                                <li><a href="blog-smallimg-aside-both.html">BOTH SIDEBAR</a></li>
                                                <li><a href="blog-smallimg-fullwidth.html">FULL WIDTH</a></li>
                                                <li class="divider"></li>
                                                <li><a href="blog-smallimg-alternate-1.html">ALTERNATE 1</a></li>
                                                <li><a href="blog-smallimg-alternate-2.html">ALTERNATE 2</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                SINGLE
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="blog-single-default.html">DEFAULT</a></li>
                                                <li><a href="blog-single-aside-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="blog-single-aside-right.html">RIGHT SIDEBAR</a></li>
                                                <li><a href="blog-single-fullwidth.html">FULL WIDTH</a></li>
                                                <li><a href="blog-single-small-image-left.html">SMALL IMAGE - LEFT</a></li>
                                                <li><a href="blog-single-small-image-right.html">SMALL IMAGE - RIGHT</a></li>
                                                <li><a href="blog-single-big-image.html">BIG IMAGE</a></li>
                                                <li><a href="blog-single-fullwidth-image.html">FULLWIDTH IMAGE</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                COMMENTS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="blog-comments-bordered.html#comments">BORDERED COMMENTS</a></li>
                                                <li><a href="blog-comments-default.html#comments">DEFAULT COMMENTS</a></li>
                                                <li><a href="blog-comments-facebook.html#comments">FACEBOOK COMMENTS</a></li>
                                                <li><a href="blog-comments-disqus.html#comments">DISQUS COMMENTS</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown"><!-- SHOP -->
                                    <a class="dropdown-toggle" href="#">
                                        SHOP
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                1 COLUMN
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="shop-1col-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="shop-1col-right.html">RIGHT SIDEBAR</a></li>
                                                <li><a href="shop-1col-both.html">BOTH SIDEBAR</a></li>
                                                <li><a href="shop-1col-full.html">FULL WIDTH</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                2 COLUMNS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="shop-2col-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="shop-2col-right.html">RIGHT SIDEBAR</a></li>
                                                <li><a href="shop-2col-both.html">BOTH SIDEBAR</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                3 COLUMNS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="shop-3col-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="shop-3col-right.html">RIGHT SIDEBAR</a></li>
                                                <li><a href="shop-3col-full.html">FULL WIDTH</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                4 COLUMNS
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="shop-4col-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="shop-4col-right.html">RIGHT SIDEBAR</a></li>
                                                <li><a href="shop-4col-full.html">FULL WIDTH</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" href="#">
                                                SINGLE PRODUCT
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="shop-single-left.html">LEFT SIDEBAR</a></li>
                                                <li><a href="shop-single-right.html">RIGHT SIDEBAR</a></li>
                                                <li><a href="shop-single-both.html">BOTH SIDEBAR</a></li>
                                                <li><a href="shop-single-full.html">FULL WIDTH</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="shop-compare.html">COMPARE</a></li>
                                        <li><a href="shop-cart.html">CART</a></li>
                                        <li><a href="shop-checkout.html">CHECKOUT</a></li>
                                        <li><a href="shop-checkout-final.html">ORDER PLACED</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown mega-menu"><!-- SHORTCODES -->
                                    <a class="dropdown-toggle" href="#">
                                        SHORTCODES
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="row">

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><a href="shortcode-animations.html">ANIMATIONS</a></li>
                                                        <li><a href="shortcode-buttons.html">BUTTONS</a></li>
                                                        <li><a href="shortcode-carousel.html">CAROUSEL</a></li>
                                                        <li><a href="shortcode-charts.html">GRAPHS</a></li>
                                                        <li><a href="shortcode-clients.html">CLIENTS</a></li>
                                                        <li><a href="shortcode-columns.html">GRID &amp; COLUMNS</a></li>
                                                        <li><a href="shortcode-counters.html">COUNTERS</a></li>
                                                        <li><a href="shortcode-forms.html">FORM ELEMENTS</a></li>
                                                    </ul>
                                                </div>

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><a href="shortcode-dividers.html">DIVIDERS</a></li>
                                                        <li><a href="shortcode-icon-boxes.html">BOXES &amp; ICONS</a></li>
                                                        <li><a href="shortcode-galleries.html">GALLERIES</a></li>
                                                        <li><a href="shortcode-headings.html">HEADING STYLES</a></li>
                                                        <li><a href="shortcode-icon-lists.html">ICON LISTS</a></li>
                                                        <li><a href="shortcode-labels.html">LABELS &amp; BADGES</a></li>
                                                        <li><a href="shortcode-lightbox.html">LIGHTBOX</a></li>
                                                        <li><a href="shortcode-forms-editors.html">HTML EDITORS</a></li>
                                                    </ul>
                                                </div>

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><a href="shortcode-list-pannels.html">LIST &amp; PANNELS</a></li>
                                                        <li><a href="shortcode-maps.html">MAPS</a></li>
                                                        <li><a href="shortcode-media-embeds.html">MEDIA EMBEDS</a></li>
                                                        <li><a href="shortcode-modals.html">MODAL / POPOVER / NOTIF</a></li>
                                                        <li><a href="shortcode-navigations.html">NAVIGATIONS</a></li>
                                                        <li><a href="shortcode-paginations.html">PAGINATIONS</a></li>
                                                        <li><a href="shortcode-progress-bar.html">PROGRESS BARS</a></li>
                                                        <li><a href="shortcode-widgets.html">WIDGETS</a></li>
                                                    </ul>
                                                </div>

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><a href="shortcode-pricing.html">PRICING BOXES</a></li>
                                                        <li><a href="shortcode-process-steps.html">PROCESS STEPS</a></li>
                                                        <li><a href="shortcode-callouts.html">CALLOUTS</a></li>
                                                        <li><a href="shortcode-info-bars.html">INFO BARS</a></li>
                                                        <li><a href="shortcode-blockquotes.html">BLOCKQUOTES</a></li>
                                                        <li><a href="shortcode-responsive.html">RESPONSIVE</a></li>
                                                        <li><a href="shortcode-sections.html">SECTIONS</a></li>
                                                        <li><a href="shortcode-social-icons.html">SOCIAL ICONS</a></li>
                                                    </ul>
                                                </div>

                                                <div class="col-md-5th">
                                                    <ul class="list-unstyled">
                                                        <li><a href="shortcode-alerts.html">ALERTS</a></li>
                                                        <li><a href="shortcode-styled-icons.html">STYLED ICONS</a></li>
                                                        <li><a href="shortcode-tables.html">TABLES</a></li>
                                                        <li><a href="shortcode-tabs.html">TABS</a></li>
                                                        <li><a href="shortcode-testimonials.html">TESTIMONIALS</a></li>
                                                        <li><a href="shortcode-thumbnails.html">THUMBNAILS</a></li>
                                                        <li><a href="shortcode-toggles.html">TOGGLES</a></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </nav>
                    </div>

                </div>
            </header>
            <!-- /Top Nav -->

        </div>
        <?php $this->load->view($subview); ?>

        <?php $this->load->view('front/layouts/layout_footer'); ?>








    </div>
    <!-- /wrapper -->


    <!-- SCROLL TO TOP -->
    <a href="#" id="toTop"></a>


    <!-- PRELOADER -->
    <div id="preloader">
        <div class="inner">
            <span class="loader"></span>
        </div>
    </div><!-- /PRELOADER -->


    <!-- JAVASCRIPT FILES -->
    <script type="text/javascript">var plugin_path = '<?= DEFAULT_PLUGINS_PATH ?>';</script> 
    

    <script type="text/javascript" src="<?= DEFAULT_JS_PATH ?>scripts.js"></script>

    

    <!-- REVOLUTION SLIDER -->
    <script type="text/javascript" src="<?= DEFAULT_PLUGINS_PATH ?>slider.revolution/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="<?= DEFAULT_PLUGINS_PATH ?>slider.revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="<?= DEFAULT_JS_PATH ?>view/demo.revolution_slider.js"></script>

</body>
</html>