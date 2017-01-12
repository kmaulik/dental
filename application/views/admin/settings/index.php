<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/forms/tags/tokenfield.min.js"></script>

<style>
.setting-heading{
    margin: 0px;
}
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="<?php echo site_url('admin/settings'); ?>"><i class="icon-gear position-left"></i> <?php echo $heading; ?></a></li>
           
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
            <form class="form-horizontal form-validate" action="<?=base_url('admin/settings/save')?>" id="frmsettings" method="POST">
                <input type="hidden" name="slug" id="slug" value="<?php echo (isset($record['slug'])) ? $record['slug'] : set_value('slug'); ?>">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <h2 class="setting-heading">Basic Configuration</h3>
                           <hr/> 
                        </div>    
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Site Name:</label>
                            <div class="col-lg-6">
                                <input type="text" name="site_name" id="site_name" placeholder="Enter Site Name" class="form-control" value="<?php echo (isset($record['site_name'])) ? $record['site_name'] : set_value('site_name'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Site Title:</label>
                            <div class="col-lg-6">
                                <input type="text" name="site_title" id="site_title" placeholder="Enter Site title" class="form-control" value="<?php echo (isset($record['site_title'])) ? $record['site_title'] : set_value('site_title'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Contact Email:</label>
                            <div class="col-lg-6">
                                <input type="text" name="contact_email" id="contact_email" placeholder="Enter Contact Email" class="form-control" value="<?php echo (isset($record['contact_email'])) ? $record['contact_email'] : set_value('contact_email'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Sender Name:</label>
                            <div class="col-lg-6">
                                <input type="text" name="sender_name" id="sender_name" placeholder="Enter Sender Name" class="form-control" value="<?php echo (isset($record['sender_name'])) ? $record['sender_name'] : set_value('sender_name'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Copy Right:</label>
                            <div class="col-lg-6">
                                <input type="text" name="copy_right" id="copy_right" placeholder="Enter Copy Right Text" class="form-control" value="<?php echo (isset($record['copy_right'])) ? $record['copy_right'] : set_value('copy_right'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Site Description:</label>
                            <div class="col-lg-9">
                                <textarea  name="site_description" id="site_description" placeholder="Enter Site Description" class="form-control" ><?php echo (isset($record['site_description'])) ? $record['site_description'] : set_value('site_description'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Site Keyword:</label>
                            <div class="col-lg-9">
                                <textarea  name="site_keywords" id="site_keywords" placeholder="Enter Site Keyword" class="form-control tokenfield-teal" ><?php echo (isset($record['site_keywords'])) ? $record['site_keywords'] : set_value('site_keywords'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h2 class="setting-heading">Social Settings</h3>
                           <hr/> 
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Facebook Link:</label>
                            <div class="col-lg-6">
                                <input type="text" name="facebook_link" id="facebook_link" placeholder="Enter Facebook Link" class="form-control" value="<?php echo (isset($record['facebook_link'])) ? $record['facebook_link'] : set_value('facebook_link'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Twitter Link:</label>
                            <div class="col-lg-6">
                                <input type="text" name="twitter_link" id="twitter_link" placeholder="Enter Twitter Link" class="form-control" value="<?php echo (isset($record['twitter_link'])) ? $record['twitter_link'] : set_value('twitter_link'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Google Plus Link:</label>
                            <div class="col-lg-6">
                                <input type="text" name="gplus_link" id="gplus_link" placeholder="Enter Google Plus Link" class="form-control" value="<?php echo (isset($record['gplus_link'])) ? $record['gplus_link'] : set_value('gplus_link'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">YouTube Link:</label>
                            <div class="col-lg-6">
                                <input type="text" name="youtube_link" id="youtube_link" placeholder="Enter YouTube Link" class="form-control" value="<?php echo (isset($record['youtube_link'])) ? $record['youtube_link'] : set_value('youtube_link'); ?>">
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

});

$("#title").blur(function () {
    var Text = $(this).val();
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
    $("#slug").val(Text);
});

//---------------------- Validation -------------------
$("#frmsettings").validate({
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
        site_name: {
            required: true,
        },
        site_title: {
            required: true,
        },
        contact_email: {
            required: true,
        },
        sender_name: {
            required: true,
        },
        copy_right: {
            required: true,
        },
        site_description: {
            required: true,
        },
        // site_keywords: {
        //     required: true,
        // },
        facebook_link: {
            required: true,
        },
        twitter_link: {
            required: true,
        },
        gplus_link: {
            required: true,
        },
        youtube_link: {
            required: true,
        },

    },
    messages: {
        site_name: {
            required: "Please provide Site Name",
        },
        site_title: {
            required: "Please provide Site Title",
        },
        contact_email: {
            required: "Please provide Contact Email",
        },
        sender_name: {
            required: "Please provide Sender Name",
        },
        copy_right: {
            required: "Please provide Copy Right",
        },
        site_description: {
            required: "Please provide Site Description",
        },
        // site_keywords: {
        //     required: "Please provide Site Keyword",
        // },
        facebook_link: {
            required: "Please provide Facebook Link",
        },
        twitter_link: {
            required: "Please provide Twitter Link",
        },
        gplus_link: {
            required: "Please provide Google Plus Link",
        },
        youtube_link: {
            required: "Please provide YouTube Link",
        },

    }
});

 // Auto hide Flash messages
    $('div.alert').delay(4000).slideUp(350);
</script>