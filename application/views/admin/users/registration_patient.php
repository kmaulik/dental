<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/form_inputs.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/forms/selects/select2.min.js"></script>

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user"></i> <span class="text-semibold"></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"><i class="icon-users4 position-left"></i> Users</a></li>
            <li class="active"><?php  ?></li>
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
                                <input type="text" name="fname" class="form-control" placeholder="First Name" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Last Name:</label>
                            <div class="col-lg-3">
                                <input type="text" name="lname" class="form-control" placeholder="Last Name" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email:</label>
                            <div class="col-lg-3">
                                <input type="text" name="email_id" class="form-control" placeholder="Email" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Password:</label>
                            <div class="col-lg-3">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Address:</label>
                            <div class="col-lg-3">
                                <textarea rows="4" name="address" class="form-control" placeholder="Your Address"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">City:</label>
                            <div class="col-lg-3">
                                <input type="text" name="city" class="form-control" placeholder="City" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Country:</label>
                            <div class="col-lg-3">
                                <select name="country_id" class="form-control select2" id="country_id">
                                        <option value="" selected disabled>Select Country</option>
                                        <?php foreach($country_list as $country) : ?>
                                        <option value="<?=$country['id']?>"><?=$country['name']?></option>
                                    <?php endforeach; ?>
                                </select>   
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Zipcode:</label>
                            <div class="col-lg-3">
                                <input type="text" name="zipcode" id="zipcode" class="form-control" onblur="check_zipcode()" 
                                      placeholder="Zip code">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Gender:</label>
                            <div class="col-lg-3">
                                <select name="gender" class="form-control select" id="gender">                         
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>                          
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Phone:</label>
                            <div class="col-lg-3">
                                <input type="text" name="phone" class="form-control" placeholder="Phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Birth Date:</label>
                            <div class="col-lg-3">
                                <input type="text" name="birth_date" placeholder="Birth Date" class="form-control datepicker" 
                                       data-format="yyyy-mm-dd" data-lang="en" data-RTL="false" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Birth Date:</label>
                            <div class="col-lg-3">
                                <label class="checkbox nomargin">
                                    <input class="checked-agree" type="checkbox" name="agree">
                                    <i></i>I agree to the
                                    <a href="#" data-toggle="modal" data-target="#termsModal">Terms of Service</a>
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


<script type="text/javascript">
    
    
    $(function() {
        // v! Simple Select and Live search select box
        $('.select').select2({ minimumResultsForSearch: Infinity });
        $('.select2').select2();
    });

</script>