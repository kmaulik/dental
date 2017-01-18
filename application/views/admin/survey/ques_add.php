<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/form_inputs.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/forms/selects/bootstrap_select.min.js"></script>

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user"></i> <span class="text-semibold">Survey Question Add</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li><a href="<?php echo site_url('admin/survey'); ?>"> Survey</a></li>
            <li><a href="<?php echo site_url('admin/survey/questions/'.$survey_id); ?>">Question Sort </a></li>
            <li class="active">Add </li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            
            <form class="form-horizontal form-validate" id="form_survey_ques" method="POST" enctype="multipart/form-data">                
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Question text</label>
                            <div class="col-lg-9">
                                <input type="text" name="ques" id="ques" placeholder="Enter Question Text" class="form-control" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Answer Type</label>
                            <div class="col-lg-3">
                                <select class="bootstrap-select" data-width="100%" onchange="change_opt_val(this)" name="opt_type">
                                    <option value="textbox">Textbox</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="radio">Radio</option>
                                    <option value="checkbox">Checkbox</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Is Required ? </label>
                            <div class="col-lg-9">
                                <label class="radio-inline">
                                    <input type="radio" name="is_required" class="styled" value="1">
                                    Yes
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" name="is_required" class="styled" checked="checked" value="0">
                                    No
                                </label>
                            </div>
                        </div> 
                        
                        <div class="survey_options" style="display:none">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Answer Options </label>
                                <div class="col-lg-4">
                                    <input type="text" name="opt_choice[]" id="" class="form-control" placeholder="Enter Option">
                                </div>
                                <a class="btn btn-xs border-primary text-primary-900 btn-flat btn-icon" title="Delete" onclick="add_option()">
                                    <i class="icon-add"></i>
                                </a>
                            </div> 
                        </div>

                        <div class="survey_no_options">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Answer Options </label>
                                <div class="col-lg-4">
                                    <input type="text" name="opt_choice[]" id="" class="form-control" disabled value="No Options">
                                </div>
                            </div> 
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Status? </label>
                            <div class="col-lg-9">
                                <label class="radio-inline">
                                    <input type="radio" name="status" class="styled" value="active">
                                    Active
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" name="status" class="styled" checked="checked" value="inactive">
                                    In-active
                                </label>
                            </div>
                        </div> 

                        <div class="form-group text-right">
                            <div class="col-lg-5">

                            </div>
                            <div class="col-lg-5">
                                <button class="btn btn-success" type="submit">
                                    Save<i class="icon-arrow-right14 position-right"></i>
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
    var total_boxes = 1;

    $(function() {
        // Override defaults
        $.fn.selectpicker.defaults = {
            iconBase: '',
            tickIcon: 'icon-checkmark3'
        }
        // Basic select
        $('.bootstrap-select').selectpicker();
    });

    function change_opt_val(obj){
        var new_str = '';
        console.log($(obj).val());
        if($(obj).val() == 'radio' || $(obj).val() == 'checkbox'){
            $('.survey_no_options').hide();
            $('.survey_options').show();
        }else{

            new_str += '<div class="form-group"> <label class="col-lg-3 control-label">Answer Options </label>';
            new_str += '<div class="col-lg-4"> <input type="text" placeholder="Enter Option"  name="opt_choice[]" id="" class="form-control "> </div>';
            new_str += '<a class="btn btn-xs border-primary text-primary-900 btn-flat btn-icon" title="Delete" onclick="add_option()">';
            new_str += '<i class="icon-add"></i> </a> </div>';

            $('.survey_no_options').show();
            $('.survey_options').html(new_str).hide();

            
        }
    }

    function add_option(){
        //.survey_options
        var new_str = '';            
        var total_textboxes = $('.survey_options .form-group').size();
        if(total_textboxes < 4){
            
            new_str += '<div class="form-group box_'+total_boxes+'"><label class="col-lg-3 control-label"></label>';
            new_str += '<div class="col-lg-4"><input type="text" placeholder="Enter Option" name="opt_choice[]" id="opt_'+total_boxes+'" class="form-control ">';
            new_str += '</div> <a class="btn btn-xs border-primary text-primary-900 btn-flat btn-icon" title="Delete" onclick="remove_option(this)">';
            new_str += '<i class="icon-minus-circle2"></i> </a> </div>';

            $('.survey_options').append(new_str);

            total_boxes++;

        }else{
            bootbox.alert('Can not add more than 4 Options');
        }        
    }

    function remove_option(obj){
        $(obj).parent().remove();
    }

    // v! Create fancy radio buttons
    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice' });

    //---------------------- Validation -------------------
    $("#form_survey_ques").validate({
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
            ques: {
                required: true
            }            
        },
        messages: {
            ques: {
                required: "Please provide a Question Title."                
            }            
        }
    });

    


</script>