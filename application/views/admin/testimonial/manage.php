<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/form_inputs.js"></script>

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">            
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - <?php echo $heading; ?></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li><a href="<?php echo site_url('admin/testimonial'); ?>">Testimonial</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="frmtestimonial" method="POST" enctype="multipart/form-data">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Author Name</label>
                            <div class="col-lg-9">
                                <input type="text" name="auther" id="auther" placeholder="Enter Author Name" class="form-control" value="<?php echo (isset($record['auther'])) ? $record['auther'] : set_value('auther'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Author Designation</label>
                            <div class="col-lg-9">
                                <input type="text" name="designation" id="designation" placeholder="Enter Author Designation" class="form-control" value="<?php echo (isset($record['designation'])) ? $record['designation'] : set_value('designation'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Author Image:</label>
                            <div class="col-lg-9">
                                <input type="file" name="img_path" class="file-styled" tabindex="4">
                                <input type="hidden" value="<?= isset($record['img_path']) ? $record['img_path'] : '' ?>" name="Himg_path">
                            </div>
                        </div>    
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Status:</label>
                            <div class="col-lg-3">

                                <label class="radio-inline">
                                    <input type="radio" class="styled" name="is_blocked" value="0" checked <?php
                                    if (isset($record['is_blocked']) && $record['is_blocked'] == '0') {
                                        echo 'checked';
                                    }
                                    ?>>
                                    Unblock
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" class="styled" name="is_blocked" value="1" <?php
                                    if (isset($record['is_blocked']) && $record['is_blocked'] == '1') {
                                        echo 'checked';
                                    }
                                    ?>>
                                    Block
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Description:</label>
                            <div class="col-lg-12">
                                <textarea name="description" id="description" placeholder="Enter Description" class="form-control"><?php echo (isset($record['description'])) ? $record['description'] : set_value('description'); ?></textarea>
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
    $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });

//---------------------- Validation -------------------
$("#frmtestimonial").validate({
    errorClass: 'validation-error-label',
    successClass: 'validation-valid-label',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    validClass: "validation-valid-label",
    success: function(label) {
        label.addClass("validation-valid-label").text("Success.")
    },
    ignore:[],
    rules: {
        auther: {
            required: true,
        },
        designation: {
            required: true,
        },
        description: {
            required: true
        }

    },
    messages: {
        auther: {
            required: "Please provide a Author Name"
        },
        designation: {
            required: "Please provide a Author Designation"
        },
        description: {
            required: "Please provide a Description"
        }

    }
});


//$(element).closest('.form-group').removeClass('has-error');

</script>

