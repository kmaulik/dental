
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/editors/summernote/summernote.min.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/editor_summernote.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/form_inputs.js"></script>

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Website Survey </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li><a href="<?php echo site_url('admin/survey'); ?>"> Survey</a></li>
            <li class="active">Add</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" id="form_survey" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="blog_slug" id="blog_slug" value="<?php echo (isset($record['blog_slug'])) ? $record['blog_slug'] : set_value('blog_slug'); ?>">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Survey Title:</label>
                            <div class="col-lg-9">
                                <input type="text" name="survey_title" id="survey_title" placeholder="Enter Survey title" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Status:</label>
                            <div class="col-lg-9">
                                <label class="radio-inline">
                                    <input type="radio" name="status" class="styled" value="active">
                                    Active
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" name="status" class="styled" checked="checked" value="inactive">
                                    Inactive
                                </label>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Blog Description:</label>
                            <div class="col-lg-12">
                                <textarea name="survey_description" id="survey_description" placeholder="Enter Survey Description"
                                          class="summernote form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <div class="col-lg-5">

                            </div>
                            <div class="col-lg-5">


                                <button class="btn btn-success" type="submit">
                                    Save 
                                    <i class="icon-arrow-right14 position-right"></i>
                                </button>
                            </div>
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
    $("#form_survey").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        validClass: "validation-valid-label",
        rules: {
            survey_title: {
                required: true
            },
            survey_description: {
                required: true
            }
        },
        messages: {
            survey_title: {
                required: "Please provide a Title"                
            },
            survey_description: {
                required: "Please provide a Description"
            }
        }
    });

</script>