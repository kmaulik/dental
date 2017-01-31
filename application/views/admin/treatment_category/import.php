<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/additional-methods.js" ></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - <?php echo $heading; ?></h4>            
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li><a href="<?php echo site_url('admin/treatment_category'); ?>">Treatment Category</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<div class="content">
    <?php
        $message = $this->session->flashdata('message');
        echo my_flash($message);
    ?>

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="frm_treat_cat" method="POST" enctype="multipart/form-data">                
                <div class="panel panel-flat">
                    <div class="panel-body">                        
                        
                        <div class="form-group">                            
                            <div class="col-lg-12 text-right" >
                                <a class="btn bg-teal-400 btn-labeled" href="<?php echo base_url().'admin/treatment_category/download_sample'; ?>">
                                    <b><i class="icon-download"></i></b> 
                                    Download sample file
                                </a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-3">CSV File <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="file" name="import_csv" class="file-styled-primary" required="required">
                            </div>
                        </div>

                       <div class="text-right">
                        <input type="hidden" name="test" value="test">
                        <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script>
    $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });
    // Primary file input
    $(".file-styled-primary").uniform({
        fileButtonClass: 'action btn bg-blue'
    });

    //---------------------- Validation -------------------
    $("#frm_treat_cat").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        validClass: "validation-valid-label",
        errorPlacement: function(error, element) {

            if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            } else {
                error.insertAfter(element);
            }
        },
        success: function(label) {
            label.addClass("validation-valid-label").text("Success.")
        },
        rules: {
            import_csv:{
                required: true,
                extension: "jpg|jpeg|pdf|doc|docx|png"
            }
        },
        messages: {
            import_csv: {
                required: "Please provide a CSV File",
                extension:"Please upload CSV file"
            }

        }
    });
</script>