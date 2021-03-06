<?php
    $role_id = $this->session->userdata['admin']['role_id'];
    if($this->session->userdata['admin']['avatar'] != ''){
        $image = (string)base_url('uploads/avatars/'.$this->session->userdata['admin']['avatar']);  
    } else{
        $image = DEFAULT_IMAGE_PATH . "user/user-img.jpg";  
    }      
?>
<!DOCTYPE html>
<html lang="en">        
    <?php $this->load->view('admin/layouts/layout_header'); ?>
    <body>
        <!-- Main navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?=base_url('admin/dashboard')?>"><img src="<?=DEFAULT_ADMIN_IMAGE_PATH?>logo_admin.png" alt=""></a>

                <ul class="nav navbar-nav visible-xs-block">
                    <!-- <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li> -->
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
                            <li><a href="<?php echo base_url() . "admin/edit_profile" ?>"><i class="icon-pencil5"></i> Edit profile</a></li>
                            <li><a href="<?php echo base_url() . "admin/change_password" ?>"><i class="icon-lock2"></i> Change Password</a></li>
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
                        <!-- Main navigation -->
                        <div class="sidebar-category sidebar-category-visible">
                            <div class="category-content no-padding">
                                <?php
                                $controller = $this->router->fetch_class();
                                ?>
                                <ul class="navigation navigation-main navigation-accordion">

                                    <!-- Main -->                                    
                                    <li class="<?php echo ($controller == 'dashboard') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . "admin/dashboard" ?>">
                                            <i class="icon-home4"></i> 
                                            <span>Dashboard</span>
                                        </a>
                                    </li>

                                    <!-- USERS Menu -->
                                    
                                        <li class="<?php echo (in_array($controller,['doctor','patient','users'])) ? 'active' : ''; ?>">
                                            <a href="#" class="has-ul"><i class="icon-users4"></i> <span>Users</span></a>
                                            <ul style="">
                                                <li class="<?php echo (in_array($controller,['patient'])) ? 'active' : ''; ?>">
                                                    <a href="<?php echo base_url().'admin/patient'; ?>">
                                                        <i class="icon-arrow-right32"></i>
                                                        Patients
                                                    </a>
                                                </li>
                                                <li class="<?php echo (in_array($controller,['doctor'])) ? 'active' : ''; ?>">
                                                    <a href="<?php echo base_url().'admin/doctor'; ?>">
                                                        <i class="icon-arrow-right32"></i>
                                                        Doctors
                                                    </a>
                                                </li>
                                                <?php if($role_id != 3) { ?>
                                                <li class="<?php echo (in_array($controller,['users'])) ? 'active' : ''; ?>">
                                                    <a href="<?php echo base_url().'admin/users'; ?>">
                                                        <i class="icon-arrow-right32"></i>
                                                        Staff
                                                    </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    
                                    
                                    <!-- Website Survey Menu -->
                                    <?php if($role_id != 3) { ?>
                                        <li class="<?php echo ($controller == 'survey') ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url() . 'admin/survey'; ?>">
                                                <i class="icon-stats-growth"></i>
                                                <span> Website Survey </span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    

                                    <li class="<?php echo ($controller == 'rfp') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/rfp'; ?>">
                                            <i class="icon-clipboard3"></i>
                                            <span>Request</span>
                                        </a>
                                    </li>
                                    
                                    <!-- Promotional Module -->
                                    <?php if($role_id != 3) { ?>
                                        <li class="<?php echo ($controller == 'promotional_code') ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url() . 'admin/promotional_code'; ?>">
                                                <i class="icon-price-tag"></i>
                                                <span>Promotional Code</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    
                                    <!-- Treatment Category Menu -->
                                    <?php if($role_id != 3) { ?>
                                        <li class="<?php echo ($controller == 'treatment_category') ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url() . 'admin/treatment_category'; ?>">
                                                <i class="icon-aid-kit"></i>
                                                <span>Treatment Category</span>
                                            </a>
                                        </li> 
                                    <?php } ?>  

                                     <!-- Payment Transaction Menu -->
                                    <?php if($role_id != 3) { ?>
                                        <li class="<?php echo ($controller == 'payment_transaction') ? 'active' : ''; ?>">
                                            <a href="#" class="has-ul"><i class="icon-coins"></i> <span>Payment Transaction</span></a>
                                            <ul>
                                                <li class="<?php echo ($this->uri->segment(3) == 'paypal_transaction') ? 'active' : ''; ?>">
                                                    <a href="<?php echo base_url() . 'admin/payment_transaction/paypal_transaction'; ?>">
                                                        <i class="icon-paypal"></i>
                                                        <span>Paypal Payment</span>
                                                    </a>
                                                </li>                                            
                                                <li class="<?php echo ($this->uri->segment(3) == 'manual_transaction') ? 'active' : ''; ?>">
                                                    <a href="<?php echo base_url() . 'admin/payment_transaction/manual_transaction'; ?>">
                                                        <i class="icon-cash"></i>
                                                        <span>Manual Payment</span>
                                                    </a>
                                                </li>                                     
                                            </ul>
                                        </li>
                                    <?php } ?>  

                                      <!-- Payment Refund Menu -->
                                    <?php if($role_id != 3) { ?>
                                        <li class="<?php echo ($controller == 'refund') ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url() . 'admin/refund'; ?>">
                                                <i class="icon-transmission"></i>
                                                <span>Payment Refund</span>
                                            </a>
                                        </li> 
                                    <?php } ?>  
                                    
                                    <!-- Email Template Menu -->
                                    <?php if($role_id != 3) { ?>
                                        <li class="<?php echo ($controller == 'email_template') ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url() . 'admin/email_template'; ?>">
                                                <i class="icon-envelop"></i>
                                                <span>Email Template</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    
                                    
                                    <li class="<?php echo ($controller == 'contact_inquiry') ? 'active' : ''; ?>">
                                        <a href="<?php echo base_url() . 'admin/contact_inquiry'; ?>">
                                            <i class="icon-phone-plus2"></i>
                                            <span>Contact Inquiry</span>
                                        </a>
                                    </li>                                    
                                    
                                    <!-- Front Side Setting Menu -->
                                    <?php if($role_id != 3) { ?>
                                        <li class="<?php echo (in_array($controller,['testimonial','blogs','cms'])) ? 'active' : ''; ?>">
                                            <a href="#" class="has-ul"><i class="icon-command"></i> <span>Front Side Setting</span></a>
                                            <ul>
                                                <li class="<?php echo ($controller == 'testimonial') ? 'active' : ''; ?>">
                                                    <a href="<?php echo base_url() . 'admin/testimonial'; ?>">
                                                        <i class="icon-vcard"></i>
                                                        <span>Testimonial</span>
                                                    </a>
                                                </li>                                            
                                                <li class="<?php echo ($controller == 'blogs') ? 'active' : ''; ?>">
                                                    <a href="<?php echo base_url() . 'admin/blogs'; ?>">
                                                        <i class="icon-blogger"></i>
                                                        <span>Blogs</span>
                                                    </a>
                                                </li>  
                                                <li class="<?php echo ($controller == 'cms') ? 'active' : ''; ?>">
                                                    <a href="<?php echo base_url() . 'admin/cms'; ?>">
                                                        <i class="icon-stack3"></i>
                                                        <span>Cms Page</span>
                                                    </a>
                                                </li>                                              
                                            </ul>
                                        </li>
                                    <?php } ?>
                                    
                                    <!-- Site Setting Menu -->
                                    <?php if($role_id != 3) { ?>
                                        <li class="<?php echo ($controller == 'settings') ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url() . 'admin/settings'; ?>">
                                                <i class="icon-gear"></i>
                                                <span>Site Settings</span></a>
                                        </li>
                                    <?php } ?>

                                    <li class="">
                                        <a href="<?php echo base_url() . "admin/logout"; ?>">
                                            <i class="icon-switch2"></i>
                                            <span>Logout</span>
                                        </a>
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
