<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('admin/layouts/layout_header'); ?>
    <body class="login-container login-cover">

        <!-- Page container -->
        <div class="page-container">

            <!-- Page content -->
            <div class="page-content">

                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Content area -->
                    <div class="content pb-20">    
                         <?php
                        $message = $this->session->flashdata('message');
                        if (!empty($message) && isset($message)) {
                            ($message['class'] != '') ? $message['class'] : '';
                            echo '<div class="' . $message['class'] . '">' . $message['message'] . '</div>';
                        }
                        ?>
                        <!-- Form with validation -->
                        <form class="form-validate" role="form" method="post">
                            <div class="panel panel-body login-form">
                                <div class="text-center">
                                    <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                                    <h5 class="content-group">Forgot Password<small class="display-block">Your credentials</small></h5>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="text" name="email_id" class="form-control" placeholder="Email Id">
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                </div>
                                <?php echo form_error('email_id','<div class="alert alert-mini alert-danger">','</div>'); ?>

                                <div class="form-group">
                                    <button type="submit" class="btn bg-blue btn-block">Submit <i class="icon-arrow-right14 position-right"></i></button>
                                </div>

                                 <div class="form-group">
                                    Already have an account?  <a href="<?=base_url('admin/login')?>"><strong> Back to login! </strong></a>
                                 </div>   
                            </div>
                        </form>
                        <!-- /form with validation -->

                    </div>
                    <!-- /content area -->

                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->

        </div>
        <!-- /page container -->

    </body>
</html>
