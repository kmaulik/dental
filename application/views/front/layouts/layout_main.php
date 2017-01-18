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

    <!-- wrapper -->
    <div id="wrapper">

        <!-- Top Bar -->
        <div id="topBar">
            <div class="container">

                        
                <!-- right -->
                <ul class="top-links list-inline pull-right">
                    <?php if($this->session->userdata('client')) :?>
                    <li class="text-welcome hidden-xs">Welcome <strong><?=$this->session->userdata['client']['fname']." ".$this->session->userdata['client']['lname']?></strong></li>
                    <li>
                        <a class="dropdown-toggle no-text-underline" data-toggle="dropdown" href="#"><i class="fa fa-user hidden-xs"></i> MY ACCOUNT</a>
                        <ul class="dropdown-menu pull-right">
                            <li><a tabindex="-1" href="<?=base_url('dashboard')?>"><i class="fa fa-home"></i> DASHBOARD</a></li>
                            
                            <?php if($this->session->userdata['client']['role_id'] == 4) :?>  <!-- For Doctor Profile--> 
                            <li><a tabindex="-1" href="<?=base_url('doctor')?>"><i class="fa fa-user"></i> PROFILE</a></li>
                            <?php endif; ?>

                            <?php if($this->session->userdata['client']['role_id'] == 5) :?> <!-- For Patient Profile-->
                            <li><a tabindex="-1" href="<?=base_url('patient')?>"><i class="fa fa-user"></i> PROFILE</a></li>
                            <?php endif; ?>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="<?=base_url('login/logout')?>"><i class="glyphicon glyphicon-off"></i> LOGOUT</a></li>
                        </ul>
                    </li>
                <?php else :?>
                <li class="hidden-xs"><a href="<?=base_url('login')?>"><i class="fa fa-lock hidden-xs"></i> LOGIN</a></li>
                <li>
                    <a class="dropdown-toggle no-text-underline" data-toggle="dropdown" href="#"><i class="fa fa-user hidden-xs"></i> REGISTRATION</a>
                    <ul class="dropdown-menu pull-right">
                        <li><a tabindex="-1" href="<?=base_url('registration/patient')?>"><i class="fa fa-user"></i> PATIENT</a></li>
                        <li><a tabindex="-1" href="<?=base_url('registration/doctor')?>"><i class="fa fa-user-md"></i> DOCTOR</a></li>
                    </ul>
                </li>
            <?php endif;?>
        </ul>

        <!-- left -->
               <!--  <ul class="top-links list-inline">
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
                </ul> -->

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
                       <!--  <li class="search">
                            <a href="javascript:;">
                                <i class="fa fa-search"></i>
                            </a>
                        </li> -->
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
                            <?php if($this->session->userdata('client') && $this->session->userdata['client']['role_id']  == 5) :?>
                                <li class="dropdown"><!-- HOME -->
                                <a href="<?=base_url('rfp')?>">RFP</a>
                            </li>
                            <?php endif;?>
                            <!-- <li class="dropdown">
                                <a href="<?=base_url('login')?>">LOGIN</a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#">REGISTRATION</a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?=base_url('registration/patient')?>">PATIENT</a></li>
                                    <li><a href="<?=base_url('registration/doctor')?>">DOCTOR</a></li>
                                </ul>    
                            </li> -->
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