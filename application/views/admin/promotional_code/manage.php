<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH ."plugins/forms/styling/uniform.min.js";?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH ."plugins/forms/styling/switchery.min.js";?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH ."plugins/forms/inputs/touchspin.min.js";?>"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">            
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - <?php echo $heading; ?></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li><a href="<?php echo site_url('admin/promotional_code'); ?>">Promotional Code</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="frmcode" method="POST">
               <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Code Title:</label>
                            <div class="col-lg-9">
                                <input type="text" name="title" id="title" placeholder="Enter code title" class="form-control" value="<?php echo (isset($record['title'])) ? $record['title'] : set_value('title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Code:</label>
                            <div class="col-lg-9">
                                <input type="text" name="code" id="code" placeholder="Enter Code" class="form-control" value="<?php echo (isset($record['code'])) ? $record['code'] : set_value('code'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Discount (%):</label>
                            <div class="col-lg-9">
                                <input type="text" name="discount" id="discount" placeholder="Enter Discount" class="form-control touchspin-postfix" value="<?php echo (isset($record['discount'])) ? $record['discount'] : set_value('discount'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Apply Code Per User:</label>
                            <div class="col-lg-9">
                                <input type="text" name="per_user_limit" id="per_user_limit" placeholder="Enter Limit Per User Use This Code" class="form-control NumbersOnly" value="<?php echo (isset($record['per_user_limit'])) ? $record['per_user_limit'] : set_value('per_user_limit'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Code Date:</label>
                            <div class="col-lg-9">
                                <input type="text" name="code_date" id="code_date" placeholder="Enter Code Date" class="form-control daterange-basic" value="<?php echo (isset($record['start_date'])) ? date("m/d/Y",strtotime($record['start_date'])).' - '.date("m/d/Y",strtotime($record['end_date'])) : set_value('code_date'); ?>">
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
$('.NumbersOnly').keyup(function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
});

 $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });

//---------------------- Date Range Picker -------------------
$('.daterange-basic').daterangepicker({
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-default'
    });

//--------------------- Discount -------------------
$(".touchspin-postfix").TouchSpin({
        min: 0,
        max: 100,
        step: 0.1,
        decimals: 2,
        postfix: '%'
    });

//---------------------- Validation -------------------
$("#frmcode").validate({
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
    rules: {
        title: {
            required: true,
            remote: {
                url: "<?php echo base_url('admin/promotional_code/check_promotional_code_exists/' . (isset($record['id']) ? $record['id'] : '0').'/title'); ?>",
                type: "post",
                data: {
                    title: function () {
                        return $("#title").val();
                    }
                }
            }
        },
        code: {
            required: true,
            remote: {
                url: "<?php echo base_url('admin/promotional_code/check_promotional_code_exists/' . (isset($record['id']) ? $record['id'] : '0').'/code'); ?>",
                type: "post",
                data: {
                    title: function () {
                        return $("#code").val();
                    }
                }
            }
        },
        per_user_limit: {
            required: true,
        },  
        code_date: {
            required: true,
        }, 
         discount: {
            required: true,
        },   
    },
    errorPlacement: function (error, element) {
            if (element[0]['id'] == "discount") {
                error.insertAfter(".bootstrap-touchspin");
            } else {
                error.insertAfter(element)
            }
        },
    messages: {
        title: {
            required: "Please provide a Title",
            remote: "Title is already exist, please choose diffrent Title"
        },
        code: {
            required: "Please provide a Promotional Code",
            remote: "Promotional Code is already exist, please choose diffrent Promotional Code"
        },
        per_user_limit: {
            required: "Please provide a limit per user apply this code"
        }, 
        code_date: {
            required: "Please provide a Promotional Code Date"
        },
         discount: {
            required: "Please provide a Discount"
        },

    }
});
</script>