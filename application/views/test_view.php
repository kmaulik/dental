<?php 
    $client_login = $this->session->userdata('client');    
    $all_notifications = get_notifications(); 
    $all_noti_cnt = get_total_noti_count();
    // pr($all_notifications,1);
    // die;
    if(!empty($client_login)) { 
        $unread_cnt = get_notifications_unread_count();
    }
?>
<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title><?=isset($cms_data[0]['seo_title'])?$cms_data[0]['seo_title']:config('site_title')?></title>
    <meta name="keywords" content="<?=isset($cms_data[0]['seo_keyword'])?$cms_data[0]['seo_keyword']:config('site_keywords')?>" />
    <meta name="description" content="<?=isset($cms_data[0]['seo_description'])?$cms_data[0]['seo_description']:config('site_description')?>" />
    <meta name="Author" content="ToothFairy" />

    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->    
    <!-- CORE CSS -->
    <link href="<?= DEFAULT_PLUGINS_PATH ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- THEME CSS -->
    <link href="<?= DEFAULT_CSS_PATH ?>essentials.css" rel="stylesheet" type="text/css" />
    <link href="<?= DEFAULT_CSS_PATH ?>layout.css" rel="stylesheet" type="text/css" />
    <!-- PAGE LEVEL SCRIPTS -->
    <link href="<?= DEFAULT_CSS_PATH ?>header-1.css" rel="stylesheet" type="text/css" />
    <link href="<?= DEFAULT_CSS_PATH ?>color_scheme/darkblue.css" rel="stylesheet" type="text/css" id="color_scheme" />
    <link href="<?= DEFAULT_CSS_PATH ?>ap_style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?= DEFAULT_PLUGINS_PATH ?>jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?= DEFAULT_PLUGINS_PATH ?>bootstrap.datepicker/js/bootstrap-datepicker.min.js"></script>    
    <script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/notifications/bootbox.min.js"></script>
    
</head>
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
    <!-- /wrapper -->
    <!-- SCROLL TO TOP -->
    <a href="#" id="toTop"></a>
    
    <!-- PRELOADER -->
    <div id="preloader">
        <div class="inner">
            <span class="loader"></span>
        </div>
    </div>
    <!-- /PRELOADER -->

    <script type="text/javascript" src="<?= DEFAULT_JS_PATH ?>scripts_for_loader"></script>
</body>
</html>