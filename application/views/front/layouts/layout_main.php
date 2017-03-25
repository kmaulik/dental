<?php 
    $client_login = $this->session->userdata('client');
    $all_notifications = get_notifications('10');     
    $all_noti_cnt = get_total_noti_count();

    if(!empty($client_login)) { 
        $unread_cnt = get_notifications_unread_count();
    }
?>
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
                                <li><a tabindex="-1" href="<?=base_url('dashboard/edit_profile')?>"><i class="fa fa-user"></i> PROFILE</a></li>   
                                <li><a tabindex="-1" href="<?=base_url('messageboard')?>"><i class="fa fa-envelope"></i> MESSAGE</a></li>    
                                <li><a tabindex="-1" href="<?=base_url('payment_transaction/history')?>"><i class="fa fa-money"></i> PAYMENT HISTORY</a></li>                         
                                <li class="divider"></li>
                                <li><a tabindex="-1" href="<?=base_url('login/logout')?>"><i class="glyphicon glyphicon-off"></i> LOGOUT</a></li>
                            </ul>
                        </li>
                    <?php else :?>
                        <li><a href="<?=base_url('login')?>"><i class="fa fa-lock hidden-xs"></i> LOGIN</a></li>
                        <li>
                            <a class="dropdown-toggle no-text-underline" href="<?=base_url('registration/user')?>">
                                <i class="fa fa-user hidden-xs"></i>
                                REGISTRATION
                            </a>
                        </li>
                    <?php endif;?>
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
                       <!--  <li class="search">
                            <a href="javascript:;">
                                <i class="fa fa-search"></i>
                            </a>
                        </li> -->
                        <!-- /SEARCH -->

                    </ul>
                    <!-- /BUTTONS -->
                    
                    <!-- Logo -->
                    <a class="logo pull-left" href="<?php echo base_url(); ?>">
                        <img src="<?= DEFAULT_IMAGE_PATH ?>logo.png" alt="" />
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
                                <li class="dropdown <?php if($this->uri->segment(1)=='') echo 'active'?>"><!-- HOME -->
                                    <a href="<?=base_url()?>">HOME </a>
                                </li>

                                <?php if($this->session->userdata('client') && ($this->session->userdata('client')['role_id'] == 4 || $this->session->userdata('client')['role_id'] == 5)) :?>
                                    <li class="dropdown <?php if($this->uri->segment(1)=='dashboard') echo 'active'; ?>">
                                        <a tabindex="-1" href="<?=base_url('dashboard')?>">DASHBOARD</a>
                                    </li>
                                <?php endif;?>
                               
                                 <?php if($this->session->userdata('client') && $this->session->userdata['client']['role_id']  == 4) :?>
                                    <li class="dropdown <?php if($this->uri->segment(1)=='rfp') echo 'active'; ?>"><!-- HOME -->
                                        <a href="<?=base_url('rfp/search_rfp')?>">RFP</a>
                                    </li>
                                <?php endif;?>

                                <?php if($this->session->userdata('client') && $this->session->userdata['client']['role_id']  == 5) :?>
                                    <li class="dropdown <?php if($this->uri->segment(1)=='rfp') echo 'active'; ?>"><!-- HOME -->
                                        <a href="<?=base_url('rfp/add')?>">RFP</a>
                                    </li>
                                <?php endif;?>

                                <!-- <li class="dropdown <?php if($this->uri->segment(1)=='blog') echo 'active'; ?>">
                                    <a href="<?=base_url('blog')?>">BLOG</a>
                                </li> -->
                                <li class="dropdown <?php if($this->uri->segment(1)=='faq') echo 'active'; ?>">
                                    <a href="<?=base_url('faq')?>">FAQ</a>
                                </li>
                                <li class="dropdown <?php if($this->uri->segment(1)=='contact_us') echo 'active'; ?>">
                                    <a href="<?=base_url('contact_us')?>">CONTACT US</a>
                                </li>  

                                <?php if(!empty($client_login)) { ?>                          
                                    <li class="notification_side">
                                        <a id="sidepanel_btn" href="#" class="fa fa-bell-o">
                                            <span>NOTIFICATION</span>
                                            <?php if($unread_cnt != 0) { ?>
                                                <span class="post_number"><?php echo $unread_cnt; ?></span>
                                            <?php } ?>
                                        </a>
                                    </li>
                                <?php } ?>
                             
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
    </div>
    <!-- /PRELOADER -->
    
    <!-- 
            SIDE PANEL 
            
                sidepanel-dark          = dark color
                sidepanel-light         = light color (white)
                sidepanel-theme-color       = theme color
                
                sidepanel-inverse       = By default, sidepanel is placed on right (left for RTL)
                                If you add "sidepanel-inverse", will be placed on left side (right on RTL).
    -->

    <div id="sidepanel" class="sidepanel-light">
        <a id="sidepanel_close" href="#"><!-- close -->
            <i class="glyphicon glyphicon-remove"></i>
        </a>

        <div class="sidepanel-content custom_notification_data">
            <h2 class="sidepanel-title">Notification</h2>

            <div class="custom_notification" >
                <ul class="scrollbar-inner " id="for_window_size" >
                    <?php 
                        if(!empty($all_notifications)) {
                            foreach($all_notifications as $noti) {
                                $noti_id = $noti['id'];
                    ?>  
                    <li style="cursor:pointer" id="li_<?php echo $noti['id']; ?>" class="<?php if($noti['is_read'] == '1'){ echo 'read'; }?>">
                        <a onclick="notification_action('<?php echo $noti_id; ?>')">
                            <p class="notifly_head">
                                <?php echo $noti['noti_msg']; ?>                                
                            </p>                            
                            <p class="notifly_ago"><?php echo time_ago($noti['created_at']); ?></p>
                        </a>
                    </li>
                    <?php } } ?>
                    
                    <?php if($all_noti_cnt > 10) { ?>
                        <li class="last_li_cls">
                            <a onclick="fetch_ajax_notification(this)" data-limit="3" data-offset="10" id="load_more" 
                               class="load_more btn btn-primary">
                                Load More
                            </a>
                        </li>
                    <?php } ?>
                                                            
                </ul>

            </div>

        </div>
        <div class="fixed_clear_btn">
            <a onclick="$('#sidepanel_close').click();unread_notifications()">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
        </div>  
    </div>
    <!-- /SIDE PANEL -->   

   


