<?php    
    $image = DEFAULT_IMAGE_PATH . "user/user-img.jpg";      
?>

<!DOCTYPE html>
<html lang="en">        
        <?php $this->load->view('admin/layouts/layout_header'); ?>
    <body>
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <h4>
                    <!-- <a href="<?php echo base_url() . "admin/dashboard" ?>"> Dental Project</a> -->
                </h4>
                <ul class="nav navbar-nav visible-xs-block">
                    <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                    <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>
            </div>

            <div class="navbar-collapse collapse" id="navbar-mobile">
                <ul class="nav navbar-nav">
                    <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown dropdown-user">                       
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo $image ?>" alt="">                                
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?php echo base_url() . "admin/edit_profile" ?>"><i class="icon-user-plus"></i> My profile</a></li>
                            <li><a href="<?php echo base_url() . "admin/change_password" ?>"><i class="icon-comment-discussion"></i> Change Password</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . 'admin/logout'; ?>"><i class="icon-switch2"></i> Logout</a></li>
                        </ul>                          
                    </li>
                </ul>
            </div>
        </div>
        <!-- /main navbar -->
        
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                <!-- Main sidebar -->
                <div class="sidebar sidebar-main">
                    <div class="sidebar-content">

                        <!-- User menu -->
                        <div class="sidebar-user">
                            <div class="category-content">
                                <div class="media">

                                    <a href="#" class="media-left"><img src="<?php echo $image ?>" class="img-circle img-sm" alt=""></a>
                                    <div class="media-body">                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /user menu -->

                        <!-- Main navigation -->
                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <?php
                                $controller = $this->router->fetch_class();
                                ?>
                                <ul class="navigation navigation-main navigation-accordion">

                                    <!-- Main -->                                    
                                    <li class="<?php echo ($controller == 'dashboard') ? 'active' : ''; ?>"><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                                    <li class="<?php echo ($controller == 'users') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/users'; ?>"><i class="icon-users4"></i> <span>Users</span></a>
                                    </li>  
                                    <li class="<?php echo ($controller == 'blogs') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/blogs'; ?>"><i class="icon-bubble"></i> <span>Blogs</span></a>
                                    </li>  
                                    <li class="<?php echo ($controller == 'cms') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/cms'; ?>"><i class="icon-file-text"></i> <span>Cms Page</span></a>
                                    </li>  
                                    <li class="<?php echo ($controller == 'contact_inquiry') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/contact_inquiry'; ?>"><i class="icon-bubbles9"></i> <span>Contact Inquiry</span></a>
                                    </li> 
                                    <li class="<?php echo ($controller == 'survey') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/survey'; ?>">
                                            <i class="icon-stats-growth"></i>
                                            <span> Website Survey </span>
                                        </a>
                                    </li>
                                    <li class="<?php echo ($controller == 'promotional_code') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/promotional_code'; ?>"><i class="icon-price-tag"></i> <span>Promotional Code</span></a>
                                    </li>
                                    <li class="<?php echo ($controller == 'treatment_category') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/treatment_category'; ?>"><i class="icon-accessibility"></i> <span>Treatment Category</span></a>
                                    </li>   
                                    <li class="<?php echo ($controller == 'email_template') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/email_template'; ?>"><i class="icon-envelop"></i> <span>Email Template</span></a>
                                    </li> 
                                    <li class="<?php echo ($controller == 'settings') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/settings'; ?>"><i class="icon-gear"></i> <span>Settings</span></a>
                                    </li>                                                            
                                    <li class="">
                                        <a href="<?php echo base_url() . "admin/logout"; ?>"><i class="icon-switch2"></i> <span>Logout</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /main navigation -->
                    </div>
                </div>
                <!-- /main sidebar -->

                <!-- Main content -->
                <div class="content-wrapper">
                    <?php $this->load->view($subview); ?>
                </div>
                <!-- /main content -->
            </div>
            <!-- /page content -->
        </div>
        <!-- /page container -->
    </body>
</html>
