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
            <li><a href="<?php echo site_url('admin/email_template'); ?>"> Email Template</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" action="" id="frmemail" method="POST" >
                <input type="hidden" name="id" id="id" value="<?php echo (isset($record['id'])) ? $record['id'] : set_value('id'); ?>">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Email Template Title:</label>
                                <div class="col-lg-9">
                                    <input type="text" name="title" id="title" placeholder="Enter email template title" class="form-control" value="<?php echo (isset($record['title'])) ? $record['title'] : set_value('title'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Description:</label>
                                <div class="col-lg-12">
                                    <textarea rows="15" name="description" id="description" placeholder="Enter email template Description" class="form-control summernote"><?php echo (isset($record['description'])) ? $record['description'] : set_value('description'); ?></textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <a class="btn btn-info btn_default">Default <i class="icon-undo position-right"></i></a>
                                <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="col-lg-12 control-label">Reference Variable</label>
                                <div class="col-lg-12">
                                    <?php echo (isset($record['ref_variable'])) ? $record['ref_variable'] : '' ?>
                                </div>
                            </div>        
                        </div>    
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

//---------------------- Validation -------------------
$("#frmemail").validate({
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
        title: {
            required: true,
            remote: {
                url: "<?php echo base_url('admin/email_template/check_email_title_exists/' . (isset($record['id']) ? $record['id'] : '0')); ?>",
                type: "post",
                data: {
                    title: function () {
                        return $("#title").val();
                    }
                }
            }
        },
        description: {
            required: true
        }

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
            required: "Please provide a Description"
        }

    }
});
    


$(document).on( "click",".btn_default", function(e) {
    e.preventDefault();
    var template_id= $("#id").val();
    bootbox.confirm('Are you sure for set default template?',function(res){
        if (res) 
        {
            $.post("<?=base_url('admin/email_template/get_template_desc')?>",{'template_id':template_id},function(data){
                if(data){
                    $("#description").html(data);
                    $(".note-editable").html(data);
                }
            });
        }     
    });
});
</script>

