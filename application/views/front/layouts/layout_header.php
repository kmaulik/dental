<head>
    <meta charset="utf-8" />
    <title><?=isset($cms_data[0]['seo_title'])?$cms_data[0]['seo_title']:config('site_title')?></title>
    <meta name="keywords" content="<?=isset($cms_data[0]['seo_keyword'])?$cms_data[0]['seo_keyword']:config('site_keywords')?>" />
    <meta name="description" content="<?=isset($cms_data[0]['seo_description'])?$cms_data[0]['seo_description']:config('site_description')?>" />
    <meta name="Author" content="ToothFairy" />

    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <!-- WEB FONTS : use %7C instead of | (pipe) -->
    <link rel="shortcut icon" type="image/ico" href="<?= DEFAULT_IMAGE_PATH ?>favicon.png"/>

    <link href="<?= DEFAULT_CSS_PATH ?>font.css" rel="stylesheet" type="text/css" />

    <!-- CORE CSS -->
    <link href="<?= DEFAULT_PLUGINS_PATH ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

   
    <!-- THEME CSS -->
    <link href="<?= DEFAULT_CSS_PATH ?>essentials.css" rel="stylesheet" type="text/css" />
    <link href="<?= DEFAULT_CSS_PATH ?>layout.css" rel="stylesheet" type="text/css" />

    <!-- PAGE LEVEL SCRIPTS -->
    <link href="<?= DEFAULT_CSS_PATH ?>header-1.css" rel="stylesheet" type="text/css" />
    <link href="<?= DEFAULT_CSS_PATH ?>color_scheme/darkblue.css" rel="stylesheet" type="text/css" id="color_scheme" />

    <link href="<?= DEFAULT_CSS_PATH ?>ap_style.css" rel="stylesheet" type="text/css" />

    <link href="<?= DEFAULT_CSS_PATH ?>tooth.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="<?= DEFAULT_PLUGINS_PATH ?>jquery/jquery-2.1.4.min.js"></script>

    <script type="text/javascript" src="<?= DEFAULT_PLUGINS_PATH ?>bootstrap.datepicker/js/bootstrap-datepicker.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url().'public/front/js/jquery.dynamic-url.js';?>"></script>    

    <script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/notifications/bootbox.min.js"></script>
    
</head>