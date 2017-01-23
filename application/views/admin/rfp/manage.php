<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/editors/summernote/summernote.min.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/editor_summernote.js"></script>
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
            <li><a href="<?php echo site_url('admin/blogs'); ?>">Blogs</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="frmblog" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="blog_slug" id="blog_slug" value="<?php echo (isset($record['blog_slug'])) ? $record['blog_slug'] : set_value('blog_slug'); ?>">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Blog Title:</label>
                            <div class="col-lg-9">
                                <input type="text" name="blog_title" id="blog_title" placeholder="Enter blog title" class="form-control" value="<?php echo (isset($record['blog_title'])) ? $record['blog_title'] : set_value('blog_title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Blog Image:</label>
                            <div class="col-lg-9">
                                <input type="file" id="img_path" name="img_path[]" multiple="multiple" class="file-styled">
                                <input type="hidden" value="<?= isset($record['img_path']) ? $record['img_path'] : '' ?>" name="Himg_path" id="Himg_path">
                                <span class="help-block">Please upload only image file With .jpg, .jpeg, .png, .gif extension (Size : 1140px * 475px)</span>
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
                            <label class="col-lg-3 control-label">Blog Description:</label>
                            <div class="col-lg-12">
                                <textarea name="blog_description" id="blog_description" placeholder="Enter blog Description" class="summernote form-control"><?php echo (isset($record['blog_description'])) ? $record['blog_description'] : set_value('blog_description'); ?></textarea>
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
 <script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/validation/additional_methods.min.js"; ?>"></script>

<script type="text/javascript">
    $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });

// For create a blog Slug based on blog title
$("#blog_title").blur(function () {
    var Text = $(this).val();
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
    $("#blog_slug").val(Text);
});

// For count file when select multiple image
$('#img_path').change(function(){
    var files = $(this)[0].files;
    var file_text= files.length+" files selected";
    $(".filename").addClass("customfilename");
    $(".countfile").remove();
    $('<span class="filename countfile"></span>').insertAfter('.filename');
    $('.customfilename').hide();
    $('.countfile').html(file_text);
});

//---------------------- Validation -------------------
$("#frmblog").validate({
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
        blog_title: {
            required: true,
            remote: {
                url: "<?php echo base_url('admin/blogs/check_blog_title_exists/' . (isset($record['id']) ? $record['id'] : '0')); ?>",
                type: "post",
                data: {
                    blog_title: function () {
                        return $("#blog_title").val();
                    }
                }
            }
        },
        blog_description: {
            required: true
        }

    },
    errorPlacement: function (error, element) {
        if (element[0]['id'] == "blog_description") {
            error.insertAfter(".note-editor");
        } 
        else if(element[0]['id'] == "img_path"){
             error.insertAfter("#uniform-img_path");
        }
        else {
            error.insertAfter(element)
        }
    },
    messages: {
        blog_title: {
            required: "Please provide a Title",
            remote: "Title is already exist, please choose diffrent Title"
        },
        blog_description: {
            required: "Please provide a Description"
        }

    }
});

    // Custom  rule add for multiple image uplaod ----------
    $("input#img_path").each(function(){        
        $(this).rules("add", {            
            required:true,            
            extension: "jpg|jpeg|png|gif",
            messages: {
                    required: "Please Select Image",            
                    extension: "Please Select Only jpg, jpeg, png, gif file type"     
                }       
        });                      
    });

    //----- Remove required validation for edit time
    if($("#Himg_path").val() != ''){
        $("input#img_path").rules("remove", "required");
    }


</script>

