<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "pages/dashboard.js"; ?>"></script>   
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Dashboard</h4>
        </div>

 
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li class="active">Dashboard</li>
        </ul>    
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
    <?php
            $message = $this->session->flashdata('message');
            if (!empty($message) && isset($message)) {
                ($message['class'] != '') ? $message['class'] : '';
                echo '<div class="' . $message['class'] . '">' . $message['message'] . '</div>';
            }

            $all_errors = validation_errors();
            if (isset($all_errors) && !empty($all_errors)) {
                echo '<div class="alert alert-danger">' . $all_errors . '</div>';
            }
        ?>
</div>
<!-- /content area -->