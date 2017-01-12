<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users4 position-left"></i> Users</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<?php
if ($this->session->flashdata('success')) {
    ?>
    <div class="content pt0">
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert">X</a>
            <strong><?= $this->session->flashdata('success') ?></strong>
        </div>
    </div>
    <?php
    $this->session->set_flashdata('success', false);
} else if ($this->session->flashdata('error')) {
    ?>
    <div class="content pt0">
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert">X</a>
            <strong><?= $this->session->flashdata('error') ?></strong>
        </div>
    </div>
    <?php
    $this->session->set_flashdata('error', false);
} else {
    echo validation_errors();
}
?>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="user_info" method="POST">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">First Name:</label>
                            <div class="col-lg-3">
                                <input type="text" name="fname" id="fname" placeholder="Enter first name" class="form-control" value="<?php echo (isset($user_datas['fname'])) ? $user_datas['fname'] : set_value('fname'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Last Name:</label>
                            <div class="col-lg-3">
                                <input type="text" name="lname" id="lname" placeholder="Enter last name" class="form-control" value="<?php echo (isset($user_datas['lname'])) ? $user_datas['lname'] : set_value('lname'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email:</label>
                            <div class="col-lg-3">
                                <input type="text" name="email_id" id="email_id" placeholder="Enter Email" class="form-control" value="<?php echo (isset($user_datas['email_id'])) ? $user_datas['email_id'] : set_value('email_id'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Country:</label>
                            <div class="col-lg-3">
                                <select name="country" id="country_code" class="form-control">
                                    <?php
                                    if (!empty($all_countries)) {
                                        foreach ($all_countries as $a_country) {
                                            ?>
                                            <option value="<?php echo $a_country['id']; ?>" <?php echo set_select('country', $a_country['id']); ?>>
                                                <?php echo $a_country['nicename']; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Birth year:</label>
                            <div class="col-lg-3">
                                <?php
                                $current_year = date('Y');
                                $ideal_year = $current_year - 18;
                                ?>
                                <select class="form-control" name="birth_year" id="birth_year">
                                    <?php
                                    for ($i = $ideal_year; $i > 1915; $i--) {
                                        ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Gender:</label>
                            <div class="col-lg-9">
                                <label class="radio-inline">
                                    <input type="radio" class="styled" name="gender" value="male" <?php
                                    if ($user_datas['gender'] == 'male') {
                                        echo 'checked';
                                    }
                                    ?>>
                                    Male
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" class="styled" name="gender" value="female" <?php
                                    if ($user_datas['gender'] == 'female') {
                                        echo 'checked';
                                    }
                                    ?>>
                                    Female
                                </label>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#country_code").val('<?php echo $user_datas['country']; ?>');
    $("#birth_year").val('<?php echo $user_datas['birth_year']; ?>');
</script>