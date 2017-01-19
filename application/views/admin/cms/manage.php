<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/forms/tags/tokenfield.min.js"></script>

<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/editors/summernote/summernote.min.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/editor_summernote.js"></script>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - <?php echo $heading; ?></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li><a href="<?php echo site_url('admin/cms'); ?>">CMS Page</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="frmcms" method="POST">
                <input type="hidden" name="slug" id="slug" value="<?php echo (isset($record['slug'])) ? $record['slug'] : set_value('slug'); ?>">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Page Title:</label>
                            <div class="col-lg-9">
                                <input type="text" name="title" id="title" placeholder="Enter page title" class="form-control" value="<?php echo (isset($record['title'])) ? $record['title'] : set_value('title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">SEO Title:</label>
                            <div class="col-lg-9">
                                <input type="text" name="seo_title" id="seo_title" placeholder="Enter SEO title" class="form-control" value="<?php echo (isset($record['seo_title'])) ? $record['seo_title'] : set_value('seo_title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">SEO Keyword:</label>
                            <div class="col-lg-9">
                                <input type="text" name="seo_keyword" id="seo_keyword" placeholder="Enter SEO Keyword" class="form-control tokenfield-teal" value="<?php echo (isset($record['seo_keyword'])) ? $record['seo_keyword'] : set_value('seo_keyword'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">SEO Description:</label>
                            <div class="col-lg-9">
                                <textarea name="seo_description" id="seo_description" placeholder="Enter SEO Description" class="form-control"><?php echo (isset($record['seo_description'])) ? $record['seo_description'] : set_value('seo_description'); ?></textarea>
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
                            <label class="col-lg-3 control-label">Page Description:</label>
                            <div class="col-lg-12">
                                <textarea name="description" id="description" placeholder="Enter Page Description" class="summernote form-control"><?php echo (isset($record['description'])) ? $record['description'] : set_value('description'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Page Css:</label>
                            <div class="col-lg-12">
                               <textarea name="css_style" id="css_style" placeholder="Enter Page Style" class="form-control" rows="15"><?php echo (isset($record['css_style'])) ? $record['css_style'] : set_value('css_style'); ?></textarea>
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
 $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });

$(function(){
     // Add class on init
     $('.tokenfield-teal').on('tokenfield:initialize', function (e) {
        $(this).parent().find('.token').addClass('bg-teal')
    });

    // Initialize plugin
    $('.tokenfield-teal').tokenfield();

    // Add class when token is created
    $('.tokenfield-teal').on('tokenfield:createdtoken', function (e) {
        $(e.relatedTarget).addClass('bg-teal')
    });

    // CSS editor
    // var css_editor = ace.edit("css_editor");
    // css_editor.setTheme("ace/theme/monokai");
    // css_editor.getSession().setMode("ace/mode/css");
    // css_editor.setShowPrintMargin(false);
});

$("#title").blur(function () {
    var Text = $(this).val();
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
    $("#slug").val(Text);
});

//------------ For Readyonly Title When Update -------
if($("#title").val() != ''){
    $('#title').attr('readonly', true);
}

//---------------------- Validation -------------------
$("#frmcms").validate({
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
    ignore : [],
    rules: {
        title: {
            required: true,
            remote: {
                url: "<?php echo base_url('admin/cms/check_cms_title_exists/' . (isset($record['id']) ? $record['id'] : '0')); ?>",
                type: "post",
                data: {
                    title: function () {
                        return $("#title").val();
                    }
                }
            }
        },
        description: {
            required: true,
        },  

    },
    errorPlacement: function (error, element) {
            if (element[0]['id'] == "description") {
                error.insertAfter(".note-editor");
            } else {
                error.insertAfter(element)
            }
        },
    messages: {
        title: {
            required: "Please provide a Title",
            remote: "Title is already exist, please choose diffrent Title"
        },
        description: {
            required: "Please provide a Description",
        },    

    }
});
</script>