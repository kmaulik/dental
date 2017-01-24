<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>

<div class="content">
    <?php
        $message = $this->session->flashdata('message');
        echo my_flash($message);
    ?>
    <!-- content area -->
    <div class="row">
        <div class="col-md-12">
            <?php
                echo validation_errors('<div class="alert alert-danger">','</div>');
            ?>
            <form class="form-horizontal form-validate" action="" id="user_info" method="POST">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Current Password:</label>
                            <div class="col-lg-3">
                                <input type="password" name="curr_pass" id="curr_pass" placeholder="Current Password" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">New Password:</label>
                            <div class="col-lg-3">
                                <input type="password" class="form-control" id="pass" placeholder="New Password" name="pass" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Repeat Password:</label>
                            <div class="col-lg-3">
                                <input type="password" class="form-control" id="re_pass" placeholder="Repeat Password" name="re_pass" >
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Reset Password <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto hide Flash messages
    //$('div.alert').delay(4000).slideUp(350);
</script>