<!--  Custom Scroll Bar Style and Script -->
<link href="<?= DEFAULT_CSS_PATH ?>custom_scrollbar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url().'public/front/js/scrollbar.min.js'; ?>"></script>

<script type="text/javascript">var plugin_path = '<?= DEFAULT_PLUGINS_PATH ?>';</script> 
<script type="text/javascript" src="<?= DEFAULT_JS_PATH ?>scripts.js"></script>
<!-- REVOLUTION SLIDER -->
<script type="text/javascript" src="<?= DEFAULT_PLUGINS_PATH ?>slider.revolution/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="<?= DEFAULT_PLUGINS_PATH ?>slider.revolution/js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="<?= DEFAULT_JS_PATH ?>view/demo.revolution_slider.js"></script>

<script type="text/javascript">
    
    jQuery('.scrollbar-inner').scrollbar();
    jQuery(document).ready(function(){
        var window_height = $( window ).height();        
        //window_height = window_height-63;
        $('.scrollbar-inner').css({'height':window_height});
    });

    function notification_action(noti_id){
        
        $.ajax({
            type:"POST",
            url:"<?php echo base_url().'home/read_notification'; ?>",
            data:{noti_id:noti_id},
            dataType:"json",
            success:function(data){
                window.location.href = "<?php echo base_url(); ?>"+data['noti_data']['noti_url'];
            }
        });
    }

    function fetch_ajax_notification(obj){

        var limit = $(obj).data('limit');
        var offset = $(obj).attr('data-offset');

        $.ajax({
            type:"POST",
            url:"<?php echo base_url().'home/fetch_notification'; ?>",
            data:{limit:limit,offset:offset},
            dataType:"json",
            success:function(data){
                console.log(data);

                if(data['new_str'] != ''){
                    offset = parseInt(offset) + limit;

                    if(data['all_noti_cnt'] < offset){
                        // $('.last_li_cls').remove();
                    }
                    
                    $('#load_more').attr('data-offset',offset);
                    $(".last_li_cls").before(data['new_str']);
                }else{
                    $('.last_li_cls').remove();
                }
            }
        });        
    }

    function unread_notifications(){
        bootbox.confirm('Are you sure to reset all unread notifications ?',function(res){
            if(res){
                window.location.href="<?php echo base_url().'home/reset_notification'; ?>";
            }
        });
    }

</script>

</body>
</html>